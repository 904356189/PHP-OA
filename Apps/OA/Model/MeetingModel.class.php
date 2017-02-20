<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class MeetingModel extends Model
{		
	protected $_validate = array(
		array('type', 'require', '会议类型不能为空！'),
		array('content', 'require', '来访内容不能为空！'),
		array('begin_time', 'require', '接待时间不能为空！'),
		array('place', 'require', '会议地点不能为空！'),
		array('departments', 'require', '参会部门不能为空！'),
		array('participants', 'require', '参会人员不能为空！')
		);

	protected $_auto = array(
		array('update_time', 'getTime', 2, 'function'), //更新时写入当前时间戳
		);

	private function getTime(){
		return date('Y-m-d H:i:s');
	}

	private function format($data){
		if($data){
			$result = array();
			foreach ($data as $k) {
				$result[] = array(
					'id' => $k['id'],
					'title' => $k['content'],
					'start' => $k['begin_time'],
					'end' => $k['end_time'],
					'allDay' => 0,
					'color' => ($k['type']=='F')?'#F75000':'#006000'
					);
			}
			return $result;
		}
		else
			return '';
	}

	public function getMeetingCalendar($format=true){
		$start = I('start').' 00:00:00';
		$end = I('end').' 00:00:00';
		$where['begin_time'] = array('between', array($start, $end));
		$data = $this->where($where)->field('id, type, content, begin_time, end_time')->select();
		if($format)
			return $this->format($data);
		else
			return $data;
	}

	public function getMeeting($id){
		return $this->find($id);

	}

	public function getMeetingForDay($date){
		if($date){
			$start = $date.TIME_START;
			$end = $date.TIME_END;
			$where['begin_time'] = array('egt', $start);
			$where['end_time'] = array('elt', $end);
			return $this->where($where)
						->field('id, vistor, begin_time, end_time')
						->order('begin_time')
						->select();
		}
	}

	// 根据POST数据构造Meeting记录数据
	private function createMeetingData(){
		if(I('post.')){
			$data = array(
				'type' => I('type'),
				'content' => I('content'),
				'begin_time' => I('begin_time'),
				//'place' => (I('type')=='L')?I('local_place'):I('foreign_place'),
				'host' => I('host'),
				'departments' => implode(",", I('departments')),
				'participants' => implode(",", I('participants')),
				'recorder_id' => getCurrentUserId()
			);
			if(I('type')=='L'){
				$data['end_time'] = I('end_time');
				$rooms = M('Room');
				$room = $rooms->where(array('id'=>I('local_place')))->getField('name');
				$data['place'] = $room;
			}
			else{
				$data['place'] = I('foreign_place');
			}
			return $data;
		}
		else
			return null;
	}

	// 生成领导日程记录
	private function createLeaderSchedule($meetingId){
		if(I('create_schedule')&&$meetingId){
			// 先判断参会人员是否有领导
			$users = D('User');
			$participants = I('participants');
			// 获取所有领导ID
			$allLeaderIds = $users->getLeaderIds(true);
			$leaderIds = array();
			foreach ($participants as $k) {
				if(in_array($k, $allLeaderIds))
					$leaderIds[] = $k;
			}
			if(!$leaderIds)
				return null;
			else{
				$data = array();
				foreach ($leaderIds as $k) {
					$data[] = array(
						'title' => I('content'),
						'description' => '参会人员：'.getMemberName($participants),
						'begin_time' => I('begin_time'),
						'end_time' => (I('type')=='L')?I('end_time'):null,
						'user_id' => $k,
						'recorder_id' => getCurrentUserId(),
						'source' => 'M',
						'related_event_id' => $meetingId
					);
				}
				return $data;
			}
			
		}
		else
			return null;
	}

	// 添加会议记录
	// 添加成功返回1，否则返回错误信息
	public function addMeeting(){
		$meeting = $this->createMeetingData();
		if($meeting){
			$this->startTrans();

			// 添加会议记录
			if(!$this->create($meeting)){
				$this->rollback();
				return $this->getError();
			}
			else{
				$meetingId = $this->add();
				if(!$meetingId){
					$this->rollback();
					return $this->getError();
				}
			}

			// 添加日程记录
			$leaderSchedule = $this->createLeaderSchedule($meetingId);
			if($leaderSchedule){
				$sch = D('Schedule');
				foreach ($leaderSchedule as $k) {
				    if($sch->create($k)){
				        $id = $sch->add();
				        if(!$id){
				        	$this->rollback();
				            return $sch->getError();
				        }
				    }
				    else{
				    	$this->rollback();
				        return $sch->getError();
				    }
				}
			}

			// 添加房间预定记录
			// 内部会议才添加
			if(I('type')=='L'&&$meetingId){
				// 先获取会议室ID
				$room = M('Room');
				$where['name'] = I('local_place');
				$room_id = $room->where($where)->getField('id');
				$bookedInfo = array(
					'room_id' => $room_id,
					'event_type' => 'M',
					'event_id' => $meetingId,
					'begin_time' => I('begin_time'),
					'end_time' => I('end_time'),
					'book_person' => getCurrentUserId()
				);
				$rb = D('RoomBooking');
				if($rb->create($bookedInfo)){
					$bookedId = $rb->add();
					if(!$bookedInfo){
						$this->rollback();
						return $rb->getError();
					}
				}
				else {
				 	$this->rollback();
				 	return $rb->getError();
				 } 
			}

			// 所有步骤完毕
			$this->commit();
			return 1;
		}
	}

	// 获取会议信息
	public function getMeetingInfo($id){
		$meeting = $this->find($id);
		if($meeting){
			$data['type'] = $meeting['type']=='F'?'外出开会':'内部会议';
			$data['time'] = date('Y-m-d H:i', strtotime($meeting['begin_time']));
			if($meeting['end_time'])
				$data['time'] .= '-'.date('H:i', strtotime($meeting['end_time']));
			$data['content'] = $meeting['content'];
			$data['place'] = $meeting['place'];
			$data['host'] = $meeting['host'];
			$data['departments'] = getDepartmentName($meeting['departments']);
			$data['participants'] = getMemberName($meeting['participants']);
			$data['delete'] = $meeting['recorder_id']==getCurrentUserId()?1:0;
			return $data;
		}
	}

	
	
}
<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class RoomBookingModel extends Model
{

	private function getContent($type, $id){
		if($type=='M'){
			$mt = M('Meeting');
			$meeting = $mt->find($id);
			if($meeting){
				if($meeting['host'])
					return getMemberName(intval($meeting['host'])).'主持召开'.$meeting['content'];
				else
					return $meeting['content'];
			}
		}
		else if($type=='R'){
			$rp = D('Reception');
			$reception = $rp->getReception($id);
			if($reception)
				return $reception['vistor'].'&nbsp;&nbsp;&nbsp;'."<strong class='text-warning'>".getDepartmentName($reception['major_department']).'接待'."</strong>";
		}
		else
			return null;
	}

	private function getEventContent($type, $id){
		if($type=='M'){
			$meetings = M('Meeting');
			$where['id'] = $id;
			return $meetings->where($where)->getField('content');
		}
		else{
			$receptions = M('Reception');
			$where['id'] = $id;
			return '接待'.$receptions->where($where)->getField('vistor');
		}
	}

	private function getEventColor($type){
		return $type=='M'?'#F75000':'#006000';
	}	

	//获取指定房间，指定日期的预定情况
	public function getRoomSchedule($roomId, $date){
		if($date){
			$start = $date.' '.TIME_START;
			$end = $date.' '.TIME_END;
			$where['room_id'] = $roomId;
			$where['begin_time'] = array('egt', $start);
			$where['end_time'] = array('elt', $end);
			$roomSchedule = $this->where($where)->order('begin_time')->select();
			if($roomSchedule){
				$formatSchedule = array();
				foreach ($roomSchedule as $item) {
					$content = $this->getContent($item['event_type'], $item['event_id']);
					$formatSchedule[] = array(
						'start' => $item['begin_time'],
						'end' => $item['end_time'],
						'content' => $content
						);
				}
				return $formatSchedule;
			}
			else
				return null;

		}
	}

	//根据事件ID获取房间预定情况
	public function getRoomBookedInfo($event_id, $event_type){
		$where['a.event_type'] = $event_type;
		$where['a.event_id'] = $event_id;
		return $this->table('oa_room_booking a')
					->join('oa_room b on b.id = a.room_id', 'LEFT')
					->where($where)
					->field('b.name, a.begin_time, a.end_time')
					->select();
	}

	// 删除指定房间、指定接待的预定信息
	public function delRoomBookedInfo($event_id, $event_type){
		$where['event_type'] = $event_type;
		$where['event_id'] = $event_id;
		$msg = $this->where($where)->delete();
		if(!$msg&&$msg!=0)
			return $this->getError();
		else
			return 1;
	}

	// 获取指定房间所有的预定信息
    public function getRoomCalendar($roomId){
    	$start = I('start').' 00:00:00';
    	$end = I('end').' 00:00:00';
    	$where['begin_time'] = array('between', array($start, $end));
    	$where['room_id'] = $roomId;
    	$roomBookInfos = $this->where($where)->select();
    	if($roomBookInfos){
    		$roomCalendar = array();
    		foreach ($roomBookInfos as $k) {
    			$roomCalendar[] = array(
    				'id' => $k['id'],
    				'title' => $this->getEventContent($k['event_type'], $k['event_id']),
    				'start' => $k['begin_time'],
    				'end' => $k['end_time'],
    				'color' => $this->getEventColor($k['event_type'])
    				);
    		}
    		return $roomCalendar;
    	}
    }
	
}
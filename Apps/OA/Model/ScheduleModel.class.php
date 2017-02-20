<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class ScheduleModel extends Model
{	

	protected $_auto = array(
		array('update_time', 'getTime', 3, 'callback'), //更新时写入当前时间戳
		array('recorder_id', 'getCurrentUserId', 3, 'function'),
		);

	public function getTime(){
		return date('Y-m-d H:i:s');
	}
	
	// 获取指定用户ID的日程
	// @type说明：
	// all: 获取$userId所有的日程信息
	public function getSchedules($userId, $type='all', $beginTimeStr=null, $endTimeStr=null){
		$where['a.user_id'] = $userId;
		if('oneday'==$type){//获取指定日期当天的日程
			if(!$beginTimeStr)
				return null;
			else{
				$startTime = date('Y-m-d', strtotime($beginTimeStr)).' '.TIME_START;
				$endTime = date('Y-m-d', strtotime($beginTimeStr)).' '.TIME_END;
				$where['a.begin_time'] = array('between', array($startTime, $endTime));
			}
		}
		else if('after'==$type){//获取指定日期后的所有日程记录
			if(!$beginTimeStr)
				return null;
			else{
				$startTime = date('Y-m-d', strtotime($beginTimeStr)).' '.TIME_START;
				$where['a.begin_time'] = array('egt', $startTime);
				
			}
		}
		else if('between'==$type){//获取区间的日程信息
			if(!$beginTimeStr || !$endTimeStr)
				return null;
			else{
				$startTime = date('Y-m-d', strtotime($beginTimeStr)).' '.TIME_START;
				$endTime = date('Y-m-d', strtotime($endTimeStr)).' '.TIME_END;
				$where['a.begin_time'] = array('between', array($startTime, $endTime));
			}
		}
		else if('before'==$type){//获取指定日期前的日程信息
			if(!$beginTimeStr)
				return null;
			else{
				$startTime = date('Y-m-d', strtotime($beginTimeStr)).' '.TIME_END;
				$where['a.begin_time'] = array('elt', $startTime);
				
			}
		}
		return $this->table('oa_schedule a')
					->join('oa_user b on a.user_id = b.id', 'LEFT')
					->where($where)
					->field('a.id, a.title, a.begin_time as start, a.end_time as end, 
						a.is_allday as allDay, b.calendar_color as color')
					->order('a.begin_time asc')
					->select(); 
	}

	// 获取多人的日程信息
	public function getSchedulesForPeople($userIds, $type, $beginTimeStr=null, $endTimeStr=null){
		if(!$userIds)
			return null;
		$data = array();
		foreach ($userIds as $id) {
			$schedule = $this->getSchedules($id, $type, $beginTimeStr, $endTimeStr);
			if($schedule)
				$data = array_merge($data, $schedule);
		}
		return $data;
	}
	
	public function getLeaderScheduleForMain($timeStr, $all=false){
		$user = D('User');
		$leaders = $user->getLeaders($all);
		$data = array();
		$i = 1;
		foreach ($leaders as $k) {
			$schedule = $this->getSchedules($k['id'], 'oneday', $timeStr);
			if($schedule){
				$data[$k['username']]['no'] = $i++;
				$data[$k['username']]['fullname'] = $k['first_name'].$k['last_name'];
				$data[$k['username']]['data'] = $schedule;
			}
			
		}
		return $data;
	}

	public function getScheduleInfo($scheduleId){
		if($scheduleId){
			$where['a.id'] = $scheduleId;
			$schedule = $this->table('oa_schedule a')
							 ->join('oa_user b on a.user_id=b.id', 'LEFT')
							 ->where($where)
							 ->field('a.description, b.image_url')
							 ->find();
			if($schedule){
				$data['description'] = $schedule['description'];
				$data['image'] = $schedule['image_url'];
				return $data;
			}
			else
				return null;
		}
		else
			return null;
	}

	// 删除接待日程记录
	public function delSchedules($leaderIds, $source='S', $receptionId=0){
		// $leaderIds可能是字符串，也可能是数组，先判断
		if(!empty($leaderIds)){
			if(is_string($leaderIds))
				$leaderIds = explode(',', $leaderIds);
			$where['source'] = $source;
			$where['related_event_id'] = $receptionId;
			foreach ($leaderIds as $k) {
				$where['user_id'] = $k;
				$flag = $this->where($where)->delete();
				// 注意：delete返回0表示没有记录被删除，返回false表示删除错误
				if(!$flag&&$flag!=0)
					return $this->getError();
			}
			return 1;
		}
		else
			return "接待领导数据错误！";
	}
	
}
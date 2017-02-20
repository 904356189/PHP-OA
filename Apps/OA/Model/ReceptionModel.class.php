<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class ReceptionModel extends Model
{		
	protected $_validate = array(
		array('vistor', 'require', '来访机构不能为空！'),
		array('visit_content', 'require', '来访内容不能为空！'),
		array('visit_count', 'require', '来访人数不能为空！'),
		// array('visit_places', 'require', '参观地点不能为空！'),
		// array('reception_leader', 'require', '接待领导不能为空！'),
		array('major_department', 'require', '接待处室不能为空！'),
		array('begin_time', 'require', '接待时间不能为空！')
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
					'title' => $k['vistor'],
					'start' => $k['begin_time'],
					'end' => $k['end_time'],
					'allDay' => false
					);
			}
			return $result;
		}
		else
			return '';
	}

	public function getReceptionCalendar($format=true){
		// 按需获取数据
		$start = I('start').' 00:00:00';
		$end = I('end').' 00:00:00';
		$where['begin_time'] = array('between', array($start, $end));
		//$where['end_time'] = array('elt', $end);
		$data = $this->where($where)->field('id, vistor, begin_time, end_time')->select();
		if($format)
			return $this->format($data);
		else
			return $data;
	}

	public function getReception($id){
		return $this->find($id);

	}

	public function getReceptionForDay($date){
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

	public function addReception(){
		
	}

	
	
}
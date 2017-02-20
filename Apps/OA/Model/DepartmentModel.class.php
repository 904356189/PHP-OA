<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class DepartmentModel extends Model
{		

	public function getDepartments($all=false){
		if($all)
			return $this->field('id, short_name')->select();
		else{
			$where['id'] = array('neq', 1);
			return $this->where($where)->field('id, short_name')->select();
		}
	}

	public function getDepartmentsExcept($ids, $all=false){
		if(!$all){
			if(is_array($ids))
				$ids[] = 1;
			else
				$ids = array($ids, 1);
			$where['id'] = array('not in', $ids);
		}
		else{
			if(is_array($ids))
				$where['id'] = array('not in', $ids);
			else
				$where['id'] = array('neq', $ids);
		}
		return $this->where($where)->field('id, short_name')->select();
	}
	
	
}
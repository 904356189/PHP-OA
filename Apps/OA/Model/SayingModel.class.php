<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class SayingModel extends Model
{		
	public function getRandom(){
		$id = rand($this->min('id'), $this->max('id'));
		return $this->where(array('id'=>$id))->getField('content');
	} 
	
}
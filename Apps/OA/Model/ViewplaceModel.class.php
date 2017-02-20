<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class ViewplaceModel extends Model
{		
	public function linkPlaces($ids){
		if(!$ids)
			return null;
		$places = "";
		$ids = explode(",", $ids);
		foreach ($ids as $id) {
			$place = $this->where(array('id'=>$id))->getField('name');
			if(!$places)
				$places = $place;
			else
				$places .= "、".$place; 
		}
		return $places;
	

	}
	
}
<?php
/**
 * 权限模型
 * Created by PhpStorm.
 * User: Rg
 * Date: 2017/2/16
 * Time: 16:02
 */
namespace OA\Model;

use Think\Model;

class PermissionsModel extends Model {
    
    /**
     * @param array $where
     * @return mixed
     */
    public function findAll( $where = array() ) {
        return $this->where( $where )->select();
    }


    /**
     * @param string $permissionsUrl
     * @return int id
     */
    public function findByPermissionsUrl( $permissionsUrl = "") {
        return $this->field("id")->where("permissions_url = '$permissionsUrl'")->find();
    }


    /**
     * 删除权限url
     * @param $id
     * @return boolean
     */
    public function removeById( $id) {
        return $this->where("id=$id")->delete();
    }


    /**
     * 修改权限url
     * @param int id
     * @param array data
     * @return boolean
     */
    public function updateById( $id, $data = array()) {
        return $this->where("id=$id")->save($data);
    }
}
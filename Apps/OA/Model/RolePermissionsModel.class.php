<?php
/**
 * 角色权限关联表
 * Created by PhpStorm.
 * User: Rg
 * Date: 2017/2/17
 * Time: 14:14
 */

namespace OA\Model;

use Think\Model;

class RolePermissionsModel extends Model {
    /**
     * 根据角色id查询权限
     * @param int id
     * @return array
     */
    public function findByRole( $id ) {
        return $this->where("role_id=$id")->find();
    }


    /**
     * 为角色修改权限
     * @param $id
     * @param array $data
     * @return boolean
     */
    public function updateRolePermissions( $id, $data = array()) {
        return $this->where("role_id=$id")->save($data);
    }


    /**
     * 创建
     * @param array $data
     * @return boolean
     */
    public function CreateRolePermissions( $data = array() ) {
        return $this->data( $data )->add();
    }
}
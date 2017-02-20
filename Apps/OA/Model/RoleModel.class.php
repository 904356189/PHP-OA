<?php
/**
 * 角色模型
 * Created by PhpStorm.
 * User: Rg
 * Date: 2017/2/15
 * Time: 14:41
 */

namespace OA\Model;

use Think\Model;

class RoleModel extends Model {

    /**
     * 获取全部角色
     * @param array where
     * @return array
     */
    public function getAll( $where = array()) {
        return $this->where($where)->select();
    }
}
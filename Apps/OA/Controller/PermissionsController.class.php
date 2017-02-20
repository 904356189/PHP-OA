<?php
/**
 * 权限管理
 * Created by PhpStorm.
 * User: Rg
 * Date: 2017/2/15
 * Time: 9:29
 */

namespace OA\Controller;
use OA\Controller\BaseController;
use OA\Model\UserModel;
use OA\Model\RoleModel;
use OA\Model\UserRoleModel;
use OA\Model\PermissionsModel;
use OA\Model\RolePermissionsModel;

class PermissionsController extends BaseController {
    /**
     * 用户列表
     */
    public function user() {
        $page     = I('page',1);
        $pageSize = I('pageSize',100);
        $name     = I('name');
        if($name) {
            $where['username'] = array('like', "%$name%");
        }

        $model = new UserModel();
        $data = $model->getAll( $page, $pageSize, $where);
        if($data) {
            $count = $model->getCount($where);
            $this->assign( 'count', $count);
            $this->assign( 'data', $data);
        }
        $this->display();
    }


    /**
     * 编辑角色
     */
    public function disRole() {
        $uid = I('uid');

        //查询某个用户的角色
        if($uid) {
            $where['uid'] = $uid;
            $userRoleModel = new UserRoleModel();
            $userRole = $userRoleModel->findByUid($where);
            if($userRole) {
                $this->assign("userRoleId",$userRole['role_id']);
            }
        }


        $role_id = I('role_id');
        if($role_id) {
            if(!$uid) {
                echo json_encode(array('status' => 302, 'message' => "参数错误"));
            }else{
                $data = array(
                    'create_time' => date("Y-m-d H:i:s"),
                    'update_time' => date("Y-m-d H:i:s"),
                    'role_id'     => $role_id
                );

                if( $userRole ) {
                    //修改角色
                    $result = $userRoleModel->update( $data, $where );
                }else {
                    //新增角色
                    $data['uid'] = $uid;
                    $result = $userRoleModel->insert( $data );
                }

                if(!$result) {
                    echo json_encode(array('status' => 300, 'message' => "数据操作失败"));
                }
                echo json_encode(array('status' => 200, 'message' => "编辑成功"));
            }
            exit;
        }

        //查询所有的角色
        $model = new RoleModel();
        $roleInfo = $model->getAll();
        $this->assign('roleInfo', $roleInfo);



        echo json_encode(array('status' => 200, 'roleInfo' => $roleInfo, 'userRoleId' => $userRole['role_id']));
        exit;
    }

    /**
     * 角色列表
     */
    public function role() {
        $model = new RoleModel();
        $data = $model->getAll();

        $this->assign( 'count', count($data));
        $this->assign( 'data', $data);
        $this->display();
    }


    /**
     * 为角色修改权限
     * @param int id
     * @param string permissions_id
     */
    public function updateRolePermissions() {
        $id = I('role_id');
        $permissions_id = I('permissions_id');

        $data = array(
            'update_time' => date("Y-m-d H:i:s"),
            'permissions_id' =>  rtrim($permissions_id,',')
        );

        $model = new RolePermissionsModel();

        if($model->findByRole($id)) {
            echo json_encode( array('status' => $model->updateRolePermissions( $id, $data )));
        } else {
            $data = array(
                'role_id'     => $id,
                'create_time' => date("Y-m-d H:i:s"),
                'update_time' => date("Y-m-d H:i:s"),
                'permissions_id' =>  rtrim($permissions_id,',')
            );
            echo json_encode( array('status' => $model->CreateRolePermissions( $data ))); }
        exit;
    }

    /**
     * 根据角色id查询该角色拥有哪些权限
     * @param int id
     */
    public function permissionsByRole() {
        $id = I('id');
        if(!$id) {
            echo json_encode( array( 'status' => 300, 'message' => '参数错误' )); exit;
        }

        $model = new RolePermissionsModel();
        $data = $model->findByRole( $id );
        if($data) {
            $permissionsArray = $data['permissions_id'];
            $permissionsArray = $permissionsArray ? explode(",", $permissionsArray) : array();
            echo json_encode(array( 'data' => $permissionsArray, 'status' => 200)); exit;
        }
        echo json_encode(array( 'data' => $data, 'status' => 302)); exit;

    }



    /**
     * 权限列表
     */
    public function permissions() {
        $model = new PermissionsModel();
        $data = $model->findAll();
        if($data) { $this->assign('count', count($data));}
        if(IS_AJAX) { echo json_encode(array( 'data' => $data)); exit;}
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 删除权限
     *
     */
    public function removePermissions() {
        $permissions_id = I('permissions_id');

        if(!$permissions_id) {
            echo json_encode( array( 'status' => 300, 'message' => '参数错误'));exit;
        }

        $model = new PermissionsModel();
        $result = $model->removeById($permissions_id);
        echo json_encode( array( 'status' => $result ? 200 : 302, 'message' => $result ? '删除成功' : '删除失败')); exit;
    }


    /**
     * 修改权限url
     */
    public function updatePermissions() {
        $permissions_id = I('permissions_id');

        if(!$permissions_id) {
            echo json_encode( array( 'status' => 300, 'message' => '参数错误'));exit;
        }

        $permissions_url  = I('permissions_url');
        $permissions_name = I('permissions_name');
        $data = array(
                'permissions_url' => $permissions_url,
                'name'            => $permissions_name,
                'update_time'     => date("Y-m-d H:i:s"),
        );

        $model = new PermissionsModel();
        $result = $model->updateById( $permissions_id, $data);
        echo json_encode( array( 'status' => $result ? 200 : 302, 'message' => $result ? '修改成功' : '修改失败')); exit;

    }
}
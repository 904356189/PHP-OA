<?php
namespace OA\Controller;
use Think\Controller;
use OA\Model\PermissionsModel;
use OA\Model\UserRoleModel;
use OA\Model\RolePermissionsModel;

class BaseController extends Controller {
	// 控制器基类，定义了一些所有控制器用到的属性和方法

	public function _initialize() {
		if(!$this->checkPermissions( $_SESSION['uid'], $_SERVER['REQUEST_URI'])) {
			if(IS_AJAX) {
				echo json_encode( array('status' => 300, 'message' => '权限错误'));exit;
			}
			$this->display("Permissions/error"); exit;
		}
	}


	/**
	 * 检查用户权限
	 * @param int uid
	 * @param string routing
	 * @return boolean
	 */
	public function checkPermissions( $uid, $routing ) {
		//退出免验证权限
		$noAuthArray = array(
			"/Index/index.html",
			"/Index/login.html",
			"/Index/logout.html",
		);
		if(in_array($_SERVER['REQUEST_URI'],$noAuthArray) ) {
			return true;
		}

		//根据用户id查询所属角色
		$userRoleModel = new UserRoleModel();
		$role_id       = $userRoleModel->findByUid(array('uid' => $uid));
		if(!$role_id || !isset($role_id['role_id'])) {
			return false;
		}

		if( $role_id['id'] == 1) {return true;};

		//根据角色id查询角色所拥有的权限
		$rolePermissionsModel = new RolePermissionsModel();
		$permissionsData      = $rolePermissionsModel->findByRole($role_id['role_id']);
		if(!$permissionsData || !isset($permissionsData['permissions_id'])) {
			return false;
		}

		//查询路由所对应的权限id
		$permissionsModel = new PermissionsModel();
		$permissionsId    = $permissionsModel->findByPermissionsUrl($routing);
		if(!$permissionsId || !isset($permissionsId['id'])) {
			return false;
		}

		$permissionsArray = explode( ",", $permissionsData['permissions_id'] );

		if(!in_array( $permissionsId['id'], $permissionsArray)) {
			return false;
		}

		return true;
	}

//********************************************************************************

	/**
	  * @access protected
      * @param  $error_str  string  错误提示信息
      * @param  $error_url  string  错误跳转地址           
      * @return author
     */
	protected function hasLogined($error_url='Index/index', $error_str='请先登录后再操作!'){
		if(!isLogin())
			$this->error($error_str, $error_url);
	}

	/**
	  * @access protected
      * @param  $error_str  string  错误提示信息
      * @param  $error_url  string  错误跳转地址           
      * @return author
     */
	protected function hasPermission($method, $error_url='Index/index', $error_str='页面不存在'){
		if(!isLogin()||(!$method)){
			$this->error($error_str, $error_url);
		}
			
	}

	//************************************************************************************
	public function __construct(){
		//调用父类构造函数
		parent::__construct();
		initialCache();
	}


}
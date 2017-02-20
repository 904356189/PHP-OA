<?php 

	//定义状态常量
	defined('TIME_START') or define('TIME_START', '00:00');
	defined('TIME_END') or define('TIME_END', '23:59');


	/**
      * 数据打印
      * 
      * @param content array      需要打印显示的内容
      * @return author            曾科		kandx@outlook.com
     */
	function p($content){
		if (is_array($content)) {
			echo "<pre>";
			print_r($content);
		}
		else{
			var_dump($content);
			//var_dump(iconv('utf-8', 'GBK',$content));
		}	
	}

   /**
      * 权限验证
      * @param rule string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
      * @param uid  int           认证用户的id
      * @param string mode        执行check的模式
      * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
      * @return boolean           通过验证返回true;失败返回false
      * @return author            黄药师		46914685@qq.com
     */
	function authCheck($rule,$uid,$type=1, $mode='url', $relation='or'){
		
		if(in_array($uid, C('ADMINISTRATOR'))){
			return true;
		}else{
			$auth=new \Think\Auth();			
			return $auth->check($rule,$uid,$type,$mode,$relation)?true:false;
		}
	}

	// 文件下载函数
	function downloadFile($file_path, $file_name)
	{
		//首先要判断给定的文件存在与否
			if(!file_exists($file_path)){
				return "该文件不存在，请与管理员联系";
			}
			$fp=fopen($file_path,"r");
			$file_size=filesize($file_path);
			//下载文件需要用到的头
			header("Content-type:text/html;charset=utf-8");
			header("Content-type: application/force-download");
			header("Accept-Ranges: bytes");
			header("Accept-Length:".$file_size);
			header("Content-Transfer-Encoding: binary");
			header("Content-Disposition: attachment; filename=".$file_name);
			header('Pragma: no-cache');
			header('Expires: 0');

			//清空缓存，避免下载乱码
			ob_clean();
        	flush();
			
			//echo fread($fp, filesize($file_path));
			while(!feof($fp)) {
                echo fgets($fp, 4096);
            }

			fclose($fp); 
	}
	//*****************************************************************************
	//以下是对session操作的封装
	//初始化和销毁
	function initialSession($user){
		session('uid', $user['id']);
		session('fullname', $user['first_name'].$user['last_name']);
		session('headImg', $user['headImg']);
	}
	function destorySession(){
		session(null);
	}

	//获取信息
	function getCurrentUserFullName(){
		return session('fullname');
	}
	function getCurrentUserId(){
		return session('uid');
	}
	function getHeadImageUrl(){
		return session('headImg');
	}
	//判断是否已登录
	function isLogin(){
		return session("?uid");
	}
	//*******************************************************************************

	//判断时间段是否存在冲突
	function isTimeConflict($usedStart, $usedEnd, $wantStart, $wantEnd){
		if((strtotime($wantStart)<strtotime($usedEnd))&&(strtotime($wantEnd)>strtotime($usedStart)))
			return true;
		else
			return false;
	}

	//******************************************************************************
	function initialCache(){
		if(!F('members')){
			$users = D('User');
			$results = $users->getAllMembers();
			$members = array();
			foreach ($results as $member) {
				$members[$member['id']] = $member['first_name'].$member['last_name']; 
			}
			F('members', $members);
		}

		;
		if(!F('departments')){
			$dp = D('Department');
			$results = $dp->getDepartments(true);
			$departments = array();
			foreach ($results as $department) {
				$departments[$department['id']] = $department['short_name'];
			}
			F('departments', $departments);
		}		

		
	}

	function destoryCache(){
		F('members', null);
		F('departments', null);
	}

	function getMemberName($ids){
		$members = F('members');
		// 字符串的情况
		if(is_string($ids)){
			if(strpos( $ids,",")){
				$ids = explode(",", $ids);
				$leaders = "";

				foreach ($ids as $k) {
					if(!$leaders)
						$leaders = $members[$k];
					else
						$leaders .= "、".$members[$k];
				}
				return $leaders;
			}
			else
				return $members[$ids];
		}
		// 数组的情况
		if(is_array($ids)){
			if(count($ids)==1)
				return $members[$ids];
			else{
				$leaders = "";

				foreach ($ids as $k) {
					if(!$leaders)
						$leaders = $members[$k];
					else
						$leaders .= "、".$members[$k];
				}
				return $leaders;
			}
		}
		
	}

	function getDepartmentName($id){
		$departments = F('departments');
		return $departments[$id];
	}



 ?>
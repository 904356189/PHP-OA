<?php
namespace OA\Model;
use Think\Model;

/**
* 用户定义类
*/
class UserModel extends Model
{		
	protected $_validate = array(
		array('username', 'required', '用户名不能为空！'),
		array('password', 'required', '密码不能为空！'),
		array('first_name', 'required', '姓不能为空！'),
		array('last_name', 'required', '名字不能为空！'),
		array('birthday', 'required', '生日不能为空！')
		);

	protected $_auto = array(
		array('update_time', 'time', 2, 'function'), //更新时写入当前时间戳
		array('password', 'md5', 3, 'callback'),
		);

	public function getFullName($id){
		$user = $this->where(array('id'=>$id))->field('first_name, last_name')->find();
		if($user){
			return $user['first_name'].$user['last_name'];
		}
		else
			return '';
	}

	public function getHolidays($id){
		$begin_work_date = $this->where(array('id'=>$id))->getField('begin_work_date');
		if($begin_work_date){
			$bwd = new \Org\Util\Date($begin_work_date);
			$years = $bwd.dateDiff(date('Y-m-d'), "y");
			if($years<10)
				return 5;
			else if($years>=10&&$years<15)
				return 10;
			else
				return 15;
		}
		else
			return -1;
	}

	public function login($username, $password){
		if($username&&$password){
			$where['username'] = $username;
			$where['password'] = md5($password);
			$user = $this->where($where)->find();
			if($user&&$user['is_active']){
				//initialSession($user['id'], $user['first_name'].$user['last_name'], $user['image_url']);
				$user['is_login'] = true;
				$user['login_count'] += 1;
				$user['last_login'] = date('Y-m-d H:i:s');
				$this->save($user);
				return $user;
			}
			else
				return null;
		}
		else
			return null;
	}

	public function logout($id){
		$user = $this->where(array('id'=>$id))->find();
		if($user){
			$user['is_login'] = false;
			$this->save($user);
			return true;
		}
		else
			return false;
	}

	public function getLeaders($all=false){
		$cond['b.name'] = '委领导';
		$cond['a.is_active'] = 1;
		$leaders = $this->table('oa_user a')
						->join('oa_department b on a.department_id = b.id', 'LEFT')
						->where($cond)
						->field('a.id, a.username, a.last_name, a.first_name, a.calendar_color')
						->select();
		if($all){
			$where['a.id'] = array('neq', 1);
			$where['b.is_active'] = 1;
			$departLeaders = $this->table('oa_department a')
								  ->join('oa_user b on a.leader_id = b.id', 'LEFT')
								  ->where($where)
								  ->field('b.id, b.username, b.last_name, b.first_name, b.calendar_color')
								  ->select();
			$leaders = array_merge($leaders, $departLeaders);								  
		}
		return $leaders;
	}

	// 获取领导的ID
	// all为true时，获取所有领导的ID，否则，仅获取委领导的ID
	public function getLeaderIds($all=false){
		$cond['b.name'] = '委领导';
		$cond['a.is_active'] = 1;
		$leaderIds = $this->table('oa_user a')
						->join('oa_department b on a.department_id = b.id', 'LEFT')
						->where($cond)
						->field('a.id')
						->select();
		if($all){
			$where['a.id'] = array('neq', 1);
			$where['b.is_active'] = 1;
			$departLeaderIds = $this->table('oa_department a')
								  ->join('oa_user b on a.leader_id = b.id', 'LEFT')
								  ->where($where)
								  ->field('b.id')
								  ->select();
			$leaderIds = array_merge($leaderIds, $departLeaderIds);								  
		}
		$Ids = array();
		foreach ($leaderIds as $leader) {
			$Ids[] = $leader['id'];
		}
		return $Ids;
	}

	//根据处室人员的ID获得处长信息
	public function getDepartLeader($staffId){
		//$department_id = $this->where('id=$staffId')->getField('department_id');
		$where['a.id'] = $staffId;
		$where['a.is_active'] = 1;
		$leaderId = $this->table('oa_user a')
			   		   	 ->join('oa_department b on a.department_id = b.id', 'LEFT')
					     ->where($where)
					     ->getField('b.leader_id');
		//$cond['id'] = $leaderId;
		return $this->table('oa_user')
					->where(array('id'=>$leaderId))
					->field('id, first_name, last_name')
					->find();
	}

	//根据部门ID获取部门成员信息
	//部门ID为0时，获取全委所有成员信息
	public function getStaff($departmentId=0, $exceptLeader=true){
		if ($departmentId) {
			$dp = M('Department');
			if($exceptLeader){
				$leaderId = $dp->where(array('id'=>$departmentId))->getField('leader_id');
				$where['id'] = array('neq', $leaderId);
			}
			$where['is_active'] = 1;
			$where['department_id'] = $departmentId; 
			return $this->where($where)->field('id, first_name, last_name')->select();
		}
		else{
			return $this->getAllMembers();
		}
	}

	//获取所有成员名单
	//isActive为true时获取所有激活状态用户，否则获取全体用户
	public function getAllMembers($isActive=true){
		if($isActive){
			$where['is_active'] = 1;
			return $this->where($where)->field('id, first_name, last_name')->select();
		}
		else
			return $this->field('id, first_name, last_name')->select();

	}

	/**
	 * 获取所有用户信息
	 * @param array $where
	 * @param string $field
	 * @param string $order
	 * @param int $page
	 * @param int $pageSize
	 * @return mixed
	 */
	public function getAll( $page = 1, $pageSize = 10, $where = array(), $field = "*", $order = "create_time DESC") {
		return $this->where($where)->field($field)->order($order)->page("{$page},{$pageSize}")->select();
	}

	/**
	 * 获取数据条数
	 * @param array $where
	 * @return mixed
	 */
	public function getCount( $where = array()) {
		return $this->where($where)->count();
	}
	
}
<?php
namespace OA\Controller;
use OA\Controller\BaseController;
class ReceptionController extends BaseController {

	//***********************************************************************************
	//一些内部处理的方法

	// 生成Rectption数据的方法
	private function createReceptionData(){
		$data = array(
			'vistor' => I('vistor'),
			'visit_content' => I('visit_content'),
			'visit_leader' => I('visit_leader'),
			'contact' => I('contact'),
			'phone' => I('phone'),
			'visitor_count' => I('visitor_count'),
			'begin_time' => I('begin_time'),
			'end_time' => I('end_time'),
			'major_department' => I('major_department'),
			'is_speech' => I('is_speech'),
			'is_meal' => I('is_meal'),
			'recorder_id' => getCurrentUserId()
			);
		//$data['vistor'] = I('vistor');
		if(!empty(I('assist_department'))){
			$data['assist_department'] = implode(",", I('assist_department'));
		}
		if(!empty(I('receptionist')))
			$data['receptionist'] = implode(",", I('receptionist'));
		if(!empty(I('reception_leader')))
			$data['reception_leader'] = implode(",", I('reception_leader'));
		if(!empty(I('view_place')))
			$data['visit_places'] = implode(",", I('view_place'));
		if(I('append_other_place')){
			if(I('other_place')){
				$vp = M('Viewplace');
				$place['name'] = I('other_place');
				$vpId = $vp->add($place);
				if($vpId){
					if($data['visit_places'])
						$data['visit_places'] .= ','.$vpId;
					else
						$data['visit_places'] = $vpId;
				}
					
			}
		}

		return $data;
	}

    // 生成房间预定数据
	private function getBookedData($receptionId){
		if($receptionId){
			$data = array();
			if(!empty(I('hall_start_time'))&&!empty(I('hall_end_time'))){
				$data[] = array(
					'room_id' => I('hall_id'),
					'event_type' => 'R',
					'event_id' => $receptionId,
					'begin_time' => I('hall_start_time'),
					'end_time' => I('hall_end_time'),
					'book_person' => getCurrentUserId()
					);
			}
			if(!empty(I('room_start_time'))&&I('room_end_time')){
				$data[] = array(
					'room_id' => I('room_id'),
					'event_type' => 'R',
					'event_id' => $receptionId,
					'begin_time' => I('room_start_time'),
					'end_time' => I('room_end_time'),
					'book_person' => getCurrentUserId()
					);
			}
			return $data;
		}
		else
			return null;
	}

    // 根据POST数据构造领导日程数据
    // 构造条件：勾选了create_schedule复选框
    private function createLeaderSchedule($receptionId){
        
        if(I('reception_leader')&&(I('create_schedule'))){
            $leaderList = I('reception_leader');
            $data = array();
            foreach ($leaderList as $k) {
                $data[] = array(
                    'title' => '接待'.I('vistor'),
                    'description' => '接待处室：'.getDepartmentName(I('major_department')),
                    'begin_time' => I('begin_time'),
                    'end_time' => I('end_time'),
                    'user_id' => $k,
                    'recorder_id' => getCurrentUserId(),
                    'source' => 'R',
                    'related_event_id' => $receptionId
                    );
            }
            return $data;
        }
        
    }

    // 向数据库添加领导日程记录
    // 添加成功：返回1；添加失败：返回错误信息
    private function addLeaderSchedule($data){
        if(!empty($data)){
            $sch = D('Schedule');
            foreach ($data as $k) {
                if($sch->create($k)){
                    $id = $sch->add();
                    if(!$id){
                        return $sch->getError();
                    }
                }
                else{
                    return $sch->getError();
                }
            }
            return 1;
        }
        
    }

	//************************************************************************************
	// 页面Action
    // 添加接待
    public function addReception(){
        $this->hasLogined();
        if(IS_GET){
            $vp = M('Viewplace');
            $this->assign('places', $vp->field('id, name')->select());
            $dp = M('Department');
            $where['id'] = array('neq', 1);
            $this->assign('departments', $dp->field('id, short_name')->where($where)->select());

            $this->display();
        }
        else if(IS_POST){
            $reception = $this->createReceptionData();
            $rp = D('Reception');

            //开始写入逻辑
            $rp->startTrans();
            //添加reception记录
            if(!$rp->create($reception)){
            	$rp->rollback();
            	$this->ajaxReturn($rp->getError());
            }
            else{
            	$receptionId = $rp->add();
            	if(!$receptionId){
            		$rp->rollback();
            		$this->ajaxReturn($rp->getError());
            	}
            }
           
            // 添加预定展厅，会议室情况
            $roomBookData = $this->getBookedData($receptionId);
            if($roomBookData){
            	$rb = M('RoomBooking');
            	foreach ($roomBookData as $k) {
            		$bookId = $rb->add($k);
            		if(!$bookId){
            			$rp->rollback();
            			$this->ajaxReturn($rb->getError());
            			break;
            		}
            	}
            }

            // 添加领导日程
            $schedules = $this->createLeaderSchedule($receptionId);
            $msg = $this->addLeaderSchedule($schedules);
            if($msg!=1)
                $this->ajaxReturn($msg);
            
            // 所有操作都正确，提交
        	$rp->commit();
        	$this->ajaxReturn(1);

        }
        
    }


    public function receptionForm(){

    	$vp = M('Viewplace');
    	$this->assign('places', $vp->field('id, name')->select());
    	
    	$dp = M('Department');
    	$where['id'] = array('neq', 1);
    	$this->assign('departments', $dp->field('id, short_name')->where($where)->select());

    	$room = M('Room');
    	$cond['name'] = array('neq', '展厅');
    	$this->assign('rooms', $room->where($cond)->select());

    	$users = D('User');
    	$this->assign('leaders', $users->getLeaders(true));

    	$this->assign('start', I('start'));
    	$this->assign('end', I('end'));
    	$this->display();

    }

    // 登记会议
    public function addMeeting(){
        $this->hasLogined();
        if(IS_GET){
            $this->display();
        }
        else if(IS_POST){
            $mt = D('Meeting');
            $this->ajaxReturn($mt->addMeeting());

        }
    }

    public function meetingForm(){
        $dp = M('Department');
        // $where['id'] = array('neq', 1);
        $this->assign('departments', $dp->field('id, short_name')->select());

        $room = M('Room');
        $cond['name'] = array('neq', '展厅');
        $this->assign('rooms', $room->where($cond)->select());

        $this->assign('start', I('start'));
        $this->assign('end', I('end'));
        $this->display();
    }

    public function bookRoom(){
        $this->hasLogined();
        $room = M('Room');
        $this->assign('rooms', $room->select());
        $this->display();
    }

    //**************************************************************************************
    // 以下是响应网页AJAX的方法
    // 获取日程安排，并在日历上显示
    public function getReception(){
    	$this->hasPermission(IS_AJAX);
    	$rp = D('Reception');
    	$this->ajaxReturn($rp->getReceptionCalendar());
        
    }

    // 根据已选择的接待处室，获取剩余处室
    public function getAssistDepartments(){
    	$this->hasPermission(IS_AJAX);
    	$exceptId = I('id');
    	$dp = D('Department');
    	$departments = $dp->getDepartmentsExcept($exceptId);
    	$this->ajaxReturn($departments);
    }

    // 获取接待人员列表
    public function getReceptionist(){
    	$this->hasPermission(IS_AJAX);
    	$ids = I('id');
        $exceptLeader = I('exceptLeader');
    	$users = D('User');
    	$staff = array();
    	if(is_array($ids)){
    		foreach ($ids as $id) {
    			$members = $users->getStaff($id, $exceptLeader);
    			$staff = array_merge($staff, $members);
    		}
    	}
    	$this->ajaxReturn($staff);
    }


    // 检测预约时间是否存在冲突
    public function checkTimeConflict(){
    	$this->hasPermission(IS_AJAX);
    	$wantStart = I('start');
    	$wantEnd = I('end');
    	$roomId = I('id');
    	$day = date('Y-m-d', strtotime($wantStart));
    	$rb = D('RoomBooking');
    	$receptions = $rb->getRoomSchedule($roomId,$day);
    	$conflictReceptions = array();
    	if($receptions){
    		foreach ($receptions as $item) {
    			if(isTimeConflict($item['start'], $item['end'], $wantStart, $wantEnd))
    				$conflictReceptions[] = $item;
    		}
    		if($conflictReceptions)
    			$this->ajaxReturn($conflictReceptions);
    		else
    			$this->ajaxReturn(-1);
    	}
    	else
    		$this->ajaxReturn(-1);
    }

    // 获取接待信息
    public function receptionInfo(){
    	$this->hasPermission(IS_AJAX);
    	$id = I('id');
    	$rp = D('Reception');
    	$reception = $rp->getReception($id);
    	if($reception){
    		$data['id'] = $reception['id'];
    		$data['vistor'] = $reception['vistor'];
    		$data['count'] = $reception['visitor_count'];
    		$vp = D('Viewplace');
    		$placeStr = $vp->linkPlaces($reception['visit_places']);
    		$data['visit_places'] = ($placeStr!=null)?$placeStr:"无";
    		if($reception['reception_leader'])
    			$data['leaders'] = getMemberName($reception['reception_leader']);
    		else
    			$data['leaders'] = "无";

    		if($reception['receptionist'])
    			$data['receptionist'] = getMemberName($reception['receptionist']);
    		else
    			$data['receptionist'] = "无";

    		$data['department'] = getDepartmentName($reception['major_department']);
    		$data['time'] = date("Y年n月j日 H:i", strtotime($reception['begin_time']))." - ".date('H:i', strtotime($reception['end_time']));
    		$rb = D('RoomBooking');
    		$bookedInfo = $rb->getRoomBookedInfo($reception['id'], 'R');
    		if($bookedInfo){
    			foreach ($bookedInfo as $k) {
    				if($k['name']=="展厅")
    					$data['hall'] = date('H:i', strtotime($k['begin_time']))." - ".date('H:i', strtotime($k['end_time']));
    				else
    					$data['meeting'] = date('H:i', strtotime($k['begin_time']))." - ".date('H:i', strtotime($k['end_time']));
    			}
    		}
    		$data['delete'] = $reception['recorder_id']==getCurrentUserId()?1:0;
    		$this->ajaxReturn($data);
    	}
    	else
    		$this->ajaxReturn(-1);
    }

    // 删除接待信息
    // 条件：接待记录添加人及其同处室人员可以删除
    // 同时删除相关展厅预定、会议室预定、领导日程记录
    public function delReception(){
        $this->hasPermission(IS_AJAX);
        $receptionId = I('id');
        if($receptionId){
            $rp = M('Reception');
            // 开始事务
            $rp->startTrans();

            // 检查并删除领导日程
            $rpLeaders = $rp->where(array('id'=>$receptionId))->getField('reception_leader');
            $sch = D('Schedule');
            $msg = $sch->delSchedules($rpLeaders, 'R', $receptionId);
            if(1!=$msg){
                $rp->rollback();
                $this->ajaxReturn($msg);
            }

            // 检查并删除场所预定情况
            $rb = D('RoomBooking');
            $msg = $rb->delRoomBookedInfo($receptionId, 'R');
            if(1!=$msg){
                $rp->rollback();
                $this->ajaxReturn($msg);
            }

            // 删除接待记录
            $msg = $rp->delete($receptionId);
            if(1!=$msg){
                $this->rollback();
                $this->ajaxReturn($rp->getError());
            }

            // 所有操作成功
            $rp->commit();
            $this->ajaxReturn(1);
        }
        else
            $this->ajaxReturn('接待ID错误！');
    }

    // 获取会议日历
    public function getMeeting(){
        $this->hasPermission(IS_AJAX);
        $mt = D('Meeting');
        $this->ajaxReturn($mt->getMeetingCalendar());
        
    }

    // 获取会议信息
    public function meetingInfo(){
        $this->hasPermission(IS_AJAX);
        $mt = D('Meeting');
        $id = I('id');
        $this->ajaxReturn($mt->getMeetingInfo($id));
    }

    // 获取各个房间的预定情况
    public function getRoomCalendar(){
        $this->hasPermission(IS_AJAX);
        $id = I('id');
        $rb = D('RoomBooking');
        $data = $rb->getRoomCalendar($id);
        $this->ajaxReturn($data);
    }

//*******************************************************************************************



    public function test(){
      
       p(__APP__);

    }




	//*****************************数据统计*************************//
	public function receptionStatics()
	{
		$this->hasLogined();
		$room = M('Room');
		$this->assign('rooms', $room->select());
		$this->display();
	}
}
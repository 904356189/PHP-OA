<?php
namespace OA\Controller;
use OA\Controller\BaseController;
class ScheduleController extends BaseController {

    public function leaderCalendar(){
        $this->hasLogined();
        $user = D('User');
        $leaders = $user->getLeaders(true);//获取处级以上领导
        $this->assign('leaders', $leaders);
        $this->display();
    }

    public function personalCalendar(){
        $this->hasLogined();
        $this->display();
    }

    //用于日程的初始化
    //有$id，表示获取该用户ID的所有日程
    //没有$id，表示获取所有领导的日程
    public function getEvents(){
        $this->hasPermission(IS_AJAX);
        
        $user_id = I('id');
        $leaderIds = I('ids');
        //p($leaderIds);
        $sch = D('Schedule');
        if(!empty($user_id)){
            $schedules = $sch->getSchedules($user_id, 'between', I('start'), I('end'));
        }
        else if(!empty($leaderIds)){
            //p($leaderIds);
            $schedules = $sch->getSchedulesForPeople($leaderIds, 'between', I('start'), I('end'));
        }
        else{
            $user = D('User');
            $ids = $user->getLeaderIds(true);
            $schedules = $sch->getSchedulesForPeople($ids, 'between', I('start'), I('end'));
        }
        
        foreach ($schedules as $sch) {
            $data[] = array(
                'id'=>$sch['id'],
                'title'=>$sch['title'],
                'start'=>$sch['start'],
                'end' => $sch['end'],
                'allDay'=>($sch['allDay']=='0')?false:true,
                'color'=>$sch['color']
                );
        }
        //p($schedules);
        $this->ajaxReturn($data);   
    }

    public function add(){
        $this->hasPermission(IS_AJAX);
        $sch = D('Schedule');

        if($sch->create()){
            $sch->add();
            $this->ajaxReturn(1);
        }
        else
            $this->ajaxReturn($sch->getError());
    }

    public function del(){
        $this->hasPermission(IS_AJAX);
        $id = I('id');
        $sch = M('Schedule');
        if(empty($id))
            $msg = '日程ID错误，请确认点击了正确的日程！';
        else{
            if($sch->delete($id))
                $msg = 1;
            else
                $msg = $sch->getError();
        }
        $this->ajaxReturn($msg);
       
    }
    public function edit(){
        $this->hasPermission(IS_AJAX);
        $sch = D('Schedule');
        if($sch->create()){
            if($sch->save())
                $this->ajaxReturn(1);
            else
                $this->ajaxReturn($sch->getError());
        }
        else
            $this->ajaxReturn($sch->getError());
        
    }
    public function getDescription(){
        $this->hasPermission(IS_AJAX);
        $id = I('id');
        $sch = M('Schedule');
        $description = $sch->where(array('id'=>$id))->getField('description');
        $this->ajaxReturn($description);
        
    }

    //拖拽操作，注意，为了自动填充，必须用D函数
    public function drop(){
        $this->hasPermission(IS_AJAX);
        $id = I('id');
        $sch = D('Schedule');
        $event = $sch->find($id);
        if($event){
            $event['begin_time'] = I('start');
            $event['end_time'] = I('end');
            $event['is_allday'] = (I('allDay')=="true")?1:0;
            if($sch->create($event, 2)){
                $sch->save();
                $this->ajaxReturn(1);
            }    
            else
                $this->ajaxReturn($sch->getError());
        }
        else
            $this->ajaxReturn('错误的日程ID');
       
    }

    // 获取日程信息，用于“领导日程”界面点击日程事件
    public function getEventInfo(){
        $this->hasPermission(IS_AJAX);
        $event_id = I('event_id');
        $sch = D('Schedule');
        $event = $sch->getScheduleInfo($event_id);
        if($event)
            $this->ajaxReturn($event);
        
    }

    public function addLeaderCalendar(){
        $this->hasLogined();
        $users = D('User');
        if(authCheck('CAN_ADD_ALL_LEADER_CALENDAR', getCurrentUserId())){
            $leaders = $users->getLeaders(true);
            $this->assign('leaders', $leaders);
        }
        if(authCheck('CAN_ADD_DEPART_LEADER_CALENDAR', getCurrentUserId())){
            $departLeader = $users->getDepartLeader(getCurrentUserId());
            $this->assign('departLeader', $departLeader);
        }

        $this->display();
        
    }


    public function test(){
        $users = D('User');
        
        p($users->getDepartLeader(getCurrentUserId()));
        // if($time)
        //     p('zero time is not false');
        // else
        //     p('zero time is false');

    }
}
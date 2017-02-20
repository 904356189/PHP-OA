<?php
namespace OA\Controller;
use OA\Controller\BaseController;
class IndexController extends BaseController {

    //设置每个日程的状态：p-过期，n-当前日程，f-将来日程
    //$formatTime为true时，格式化时间表示
    private function setSchduleState(&$schedules, $scheduleTimeStr){
        $isLastSchedulePass = true; //标志位，用于标示前一次日程状态
        $scheduleTime = strtotime($scheduleTimeStr);
        foreach ($schedules as &$k) {//有开始时间和结束时间
            $beginTime = strtotime($k['start']);
            if($k['end']){
                $endTime = strtotime($k['end']);
                if($scheduleTime>$endTime)
                    $k['state'] = 'p';
                else if($scheduleTime<$endTime&&$scheduleTime>$beginTime)
                    $k['state'] = 'n';  
                else
                    $k['state'] = 'f';  
            }
            else{//只有开始时间
                if($beginTime>$scheduleTime&&$isLastSchedulePass)
                    $k['state'] = 'n';
                if($beginTime>$scheduleTime&&!$isLastSchedulePass)
                    $k['state'] = 'f';
                if($beginTime<$scheduleTime)
                    $k['state'] = 'p';
            }
            $isLastSchedulePass = ($k['state']=='p')?true:false;
        }
    }

    public function index(){
        $d = M('Duty');
        $l = M('Level');
        $depart = M('Department');
        $this->assign('departments', $depart->field('id, name')->select());
        $this->assign('levels', $l->field('id, name')->select());
        $this->assign('duties', $d->field('id, name')->select());
        $this->display();
        
    }

    public function login(){
    	if (IS_GET) {
    		$this->redirect('Index/index');
    	} 
    	else if(IS_POST){
    		$users = D('User');
            $user = $users->login(I('username'), I('password'));
            if($user){
                initialSession($user);
                $this->redirect('Index/main');
            }    
            else
                $this->error('用户名或密码不正确！');
    	}
    }

    public function logout(){
        if(isLogin()){
            $user = D('User');
            if($user->logout(getCurrentUserId())){
                destorySession();
                destoryCache();
                $this->redirect('Index/index');
            }
                
        }
        else
            $this->redirect('Index/index');
        
    }

    public function register(){
        dump($_POST);
    }

    public function main(){
        $this->hasLogined();
        //CBD每日一言
        $saying = D('Saying');
        $this->assign('saying', $saying->getRandom());

        //日程
        $schedule = D('Schedule');
        $scheduleTimeStr = date('Y-m-d H:i');
        $schedules = $schedule->getLeaderScheduleForMain($scheduleTimeStr, true);
        foreach ($schedules as &$sch) {
            $this->setSchduleState($sch['data'], $scheduleTimeStr);
        }
        $this->assign('schedules', $schedules);

        $this->display();
        // foreach ($schedules as $s) {
        //     p($s['data']);
        // }
    }

    public function test(){
        $schedule = D('Schedule');
        $schedules = $schedule->getLeaderScheduleFor(date('Y-m-d H:i'), true);
        foreach ($schedules as &$sch) {
            $this->setSchduleState($sch['data'], date('Y-m-d H:i'));
        }
        foreach ($schedules as $k) {
            dump($k['data']);
        }
    }
}
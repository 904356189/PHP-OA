<?php
/**
 * Created by PhpStorm.
 * User: Rg
 * Date: 2017/2/14
 * Time: 14:19
 */

namespace OA\Controller;
use OA\Controller\BaseController;


class VacationController extends BaseController {
    /**
     * 请休假申请
     */
    public function addVacation() {
        $this->display();
    }


    /**
     * 请休假申请查询
     */
    public function search() {
        $this->display();
    }



    /**
     * 数据统计
     */
    public function statics() {
        $this->display();
    }
}
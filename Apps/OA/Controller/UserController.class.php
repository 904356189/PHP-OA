<?php
/**
 * Created by PhpStorm.
 * User: Rg
 * Date: 2017/2/15
 * Time: 9:24
 */

namespace OA\Controller;
use OA\Controller\BaseController;


class UserController extends BaseController {
    /**
     * 个人资料
     */
    public function profile() {
        $this->display();
    }
}
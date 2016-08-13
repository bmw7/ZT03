<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 设置栏目
// +--------------------------------------------

class SettingController extends AuthController {
    public function index(){
		$this->display();
    }
}
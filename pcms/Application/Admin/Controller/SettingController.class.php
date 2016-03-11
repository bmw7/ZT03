<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class SettingController extends AuthController {
    public function index(){
		$this->display();
    }
}
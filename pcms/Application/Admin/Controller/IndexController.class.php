<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class IndexController extends AuthController {
    public function index(){
    	$info = session("login");
    	$this->assign('id',$info[4]);
		$this->display();
    }
    
    public function welcome(){
    	$info = session("login");
    	$this->assign('username',$info[0]);
    	$this->assign('login_count',$info[1]);
    	$this->assign('login_date',$info[2]);
    	$this->assign('login_address',$info[3]);
    	$this->display();
    }
}
<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 后台管理首页
// +--------------------------------------------

class IndexController extends AuthController {
	
	/** 
	 * 后台管理页面框架 - 左侧和上侧边栏 
	 * $info 为 管理账号session - 来自LoginController(submit方法)
	 * */
    public function index(){
    	$info = session("login");
    	$this->assign('id',$info[4]);
		$this->display();
    }
    
    /** 后台首页 - 欢迎页面  */
    public function welcome(){
    	$info = session("login");
    	$this->assign('username',$info[0]);
    	$this->assign('login_count',$info[1]);
    	$this->assign('login_date',$info[2]);
    	$this->assign('login_address',$info[3]);
    	
    	$guestbook = M('guestbook'); // 实例化User对象
    	$count = $guestbook->where("reply_content is null")->count();
    	$this->assign('count',$count);
    	
    	$this->display();
    }
}
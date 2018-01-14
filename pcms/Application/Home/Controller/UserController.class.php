<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 用户操作
// +--------------------------------------------

class UserController extends Controller {
	
	public function register(){
		$this->display();
	}
	
	
	public function save(){
		$User = M('user');
		$User->create();
		if($User->add()){
			$this->ajaxReturn("注册成功！");
		}else{
			$this->ajaxReturn("注册失败！");
		}
	}
	
	// 手机号唯一性判断
	public function only(){	
		$User = M('user');
		
		if(false != $User->where('phone = '.'"'.I('post.phone').'"')->select()){
			$this->ajaxReturn("occupied");
		}else{
			$this->ajaxReturn("disengaged");
		}
		
	}
	
	// 登录页面
	public function login(){
		$this->display();
	}
	
	// 登录提交
	public function login_submit(){
		$User = M('user');
		$password = $User->where('phone = '.'"'.I('post.phone').'"')->getField('password');
		if($password == I('post.password')){
			
			$info = $User->where('phone = '.'"'.I('post.phone').'"')->select();
			$info = $info[0];
			session('info',$info);	
			$this->ajaxReturn("success");
		}else{
			$this->ajaxReturn("failed");
		}
		
	}
	
	// 登录成功
	public function user(){
		if(null != session('info')){
			$info = session('info');
			$this->assign('pwd',$info["password"]);
			$this->display();
		}else{
			$this->redirect('index');
		}
		
	}
	
	
	// 注销
	public function logout(){
		session('info',null);
		$this->redirect('/index');		
	}
	
}
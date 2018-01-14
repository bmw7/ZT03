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
		$User->add();
	}
	
	
	public function only(){	
		$User = M('user');
		$id = $User->where('username = '.I('post.username'))->getField('id');
		//if($id != null){
			$this->ajaxReturn('false');
		//}
		
	}
	
	public function login(){
	
	}
	
}
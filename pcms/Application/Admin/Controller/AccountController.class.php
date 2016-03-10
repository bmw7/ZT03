<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 管理账号
// +--------------------------------------------

class AccountController extends AuthController {
    
    /** 账号列表  */
	public function index(){
		$Account = M('Account');
		$this->assign("accounts",$Account->where('id != 1')->select());
		$this->display();
    }
}
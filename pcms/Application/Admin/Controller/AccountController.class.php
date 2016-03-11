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
		$this->assign('sid',session('login')[4]);
		$this->display();
    }
    
    /** 添加账号  */
    public function save(){
    	$Account = M('Account');
    	$Account->create();
    	
    	$CryptService = A('Crypt','Service');
    	$Account->password = $CryptService->work(I('post.password')); // 前台传递密码加密
    	
    	if ($Account->add()){
    		$this->success('添加成功',U('admin/account/index'));
    	}else {
    		$this->error('添加失败',U('admin/account/index'));
    	}
    }
    
    /** 编辑账号  */
    public function edit(){
    	$Account = M('Account');
    	$att = $Account->where("id = '%d'",I('get.id'))->select();
    	$this->assign('account',$att[0]);
    	$this->display();
    }
    
    /** 更新账号  */
    public function update(){
    	$Account = M('Account');
    	$Account->create();
    	
    	if (I('post.newPassword') != ''){
    		$CryptService = A('Crypt','Service');
    		$Account->password = $CryptService->work(I('post.newPassword')); // 前台传递密码加密
    	}
    	
    	if ($Account->save()){
    		$this->success('更新成功',U('admin/account/index'));
    	}else {
    		$this->error('更新失败',U('admin/account/index'));
    	}
    }
    
}
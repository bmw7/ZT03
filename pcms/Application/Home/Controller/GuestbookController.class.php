<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 留言管理
// +--------------------------------------------

class GuestbookController extends Controller {

	/** 留言提交  */
	public function save(){
		$guestbook = M('guestbook');
		$guestbook->create();
		$guestbook->create_date = Date('Y-m-d H:i:s');
		if ($guestbook->add()){
			$this->success("操作成功",U('guestbook/add'));
		}else{
			$this->error("操作失败",U('guestbook/add'));
		}
	}
	

	
}
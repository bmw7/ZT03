<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 标签管理
// +--------------------------------------------

class TagController extends AuthController{
	
	/** 展示  */
	public function index(){
		$group = M('tag_group');
		$this->assign("groups",$group->select());
		$this->display();
	}
	
	public function add_group(){
		$db = M('tag_group');
		$db->create();
		if ($db->add()) {
			$this->success("添加成功!",U('admin/tag/index'));
		}else {
			$this->error("添加失败",U('admin/tag/index'));
		}
	}
	
	public function add_tag(){
		$db = M('tag');
		$db->create();
		if ($db->add()) {
			$this->success("添加成功!",U('admin/tag/index'));
		}else {
			$this->error("添加失败",U('admin/tag/index'));
		}
	}
    
}







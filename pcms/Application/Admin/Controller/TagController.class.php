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
	
	/** 添加标签组  */
	public function add_group(){
		$db = M('tag_group');
		$db->create();
		if ($db->add()) {
			$this->success("添加成功!",U('admin/tag/index'));
		}else {
			$this->error("添加失败",U('admin/tag/index'));
		}
	}
	
	/** 添加标签  */
	public function add_tag(){
		$db = M('tag');
		$db->create();
		if ($db->add()) {
			$this->success("添加成功!",U('admin/tag/index'));
		}else {
			$this->error("添加失败",U('admin/tag/index'));
		}
	}
	
	/** 删除标签  */
	public function del(){
		$db = M('tag');
		if($db->delete(I('get.id'))){
			$this->success("操作成功!",U('admin/tag/index'));
		}
	}
	
	/** 删除标签组  */
	public function del_group(){
		$group_id = I('get.id');
		$group = M('tag_group');
		$tag = M('tag');
		$group->delete($group_id);
		$tag->where("group_id = ".$group_id)->delete();
		
		$this->success("操作成功!",U('admin/tag/index'));		
	}
    
}







<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 文章分类
// +--------------------------------------------

class CategoryController extends AuthController{
	
	/** 展示  */
	public function index(){
		$categoryService = A('Category','Service');
		$this->assign("tree",$categoryService->getTree('Category'));
		$this->display();
	}
	
	/** 添加  */
	public function add() {
		$categoryService = A('Category','Service');
		$this->assign("tree",$categoryService->getTree('Category'));
		$this->display();
	}
	
	/** 保存  */
	public function save(){
		$category = M('category');
		$category->create();
		$category->add();
	}
	
	/** 编辑  */
	public function edit() {
		$category = M('category');
		$this->assign("current",$category->find(I('get.id')));
		$this->display();
	}
	
	/** 更新  */
	public function update(){
		$category = M('category');
		$category->create();
		$category->save();
	}
	
	/** 删除  */
	public function del(){
		$category = M('category');
		$category->delete(I('get.id'));
	}
	
}
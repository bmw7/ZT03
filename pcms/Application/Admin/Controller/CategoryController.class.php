<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class CategoryController extends AuthController{
		
	public function index(){
		$category = A('Category','Service');
		$this->assign("tree",$category->getTree('Category'));
		$this->display();
	}
	
	public function add() {
		$category = A('Category','Service');
		$this->assign("tree",$category->getTree('Category'));
		$this->display();
	}
	
	public function save(){
		$category = M('category');
		$category->create();
		$category->add();
	}
	
}
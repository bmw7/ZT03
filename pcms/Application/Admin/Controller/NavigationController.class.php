<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 导航栏目
// +--------------------------------------------

class NavigationController extends AuthController{
	
	/** 展示  */
	public function index(){      
        $categoryService = A('Category','Service');
        $this->assign("tree",$categoryService->getTree('Navigation'));
        $this->display();
    }
    
    /** 保存  */
    public function save(){
    	$Navigation = M('Navigation');
    	$Navigation->create();
    	$Navigation->add();
    }
    
    /** 编辑  */
    public function edit() {
    	$Navigation = M('Navigation');
    	$this->assign("current",$Navigation->find(I('get.id')));
    	$this->display();
    }
    
    /** 更新  */
    public function update(){
    	$Navigation = M('Navigation');
    	$Navigation->create();
    	$Navigation->save();
    }
    
    /** 删除  */
    public function del(){
    	$Navigation = M('Navigation');
    	$Navigation->delete(I('get.id'));
    }
    

}
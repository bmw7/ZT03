<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------------------
// | Controller - 导航栏目 - 为自由定义前台页面 菜单/导航 项目而设置
// +--------------------------------------------------------

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
    	if ($Navigation->add()){
    		$this->redirect('/admin/navigation');
    	}else{
    		$this->error('操作失败',U('/admin/navigation'));
    	}
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
        if ($Navigation->save()){
    		$this->redirect('/admin/navigation');
    	}else{
    		$this->error('操作失败',U('/admin/navigation'));
    	}
    }
    
    /** 删除  */
    public function del(){
    	$Navigation = M('Navigation');
    	$id = I('get.id');
    	
    	if ($Navigation->delete($id)){
    		$this->redirect('/admin/navigation');
    	}else{
    		$this->error('操作失败',U('/admin/navigation'));
    	}
    }
    

}
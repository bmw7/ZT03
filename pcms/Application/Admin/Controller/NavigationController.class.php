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
    		
    		$id = $Navigation->getLastInsID();
    		$Navigation->orders = $id;
    		$Navigation->where('id = '.$id)->save();
    		
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
    	$att = $Navigation->where('parent_id = '.$id)->select();
    	
    	
    	// 判断有子项目则不能删除。否则删除
    	if (count($att) > 0){
    		$this->error('操作失败！该分类下尚有子分类！',U('/admin/article/manage'));
    	}else{
    		if($Navigation->delete($id)){
    			$this->redirect('/admin/navigation');
    		}else{
    			$this->error('操作失败！',U('/admin/navigation'));
    		}
    	}

    }
    
    
    /** 分类移动  */
    public function category_move(){
    	$category = M('navigation');
    		
    	$originId = I('post.originId');
    	$originOrders = I('post.originOrders');
    
    	$changeId = I('post.changeId');
    	$changeOrders = I('post.changeOrders');
    
    	$category->orders = $originOrders;
    	$category->where('id ='.$changeId)->save();
    		
    	$category->orders = $changeOrders;
    	$category->where('id ='.$originId)->save();
    }
    
    
    

}
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
		if ($category->add()){
			
			$id = $category->getLastInsID();
			$category->orders = $id;
			$category->where('id = '.$id)->save();
			
			$this->redirect('/admin/article/manage');
		}else{
			$this->error('操作失败！',U('admin/article/manage'));
		}
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
		if($category->save()){
			$this->redirect('/admin/article/manage');
		}else{
			$this->error('操作失败！',U('/admin/article/manage'));
		}
	}
	
	/** 删除  */
	public function del(){
		$category = M('category');
		$id = I('get.id');
		$att = $category->where('parent_id = '.$id)->select();
		
		// 判断有子项目则不能删除。否则删除
		if (count($att) > 0){
			$this->error('操作失败！该分类下尚有子分类！',U('/admin/article/manage'));
		}else{
			if($category->delete($id)){
				$this->redirect('/admin/article/manage');
			}else{
				$this->error('操作失败！',U('/admin/article/manage'));
			}
		}

	}
	
	
	/** 分类移动  */
	public function category_move(){
		$category = M('category');
		 
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
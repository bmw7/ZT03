<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 文章展示
// +--------------------------------------------

class ArticleController extends Controller {

	/** 展示 单篇类 文章  */
	public function show(){
		$id = I('get.doc');
		$db = M('Article');
		$article = $db->where('id = '.$id)->select();
		$this->assign('article',$article[0]);
		$this->display();
	}
	
	
	/** 展示 多篇类 文章  */
	public function shows(){
		$id = I('get.docs');
		$db = M('Article');
		$article = $db->where('id = '.$id)->select();
		$this->assign('article',$article[0]);
		$this->display();
	}
	
	/** 展示 多篇类 文章  */
	public function shows(){
		$id = I('get.docs');
		$db = M('Article');
		$article = $db->where('id = '.$id)->select();
		$this->assign('article',$article[0]);
		$this->display();
	}
	
	
}
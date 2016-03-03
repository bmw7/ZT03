<?php
namespace Admin\Controller;
use Admin\Common\AuthController;
class ArticleController extends AuthController{
	
	/** 添加页面*/
    public function add(){
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Category'));
    	$this->display();
    }
    
    /** 添加-保存  */
    public function save(){
        $Article = M('article');
        $Article->create();
        $Article->add();       
    }
    
}







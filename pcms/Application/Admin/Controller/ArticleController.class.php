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
        $att['title'] = I('post.title');
        $att['content'] = I('post.content');
        $att['create_date'] = Date('Y-m-d H:i:s');
        $att['category_id'] = I('post.category_id');
        $att['source'] = I('post.source');
        $att['seo_keywords'] = I('post.seo_keywords');
        $att['seo_description'] = I('post.seo_description');
        if ($Article->add($att)){
        	$this->success('添加成功！',U('admin/article/add'));
        }else{
        	$this->redirect(U('admin/article/add'), 3, '操作失败！页面跳转中...');
        }
        
    }
    
}







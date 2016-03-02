<?php
namespace Admin\Controller;
use Admin\Common\AuthController;
class ArticleController extends AuthController{
    public function add(){
        $this->display();
    }
    
    /**
     * 添加文章
     * */
    public function save(){
        $Article = M('article');
        $Article->create();
        $Article->add();       
    }
    
}







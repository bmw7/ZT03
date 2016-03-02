<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class NavigationController extends AuthController{
    public function index(){      
        $category = A('Category','Service');
        $this->assign("tree",$category->getTree('Navigation'));
        $this->display();
    }
    
    public function edit(){
        
    }
    

}
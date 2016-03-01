<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

class NavigationController extends AuthController{
    public function show(){      
        $service = A('Navigation','Service');
        $service->getTree();
        //$this->assign("tree",$service->getTree());
        $this->display();
    }
    
    public function edit(){
        
    }
    

}
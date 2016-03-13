<?php
namespace Admin\Common;
use Think\Controller;

class AuthController extends Controller{
    public function _initialize(){
        if(session('login') == null){
            $this->error("没有访问权限",U('./admin/login'));
        }
    }
}

?>
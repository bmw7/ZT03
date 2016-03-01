<?php
namespace Admin\Controller;
use Admin\Common\AuthController;
class LoginController extends AuthController{
    public function index(){
        $this->display();
    }
    

    
    public function verify(){
        $config =    array(
            'fontSize'    =>    34,    // 验证码字体大小
            'length'      =>    5,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
        );
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }
    
    
}
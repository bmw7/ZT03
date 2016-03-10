<?php
namespace Admin\Controller;

class LoginController extends Controller{
    public function index(){
        $this->display();
    }
    
    /** 登陆  */
    public function submit(){
    	$username = I('post.username');
    	$password = I('post.password');
    	
    	$Account = M('Account');
    	$password_db = $Account->where('username = '.$username)->getField('password');
    	
    	$CryptService = A('Crypt','Service');
    	$password_cr = $CryptService->work($password);
    	
    	if ($password_db == $password_cr){
    		
    	}
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
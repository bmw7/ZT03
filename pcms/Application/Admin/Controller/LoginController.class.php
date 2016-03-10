<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
    public function index(){
        $this->display();
    }
    
    /** 登陆  */
    public function submit(){
    	$username = I('post.username');
    	$password = I('post.password');
    	
     	$Account = M('Account');
     	$att = $Account->where("username = '%s'",$username)->select();
    	
    	if (count($att) == 1){
    		$password_db = $att[0][password]; // 数据库中存储密码
    		$CryptService = A('Crypt','Service');
    		$password_cr = $CryptService->work($password); // 前台传递密码加密
    		
    		// 密码校验通过
    		if ($password_db == $password_cr){
    			
    			$info = array();
    			array_push($info, $username);
    			array_push($info, $att[0]['login_count']+1);
    			array_push($info, $att[0]['login_date']);
    			array_push($info, $att[0]['login_address']);
    			session('login',$info);
    			
    			$att[0]['login_address'] = I('post.address');
    			$att[0]['login_count'] += 1;
    			$att[0]['login_date'] = date('Y-m-d H:i:s');
    			  			
    			$Account->save($att[0]);
    			$this->ajaxReturn("");
    		}
    	}

    	$this->ajaxReturn("failed");
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
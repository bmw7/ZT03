<?php
namespace Admin\Controller;
use Think\Controller;
// +--------------------------------------------
// | Controller - 登陆操作
// +--------------------------------------------
class LoginController extends Controller{
    public function index(){
        $this->display();
    }
    
    /** 登陆  */
    public function submit(){
    	// 获取登陆用户名和密码
    	$username = I('post.username');
    	$password = I('post.password');
    	
     	$Account = M('Account');
     	
     	// 根据登陆用户账号,获取登陆用户对象数组 $user
     	$user = $Account->where("username = '%s'",$username)->select();
    	
    	// 若登陆用户对象存在
    	if (count($user) == 1){
    		$password_db = $user[0][password]; // 数据库中存储密码
    		$CryptService = A('Crypt','Service');
    		$password_cr = $CryptService->work($password); // 前台传递密码加密
    		
    		// 密码校验通过
    		if ($password_db == $password_cr){
    			
    			$info = array();
    			array_push($info, $username);
    			array_push($info, $user[0]['login_count']+1);
    			array_push($info, $user[0]['login_date']);
    			array_push($info, $user[0]['login_address']);
    			array_push($info, $user[0]['id']);
    			
    			// 将登陆用户对象信息加入session
    			session('login',$info);
    			
    			$user[0]['login_address'] = I('post.address');
    			$user[0]['login_count'] += 1;
    			$user[0]['login_date'] = date('Y-m-d H:i:s');
    			  			
    			$Account->save($user[0]);
    			$this->ajaxReturn("index");
    		}
    	}

    	$this->ajaxReturn("failed");
    }

    /** 验证码  */
    public function verify(){
        $config =    array(
            'fontSize'    =>    34,    // 验证码字体大小
            'length'      =>    5,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
        );
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }
    
    /** 验证码验证  */
    public function check_verify(){
    	$verify = new \Think\Verify();
    	if (!$verify->check(I('post.verify'))){
    		$this->ajaxReturn("wrong");
    	} 
    }
    
    /** 退出  */
    public function logout(){
    	session("login",null);
    	$this->success("退出成功",U('./admin/login'));
    }
}
<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	// 获取一级二级导航菜单
    	$Navigation = M('Navigation');
    	$menu = $Navigation->where('grade = 1')->order('orders asc')->select();
    	foreach ($menu as $k => $v){
    		// 添加subs二级导航菜单变量
    		$subs = $Navigation->where('parent_id = '.$menu[$k]['id'])->order('orders asc')->select();
    		if (count($subs) > 0){
    			$menu[$k]['subs'] = $subs;
    		}	
    	}
    	
    	$this->assign('menu',$menu);
    	$this->display();
    }
    
    public function index_show(){
    	$this->display();
    }
    
    
    // 安装数据库
    public function install_database(){
    	$link = mysql_connect(C('DB_HOST'), C('DB_USER'), C('DB_PWD'));
    	$result = mysql_select_db(C('DB_NAME'), $link); // 若存在，则值为 1

    	// 数据库不存在，创建
    	if ($result != 1){  
    		// 该句必加。否则乱码
    		mysql_query("SET NAMES utf8");
    		
    		mysql_query("CREATE DATABASE ".C('DB_NAME'));
    		mysql_query("USE ".C('DB_NAME'));
    		
    		$_sql = file_get_contents('database.sql');	
    		$_arr = explode(';', $_sql);
    		
    		//执行sql语句
    		foreach ($_arr as $_value) {
    			mysql_query($_value.';');
    			echo explode('(', $_value)[0].'  安装完毕<br>';
    		}
	
    	}else{
    		echo '<h1>数据库已经存在。本操作系统已经记录，请勿再尝试。</h1>';
    	}
    }
    
}
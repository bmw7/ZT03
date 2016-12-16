<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){     
    	$this->display();
    }
    
    public function show(){
    	$this->display();
    }
    
    // 安装数据库
    /*
    public function install(){
    	$link = mysql_connect(C('DB_HOST'), C('DB_USER'), C('DB_PWD'));
    	$result = mysql_select_db(C('DB_NAME'), $link); // 若存在，则值为 1
    
    	// 数据库不存在，创建
    	if ($result == 1){
    		// 该句必加。否则乱码
    		mysql_query("SET NAMES utf8");
    
    		//mysql_query("CREATE DATABASE ".C('DB_NAME'));
    		mysql_query("USE ".C('DB_NAME'));
    
    		$_sql = file_get_contents('database.sql');
    		$_arr = explode(';', $_sql);
    
    		//执行sql语句
    		foreach ($_arr as $_value) {
    			mysql_query($_value.';');
    			echo explode('(', $_value)[0].'  安装完毕<br>';
    		}
    
    	}else{
    		echo '<h1>没有安装 </h1>';
    	}
    }*/
    
    
    // 数据恢复
    /*
    public function backup(){
    	$start = I('get.start');
    	$cid = I('get.cid');
    	 
    	 
    	$Article = M('Article');
    
    	$link = mysql_connect('rdss826cy1y4at8og84ro.mysql.rds.aliyuncs.com', 'zhangtao', 'Zhangtao2015');
    	$result = mysql_select_db('wenzhou', $link); // 若存在，则值为 1
    	mysql_query("SET NAMES utf8");
    
    	$count = mysql_fetch_array(mysql_query("select count(*) from article where articleCategoryId = ".$cid));
    	 
    	$result = mysql_query("select * from article where articleCategoryId = ".$cid." order by id asc limit ".$start.",50");
    
    	while($rs = mysql_fetch_array($result)){
    		$data['title'] = $rs['title'];
    		$data['create_date'] = $rs['createDate'];
    		$data['content'] = $rs['content'];
    		$data['category_id'] = $cid;
    		$data['category_url'] = 'docs';
    		$data['seo_keywords'] = $rs['seoKeywords'];
    		$data['seo_description'] = $rs['seoDescription'];
    		$Article->add($data);
    	}
    	 
    	$this->assign('count',$count[0]);
    	$this->assign('end',$start+50);
    	$this->display();
    	 
    }*/
    
    
    
    
    
    
    
    
    
    
    
    
}
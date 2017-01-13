<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	// 实例化对象
    	$article = M('article'); 
    	$article_image = M('article_image');
    	
    	// 展示顶部导航菜单
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Navigation'));
    	
    	// 律师团队
    	$lawyers = $article->where('category_id = 1')->order('id asc')->limit(5)->select();
    	foreach ($lawyers as $k => $v){
    		// 添加新成员 image
    		$lawyers[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
    	}
    	$this->assign('lawyers',$lawyers);
    	
    	// 业务领域
    	$business = $article->where('category_id = 2')->order('id desc')->limit(9)->select();
    	$this->assign('business',$business);
    	
    	// 媒体报道
    	$media = $article->where('category_id = 3')->order('id desc')->limit(9)->select();
    	$this->assign('media',$media);
    	    
    	// 经典案例
    	$examples = $article->where('category_id = 4')->order('id desc')->limit(9)->select();
    	$this->assign('examples',$examples);
    	
    	// 文书范本
    	$paper = $article->where('category_id = 5')->order('id desc')->limit(9)->select();
    	$this->assign('paper',$paper);
    	
    	// 维权技巧
    	$defends = $article->where('category_id = 6')->order('id desc')->limit(9)->select();
    	$this->assign('defends',$defends);
    	 
    	// 法律法规
    	$rules = $article->where('category_id = 7')->order('id desc')->limit(9)->select();
    	$this->assign('rules',$rules);
    	
    	$article_ids = M('article_tag')->where('tag_id = 1')->getField('article_id',true);
    	
    	if (count($article_ids) > 0){
    		$list  = $article->where(array('id'=>array('IN',$article_ids)))->order('create_date desc')->limit(1)->select();
    	}else{
    		$list = array();
    	}
    	
    	$headline = $list[0];
    	$headline['content'] = strip_tags($headline['content']);
    	$this->assign('headline',$headline);
    	
    	// 友情链接
    	$links_db = M('links');
    	$links = $links_db->order('orders asc')->select();
    	$this->assign('links',$links);
    	
    	$this->display();
    }
    
    
    // 数据恢复
    /*
    public function backup(){
    	$start = I('get.start');
    	$cid = I('get.cid');
    	
    	
    	$Article = M('Article');
    	 
    	$link = mysql_connect('rdss826cy1y4at8og84ro.mysql.rds.aliyuncs.com', 'zhangtao', 'Zhangtao2015');
    	$result = mysql_select_db('wzxbls', $link); // 若存在，则值为 1
    	mysql_query("SET NAMES utf8");
    	 
    	$count = mysql_fetch_array(mysql_query("select count(*) from article where articleCategoryId = ".$cid));
    	
    	$result = mysql_query("select * from article where articleCategoryId = ".$cid." order by id asc limit ".$start.",50");
    	 
    	while($rs = mysql_fetch_array($result)){
    		$data['title'] = $rs['title'];
    		$data['create_date'] = $rs['createDate'];
    		$data['content'] = $rs['content'];
    		$data['category_id'] = $cid;
    		$data['category_url'] = 'docs';
    		$Article->add($data);
    	}
    	
    	$this->assign('count',$count[0]);
    	$this->assign('end',$start+50);
    	$this->display();
    	
    }
    
    // 数据恢复
    public function backups(){
    	$start = I('get.start');
    	$cid = I('get.cid');
    	$oid = I('get.oid');
    	 
    	 
    	$Article = M('Article');
    
    	$link = mysql_connect('rdss826cy1y4at8og84ro.mysql.rds.aliyuncs.com', 'zhangtao', 'Zhangtao2015');
    	$result = mysql_select_db('wzxbls', $link); // 若存在，则值为 1
    	mysql_query("SET NAMES utf8");
    
    	$count = mysql_fetch_array(mysql_query("select count(*) from article where articleCategoryId = ".$oid));
    	 
    	$result = mysql_query("select * from article where articleCategoryId = ".$oid." order by id asc limit ".$start.",50");
    
    	while($rs = mysql_fetch_array($result)){
    		$data['title'] = $rs['title'];
    		$data['create_date'] = $rs['createDate'];
    		$data['content'] = $rs['content'];
    		$data['category_id'] = $cid;
    		$data['category_url'] = 'docs';
    		$Article->add($data);
    	}
    	 
    	$this->assign('count',$count[0]);
    	$this->assign('end',$start+50);
    	$this->display();
    	 
    }
    
    
    // 数据恢复
    public function del(){
    	$num = I('get.num');
    	$cid = I('get.cid');
    	 
    	 
    	$Article = M('Article');
    
		$Article->where('category_id = '.$cid)->order('id desc')->limit($num)->delete();
    	 
    	$this->display();
    	 
    }
    
    
    public function show(){
    	$this->display();
    }
    
    
    // 安装数据库
    public function install_database(){
    	$link = mysql_connect(C('DB_HOST'), C('DB_USER'), C('DB_PWD'));
    	$result = mysql_select_db(C('DB_NAME'), $link); // 若存在，则值为 1
    
    	// 有数据库，执行建表语句
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
    		echo '<h1>数据库不存在或操作失败</h1>';
    	}
    }
    
    
    // article表操作
    public function install_article(){
    	$link = mysql_connect(C('DB_HOST'), C('DB_USER'), C('DB_PWD'));
    	$result = mysql_select_db(C('DB_NAME'), $link); // 若存在，则值为 1
    
    	// 数据库不存在，创建
    	if ($result == 1){
    		// 该句必加。否则乱码
    		mysql_query("SET NAMES utf8");
    
    		mysql_query("USE ".C('DB_NAME'));
    		mysql_query("DROP TABLE tp_article");
    
    		$_sql = file_get_contents('article.sql');
    		$_arr = explode(';', $_sql);
    
    		//执行sql语句
    		foreach ($_arr as $_value) {
    			mysql_query($_value.';');
    			echo explode('(', $_value)[0].'  安装完毕<br>';
    		}
    
    	}else{
    		echo '<h1>数据库已经存在。本操作系统已经记录，请勿再尝试。</h1>';
    	}
    }*/
    
}
<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {

	//返回json数据格式
	public function json(){
		header('Access-Control-Allow-Origin:*');
		$Article = M('article');
		$catid = I('get.catid');
		$page = I('page');
		$data = $Article->where('category_id = '.$catid)->order('id desc')->limit(($page-1)*10,10)->select();
		$data = array('result'=>$data);
		$this->ajaxReturn($data,'JSON');
	}
	
	// 页面详情
	public function detail(){
		header('Access-Control-Allow-Origin:*');
		$Article = M('article');
		$id = I('get.id');
		$data = $Article->where('id = '.$id)->select();
		$data = array('result'=>$data[0]);
		$this->ajaxReturn($data,'JSON');
	}
	
	
	// 接收json数据
	public function login(){
		header('Access-Control-Allow-Origin:*');
		$postData = file_get_contents('php://input',true);
		$d = json_decode($postData);
	
		$username = isset($d->username)?dhtmlspecialchars($d->username):'';
		$password = isset($d->password)?dhtmlspecialchars($d->password):'';
	
		$array = array('username'=>$username,'password'=>$password);
		$data = array('result'=>$array);
		$this->ajaxReturn($data,'JSON');
	}
	
	// 添加数据供json使用
	public function add(){
		
		$catid = I('get.catid');	
		
		for ($i = 1;$i<=200;$i++){
			$Article = M('article');
			$Article->category_id = $catid;
			$Article->title = '题目标号: '.$i.' - 所属类别: '.$catid;
			$Article->content = '题目标号: '.$i.' - 所属类别: '.$catid.'这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是<br><br>内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是<br><br>内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内<br><br>容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容这里是内容<br><br>这里是内容这里是内容这里是内容这里是内容';
			$Article->create_date = Date('Y-m-d H:i:s');
			$Article->add();
		}	
		
	}
	

	
	
    public function shows(){

        $id = I('get.id');

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = '.$id)->select();
        $this->assign("article",$db[0]);
        $this->display();

    }
    
    public function show_conference(){
    
    	$id = I('get.id');
    
    	// 会议内容
    	$Article = M('article');
    	$db = $Article->where('id = '.$id)->select();
        $all = $db[0];
    	
    	$title = $all['title'];
    	$this->assign("title",$title);
    	
    	$content = explode("[#webm#]", $all['content']);
    
    	for ($index = 1;$index<=count($content);$index++){
    		$this->assign("content".$index,$content[$index-1]);
    	}
    	
    	$this->display();
    
    }


    public function about(){

        $id = I('get.id');

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = '.$id)->select();
        $this->assign("article",$db[0]);
        $this->display();

    }

    public function membership(){

        $id = I('get.id');

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = '.$id)->select();
        $this->assign("article",$db[0]);
        $this->display();

    }

    public function committee(){

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = 9')->select();
        $this->assign("article",$db[0]);
        $this->display();

    }


    public function societies(){

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = 10')->select();
        $this->assign("article",$db[0]);
        $this->display();

    }


    public function conferences(){

        // 文章内容
        $Article = M('article');
        $db = $Article->where('category_id = 5')->order('id desc')->select();
        $this->assign("list",$db);
        $this->display();

    }


    public function publications(){

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = 13')->select();
        $this->assign("article",$db[0]);
        $this->display();

    }


    public function contact(){

        // 文章内容
        $Article = M('article');
        $db = $Article->where('id = 14')->select();
        $this->assign("article",$db[0]);
        $this->display();

    }

    public function scholars(){

    // 文章内容
    $Article = M('article');
    $db = $Article->where('id = 27')->select();
    $this->assign("article",$db[0]);
    $this->display();

}

}
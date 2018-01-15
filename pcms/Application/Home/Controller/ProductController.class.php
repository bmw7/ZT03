<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 产品操作
// +--------------------------------------------

class ProductController extends Controller {
	
     /**
	 * 产品列表展示 多篇类 文章条目
	 * 前台访问网址为 item/id.html 例如 item/2.html
	 *  */
	public function lists(){
	    
    	$article = M('article'); 
    	$category_id = I('get.pros');
    	
    	$count = $article->where('category_id = '.$category_id)->count();
    	   
    	$Page      = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数
    	$Page->setConfig('next','下一页');
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('first','首页');
    	$Page->setConfig('last','尾页');
    	$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
    	 
    	$show  = $Page->show();// 分页显示输出
    	
    	if ($count > 0){
    		$list  = $article->where('category_id = '.$category_id)->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	 
	    	 /**
	    	 * 对$list中每个文章对象，附加上其第一幅图像
	    	 *【注意】 该代码片段非必须。但在图片排列时候，该代码必须附加。
	    	 * */
	    	$article_image = M('article_image');
	    	foreach ($list as $k => $v){
	    		// 添加新成员 image
	    		$list[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
	    	}
    	
    	}else{
    		$list = array();
    	}
    	 	 
    	$this->assign('list',$list);               // 赋值数据集
    	$this->assign('page',$show);               // 赋值分页输出           
    	$this->display();
	}	
	
	
	
	/**
	 * 展示  产品详情页面 
	 * 前台访问网址为 pro/id.html 例如 pros/22.html
	 * 使用了url默认路由设置，其真实对应的完整模块地址为 public/show/pro/id.html
	 *  */
	public function show(){
	    $id = I('get.pro'); // 这里用pro来指代id
	    $db = M('Article');  // 暂时借用Article数据库
	    $arr = $db->where('id = '.$id)->select();
	    $article = $arr[0];
	
	    // 点击次数+1 并更新数据库
	    $article['hits'] = $article['hits'] + 1;
	    $db->where('id = '.$id)->setField('hits',$article['hits']);
	
	    // 未设置文章来源，则以“本站”代替
	    if ($article['source'] == ''){  $article['source'] = '本站';  }
	    // 未设置关键词，则以标题代替
	    if ($article['seo_keywords'] == ''){ $article['seo_keywords'] = $article['title']; }
	    // 未设置内容描述，则以正文内容截取前255字代替。msubstr为自定义函数
	    if ($article['seo_description'] == ''){ $article['seo_description'] = msubstr($article['content'],0,255,'utf-8',false); }
	
	    /** 获取文章对象所附属图像 */
	    $article_image = M('article_image');
	    $article_images = $article_image->where('article_id ='.$id)->order('orders asc')->getField('filename',true);
	
	    // 折后价格
	    $price = $article['price'];
	    $discount = $price * 0.2;
	    $this->assign('discount',$discount);
	    $this->assign('preferential',$price - $discount);
	
	    $this->assign('product',$article);
	    $this->assign('product_images',$article_images);
	    $this->assign('size',count($article_images));
	    $this->display();
	}
    
    // 产品购买
	public function buy(){
	    $user_id = I('get.uid');
	    $pro_id = I('get.pid');

	    $db_product = M('article');
	    $db_user = M('user');
	    
	    $pro = $db_product->where('id = '.$pro_id)->select(); $pro  = $pro[0];
	    $user = $db_user->where('id = '.$user_id)->select();  $user = $user[0];
	    
	    $double = $user['double'];
	    $price = $pro['price'];
	    
	    // 根据优惠余额判断
	    if ($double > 0){
	        
	        $double_rest = $double - $price * 0.2;
	        
	        if($double_rest < 0){ 
	            $double_rest = 0; 
	            $price = $price - $double;
	        }else{
	            $price = $price * 0.8;
	        } 
	        
	        $pro['price'] = $price;
	        $this->assign('tips',"您可以使用优惠余额，商品价格的20%");
	            
	    }
	    
	    $this->assign('product',$pro);
	    $this->display();
	}
	
	
	// 购买过程
	public function proceed(){
	    $user_id = I('user_id');
	    $pro_id = I('pro_id');
	     
	    $order = M('order');
	    $product = M('article');
	     
	    $this->display();
	}
	
	
    public function register(){
		$this->display();
	}
	
	
	public function save(){
		$User = M('user');
		$User->create();
		if($User->add()){
			$this->ajaxReturn("注册成功！");
		}else{
			$this->ajaxReturn("注册失败！");
		}
	}
	
	// 手机号唯一性判断
	public function only(){	
		$User = M('user');
		
		if(false != $User->where('phone = '.'"'.I('post.phone').'"')->select()){
			$this->ajaxReturn("occupied");
		}else{
			$this->ajaxReturn("disengaged");
		}
		
	}
	
	// 登录页面
	public function login(){
		$this->display();
	}
	
	// 登录提交
	public function login_submit(){
		$User = M('user');
		$password = $User->where('phone = '.'"'.I('post.phone').'"')->getField('password');
		if($password == I('post.password')){
			
			$info = $User->where('phone = '.'"'.I('post.phone').'"')->select();
			$info = $info[0];
			session('info',$info);	
			$this->ajaxReturn("success");
		}else{
			$this->ajaxReturn("failed");
		}
		
	}
	
	// 登录成功
	public function user(){
		if(null != session('info')){
			$info = session('info');
			$this->assign('pwd',$info["password"]);
			$this->display();
		}else{
			$this->redirect('index');
		}
		
	}
	
	
	// 注销
	public function logout(){
		session('info',null);
		$this->redirect('/index');		
	}
	
}
<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 文章展示
// +--------------------------------------------

class ArticleController extends Controller {

	/** 
	 * 展示 单篇类 文章 
	 * 前台访问网址为 doc/id.html 例如 doc/22.html 
	 * 使用了url默认路由设置，其真实对应的完整模块地址为 article/show/doc/id.html 
	 *  */
	public function show(){
		$id = I('get.doc'); // 这里用docs来指代id
		$db = M('Article');
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
		
		$category = M('category');
		$cname = $category->where('id = '.$article['category_id'])->getField('name');
		
		$this->assign('main',$article);
		$this->assign('cname',$cname);
		
		
		// 展示顶部导航菜单
		$categoryService = A('Category','Service');
		$this->assign("tree",$categoryService->getTree('Navigation'));
		
		// 律师观点
		$views = $db->where('category_id = 8')->order('id desc')->limit(3)->select();
		for ($i=0;$i<3;$i++){
			$views[$i]['content'] = strip_tags($views[$i]['content']);
		}
		$this->assign('views',$views);
		
		
		// 媒体顾问
		$medias = $db->where('category_id = 11')->order('id desc')->limit(4)->select();
		$article_image = M('article_image');
		foreach ($medias as $k => $v){
			// 添加新成员 image
			$medias[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
			$medias[$k]['content'] = strip_tags($medias[$k]['content']);
		}
		$this->assign('medias',$medias);
		
		// 友情链接
		$links_db = M('links');
		$links = $links_db->order('orders asc')->select();
		$this->assign('links',$links);
		
		$this->display();
	}
	
	
	/** 
	 * 展示 多篇类 文章 
	 * 前台访问网址为 docs/id.html 例如 docs/22.html 
	 * 使用了url默认路由设置，其真实对应的完整模块地址为 article/shows/docs/id.html 
	 *  */
	public function shows(){
		$id = I('get.docs'); // 这里用docs来指代id
		$db = M('Article');
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
		
		$category = M('category');
		$cname = $category->where('id = '.$article['category_id'])->getField('name');
		
		$this->assign('main',$article);
		$this->assign('cname',$cname);
		
		
		// 展示顶部导航菜单
		$categoryService = A('Category','Service');
		$this->assign("tree",$categoryService->getTree('Navigation'));
		
		// 律师观点
		$views = $db->where('category_id = 8')->order('id desc')->limit(3)->select();
		for ($i=0;$i<3;$i++){
			$views[$i]['content'] = strip_tags($views[$i]['content']);
		}
		$this->assign('views',$views);
		
		
		// 媒体顾问
		$medias = $db->where('category_id = 11')->order('id desc')->limit(4)->select();
		$article_image = M('article_image');
		foreach ($medias as $k => $v){
			// 添加新成员 image
			$medias[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
			$medias[$k]['content'] = strip_tags($medias[$k]['content']);
		}
		$this->assign('medias',$medias);
		
		// 友情链接
		$links_db = M('links');
		$links = $links_db->order('orders asc')->select();
		$this->assign('links',$links);
		
		$this->display();
	}
	
	
	/**
	 * 展示 多篇类 带图 文章
	 * 前台访问网址为 pics/id.html 例如 pics/22.html
	 * 使用了url默认路由设置，其真实对应的完整模块地址为 article/showPics/pics/id.html
	 *  */
	public function showPics(){
		$id = I('get.pics'); // 这里用pics来指代id
		$db = M('Article');
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

		
		$this->assign('main',$article);
		$this->assign('article_images',$article_images);
		
		
		// 展示顶部导航菜单
		$categoryService = A('Category','Service');
		$this->assign("tree",$categoryService->getTree('Navigation'));
		
		// 律师观点
		$views = $db->where('category_id = 8')->order('id desc')->limit(3)->select();
		for ($i=0;$i<3;$i++){
			$views[$i]['content'] = strip_tags($views[$i]['content']);
		}
		$this->assign('views',$views);
		
		
		// 媒体顾问
		$medias = $db->where('category_id = 11')->order('id desc')->limit(4)->select();
		$article_image = M('article_image');
		foreach ($medias as $k => $v){
			// 添加新成员 image
			$medias[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
			$medias[$k]['content'] = strip_tags($medias[$k]['content']);
		}
		$this->assign('medias',$medias);
		
		// 友情链接
		$links_db = M('links');
		$links = $links_db->order('orders asc')->select();
		$this->assign('links',$links);
		
		$this->display();
	}
	
	/**
	 * 列表展示 多篇类 文章条目
	 * 前台访问网址为 list/id.html 例如 docs/2.html
	 * 使用了url默认路由设置，其真实对应的完整模块地址为 article/showList/list/id.html
	 *  */
	public function showList(){
		$article = M('article'); 
		$category = M('category');
    	$category_id = I('get.list'); // 这里用list来指代id
    	
    	$name = $category->where('id = '.$category_id)->getField('name');
    	$this->assign('name',$name);
    	
    	$count     = $article->where('category_id = '.$category_id)->count();// 查询满足要求的总记录数
    	
    	$Page      = new \Think\Page($count,40);// 实例化分页类 传入总记录数和每页显示的记录数(12)
    	$Page->setConfig('next','下一页');
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('first','首页');
    	$Page->setConfig('last','尾页');
    	$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
    	
    	$show      = $Page->show();// 分页显示输出
    	$list      = $article->where('category_id = '.$category_id)->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	
    	
    	/**
    	 *【可选】- 应用于图片列表方式
    	 * 
    	 * 对$list中每个文章对象，附加上其第一幅图像
    	 *【注意】 该代码片段非必须。但在图片排列时候，该代码必须附加。
    	 * */
    	$article_image = M('article_image');
    	foreach ($list as $k => $v){
    		// 添加新成员 image
    		$list[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
    	}
    	
    	
    	// 展示顶部导航菜单
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Navigation'));
    	
    	// 律师观点
    	$views = $article->where('category_id = 8')->order('id desc')->limit(3)->select();
    	for ($i=0;$i<3;$i++){
    		$views[$i]['content'] = strip_tags($views[$i]['content']);
    	}
    	$this->assign('views',$views);
    	
    	
    	// 媒体顾问
    	$medias = $article->where('category_id = 11')->order('id desc')->limit(4)->select();
    	$article_image = M('article_image');
    	foreach ($medias as $k => $v){
    		// 添加新成员 image
    		$medias[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
    		$medias[$k]['content'] = strip_tags($medias[$k]['content']);
    	}
    	$this->assign('medias',$medias);
    	
    	// 友情链接
    	$links_db = M('links');
    	$links = $links_db->order('orders asc')->select();
    	$this->assign('links',$links);
    	
    	
    	$this->assign('list',$list);// 赋值数据集
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
	}
	
	
	
	
	public function showLists(){
		$article = M('article');
		$category = M('category');
		$category_id = I('get.lists'); // 这里用list来指代id
		 
		$name = $category->where('id = '.$category_id)->getField('name');
		$this->assign('name',$name);
		 
		$count     = $article->where('category_id = '.$category_id)->count();// 查询满足要求的总记录数
		 
		$Page      = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(12)
		$Page->setConfig('next','下一页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('first','首页');
		$Page->setConfig('last','尾页');
		$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
		 
		$show      = $Page->show();// 分页显示输出
		$list      = $article->where('category_id = '.$category_id)->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		 
		   
		/**
		 *【可选】- 应用于图片列表方式
		 *
		 * 对$list中每个文章对象，附加上其第一幅图像
		 *【注意】 该代码片段非必须。但在图片排列时候，该代码必须附加。
		* */
		$article_image = M('article_image');
		foreach ($list as $k => $v){
			// 添加新成员 image
			$list[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
			$list[$k]['content'] = strip_tags($list[$k]['content']);
		}
		 
		 
		// 展示顶部导航菜单
		$categoryService = A('Category','Service');
		$this->assign("tree",$categoryService->getTree('Navigation'));
		 
		// 律师观点
		$views = $article->where('category_id = 8')->order('id desc')->limit(3)->select();
		for ($i=0;$i<3;$i++){
			$views[$i]['content'] = strip_tags($views[$i]['content']);
		}
		$this->assign('views',$views);
		 
		 
		// 媒体顾问
		$medias = $article->where('category_id = 11')->order('id desc')->limit(4)->select();
		$article_image = M('article_image');
		foreach ($medias as $k => $v){
			// 添加新成员 image
			$medias[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
			$medias[$k]['content'] = strip_tags($medias[$k]['content']);
		}
		$this->assign('medias',$medias);
		 
		// 友情链接
		$links_db = M('links');
		$links = $links_db->order('orders asc')->select();
		$this->assign('links',$links);
		 
		 
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}
	
	
	
}
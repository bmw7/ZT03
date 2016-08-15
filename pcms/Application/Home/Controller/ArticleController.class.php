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
		$id = I('get.doc'); // 这里用doc来指代id
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
		// 未设置内容描述，则以正文内容截取前225字代替。msubstr为自定义函数
		if ($article['seo_description'] == ''){ $article['seo_description'] = msubstr($article['content'],0,225,'utf-8',false); }
		
		$this->assign('article',$article);
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
		
		if ($article['source'] == ''){  $article['source'] = '本站';  } // 文章来源
		$article['hits'] = $article['hits'] + 1;                        // 点击次数
		$db->where('id = '.$id)->setField('hits',$article['hits']);     // 更新点击次数
		
		$this->assign('article',$article);
		$this->display();
	}
	
	
}
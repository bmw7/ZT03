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
    	$lawyers = $article->where('category_id = 1')->order('id desc')->limit(5)->select();
    	foreach ($lawyers as $k => $v){
    		// 添加新成员 image
    		$lawyers[$k]['image'] = $article_image->where('article_id ='.$v['id'])->order('orders asc')->limit(1)->getField('filename');
    	}
    	$this->assign('lawyers',$lawyers);
    	
    	// 通知公告
    	$notice = $article->where('category_id = 23')->order('id desc')->limit(10)->select();
    	$this->assign('notice',$notice);
    	
    	// 成功案例
    	$success = $article->where('category_id = 4')->order('id desc')->limit(10)->select();
    	$this->assign('success',$success);
    	
    	// 法律顾问
    	$consult = $article->where('category_id = 11')->order('id desc')->limit(10)->select();
    	$this->assign('consult',$consult);
    	
    	// 婚姻继承
    	$marry = $article->where('category_id = 12')->order('id desc')->limit(10)->select();
    	$this->assign('marry',$marry);
    	
    	// 经济合同
    	$contract = $article->where('category_id = 14')->order('id desc')->limit(10)->select();
    	$this->assign('contract',$contract);
    	
    	// 债务清偿
    	$debt = $article->where('category_id = 15')->order('id desc')->limit(10)->select();
    	$this->assign('debt',$debt);
    	
    	// 劳动纠纷
    	$labour = $article->where('category_id = 16')->order('id desc')->limit(10)->select();
    	$this->assign('labour',$labour);
    	
    	// 交通事故
    	$traffic = $article->where('category_id = 17')->order('id desc')->limit(10)->select();
    	$this->assign('traffic',$traffic);
    	
    	// 人身损害
    	$harm = $article->where('category_id = 18')->order('id desc')->limit(10)->select();
    	$this->assign('harm',$harm);
    	
    	// 房产地产
    	$real = $article->where('category_id = 19')->order('id desc')->limit(10)->select();
    	$this->assign('real',$real);
    	
    	// 刑事辩护
    	$defend = $article->where('category_id = 21')->order('id desc')->limit(10)->select();
    	$this->assign('defend',$defend);
    	
    	// 友情链接
    	$links_db = M('links');
    	$links = $links_db->order('orders asc')->select();
    	$this->assign('links',$links);
    	 
    	
    	$this->display();
    }
   
    
}
<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 留言管理
// +--------------------------------------------

class GuestbookController extends Controller {

	/** 留言列表 */
	public function index(){
		$guestbook = M('guestbook');
		
		$count     = $guestbook->count();// 查询满足要求的总记录数
    	
    	$Page      = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(10)
    	$Page->setConfig('next','下一页');
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('first','首页');
    	$Page->setConfig('last','尾页');
    	$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
    	
    	$show  = $Page->show();// 分页显示输出
    	$list  = $guestbook->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	
    	$this->assign('list',$list);               // 赋值数据集
    	$this->assign('page',$show);               // 赋值分页输出
    	
    	// 展示顶部导航菜单
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Navigation'));
    	 
    	// 友情链接
    	$links_db = M('links');
    	$links = $links_db->order('orders asc')->select();
    	$this->assign('links',$links);
    	
    	$this->display();
		
	}
	
	
	/** 留言提交  */
	public function save(){
		$guestbook = M('guestbook');
		$guestbook->phone = I('phone');
		$guestbook->email = I('email');
		$guestbook->guest_content = I('guest_content');;
		$guestbook->create_date = Date('Y-m-d H:i:s');
		$guestbook->address = get_client_ip();
		
		if ($guestbook->add()){
			echo 'success';
		}else{
			echo 'failed';
		}
	}
	
	/** 留言详情  */
	public function detail(){
		$guestbook = M('guestbook');
		$id = I('id');
		$message = $guestbook->where('id = '.$id)->select();
		$this->assign('message',$message[0]);
		$this->display();
		
		
	}
	
	
}
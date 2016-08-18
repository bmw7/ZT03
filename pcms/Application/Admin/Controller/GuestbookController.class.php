<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 留言管理
// +--------------------------------------------

class GuestbookController extends AuthController{
	
	/** 展示  */
	public function index(){
		$guestbook = M('guestbook'); // 实例化User对象
		$count     = $guestbook->count();// 查询满足要求的总记录数
		$Page      = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		
		$Page->setConfig('next','下一页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('first','首页');
		$Page->setConfig('last','尾页');
		$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
		
		$show      = $Page->show();// 分页显示输出
		$list      = $guestbook->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); 
	}
	
	/** 留言删除  */
	public function del(){
		$guestbook = M('guestbook');
		if ($guestbook->delete(I('id'))){
			$this->success('操作成功！',U('admin/guestbook/index'));
		}else{
			$this->error('操作失败！',U('admin/guestbook/index'));
		}
	}
	
	/** 回复留言  */
	public function reply(){
		$guestbook = M('guestbook');
		$guestbook->reply_content = I('post.reply_content');
		if ($guestbook->where('id = '.I('get.id'))->save()){
			$this->success('操作成功！',U('admin/guestbook/index'));
		}else{
			$this->error('操作失败！',U('admin/guestbook/index'));
		}
	}
	
	/** 回复留言  */
	public function unreply(){
		$guestbook = M('guestbook'); // 实例化User对象
		$count     = $guestbook->where("reply_content = ''")->count();// 查询满足要求的总记录数
		$Page      = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		
		$Page->setConfig('next','下一页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('first','首页');
		$Page->setConfig('last','尾页');
		$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
		
		$show      = $Page->show();// 分页显示输出
		$list      = $guestbook->where("reply_content = ''")->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); 
	}
    
}







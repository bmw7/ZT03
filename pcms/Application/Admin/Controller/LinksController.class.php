<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 友情链接
// +--------------------------------------------

class LinksController extends AuthController {
	
	/** 展示  */
    public function index(){
    	$groups = M('Links_group');
    	$this->assign('groups',$groups->select());
    	
    	$links = M('Links');
    	$this->assign("links",$links->order('orders')->select());
    	
		$this->display();
    }
    
    /** 添加  */
    public function add(){
    	$links = M('Links');
    	$links->create();
    	
    	if ($_FILES['logofile']['size'] > 0){
    		//$filename = $_FILES['logofile']['name'];
    		$upload = new \Think\Upload();// 实例化上传类
    		$upload->maxSize  = 3145728 ;// 设置附件上传大小
    		$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    		$upload->rootPath = './upload/'; // 设置附件上传根目录
    		$upload->saveName = 'com_create_guid';
    		// 上传单个文件
    		$info   =   $upload->uploadOne($_FILES['logofile']);
    		if(!$info) {// 上传错误提示错误信息
    			$this->error($upload->getError());
    		}else{// 上传成功 获取上传文件信息
    			$links->filename = $info['savepath'].$info['savename'];
    		}
    		 
    	}
    	
    	$links->add();
    	$id = $links->getLastInsID();
    	$links->orders = $id;
    	$links->where('id = '.$id)->save();
    	

    	$this->success('操作成功',U('admin/links/index'));
    }
    
    public function add_group(){
    	$group = M('Links_group');
    	$group->create();
    	if ($group->add()){
    		$this->success('添加分组成功！',U('admin/links/index'));
    	}else{
    		$this->error('添加分组失败！',U('admin/links/index'));
    	}
    }

}
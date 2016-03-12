<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 友情链接
// +--------------------------------------------

class LinksController extends AuthController {
	
	/** 首页  */
	public function index(){
		$Links_group = M('Links_group');
		$groups = $Links_group->order('orders asc')->select();
		$this->assign('groups',$groups);
		$this->display();
	}
	
	/** 展示  */
    public function show(){
    	$Links_group = M('Links_group');
    	$Links = M('Links');
    	
    	$groups = $Links_group->order('orders asc')->select();
    	foreach ($groups as $k => $v){
    		// 添加新成员 Links 
    		$groups[$k]['links'] = $Links->where('group_id ='.$v['id'])->order('orders asc')->select();
    	}
    	$this->assign('groups',$groups);

		$this->display();
    }
    
    /** 添加链接  */
    public function links_add(){
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
    	
    	$this->success('操作成功',U('admin/links/show'));
    }
    
    /** 更新链接  */
    public function links_update(){
    	$links = M('Links');
    	$links->create();
    	
    	if ($_FILES['logofile']['size'] > 0){
    		$upload = new \Think\Upload();// 实例化上传类
    		$upload->maxSize  = 3145728 ;// 设置附件上传大小
    		$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    		$upload->rootPath = './upload/'; // 设置附件上传根目录
    		$upload->saveName = 'com_create_guid';
    		// 上传单个文件
    		$info   =   $upload->uploadOne($_FILES['logofile']);
    		if(!$info) {// 上传错误提示错误信息
    			$this->error($upload->getError());
    		}else{      // 上传成功 获取上传文件信息 
    			// 原图片存在则删除
    			$filename = $links->where('id ='.I('get.id'))->getField('filename');
    			if ($filename != ''){
    				unlink('upload/'.$filename);
    			}			
    			$links->filename = $info['savepath'].$info['savename'];
    		}	 
    	}
    	
    	$result = $links->where('id = '.I('get.id'))->save();
    	if ($result){
    		$this->success('更新成功',U('admin/links/show'));
    	}else{
    		$this->error('更新失败',U('admin/links/show'));
    	}
    }
    
    /** 删除链接  */
    public function links_del(){
    	$links = M('Links');
        $filename = $links->where('id ='.I('get.id'))->getField('filename');
    	if ($filename != ''){
    		unlink('upload/'.$filename);
    	}
    	$result = $links->delete(I('get.id'));
    	if ($result){
    		$this->success('删除成功',U('admin/links/show'));
    	}else{
    		$this->error('删除失败',U('admin/links/show'));
    	}
    }
    
    /** 添加分组  */
    public function group_add(){
    	$group = M('Links_group');
    	$group->create();
    	if ($group->add()){
    		$id = $group->getLastInsID();
    		$group->orders = $id;
    		$group->where('id ='.$id)->save();
    		$this->success('添加分组成功！',U('admin/links/index'));
    	}else{
    		$this->error('添加分组失败！',U('admin/links/index'));
    	}
    }
    
    /** 更新分组  */
    public function group_update(){
    	$group = M('Links_group');
    	$group->create();
    	$result = $group->where('id ='.I('get.id'))->save();
    	if ($result){ 		
    		$this->success('更新分组成功！',U('admin/links/index'));
    	}else{
    		$this->error('更新分组失败！',U('admin/links/index'));
    	}
    }
    
    /** 删除分组  */
    public function group_del(){
    	$group = M('Links_group');
    	$id = I('get.id');
    	
    	$links = M('Links');
    	$att = $links->where('group_id ='.$id)->select();
    	
    	if (count($att) > 0){
    		$this->error('该分组下尚有链接，不能删除！',U('admin/links/index'));
    	}else{
    		if ($group->delete($id)){
    			$this->success('删除成功！',U('admin/links/index'));
    		}else {
    			$this->error('删除失败！',U('admin/links/index'));
    		}
    	} 	
    }
    

}
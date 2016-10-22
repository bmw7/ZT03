<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +---------------------------------------------------------------------
// | Controller - 图文链接
// | 基本形式是 - 图片 文字 链接 三者作为一项相互结合在一起,可以添加多项，并对这些项进行分组，以方便前台展示
// | 可使用在 友情链接、轮播图片、图片列表等多种场合
// | 在使用图文链接时候，首先要确定分组
// +---------------------------------------------------------------------

class LinksController extends AuthController {
	
	/** 首页 - 分组管理页面  */
	public function index(){
		$Links_group = M('Links_group');
		$groups = $Links_group->order('orders asc')->select();
		$this->assign('groups',$groups);
		$this->display();
	}
	
	
	/** 添加分组  */
	public function group_add(){
	if (trim(I('post.name')) == ''){
		$this->error('表单填写不完整，请重新填写！',U('admin/links'));
	}else{
		
		
		$group = M('Links_group');
		$group->create();
		if ($group->add()){
			$id = $group->getLastInsID();
			$group->orders = $id;
			$group->where('id ='.$id)->save();
			$this->redirect('/admin/links');
		}else{
			$this->error('添加分组失败！',U('/admin/links'));
		}
		
	}
	}
	
	/** 更新分组  */
	public function group_update(){
		$group = M('Links_group');
		$group->create();
		$result = $group->where('id ='.I('get.id'))->save();
		if ($result){
			$this->redirect('/admin/links');
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
			$this->error('该分组下还有项目，不能删除！',U('admin/links/index'));
		}else{
			if ($group->delete($id)){
				$this->redirect('/admin/links');
			}else {
				$this->error('删除失败！',U('admin/links/index'));
			}
		}
	}
	
	/*----------------------------------------------------------------------------*/
	
	/** 展示链接项目 - 链接管理页面  */
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
    
    /** 添加链接项目  */
    public function links_add(){
    	$links = M('Links');
    	$links->create();
    	
    	if ($_FILES['logofile']['size'] > 0){
    		//$filename = $_FILES['logofile']['name'];
    		$upload = new \Think\Upload();// 实例化上传类
    		$upload->maxSize  = 3145728 ;// 设置附件上传大小
    		$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    		$upload->rootPath = './Public/upload/'; // 设置附件上传根目录
    		$upload->saveName = array('uniqid',$_SERVER['REQUEST_TIME']);
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
    	
    	if ($links->where('id = '.$id)->save()){
    		$this->redirect('/admin/links/show');
    	}else{
    		$this->success('操作失败',U('admin/links/show'));
    	}
    	
    }
    
    /** 更新链接项目  */
    public function links_update(){
    	$links = M('Links');
    	$links->create();
    	
    	if ($_FILES['logofile']['size'] > 0){
    		$upload = new \Think\Upload();// 实例化上传类
    		$upload->maxSize  = 3145728 ;// 设置附件上传大小
    		$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    		$upload->rootPath = './Public/upload/'; // 设置附件上传根目录
    		$upload->saveName = 'com_create_guid';
    		// 上传单个文件
    		$info   =   $upload->uploadOne($_FILES['logofile']);
    		if(!$info) {// 上传错误提示错误信息
    			$this->error($upload->getError());
    		}else{      // 上传成功 获取上传文件信息 
    			// 原图片存在则删除
    			$filename = $links->where('id ='.I('get.id'))->getField('filename');
    			if ($filename != ''){
    				unlink('Public/upload/'.$filename);
    			}			
    			$links->filename = $info['savepath'].$info['savename'];
    		}	 
    	}
    	
    	$result = $links->where('id = '.I('get.id'))->save();
    	if ($result){
    		$this->redirect('/admin/links/show');
    	}else{
    		$this->error('更新失败',U('admin/links/show'));
    	}
    }
    
    /** 删除链接项目  */
    public function links_del(){
    	$links = M('Links');
        $filename = $links->where('id ='.I('get.id'))->getField('filename');
    	if ($filename != ''){
    		unlink('upload/'.$filename);
    	}
    	$result = $links->delete(I('get.id'));
    	if ($result){
    		$this->redirect('/admin/links/show');
    	}else{
    		$this->error('删除失败',U('admin/links/show'));
    	}
    }
    

    

}
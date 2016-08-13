<?php
namespace Home\Controller;
use Think\Controller;

// +--------------------------------------------
// | 前台客户端 - 图文链接项目展示
// +--------------------------------------------

class LinksController extends Controller {

	
	public function index(){
    	$Links_group = M('Links_group'); 
    	$Links = M('Links');
    	
    	/** 
    	 * 展示所有组、组下面所有项目
    	 * 在前台页面对 groups遍历即可
    	 * */
    	$groups = $Links_group->order('orders asc')->select();
    	foreach ($groups as $k => $v){
    		// 添加新成员 Links 
    		$groups[$k]['links'] = $Links->where('group_id ='.$v['id'])->order('orders asc')->select();
    	}
    	$this->assign('groups',$groups);  
    	
    	
    	/**
    	 * 展示某一分组下的所有项目  以组 group_id = 1 为例
    	 * 在前台页面对 links遍历即可
    	 * */
    	$links = $Links->where('group_id = 1')->order('orders asc')->select();
    	$this->assign('links',$links);
    	

		$this->display();
	}
	
	
	
}
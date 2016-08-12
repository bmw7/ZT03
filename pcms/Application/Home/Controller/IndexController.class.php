<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $article = M('article'); // 实例化article对象
        $list    = $article->where('category_id = 5')->order('id desc')->limit(8)->select();
        $this->assign('list',$list);// 赋值数据集
    	$this->display();
    }
    
    public function show(){
    	$this->display();
    }
    
}
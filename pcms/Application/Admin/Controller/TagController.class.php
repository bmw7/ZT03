<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 标签管理
// +--------------------------------------------

class TagController extends AuthController{
	
	/** 展示  */
	public function index(){
		$Tag_group = M('Tag_group');
		$Tag = M('Tag');
		 
		$groups = $Tag_group->select();
		foreach ($groups as $k => $v){
			// 添加新成员 tags
			$groups[$k]['tags'] = $Tag->where('group_id ='.$v['id'])->select();
		}
		$this->assign('groups',$groups);	
		$this->display();
	}
	
	/** 添加标签组  */
	public function add_group(){
	
	if (trim(I('post.name')) == ''){
		$this->error('表单填写不完整，请重新填写！',U('tag/index'));
	}else{
			
	
		$db = M('tag_group');
		$db->create();
		
		if ($db->add()) {
			$this->redirect('/admin/tag');
		}else {
			$this->error("添加失败",U('admin/tag/index'));
		}
		
	}
	}
	
	/** 添加标签  */
	public function add_tag(){
		
	if (trim(I('post.name')) == ''){
		$this->error('表单填写不完整，请重新填写！',U('admin/tag'));
	}else{
		
		
		
		$db = M('tag');
		$db->create();
		if ($db->add()) {
			$this->redirect('/admin/tag');
		}else {
			$this->error("添加失败",U('admin/tag/index'));
		}
		
		
	}
	}
	
	/** 删除标签  */
	public function del(){	
		$id = I('get.id');
		
		$article_tag = M('article_tag');
		$arr = $article_tag->where('tag_id ='.$id)->select();
		if (count($arr) > 0){
			$this->error("删除标签失败！本标签下尚有文章！",U('admin/tag/index'));
		}
		
		$tag = M('tag');
		if($tag->delete($id)){
			$this->redirect('/admin/tag');
		}else{
			$this->error("操作失败！",U('admin/tag/index'));
		}
	}
	
	/** 删除标签组  */
	public function del_group(){
		$group_id = I('get.id');
		$group = M('tag_group');
		$tag = M('tag');
		
		$tags = $tag->where("group_id = ".$group_id)->select();
		
		$article_tag = M('article_tag');
		$k = 0;
		
		for ($i = 0;$i < count($tags);$i++){	
			$att = $article_tag->where('tag_id = '.$tags[$i]['id'])->select();
			if (count($att) > 0){
				$k++;
			}	
		}
		
		if ($k > 0){
			$this->error('该标签组内标签下尚有文章，不能删除！',U('/admin/tag'));
		}else{
			
			$group->delete($group_id);
			$tag->where("group_id = ".$group_id)->delete();
			$this->redirect('/admin/tag');
		}
		
	}
	
	/** 列表标签文章  */
	public function lists(){
		$tag_id = I('get.id');
		$article_tag = M('article_tag');
		
		$count     = $article_tag->where('tag_id = '.$tag_id)->count();// 查询满足要求的总记录数
		$Page      = new \Think\Page($count,11);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$Page->setConfig('next','下一页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('first','首页');
		$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
		 
		$show      = $Page->show();// 分页显示输出
		$list      = $article_tag->where('tag_id = '.$tag_id)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		 
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		
		$this->display();
	}
	
	/** 文章标签对应组 删除 */
	public function article_tag_del(){
		$article_id = I('get.article_id');
		$tag_id = I('get.tag_id');
		
		$article_tag = M('article_tag');
		
		$condition=array(
			'article_id'=>$article_id,
			'tag_id'=>$tag_id
		);
		
		if ($article_tag->where($condition)->delete()){
			$this->redirect('/admin/article/tag_articles/tag_id/'.$tag_id);
		}
	}
	
	/** 文章标签对应组 批量删除 */
	public function article_tag_batchDel(){
		$article_tag = M('article_tag');
		$ids = explode('#', I('post.ids'));
		
		for ( $i = 0; $i < (count($ids) - 1); $i++ ){
			if (!$article_tag->delete($ids[$i])){
				$this->ajaxReturn("操作失败！");
			}
		}
		$this->ajaxReturn("操作成功！");
	}
    
}







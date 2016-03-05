<?php
namespace Think\Template\TagLib;
use Think\Template\TagLib;

// +----------------------------------------------------------------------
// | 自定义标签库
// +----------------------------------------------------------------------

class Cu extends TagLib{
    // 标签定义
    protected $tags   =  array(
        'taglist'    => array('attr'=>'group_id','close'=>1)
        );
    
    /** 标签列表  */
    public function _taglist($tag,$content) {
    	$group_id = $tag['group_id'];
    	//$group_id = $this->autoBuildVar($tag['group_id']);
    	$db = M('tag');		
    	$results = $db->where('group_id = '.$group_id)->select();
    	
    	$tags = "";
    	
    	foreach ($results as $item){
    		$tags .= $item[name];
    	}
    	
    	return $tags;
    }
}
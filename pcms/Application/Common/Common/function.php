<?php

// +----------------------------------------------------------------------
// | 自定义函数库 - 供模板调用
// +----------------------------------------------------------------------

/**
 * 显示标签名称
 * 
 * @param $id 标签组id
 *
 * @return 该标签组下所有标签
 * */
function showtags($id){
	$db = M('tag');
	$att = $db->where('group_id = '.$id)->select();
	$tags = "";
	for($i = 0;$i<count($att);$i++){
		$tags .= $att[$i][name]."&nbsp;&nbsp;<a href='/git/pcms/admin/tag/del?id=".$att[$i][id]."'>删除</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	return $tags;
}
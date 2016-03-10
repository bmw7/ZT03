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

function showgroups($group_id){
	$tag_group = M('tag_group');
	$group_name = $tag_group->where('id ='.$group_id)->getField('name');
	
	$tag = M('tag');
	$tags = $tag->where('group_id ='.$group_id)->select();
	$tag_name = "";
	for ($i = 0;$i < count($tags);$i++){
		$tag_name .= '<input type="checkbox" name="tags" value="'.$tags[$i][id].'">'.$tags[$i][name]."&nbsp;&nbsp;";
	}
	return $group_name."：".$tag_name."&nbsp;&nbsp;";
}

/** 超过3000年 则减少1000年,恢复正常时间  */
function time_top($time){
	$att = explode("-", $time);
	if ($att[0]>3000){
		$year = $att[0] - 1000;
		return $year.'-'.$att[1].'-'.$att[2];
	}
	return $time;
}

/** 是否显示置顶图标  */
function time_icon($time){
	$att = explode("-", $time);
	if ($att[0]>3000){
		return '<span class="label label-xs bg-primary">置顶</span>';
	}
	
}

/** 编辑页面置顶图标  */
function time_edit_icon($time){
	$att = explode("-", $time);
	if ($att[0]>3000){
		return '<span class="label label-xs bg-primary">置顶</span>';
	}

}

/** 是否显示置顶图标  */
function time_checked($time){
	$att = explode("-", $time);
	if ($att[0]>3000){
		return 'checked';
	}
}




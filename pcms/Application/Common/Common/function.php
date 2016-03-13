<?php

// +----------------------------------------------------------------------
// | 自定义函数库 - 供模板调用
// +----------------------------------------------------------------------


/**
 * 文章编辑时 显示选中标签
 *
 * @param $tag_ids 标签组id
 * @param $tag_id  当前标签id
 *
 * @return checked
 * */
function tag_checked($tag_ids,$tag_id){
	for ($i = 0;$i < count($tag_ids);$i++){
		if ($tag_id == $tag_ids[$i]){
			return "checked";
		}
	}
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


/** 账号编辑 设置 */
function account_edit($sid,$id){
	if ($sid != $id){
		if ($sid <= 2){
			return "编辑";
		}
	}else{
		return "编辑";
	}
}

/** 账号删除 设置*/
function account_del($sid,$id){
	if ($sid <= 2 && $id != 2){
		return "删除";
	}
}

/** 图文链接 图片显示*/
function link_logo($filename){
	if ($filename != null){
		return "<img src='../../upload/".$filename."' height='30' >";
	}
}


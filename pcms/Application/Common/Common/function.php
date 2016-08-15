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

/**
 * 截取中文字符串函数
 * 
 * msubstr($str, $start=0, $length, $charset=”utf-8″, $suffix=true)
 * $str:要截取的字符串
 * $start=0：开始位置，默认从0开始
 * $length：截取长度
 * $charset=”utf-8″：字符编码，默认UTF－8
 * $suffix=true：是否在截取后的字符后面显示省略号，默认true显示，false为不显示
 * 模版使用：{$vo.title|msubstr=0,5,'utf-8',false}
 * 
 * @param unknown $str
 * @param number $start
 * @param unknown $length
 * @param string $charset
 * @param string $suffix
 * @return string|unknown
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)

{
	if(function_exists("mb_substr")){

		if($suffix)

			return mb_substr($str, $start, $length, $charset)."...";

		else

			return mb_substr($str, $start, $length, $charset);

	}

	elseif(function_exists('iconv_substr')) {

		if($suffix)

			return iconv_substr($str,$start,$length,$charset)."...";

		else

			return iconv_substr($str,$start,$length,$charset);

	}

	$re['utf-8']   = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef]
                  [x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";

	$re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";

	$re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";

	$re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";

	preg_match_all($re[$charset], $str, $match);

	$slice = join("",array_slice($match[0], $start, $length));

	if($suffix) return $slice."…";

	return $slice;

}

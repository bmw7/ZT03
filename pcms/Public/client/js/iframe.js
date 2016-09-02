$(document).ready(function() {

	/** 首页默认加载 */
	$.ajax({
		type:"post",
		url:'index/index_show',
		success:function(html){
			$("#ajax-show").html(html);
		}
	});

	/** 左侧边栏 或 外部存在链接 */
	$('.outer-link').click(function(){
		event.preventDefault();
		var url = $(this).attr('href');
		$.ajax({
			type:"post",
			url:url,
			success:function(html){
				$("#ajax-show").html(html);
			}
		});

	});

	/** 内部动态生成页面 */
	$('div').on('click','.inner-link',function(){
		event.preventDefault();
		var url = $(this).attr('href');
		$.ajax({
			type:"post",
			url:url,
			success:function(html){
				$("#ajax-show").html(html);
			}
		});
	});


});
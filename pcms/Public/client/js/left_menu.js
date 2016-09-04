$(document).ready(function() {
	$('.carousel').carousel();
	
	$(document).on("click",".menu_left_item",function(){
		if ($(this).next().attr('class') == 'menu_left_item_sub') {
			$(this).next().toggle();
		};
		
		// 子菜单是关闭状态 url指的是当前页面的路径
		if ($(this).next().css('display') == 'none') {
			$(this).find('a').css('background-image', 'url(PUBLIC/client/img/left_menu.jpg)');
		// 子菜单是开启状态
		}else{
			$(this).find('a').css({'background-image':'url(PUBLIC/client/img/left_menu_out.jpg)','font-weight':'bold'});
			$('.menu_left_item').not(this).find('a').css({'background-image':'url(PUBLIC/client/img/left_menu.jpg)','font-weight':'normal'});
			$('.menu_left_item').not(this).next().each(function(){
				if ($(this).attr('class') == 'menu_left_item_sub') { $(this).hide(); };
			});
		};	
	});
	
	
});
$(document).ready(function() {
	$('.carousel').carousel();
	
	$(document).on("click",".menu_left_item",function(){
		if ($(this).next().attr('class') == 'menu_left_item_sub') {
			$(this).next().toggle();
		};
		
		// 子菜单是关闭状态     url指的是当前页面的路径
		if ($(this).next().css('display') == 'none') {
			$(this).find('a').css({'background-image':'url(Public/client/img/left_menu.jpg)','font-weight':'normal'});	
			
			// 鼠标离开
			$(this).find('a').mouseout(function(){
				$(this).css({'background-image':'url(Public/client/img/left_menu.jpg)','font-weight':'normal'});
			});
			
		// 子菜单是开启状态
		}else{
			$('.menu_left_item').not(this).find('a').css({'background-image':'url(Public/client/img/left_menu.jpg)','font-weight':'normal'});
			$('.menu_left_item').not(this).next().each(function(){
				if ($(this).attr('class') == 'menu_left_item_sub') { $(this).hide(); };
			});
			
			
			// 给其他项目添加鼠标滑过效果
			$('.menu_left_item').not(this).find('a').hover(
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu_out.jpg)','font-weight':'bold'});
					},
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu.jpg)','font-weight':'normal'});
					}
			);
			
			$(this).find('a').hover(
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu_out.jpg)','font-weight':'bold'});
					},
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu_out.jpg)','font-weight':'bold'});
					}
			);
			
		};	
		
		
	});



	$(document).on("click",".sub_item",function(){
			$(this).find('a').css({'background-image':'url(Public/client/img/left_menu_in.jpg)','font-weight':'bold'});
			$('.sub_item').not(this).find('a').css({'background-image':'url(Public/client/img/left_menu.jpg)','font-weight':'normal'});
			
			// 给其他项目添加鼠标滑过效果
			$('.sub_item').not(this).find('a').hover(
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu_in.jpg)','font-weight':'bold'});
					},
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu.jpg)','font-weight':'normal'});
					}
			);
			
			$(this).find('a').hover(
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu_in.jpg)','font-weight':'bold'});
					},
					function(){
						$(this).css({'background-image':'url(Public/client/img/left_menu_in.jpg)','font-weight':'bold'});
					}
			);
			
			
			
	});
	
	
});
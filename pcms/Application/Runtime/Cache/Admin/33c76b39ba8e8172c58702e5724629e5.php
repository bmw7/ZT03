<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/git/pcms/Public/admin/assets/skin/default_skin/css/theme_inner.css">
    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="/git/pcms/Public/admin/assets/admin-tools/admin-forms/css/admin-forms.css">
    <link rel="stylesheet" type="text/css" href="/git/pcms/Public/admin/css/custom.css">
    <script type="text/javascript" src="/git/pcms/Public/admin/vendor/jquery/jquery-1.11.1.min.js"></script>
    <script>
     // 弹出框提示
 	 if('${info}' != ""){
 		//parent.bootAlert('${info}');
 	 }

     // 删除确认框 
     function del(url,name){
        parent.bootConfirm(url,name);
     }
     
	 $(document).ready(function(){
	    // 全选
	 	$('#all').click(function() { 
         	$('.item').prop('checked', $(this).is(':checked')); 
     	}); 
    
		// 赋值grade
		$('#category').change(function(){
			var optionId = "option"+$(this).val();
			var optionName = $('#'+optionId).attr("name");
			$('#grade').val(optionName);
		});
		
     	// 获取与点击<a>元素有相同grade的上一层的 <a>元素的父级<tr>元素   -- @param $self 为<a>元素; @param $prev为$self的父级<tr>元素的上级<tr>元素
     	function samePrev($self,$prev){
     	    // 若不是常规的列表中的tr,则跳出
     		if($prev.find('.movedown').attr('grade') == null){ return null; }
     		
	        var selfGrade = $self.attr('grade');
	    	var prevGrade = $prev.find('.moveup').attr('grade')
	    	if(selfGrade == prevGrade){
	    		return $prev;
	    	}else{
	    		var $pp = $prev.prev();
	    		return samePrev($self,$pp);
	    	}
	    }
	    
	    
	    // 获取与点击<a>元素有相同grade的下一层的 <a>元素的父级<tr>元素   -- @param $self 为<a>元素; @param $next为$self的父级<tr>元素的下级<tr>元素
     	function sameNext($self,$next){
     		// 若不是常规的列表中的tr,则跳出
     		if($next.find('.movedown').attr('grade') == null){ return null; }
     		
	        var selfGrade = $self.attr('grade');
	    	var nextGrade = $next.find('.movedown').attr('grade')
	    	if(selfGrade == nextGrade){
	    		return $next;
	    	}else{
	    		var $nn = $next.next();
	    		return sameNext($self,$nn);
	    	}
	    }
     	
     	// 上移
     	$('.moveup').click(function(){    	    
     		var myGrade = $(this).attr('grade');
     		var rpGrade = $(this).parent().parent().prev().find('.moveup').attr('grade');    // 第一个parent()到<td> 第二个parent()到 <tr> prev() 到上一个<tr>
     		
     		if(myGrade > rpGrade){ 
     			parent.bootAlert('已经移动到本层级最顶端，无法再往上移动！'); 
     		}else{
     			var $self = $(this);
     			var $prev = samePrev($self,$self.parent().parent().prev());
     			
     		    var myId = $self.attr('id');
     	    	var rpId = $prev.find('.moveup').attr('id');
	
     	    	var myOrders = $self.attr('orders');
     	    	var rpOrders = $prev.find('.moveup').attr('orders');
     	    	
     	    	$.ajax({
			    	type: 'POST',
			    	url:  '/admin/setting/navigation/move' ,
			    	data: {'myId':myId,'rpId':rpId,'myOrders':myOrders,'rpOrders':rpOrders},
			    	success: function(data){ parent.bootAlert(data); }
				});	
     		}
     	});  
     	
     	// 下移
     	$('.movedown').click(function(){
     		var myGrade = $(this).attr('grade');
     		var rpGrade = $(this).parent().parent().next().find('.movedown').attr('grade');
     		if(myGrade > rpGrade){ 
     			parent.bootAlert('已经移动到本层级最末端，无法再往下移动！'); 
     		}else{
     		    var $self = $(this);
     			var $next = sameNext($self,$self.parent().parent().next());
     			
     		    var myId = $self.attr('id');
     	    	var rpId = $next.find('.movedown').attr('id');
     	    	
     	    	var myOrders = $self.attr('orders');
     	    	var rpOrders = $next.find('.movedown').attr('orders');
     	    	
     	    	$.ajax({
			    	type: 'POST',
			    	url:  '/admin/setting/navigation/move' ,
			    	data: {'myId':myId,'rpId':rpId,'myOrders':myOrders,'rpOrders':rpOrders},
			    	success: function(data){ parent.bootAlert(data); }
				});	
     		}
     	});
	    
	     
	    
	 });
     </script>
</head>
<body>
<div class="custom_main">
<div class="custom_title">
	<span class="custom_title_word">导航设置</span>
</div>
<div class="custom_body">
<table class="table table-hover" id="datatable3" cellspacing="0" width="100%">
    <thead>
        
<tr><!-- 添加栏目 -->
	
	<form id="inputForm" class="form-horizontal" action="<?php echo U('admin/navigation/save');?>" method="post">
	<div class="form-group">
	
	<label class="control-label pull-left" style="padding-top:20px;padding-left:42px;width:130px">添加栏目:</label>

	<div class="col-md-2 col-sm-2  admin-form">
		<label class="field select">
			<select name="parent_id" id="category" style="height:30px;padding:0px;font-size:12px;margin-top:15px">
				<option value="0">&nbsp;&nbsp;请选择上级分类</option>
				<?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><option value="<?php echo ($category["id"]); ?>" id="option<?php echo ($category["id"]); ?>" name="<?php echo ($category['grade']+1); ?>">
						<?php $__FOR_START_7641__=1;$__FOR_END_7641__=$category["grade"];for($i=$__FOR_START_7641__;$i < $__FOR_END_7641__;$i+=1){ ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>&nbsp;&nbsp;<?php echo ($category["name"]); ?>	
					</option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		    <!-- grade -->
		    <input type="hidden" name="grade" id="grade" value="1" />
	    </label>
	</div>
	
	<div class="col-md-2 col-sm-2" style="padding-top:15px">
		<input type="text" name="name" placeholder="栏目名称" class="form-control input-sm" />				
	</div>
	
	<div class="col-md-4 col-sm-4" style="padding-top:15px">
		<input type="text" name="url" placeholder="栏目网址" class="form-control input-sm" />				
	</div>
	<div class="admin-form">
	<input type="submit" class="btn input-sm" style="padding-top:5px;margin-top:15px" value="添  加"/ ></tr>
	</div>
	</div>
	</form>
	
	
</tr> 
         
         
            <tr>
                <th><input type="checkbox" id="all"></th>
                <th width="60%">导航栏目</th>
                <th width="20%">排序调整</th>
                <th width="20%">管理操作</th>
            </tr>
            
        </thead>

        <tbody>
                                                                                                                               
   		<?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$navigation): $mod = ($i % 2 );++$i;?><tr>
			    <td><input type="checkbox" class="item" name="<?php echo ($navigation["id"]); ?>"></td>
				<td>
					<span style="margin-left: <?php echo ($navigation['grade'] * 20 - 20); ?>px">
						<?php echo ($navigation["name"]); ?>
					</span>
				</td>

				<td>
					<a href="#" class="moveup" id="${navigation.id}" orders="${navigation.orders}" grade="${navigation.grade}"><span class="glyphicons glyphicons-up_arrow"></span>上</a>&nbsp;&nbsp;<a href="#" class="movedown" id="${navigation.id}" orders="${navigation.orders}" grade="${navigation.grade}"><span class="glyphicons glyphicons-down_arrow"></span>下</a>
				</td>
				<td>
					<a href="<?php echo U('admin/navigation/edit',array('id'=>$navigation[id]));?>">编辑</a>&nbsp;&nbsp;
					<a href="#" onclick="del('<?php echo U('/admin/navigation/del',array('id'=>$navigation[id]));?>',this.name)" name="${navigation.name}">删除</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
       </tbody>
       
</table>
</div>
</div>


</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="/git/pcms/Public/admin/assets/skin/default_skin/css/theme_inner.css">
<link rel="stylesheet" type="text/css" href="/git/pcms/Public/admin/css/custom.css">
<link rel="stylesheet" type="text/css" href="/git/pcms/Public/admin/assets/admin-tools/admin-forms/css/admin-forms.css">
<script> if("${info}" != ""){ //parent.bootAlert("${info}"); } </script>
</head>
<body>
<div class="custom_main">

	<div class="custom_title">
		<span class="custom_title_word">分类编辑</span>
		<label class="pull-right"><span class="glyphicons glyphicons-rewind"></span>&nbsp;&nbsp;<a href="${base}/admin/article/category/list" class="custom_href">返回分类</a></label> 
	</div>
	
	<div class="custom_body">                                         
		<form class="form-horizontal" action="<?php echo U('admin/category/update');?>" id="inputForm" method="post" role="form">
	    <input type="hidden" name="id" value="<?php echo ($current["id"]); ?>">
	    <div class="form-group">
	        <label for="name" class="col-md-1 col-sm-1  control-label">分类名称</label>
	        <div class="col-md-5 col-sm-5"><input type="text" name="name" id="name" class="form-control" value="<?php echo ($current["name"]); ?>"></div>      
	    </div>
	
	    <div class="form-group">
			<label for="author" class="col-md-1 col-sm-1 control-label">分类类型</label>
	        <div class="col-md-2 col-sm-2  admin-form">
	        	<label class="field select">
	            <select name="type" id="category">
				<option value="0" <?php if($current["type"] == 0): ?>selected="selected"<?php endif; ?> >标题</option>	
				<option value="1" <?php if($current["type"] == 1): ?>selected="selected"<?php endif; ?> >单篇</option>
				<option value="2" <?php if($current["type"] == 2): ?>selected="selected"<?php endif; ?> >多篇</option>
				</select>
				</label>
	        </div>
		</div>
	
	    <div class="form-group">
	        <label class="col-md-1 col-sm-1  control-label" for="textArea2"></label>
	        <div class="admin-form col-md-5 col-sm-5">
	            <button type="submit" class="button btn-primary mr10">更   新</button>
	        </div>
	    </div>
	        
	    </form>
	</div>
</div>
                        
                        
<script type="text/javascript" src="/git/pcms/Public/admin/vendor/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/git/pcms/Public/admin/vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="/git/pcms/Public/admin/js/jquery.validate.js"></script> 
<script type="text/javascript" src="/git/pcms/Public/admin/assets/js/bootstrap/bootstrap.min.js"></script>

<!--Ueditor 编辑器-->
<script type="text/javascript" charset="utf-8" src="/git/pcms/Public/plugin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/git/pcms/Public/plugin/ueditor/ueditor.all.min.js"> </script>  
<script type="text/javascript" charset="utf-8" src="/git/pcms/Public/plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
   
<script type="text/javascript">
$(document).ready(function() {

    var $inputForm = $("#inputForm");

	// 表单验证
	$inputForm.validate({
		rules: {
			name: "required",
			order: "digits"
		}
	});
	
});
</script>

</body>
</html>
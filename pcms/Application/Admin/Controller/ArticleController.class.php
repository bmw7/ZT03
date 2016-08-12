<?php
namespace Admin\Controller;
use Admin\Common\AuthController;

// +--------------------------------------------
// | Controller - 文章发布/文章管理
// +--------------------------------------------

class ArticleController extends AuthController{
	
	/** 添加页面  */
    public function add(){ 	
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Category'));
    	
    	// 标签
    	$tag_group = M('tag_group');
    	$group = $tag_group->select();
    	if (count($group) > 0){
    		$tag = M('tag');
    		foreach ($group as $k => $v){
    			$group[$k]['tags'] = $tag->where('group_id ='.$v['id'])->select();
    		}
    		$this->assign("groups",$group);
    	}
    	
    	$this->display();
    }
    
    /** 添加-保存  */
    public function save(){
        $Article = M('article');
		$Article->create();
		$Article->content = $_POST['content']; //为了防止转义html字符
		$Article->create_date = Date('Y-m-d H:i:s');
		
		//选中置顶，时间加1000年
		if(I('post.isTop')){
			$year = date('Y')+1000;
			$Article->create_date = $year.'-'.date('m-d H:i:s');
		}
		
		
        if ($Article->add()){
        	
        	// 文章id
        	$article_id = $Article->getLastInsID();
        	
        	// 上传图片session存在
        	if (session('?images')){
        		$article_image = M('article_image');
        		$images = session('images');
        		for ($i=0;$i<count($images);$i++){
        			// 保存图片名称和文章id
        			$article_image->article_id = $article_id;
        			$article_image->filename = $images[$i];
        			$article_image->add();
        			// 更新orders = id
        			$id = $article_image->getLastInsID();
        			$article_image->orders = $id;
        			$article_image->where('id = '.$id)->save();
        		}
        		// 处理完毕，销毁session
        		session('images',null);
        	}
        	
        	// 标签存在
        	if (count($_POST['tags']) > 0){
        		$article_tag = M('Article_tag');
        		$tags = $_POST['tags'];
        		for ($i = 0;$i < count($tags);$i++){
        			$article_tag->article_id = $article_id;
        			$article_tag->title = I('post.title');
        			$article_tag->tag_id = $tags[$i];
        			$article_tag->add();
        		}
        	}
        	
        	$this->success('添加成功！',U('admin/article/add'));
        		
        }else{
        	$this->success('添加失败！',U('admin/article/add'));
        }
        
    }
    
    
    
    
    /** 添加-保存  */
    public function save_conference(){
    	$Article = M('article');
    	$Article->create();
    	$Article->category_id = 5;
    	$Article->content = $_POST['content'].'[#webm#]'.$_POST['content2'].'[#webm#]'.$_POST['content3'].'[#webm#]'.$_POST['content4'].'[#webm#]'.$_POST['content5'].'[#webm#]'.$_POST['content6'].'[#webm#]'.$_POST['content7'].'[#webm#]'.$_POST['content8'].'[#webm#]'.$_POST['content9'].'[#webm#]'.$_POST['content10'].'[#webm#]'.$_POST['content11'].'[#webm#]'.$_POST['content12'].'[#webm#]'.$_POST['content13']; //为了防止转义html字符
    	$Article->create_date = Date('Y-m-d H:i:s');
       
    	if ($Article->add()){ 		 		 
    		$this->success('添加成功！',U('admin/article/add_conference'));
    
    	}else{
    		$this->success('添加失败！',U('admin/article/add_conference'));
    	}
    
    }    
      
    
    
    
    /** 文章管理  */
    public function manage(){
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Category'));
    	$this->display();
    }
    
    /** 文章列表  */
    public function lists(){
    	
    	$article = M('article'); // 实例化User对象
    	$category_id = I('get.id');
    	$count     = $article->where('category_id = '.$category_id)->count();// 查询满足要求的总记录数
    	
    	$Page      = new \Think\Page($count,11);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    	$Page->setConfig('next','下一页');
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('first','首页');
    	$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
    	
    	$show      = $Page->show();// 分页显示输出
    	$list      = $article->where('category_id = '.I('get.id'))->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	
    	$this->assign('list',$list);// 赋值数据集
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('category_id',$category_id);
    	$this->display();
    	
    }
    
    
    /** 文章列表  */
    public function lists_conference(){
    	 
    	$article = M('article'); // 实例化User对象
    	$category_id = I('get.id');
    	$count     = $article->where('category_id = '.$category_id)->count();// 查询满足要求的总记录数
    	 
    	$Page      = new \Think\Page($count,11);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    	$Page->setConfig('next','下一页');
    	$Page->setConfig('prev','上一页');
    	$Page->setConfig('first','首页');
    	$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  共 %TOTAL_ROW% 条记录');
    	 
    	$show      = $Page->show();// 分页显示输出
    	$list      = $article->where('category_id = '.I('get.id'))->order('create_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	 
    	$this->assign('list',$list);// 赋值数据集
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('category_id',$category_id);
    	$this->display();
    	 
    }
    
    /** 文章编辑  */
    public function edit(){
    	$id = I('get.id');
    	
    	// 文章内容
    	$Article = M('article');
    	$db = $Article->where('id = '.$id)->select();
    	$this->assign("article",$db[0]);
    	
    	// 文章目录
    	$categoryService = A('Category','Service');
    	$this->assign("tree",$categoryService->getTree('Category'));
    	
    	// 文章图片
    	$article_image = M('article_image');
    	$image = $article_image->where('article_id = '.$id)->order('orders asc')->select();
    	if (count($image) > 0){
    		$this->assign("images",$image);
    	}
    	
    	// 标签
    	$tag_group = M('tag_group');
    	$group = $tag_group->select();
    	if (count($group) > 0){
    		$tag = M('tag');
    		foreach ($group as $k => $v){
    			$group[$k]['tags'] = $tag->where('group_id ='.$v['id'])->select();
    		}
    		$this->assign("groups",$group);
    		
    		$article_tag = M('Article_tag');
    		$tag_ids = $article_tag->where('article_id ='.$id)->getField('tag_id',true);
    		$this->assign("tag_ids",$tag_ids);
    	}
    	
    	$this->display();
    }
    
    
    
    /** 会议编辑  */
    public function edit_conference(){
    	$id = I('get.id');
    	$this->assign("id",$id);
    	// 文章内容
    	$Article = M('article');
    	$db = $Article->where('id = '.$id)->select();
    	$all = $db[0];
    	
    	$title = $all['title'];
    	$this->assign("title",$title);
    	
    	$content = explode("[#webm#]", $all['content']);
    
    	for ($index = 1;$index<=count($content);$index++){
    		$this->assign("content".$index,$content[$index-1]);
    	}
    	 
    	$this->display();
    }
    
    
    /** 文章删除  */
    public function del(){
    	$Article = M('article');
    	$Article->delete(I('get.id'));
    }
    
    /** 文章更新  */
    public function update(){
    	$Article = M('article');
    	$Article->create();
    	$Article->content = $_POST['content'];
    	$article_id = I('post.id');
    	
    	if (I('post.isTop')){
    		$att = explode("-", I('post.create_date'));
    		$year = $att[0] + 1000;
    		$Article->create_date = $year.'-'.$att[1].'-'.$att[2];
    	}
    	
    	$Article->save();
    	
    	// 上传图片session存在
    	if (session('?images')){
    		$article_image = M('article_image');
    		$images = session('images');
    		for ($i=0;$i<count($images);$i++){
    			// 保存图片名称和文章id
    			$article_image->article_id = $article_id;
    			$article_image->filename = $images[$i];
    			$article_image->add();
    			// 更新orders = id
    			$id = $article_image->getLastInsID();
    			$article_image->orders = $id;
    			$article_image->where('id = '.$id)->save();
    		}
    		// 处理完毕，销毁session
    		session('images',null);
    	}
    	
    	
    	// 标签存在
    	if (count($_POST['tags']) > 0){
    		$article_tag = M('Article_tag');
    		$tags = $_POST['tags'];
    		$tags_origin = M('Article_tag')->where('article_id ='.$article_id)->getField('tag_id',true);
    		 
    		// 表单提交上来的新tags组中的元素  在  旧tags组中查不到,则添加
    		for ($i = 0;$i < count($tags);$i++){
    			if (!in_array($tags[$i],$tags_origin)){
    				$article_tag->article_id = $article_id;
    				$article_tag->title = I('post.title');
    				$article_tag->tag_id = $tags[$i];
    				$article_tag->add();
    			}
    		}
    		 
    		//  旧tags组中的元素，在表单提交上来的新tags组中查不到,则删除
    		for ($i = 0;$i < count($tags_origin);$i++){
    			if (!in_array($tags_origin[$i],$tags)){
    				$article_tag->where("article_id = '%d' and tag_id = '%d'",$article_id,$tags_origin[$i])->delete();
    			}
    		}
    	}
    			
    	$this->success('更新成功！',U('admin/article/add'));
    	
    }
    
    
    /** 会议更新  */
    public function update_conference(){
    	$Article = M('article');
    	$Article->create();
    	$Article->content = $_POST['content1'].'[#webm#]'.$_POST['content2'].'[#webm#]'.$_POST['content3'].'[#webm#]'.$_POST['content4'].'[#webm#]'.$_POST['content5'].'[#webm#]'.$_POST['content6'].'[#webm#]'.$_POST['content7'].'[#webm#]'.$_POST['content8'].'[#webm#]'.$_POST['content9'].'[#webm#]'.$_POST['content10'].'[#webm#]'.$_POST['content11'].'[#webm#]'.$_POST['content12'].'[#webm#]'.$_POST['content13'];
      	$Article->category_id = 5; 
    	$Article->save();
    	  	 
    	$this->success('更新成功！',U('admin/article/lists_conference/id/5'));
    	 
    }
    
    
    /** 图片删除  */
    public function image_del(){
    	$Article_image = M('Article_image');
    	if ($Article_image->delete(I('post.imageId'))){
    		unlink("upload" . DIRECTORY_SEPARATOR . I('post.imageName'));
    		unlink("upload" . DIRECTORY_SEPARATOR . 'thumb_' . I('post.imageName'));
    	}
    }
    
    /** 图片移动  */
    public function image_move(){
    	$Article_image = M('Article_image');
    	
    	$originId = I('post.originId');
    	$changeId = I('post.changeId');

    	$origin_orders = $Article_image->where('id ='.$originId)->getField('orders');
    	$change_orders = $Article_image->where('id ='.$changeId)->getField('orders');
    	
    	$Article_image->orders = $origin_orders;
    	$Article_image->where('id ='.$changeId)->save();
    	
    	$Article_image->orders = $change_orders;
    	$Article_image->where('id ='.$originId)->save();
    }
    
    /** 置顶  */
    public function stick(){
    	$Article = M('Article');
    	$id = I('post.id');
    	$date = $Article->where('id ='.$id)->getField('create_date');
    	$att = explode("-", $date);
    	$year = (I('post.checked') == 'true') ? ($att[0] + 1000) : ($att[0] - 1000);
    	$Article->create_date = $year.'-'.$att[1].'-'.$att[2];
    	$Article->where('id ='.$id)->save();
    	$this->ajaxReturn($year.'-'.$att[1].'-'.$att[2]);
    }
    
    /** 图片上传  */
    public function uploadimages(){
    	// Make sure file is not cached (as it happens for example on iOS devices)
    	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: no-store, no-cache, must-revalidate");
    	header("Cache-Control: post-check=0, pre-check=0", false);
    	header("Pragma: no-cache");
    	
    	// Support CORS
    	// header("Access-Control-Allow-Origin: *");
    	// other CORS headers if any...
    	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    		exit; // finish preflight CORS requests here
    	}
    	
    	
    	if ( !empty($_REQUEST[ 'debug' ]) ) {
    		$random = rand(0, intval($_REQUEST[ 'debug' ]) );
    		if ( $random === 0 ) {
    			header("HTTP/1.0 500 Internal Server Error");
    			exit;
    		}
    	}
    	
    	// header("HTTP/1.0 500 Internal Server Error");
    	// exit;
    	
    	
    	// 5 minutes execution time
    	@set_time_limit(5 * 60);
    	
    	// Uncomment this one to fake upload time
    	// usleep(5000);
    	
    	// Settings
    	// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
    	$targetDir = 'upload_tmp';
    	$uploadDir = 'upload';
    	
    	$cleanupTargetDir = true; // Remove old files
    	$maxFileAge = 5 * 3600; // Temp file age in seconds
    	
    	
    	// Create target dir
    	if (!file_exists($targetDir)) {
    		@mkdir($targetDir);
    	}
    	
    	// Create target dir
    	if (!file_exists($uploadDir)) {
    		@mkdir($uploadDir);
    	}
    	
    	// Get a file name
    	if (isset($_REQUEST["name"])) {
    		$fileName = $_REQUEST["name"];
    	} elseif (!empty($_FILES)) {
    		$fileName = $_FILES["file"]["name"];
    	} else {
    		$fileName = uniqid("file_");
    	}
    	
    	$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
    	$randomFileName = uniqid().rand(100,999).'.'.pathinfo($fileName)['extension']; // 随机文件名
    	$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $randomFileName;
    	
    	// Chunking might be enabled
    	$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    	$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
    	
    	
    	// Remove old temp files
    	if ($cleanupTargetDir) {
    		if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
    			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
    		}
    	
    		while (($file = readdir($dir)) !== false) {
    			$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
    	
    			// If temp file is current file proceed to the next
    			if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
    				continue;
    			}
    	
    			// Remove temp file if it is older than the max age and is not the current file
    			if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
    				@unlink($tmpfilePath);
    			}
    		}
    		closedir($dir);
    	}
    	
    	
    	// Open temp file
    	if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
    		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    	}
    	
    	if (!empty($_FILES)) {
    		if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
    			die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    		}
    	
    		// Read binary input stream and append it to temp file
    		if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
    			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    		}
    	} else {
    		if (!$in = @fopen("php://input", "rb")) {
    			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    		}
    	}
    	
    	while ($buff = fread($in, 4096)) {
    		fwrite($out, $buff);
    	}
    	
    	@fclose($out);
    	@fclose($in);
    	
    	rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
    	
    	$index = 0;
    	$done = true;
    	for( $index = 0; $index < $chunks; $index++ ) {
    		if ( !file_exists("{$filePath}_{$index}.part") ) {
    			$done = false;
    			break;
    		}
    	}
    	if ( $done ) {
    		if (!$out = @fopen($uploadPath, "wb")) {
    			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    		}
    	
    		if ( flock($out, LOCK_EX) ) {
    			for( $index = 0; $index < $chunks; $index++ ) {
    				if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
    					break;
    				}
    	
    				while ($buff = fread($in, 4096)) {
    					fwrite($out, $buff);
    				}
    	
    				@fclose($in);
    				@unlink("{$filePath}_{$index}.part");
    			}
    	
    			flock($out, LOCK_UN);
    		}
    		@fclose($out);
    		
    		// 将上传文件名放入名为images的session
    		if (!session('?images')){
    			$att = array();
    			array_push($att, $randomFileName);
    			session('images',$att);
    		}else{
    			$att = session('images');
    			array_push($att, $randomFileName);
    			session('images',$att);
    		}
    		
    		// 生成缩略图
    		$image = new \Think\Image();
    		$image->open($uploadPath);
    		$image->thumb(150, 150)->save($uploadDir . DIRECTORY_SEPARATOR . "thumb_".$randomFileName);// 按照原图的比例生成一个最大为150*150的缩略图并保存
    	}
    	
    	// Return Success JSON-RPC response
    	die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
    
}







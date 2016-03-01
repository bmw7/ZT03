<?php
namespace Admin\Service;

class NavigationService{
		
    /** 获取目录树 */
    public function getTree(){
    	$result = array();
        $Navigation = M("navigation");
        $navigations = $Navigation->select();
        foreach ($navigations as $item){
            if ($item[grade] == 1){
            	array_push($result,$item);
            	if ($this->hasChildren($item,$navigations)) {  /** 该顶级分类是否有下级分类 */
            		
            		//array_merge($result,$this->getChildren($item,navigations));  /** 该分类所有下级分类递归全部加入 */
            	}
            }
        }
        
        echo $result[2][name];
    }
    
    /** 
     * 是否有下级目录
     * 
     * 判断 $item 在 $navigations 中是否有下级分类
     *  */
    public function hasChildren($item,$navigations){
    	foreach ($navigations as $navigation){
    		echo $item[id];
    		if ($item[id] == $navigation[parentId]){
    			echo '[=========]';
    			return true;
    		}
    	} 	
    	return false;
    }
    
    /** 
     * 获取下级目录
     * 
     * @param unknown $item
     * @param unknown $navigations 
     * */
    public function getChildren($item,$navigations){
    	$sub = array();
    	foreach ($navigations as $navigation){
    		if ($item[id] == $navigation[parentId]) {  // B
    			echo '有子目录';
    			array_push($sub,$navigation);
    			if ($this->hasChildren($navigation, $navigations)){
	    			$navigationAlias = $navigation; // 此步很关键，不然会导致参数在递归中混乱
	    			array_push($sub,$this->getChildren($navigationAlias, $navigations));
    			}
    		}
    	}
    	return $sub;
    }
    
    
    
}
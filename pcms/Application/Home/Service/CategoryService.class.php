<?php
namespace Home\Service;

class CategoryService{
		
    /** 
     * 获取顺序排列的目录树数组
     * 
     * @param $table 表名
     * 
     * @return 获取目录树数组 
     * */
    public function getTree($table){
    	$tree = array();
        $instance = M($table);
        $results = $instance->order('orders asc')->select();
        foreach ($results as $item){
            if ($item[grade] == 1){	
            	array_push($tree,$item);
            	if ($this->hasChildren($item,$results)) {  	
            		$tree = array_merge($tree,$this->getChildren($item,$results));  	
            	}
            }
        }
   		return $tree;
    }
    
    /** 
     * 是否有下级目录   - 判断 $target在 $navigations中是否有下级分类
     * 
     * @param $target   欲查询的目标元素
     * @param $results  结果集数组
     * 
     * @return 结果
     *  */
    public function hasChildren($target,$results){
    	foreach ($results as $item){
    		if ($target[id] == $item[parent_id]){
    			return true;
    		}
    	}
    	return false;
    }
    
    /** 
     * 获取下级目录树数组   - 获取 $target在 $navigations中所有下级元素并加入数组
     * 
 	 * @param $target   欲查询的目标元素
     * @param $results  结果集数组
     * 
     * @return 下级元素数组
     * */
    public function getChildren($target,$reults){
    	$sub = array();
    	foreach ($reults as $item){
    		if ($target[id] == $item[parent_id]) {  
    			array_push($sub,$item);
    			if ($this->hasChildren($item, $reults)){
	    			$sub = array_merge($sub,$this->getChildren($item, $reults));
    			}
    		}
    	}
    	return $sub;
    }
    
    
    
}
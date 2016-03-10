<?php
namespace Admin\Service;

class CryptService{
		
    /** 
     * 加密函数
     * 
     * @param $pass 欲加密数据
     * 
     * @return 加密之后的数据 
     * */
    public function work($pass){
		return md5(crypt($pass,substr($pass,1,2)));
    }
    
}    
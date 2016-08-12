<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function join(){
    	$this->display();
    }

    public function submit(){
        $member = M('guestbook');
        $member->create();
        $member->save();
    }

    
}
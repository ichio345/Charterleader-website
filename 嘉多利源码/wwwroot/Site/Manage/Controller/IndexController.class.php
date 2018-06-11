<?php
namespace Manage\Controller;
use Think\Controller;
class IndexController extends CommonController {
	
    public function index(){
    	$ip = get_client_ip();
		$Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类
		$location = $Ip->getlocation($ip); // 获取某个IP地址所在的位置  当参数为空的时候是获取当前的客户端的
		//var_dump($location);
		$this->display();
    }
    
}
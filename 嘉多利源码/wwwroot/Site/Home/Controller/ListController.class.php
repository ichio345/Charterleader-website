<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends CommonController{
	//产品列表
	public function product(){	
		$this->display();
	}

	//图片列表
	public function picture(){
		$this->display();
	}

	//新闻列表
	public function article(){
		$this->display();
	}

}

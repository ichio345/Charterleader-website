<?php


/**
 * 公共分类获取
 * @return [type] [description]
 */
function selectCl($depth=''){
	$dbc=M('class');
	$field=array('tp_class.ID cid','tp_class.Name cname','PID','depth');
	empty($depth)?$where='':$where['depth']=array('lt',$depth);
	$where['Edition']=session('edition');
	$up_cl=$dbc->field($field)->where($where)->order('Sort')->select();
	return $up_cl;
}


/**
 * [getLevelOfModelId 删除其他的模型]
 */
function getLevelOfModelId($num) {
	//遍历当前模型下的栏目
	foreach ($num as $key => $value){
		if($value['mname']!=strtolower(CONTROLLER_NAME)){
			unset($num[$key]);
		}	
	}
	return $num;	
}


/**
 * 定义一个取产品栏目的方法
 * @param  string $field [description]
 * @return [type]        [description]
 */
function currentl($field=''){
	//获取当前模型的栏目 
	$current=on_class($field);
	import("Class.expand",APP_PATH);
	$object = new \Expand();
	//将数组转成有分类级别的一维数组 
	$num=$object->yiwei($current,"ID",'- ');
	//删除不同模型的分类
	$aa=getLevelOfModelId($num);
	return $aa;	
}


/**
 * [upload 图片上传函数]
 * @param  [type] $cut 		[是否裁剪]
 * @return [type]      [description]
 */
function upload($cut){
	$cut=(int)$cut;
	 $upload = new \Think\Upload();
	 $upload->maxSize   =     3145728 ;// 设置附件上传大小   
	 $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型   
	 $upload->savePath  =      '/'; // 设置附件上传目录    // 上传文件 
	 $upload->rootPath=  './Upload' ;
	 $info   =   $upload->upload();    
	 if(!$info) {	 	 
	 	//上传错误提示错误信息       
	 	return $upload->getError();    
	 }else{
	 	//上传成功        
		foreach($info as $file){
			// 不使用裁剪
			if(!$cut){
				return $file;
			}
			//调用图像处理类
			$image = new \Think\Image(); 
			$picurl=$upload->rootPath.$file['savepath'].$file['savename'];
			$image->open($picurl);
			$width = $image->width();
			if($width>C('SWIDTH')){
				//判断是否添加水印 
				if(C('IS_WATER')){
				// 类型参数（L）是后扩展的按宽度的比例缩放图片
					$image->thumb(C('SWIDTH'),150,'L')->water(C('WATER'),1,50)->save($picurl);
				}else{
					$image->thumb(C('SWIDTH'),150,'L')->save($picurl);
				}	
			}			
		 	return  $file;    
		}
	}
}

/**
 * [Hpage 设置分页]
 * @param [type] $count []
 */
function Hpage($count,$pagesize=0){
empty($pagesize)?$pagesize=C('FPage'):$pagesize;
$page=new \Think\Page($count,$pagesize);
$page->setConfig('prev',"&laquo;"); //上一页
$page->setConfig('next','&raquo;'); //下一页
$page->setConfig('first','首页');  //第一页
$page->setConfig('last','末页');   //最后一页
$page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%'); 
return $page;
}




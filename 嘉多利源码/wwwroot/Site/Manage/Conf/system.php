<?php
//获取核心设置
$hxset=F('hxset','',CONF_PATH);
return array(
	// 验证码字体大小
	'VFONTSIZE' =>15,
	// 验证码位数
	'VLENTH'   =>$hxset['VLENTH'],
	//关闭混淆曲线 
	'VUSECURVE'=>false,
	//杂点
	'VUSENOISE'=>true,
	//URL模式
	'URL_MODEL'=>0,
	'IS_WATER'=>$hxset['is_water'],
	//水印上传路径
	'WATER'=>"./Site/Common/system/water/water.png",
	//缩略图宽
	'SWIDTH'=>1200,	
	//缩略图高
	'SHEIGHT'=>1200,
	//模板样式路径
	'HTStyle'=>__ROOT__.'/Site/Manage/View/Common',
	
	'ClumnPath'=>$hxset['depth'],
);
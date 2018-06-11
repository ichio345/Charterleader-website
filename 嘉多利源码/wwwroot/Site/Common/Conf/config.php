<?php
return array(
    // 加载扩展配置文件
    'LOAD_EXT_CONFIG' =>'db,mail',
    // 设置默认模块
    'MODULE_ALLOW_LIST'    => array('Home','Manage'),
	'DEFAULT_MODULE'       => 'Home',   
    // 显示每列多少个
    'Fpage'=>10,
    //默认错误跳转对应的模板文件
    'TMPL_ACTION_ERROR' => 'Common:error',
    //默认成功跳转对应的模板文件
    'TMPL_ACTION_SUCCESS' => 'Common:success',
    // 'SHOW_ERROR_MSG'      =>  false, 
    // 'ERROR_PAGE'          => __ROOT__.'/Home/Index/index'  , 
   // 系统版本
    'SYS_VERSION'=>'V2016.01',



);
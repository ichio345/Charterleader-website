<?php
//模板名
$tmName=F('hxset','',CONF_PATH)['systemp'];
return array(
	//开启页面Trace
	 //'SHOW_PAGE_TRACE' =>true,
	// 'APP_STATUS'	=> 'debug',
	// 更改默认的/Public 替换规则  
	'TMPL_PARSE_STRING'  =>array('__PUBLIC__' =>__ROOT__.APP_PATH .'Common'),
	//设置网站的前台模板
    'DEFAULT_V_LAYER'  => 'Templates',
    'VIEW_PATH'=>'./Templates/',
    'TMPL_DETECT_THEME'=>true,
    //'DEFAULT_THEME'=>'default',
    'DEFAULT_THEME'=>$tmName,
    //模板样式路径
    'TMURL'=>__ROOT__."/Templates/{$tmName}/Common",

    // 语言常量
    'EDITION'=>1,
    'URL_CASE_INSENSITIVE' => true,
    'URL_MODEL'=>2,
    //自定义标签库
    'TAGLIB_LOAD'=>true,//加载标签库打开
    'APP_AUTOLOAD_PATH'=>'@.TagLib',//标签库的文件名
    'TAGLIB_BUILD_IN'=>'Cx,Home\TagLib\TagLibLd', //标签库类名 ,注意自定义的标签库要写全路径


    'URL_PATHINFO_DEPR'=>'/',
    //开启路由
    'URL_ROUTER_ON'   => true , 
    // 加载扩展配置文件
    'LOAD_EXT_CONFIG' =>'url_route',

    // 设置语言包
    'DEFAULT_LANG'         => 'cn',
    'LANG_SWITCH_ON'       => true,// 开启语言包功能
    'LANG_AUTO_DETECT'     => true, // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'            => 'cn,en', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'         => 'l', // 默认语言切换变量


// 配置邮件发送服务器(易动力自己的邮件发送配置)
    // 'MAIL_HOST' =>'smtp.exmail.qq.com',//smtp服务器的名称
    // 'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    // 'MAIL_USERNAME' =>'ydlmessage@jsydl.com',//你的邮箱名
    // 'MAIL_FROM' =>'ydlmessage@jsydl.com',//发件人地址
    // 'MAIL_FROMNAME'=>'易动力网络',//发件人姓名
    // 'MAIL_PASSWORD' =>'Ydl004',//邮箱密码
    // 'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    // 'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件


// 配置邮件发送服务器(客户自己的邮件发送配置)
    'MAIL_HOST' =>'smtp.qq.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'',//你的邮箱名
    'MAIL_FROM' =>'',//发件人地址
    'MAIL_FROMNAME'=>'',//发件人姓名
    'MAIL_PASSWORD' =>'',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
   
);


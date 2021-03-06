<?php
return array(
    //自定义模板定界符
    'TMPL_L_DELIM'=>'{y!',
    'TMPL_R_DELIM'=>'}',
	//开启页面Trace
	// 'SHOW_PAGE_TRACE' =>true,
	// 'APP_STATUS'	=> 'debug',
	// 更改默认的/Public 替换规则  
	'TMPL_PARSE_STRING'  =>array('__PUBLIC__' => __ROOT__.'/Common/Js'),
	//是否需要认证，设置为true时$rbac::AccessDecision()函数才会根据当前的操作检查权限并返回true或false，，设为false只返回true  
    'USER_AUTH_ON'     =>    true,  
    //认证类型,2代表每次进行操作的时候都会数据库取出权限(权限更改即时生效)，1代表只在登录的时候取出权限(权限更改下次登录时生效)  
    'USER_AUTH_TYPE'     =>    1,  
    //认证识别号,执行$rbac::saveAccessList();的时候回用以这个为键值的session去数据库取权限  
    'USER_AUTH_KEY' =>    'user_id',  
    //认证网关,执行$rbac::checkLogin()函数(检查是否登录),如果没有登录，去到这个设置的网址(当前url直接加上这个设置的值)  
    'USER_AUTH_GATEWAY' =>'/login',  
    //数据库连接DSN???  
    //'RBAC_DB_DSN'  =>,  
    //角色表名称  
    'RBAC_ROLE_TABLE' =>'tp_role',  
    //用户表名称(rbac类说的是用户表，其实是用户角色关联表)  
    'RBAC_USER_TABLE' =>'tp_role_user',  
    //权限表名称  
    'RBAC_ACCESS_TABLE' =>'tp_access',  
    //节点表名称  
    'RBAC_NODE_TABLE' =>'tp_node',  
    //定义rbac超级管理员,登录成功之后把用户名和这个值进行比对，一样就是超级管理员  
    'RBAC_SUPERADMIN'   =>  'jsydl',  
    //超级管理员识别,当当前用户是超级管理员时，把键值为这个值的session这个设置为true，当前用户就能进行一切操作  
    'ADMIN_AUTH_KEY'    =>  'superadmin',
    //无须认证的模块 
    'NOT_AUTH_MODULE' =>'Index,Common',
     'NOT_AUTH_ACTION' =>'add_user_form,uppath,common_fl,login,login_form,code,yzlogin,userout,ajax_click_pic,ajax_sort_pic,ajax_click_product,ajax_sort_product,updata_admin,sort_column,ajax_click_article',
    'LOAD_EXT_CONFIG' =>'system',
);


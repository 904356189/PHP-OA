<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODEL' => '2',
    'MULTI_MODULE' => false,
    'DEFAULT_MODULE' => 'OA',
	
	//数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'oa', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'oa_', // 数据库表前缀

    //权限管理设置

    'AUTH_ON'           => true,            // 认证开关
    'AUTH_TYPE'         => 1,               // 认证方式，1为实时认证；2为登录认证。
    'AUTH_GROUP'        => 'group',        // 用户组数据表名
    'AUTH_GROUP_ACCESS' => 'group_access', // 用户-用户组关系表
    'AUTH_RULE'         => 'rule',         // 权限规则表
    'AUTH_USER'         => 'user',             // 用户信息表


	'APP_DEBUG'     => true,
 	'TMPL_CACHE_ON' => false,
	'TMPL_CACHE_ON' => false
);
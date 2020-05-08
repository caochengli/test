<?php
$DB_CONFIG = array(
	//'配置项'=>'配置值'
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '127.0.0.1', // 服务器地址
	'DB_NAME'   => 'guancn', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => 'root', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'jw_', // 数据库表前缀
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
);
$SITE_CONFIG = include 'config.site.php';
$SYS_CONFIG = include 'config.sys.php';
/*$WECHAT_CONFIG = include 'config.wechat.php';
$WXPAY_CONFIG = include 'config.wxpay.php';
$MAIL_CONFIG = include 'config.mail.php';
$ALI_CONFIG = include 'config.alipaychr.php';
return array_merge($DB_CONFIG,$SITE_CONFIG,$SYS_CONFIG,$WXPAY_CONFIG,$WECHAT_CONFIG,$MAIL_CONFIG,$ALI_CONFIG);*/
return array_merge($DB_CONFIG,$SITE_CONFIG,$SYS_CONFIG);
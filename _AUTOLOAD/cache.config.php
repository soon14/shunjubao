<?php
/**
 * @name cache.config.php
 * @desc memcache & mysql cache 配置文件
 * @author caoxd
 * @todo 1.支持mysql 主从设置.及多从自动轮循.   2.数据库管理生成配置
 **/

$host = '127.0.0.1';

$CACHE['memcached'] = array(
        'default' => array(
                array(
                        "{$host}", 11211, 1
                ),
//              array(
//                      "{$host}", 11211, 2
//              ),
        ),
);

$CACHE['ttserver'] = array(
	'default' => array(
		array(
			'host'=>"{$host}",
			'port'=>'11211',
			'weight'	=> 1,
		),
	),
);

$CACHE['db'] = array(
    'default'   => "mysqli://root:meijun820526^&LKASI@{$host}:3306/zhiying",
	'leida'   	=> "mysqli://root:meijun820526^&LKASI@{$host}:3306/leida",
	'log_data'	=>	"mysqli://root:meijun820526^&LKASI@{$host}:3306/log_data",
	'org_spdata'	=>	"mysqli://root:meijun820526^&LKASI@{$host}:3306/org_spdata",
	'quan'	=>	"mysqli://root:meijun820526^&LKASI@{$host}:3306/zhiying_quan",
);
?>

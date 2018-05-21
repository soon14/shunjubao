<?php
/**
 * 智赢项目api接口配置信息
 * 接口输入必要参数：
 * appId->int
 * timastamp->时间戳
 * token->string(16)
 * 为每一个第三方分配的appKey
 */
return array(
	ZYAPI::APPID_WWW => array(
		'appId'		=> ZYAPI::APPID_WWW,
		'appKey'	=> 'b35977a00ebd8086',
		'desc'		=> '智赢主项目',
	),
	ZYAPI::APPID_SHOP => array(
		'appId'		=> ZYAPI::APPID_SHOP,
		'appKey'	=> '992b96d001bb16e8',
		'desc'		=> '智赢商城',
	),
	ZYAPI::APPID_WANGZUOZHU => array(
		'appId'		=> ZYAPI::APPID_WANGZUOZHU,
		'appKey'	=> '9cb6bc11c960e0c7',
		'desc'		=> 'wzz项目',
	),
	ZYAPI::APPID_HEZHENGDE => array(
		'appId'		=> ZYAPI::APPID_HEZHENGDE,
		'appKey'	=> 'b9705bc6df1e6b9',
		'desc'		=> 'hzd项目',
	),
	
);
<?php
/**
 * 唯一CPS跳转页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if(!get_cfg_var("register_globals")){
	$cid = $_REQUEST["cid"];
	$url = $_REQUEST["url"]?$_REQUEST["url"]: ROOT_DOMAIN;
}
Header("P3P:CP=\"NOI DEVa TAIa OUR BUS UNI\"");

$rd = 30; //这里是设置COOKIE的有效周期，请按合同规定的广告效果认定期设置， 此处假设广告效果认定期为30天
If($rd==0){
	SetCookie("weiyi", "$cid", 0, "/", DOMAIN);
}
else{
	SetCookie("weiyi", "$cid", time()+($rd*24*60*60), "/", DOMAIN);
}

# 加入$adsense_from,$channelid参数
$url_info = parse_url($url);
$tmpQuery = $url_info['query'];
parse_str($tmpQuery, $params);
if(!$params['channelid']){
	$url = jointUrl($url, array('channelid' => '9000004'));
}
if(!$params['adsense_from']){
	$url = jointUrl($url, array('adsense_from' => 'weiyi'));
}

//重定向URL
Header("Location: $url");
Header("URI: $url");
?>
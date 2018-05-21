<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$source = $_GET['source'];//duomai
$url = $_GET['u'];
$edid = $_GET['edid'];

if($source != 'duomai') {
    die('error');
}

$channelid = '9000006';
$rd = 30; //这里是设置COOKIE的有效周期，请按合同规定的广告效果认定期设置， 此处假设广告效果认定期为30天
SetCookie('duomai', "$edid", time()+($rd * 86400), "/", DOMAIN);

# 加入$adsense_from,$channelid参数
$url_info = parse_url($url);
$tmpQuery = $url_info['query'];
parse_str($tmpQuery, $params);

if(!$params['channelid']){
	$url = jointUrl($url, array('channelid' => $channelid));
}
if(!$params['adsense_from']){
	$url = jointUrl($url, array('adsense_from' => $source));
}

//重定向URL
Header("Location: $url");
Header("URI: $url");
?>
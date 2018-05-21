	<?php
/**
 * 360 CPS接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$bid	= Request::p('bid');
$qihoo_id	= Request::p('qihoo_id');

$url = Request::p('url', Filter::TRIM);// 默认会做html转义，把&替换成&amp; ，所以这里改为只处理trim
if (!$url) {
	$url = ROOT_DOMAIN;
}

$active_time = Request::p('active_time');
$ext	= Request::p('ext');
$sign	= Request::p('sign');
$qid	= Request::p('qid');
$qmail	= Request::p('qmail');
$qname	= Request::p('qname');
$cp_key = Qihoo360Connect::CP_KEY;

if ($bid != Qihoo360Connect::BID) {
	redirect($url);
}

/*
$request = true; //签名验证失败或检查超时
if ( $sign != md5("{$bid}#{$active_time}#{$cp_key}#{$qid}#{$qmail}#{$qname}") ) { //签名验证失败 向360cps系统发送一个请求
	$request = false;
	$time = time();
	$ne_sign = md5("{$bid}#{$active_time}#{$cp_key}");
	$url = "http://open.union.360.cn/gofailed?bid={$bid}&active_time={$time}&sign={$ne_sign}&pre_bid={$bid}&pre_active_time={$active_time}&pre_sign={$sign}&qid={$qid}&qname={$qname}&qmail={$qmail}";
	$objCurl = new Curl($url);
	$objCurl->get();
}

if ( (time() - $active_time) > (15*60) ) {
	$request = false;
}
*/
$url_info = parse_url($url);
$tmpQuery = $url_info['query'];
parse_str($tmpQuery, $params);

if(!$params['channelid']){
	$url = jointUrl($url, array('channelid' => '4000006'));
}
if(!$params['adsense_from']){
	$url = jointUrl($url, array('adsense_from' => 'mall360'));
}

if ($params['channelid'] == 2400002) { //暂时去掉360团购CPS
	redirect($url);
}

$cookieInfo = array(
	'bid'	=> $bid,
	'qid'	=> $qid,
	'qihoo_id'=> $qihoo_id,
	'ext'	=> $ext,
);
SetCookie("qihoo360", json_encode($cookieInfo), time() + Qihoo360Connect::RD * 86400, "/", DOMAIN);
Setcookie(Qihoo360Connect::TUAN_360_COOKIE_NAME, null, time() - 1, "/", DOMAIN); // 取消团购的cookie

# 自动登录
if ( $qid ) {
	$reloginUrl = ROOT_DOMAIN . "/connect/360_bind.php?state=".ConnectBind::SITE_360."&qid={$qid}&qmail={$qmail}&qname={$qname}&referer={$url}";
	redirect($reloginUrl);
}
redirect($url);


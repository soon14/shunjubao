<?php
/**
 * 由亿起发广告过来的跳转页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

# 跳转地址
$url = Request::g('url', Filter::TRIM);// 默认会做html转义，把&替换成&amp; ，所以这里改为只处理trim
if (!$url) {
	$url = ROOT_DOMAIN;
}

$url_info = parse_url($url);
$tmpQuery = $url_info['query'];
parse_str($tmpQuery, $params);

if(!$params['channelid']){
	if (Request::g('channelid')) {
		$url = jointUrl($url, array('channelid' => Request::g('channelid')));
	} else {
		$url = jointUrl($url, array('channelid' => '9000001'));
	}
}

if(!$params['adsense_from']){
	$url = jointUrl($url, array('adsense_from' => 'yima'));
}

##############################
# 处理360团购特权活动
do {
	if ($params['channelid'] != '2400002') {
		break;
	}
	if (!(isset($_GET['_360t']) && isset($_GET['_360right']) && isset($_GET['_360sign']))) {
		break;
	}
	if (md5("d3f4546b1f59798cf892a3250b65e8db|gao_jie|{$_GET['_360right']}|{$_GET['_360t']}") != $_GET['_360sign']) {
		break;
	}
	if ($_GET['_360right'] == '101') {
		$url = str_replace('2400002', '2400022', $url);
	}
} while (false);

##############################

# 亿起发标识
if( Request::g('src') == 'ymcps'){
	$src = Request::g('src');
}else{
	$src = '';
}

# 来源渠道
if( Verify::unsignedInt(Request::g('cid')) ){
	$cid = Request::g('cid');
}else{
	$cid = '';
}

if( Request::g('wi')){
	$wi = Request::g('wi');
}else{
	$wi = '';
}

$info = "{$src}|{$cid}|{$wi}";

setcookie('eqifa_cps', $info, time()+ 30*86400, '/', DOMAIN);

redirect($url);


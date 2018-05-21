<?php
/**
 * 360团购 CPS
 * cps文档地址：http://union.360.cn/help/apidocnew#
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$params = Request::getRequestParams();

$bid = $params['bid']; // 合作方网站编号
$qihoo_id = $params['qihoo_id']; // 360业务编号
$url = !empty($params['url']) ? $params['url'] : ROOT_DOMAIN;
$from_url = $params['from_url']; // 请求来源url
$active_time = $params['activity_time']; // 调用发起时间，unix时间戳
$ext = $params['ext']; // 扩展字段，需保存到订单中
$qid = $params['qid']; //360用户ID，保存到订单中
$qmail = $params['qmail']; // 360用户邮箱地址
$qname = $params['qname']; // 用户显示名称
$sign = $params['sign']; // 签名字符串

# 补充来源渠道
$url_info = parse_url($url);
$tmpQuery = $url_info['query'];
parse_str($tmpQuery, $url_params);
$url = jointUrl($url, array('channelid' => '2400002'));
$url = jointUrl($url, array('adsense_from' => 'tuan360'));

if ($bid != Qihoo360Connect::TUAN_BID) {
	redirect($url);
}

$cookies = array(
	'qihoo_id'	=> $qihoo_id,
	'ext'		=> $ext,
	'qid'		=> $qid,
);
SetCookie(Qihoo360Connect::TUAN_360_COOKIE_NAME, json_encode($cookies), time() + Qihoo360Connect::RD * 86400, "/", DOMAIN);
Setcookie("qihoo360", null, time() - 1, "/", DOMAIN); // 取消购物的cookie

# 验签
$sign_arr = array($bid, $active_time, Qihoo360Connect::TUAN_CP_KEY, $qid, $qmail, $qname);
$new_sign = md5(join("#", $sign_arr));
if (!$sign) { // 验签失败或检查超时，不进行自动登录，向360返回异常信息
	$from_ip = Request::getIpAddress();
	$gofailed_url = "http://open.union.360.cn/gofailed?bid={$bid}&active_time={$active_time}&sign={$new_sign}&pre_bid={$bid}&pre_active_time={$active_time}&pre_sign={$sign}&qid={$qid}&qname={$qname}&qmail={$qmail}&from_url={$from_url}&from_ip={$from_ip}";
	$objCurl = new Curl($gofailed_url);
	$objCurl->get();
	
	redirect($url);
}

# 自动登录
if ( $qid ) {
	$reloginUrl = ROOT_DOMAIN . "/connect/360_bind.php?state=".ConnectBind::SITE_360."&qid={$qid}&qmail={$qmail}&qname={$qname}&referer={$url}";
	redirect($reloginUrl);
}

redirect($url);
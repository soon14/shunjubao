<?php
/**
 * 获取赛事信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if (stripos($_SERVER['HTTP_REFERER'],'yingzai360.com') !== false) {
	exit;
}

$s		= $_REQUEST["s"];
$p		= $_REQUEST["p"];//北单时，p表示lotteryId
$f		= $_REQUEST["f"];
$date	= $_REQUEST["d"]?$_REQUEST["d"]:date("Y-m-d");//当玩法为北单时，d表示期数即：issueNumber

// $objZYMemcache = new ZYMemcache();
// $key = $s.'_list_'.$p.'_'.$date;
// $result = $objZYMemcache->get($key);
// if (!$result) {
	
	
	switch($s){
		case "fb":
			$result = fb_list($p, $date);
			break;
		case "bk":
			$result = bk_list($p, $date);
			break;
		case "bd":
			$result = bd_list($p, $date);
			break;
		default:
			ajax_fail_exit('未知的类型');
			break;
	}
// 	$objZYMemcache->set($key, $result, 1, 7200);
// }
ajax_success_exit($result);
?>
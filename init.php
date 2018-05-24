<?php
ob_start();
include dirname(__FILE__) . DIRECTORY_SEPARATOR .'_LOCAL/local.inc.php';

include YIC_PATH . '/init.php';

include_once ROOT_PATH . DIRECTORY_SEPARATOR . 'function.inc.php';

header('P3P: CP="ALL ADM DEV PSAi COM OUR OTRo STP IND ONL"');

# 如果存在特定的cookie及值，则将后续的查询语句，强制指定到主库上
# 该方案用于解决mysql主、从同步延迟问题。
//if (TMCookie::get(getCookieKeyForMasterDBHasWrite()) == '1') {
//	# 把后续的查询语句，强制指定到主库上
//	$objDBTransaction = new DBTransaction();
//	$objDBTransaction->beginUseMaster();
//}

Session::Init(SESSION_EXPIRE_TIME, '/', ROOT_DOMAIN);

$TEMPLATE['keywords'] 		= '竞彩,中国竞彩网,足彩,中国足彩网,篮彩,单场,福彩,体彩,足球彩票,篮球彩票';
$TEMPLATE['description'] 	= '智赢网是彩票赢家的聚集地，口碑最好的彩票做单网站，竞彩、单场彩票、篮球彩票、足球彩票人气超旺，可以通过网站和手机客户端使用。提供福利彩票和体育彩票的开奖、走势图表、缩水过滤、奖金评测、比分直播等资讯服务。';

if (isset($_SERVER['HTTP_HOST'])) {
	if ($_SERVER["HTTP_HOST"] == '202.85.221.248' || $_SERVER["HTTP_HOST"] == 'zhiying365365.com') redirect('http://www.shunjubao.xyz' , 301);
	
}
?>
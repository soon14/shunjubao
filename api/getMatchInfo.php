<?php
/**
 * 获取赛事信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_MATCHINFO;

$matchId = Request::r('matchId');
$sport = Request::r('sport');

$objZYAPI = new ZYAPI();
if (!Verify::int($matchId)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_PARAMS);
}

if (!in_array($sport, array('bk','fb'))) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_PARAMS);
}

$objBetting = new Betting($sport);
$matchInfo = $objBetting->get($matchId);





if (!$matchInfo) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_PARAMS);
}
$objZYAPI->outPutF($matchInfo);
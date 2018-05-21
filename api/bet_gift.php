<?php
/**
 * 投注赠送积分
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_BET_SCORE;
$params = Request::getRequestParams();

//total
$score = $params['total'];
$to_uid = $params['to_uid'];

if (!Verify::int($to_uid)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$objZYAPI = new ZYAPI();
$objUserAccountFront = new UserAccountFront();
$userAccount = $objUserAccountFront->get($to_uid);

if (!$userAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}


//接受人
$toUserAccount = $objUserAccountFront->get($to_uid);
if (!$toUserAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$result = $objUserAccountFront->addScore($to_uid, $score);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserScoreLogFront = new UserScoreLogFront();
$tableInfo = array();
$tableInfo['u_id'] 			= $to_uid;
$tableInfo['score'] 		= $score;
$tableInfo['log_type'] 		= BankrollChangeType::GIFT_API_BET;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $to_uid;
$objUserScoreLogFront->add($tableInfo);

$objZYAPI->outPutS();
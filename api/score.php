<?php
/**
 * 账户消费积分接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_SCORE;
$params = Request::getRequestParams();

//total
$score = $params['total'];
$u_id = $params['u_id'];

$objZYAPI = new ZYAPI();
$objUserAccountFront = new UserAccountFront();
$userAccount = $objUserAccountFront->get($u_id);

if (!$userAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

if ($userAccount['score'] < $score) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_CASH_BZ);
}

$result = $objUserAccountFront->consumeScore($u_id, $score);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserScoreLogFront = new UserScoreLogFront();
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['score'] 		= $score;
$tableInfo['log_type'] 		= BankrollChangeType::SCORE_API_CONSUME;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $u_id;
$objUserScoreLogFront->add($tableInfo);

$objZYAPI->outPutS();
<?php
/**
 * 打赏消积分额接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_DASHANG_SCORE;
$params = Request::getRequestParams();

//total
$score = $params['total'];
$u_id = $params['u_id'];
$to_uid = $params['to_uid'];

if (!Verify::int($u_id) || !Verify::int($to_uid)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$objZYAPI = new ZYAPI();
$objUserAccountFront = new UserAccountFront();
$userAccount = $objUserAccountFront->get($u_id);

if (!$userAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

if ($userAccount['score'] < $score) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_CASH_BZ);
}

//接受人
$toUserAccount = $objUserAccountFront->get($to_uid);
if (!$toUserAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$result = $objUserAccountFront->consumeScore($u_id, $score);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserScoreLogFront = new UserScoreLogFront();
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['score'] 		= $score;
$tableInfo['log_type'] 		= BankrollChangeType::SCORE_API_CONSUME_DASHANG;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $u_id;
$objUserScoreLogFront->add($tableInfo);

$result = $objUserAccountFront->addScore($to_uid, $score);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$tableInfo = array();
$tableInfo['u_id'] 			= $to_uid;
$tableInfo['score'] 		= $score;
$tableInfo['log_type'] 		= BankrollChangeType::SCORE_API_ADD_DASHANG;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $to_uid;
$objUserScoreLogFront->add($tableInfo);

$objZYAPI->outPutS();
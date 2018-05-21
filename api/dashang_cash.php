<?php
/**
 * 打赏消费金额接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_DASHANG_CASH;
$params = Request::getRequestParams();

//total,单位：分
$cash = ConvertData::toMoney($params['total']/100);
$u_id = $params['u_id'];
$to_uid = $params['to_uid'];

if (!Verify::int($u_id) || !Verify::int($to_uid)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$objZYAPI = new ZYAPI();
$objUserAccountFront = new UserAccountFront();
$userAccount = $objUserAccountFront->get($u_id);
//打赏人
if (!$userAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

if ($userAccount['cash'] < $cash) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_CASH_BZ);
}

//接受人
$toUserAccount = $objUserAccountFront->get($to_uid);
if (!$toUserAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$result = $objUserAccountFront->consumeCash($u_id, $cash);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['money'] 		= $cash;
$tableInfo['log_type'] 		= BankrollChangeType::CASH_API_CONSUME_DASHANG;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $u_id;
$objUserAccountLogFront->add($tableInfo);

$result = $objUserAccountFront->addCash($to_uid, $cash);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountLogFront = new UserAccountLogFront($to_uid);
$tableInfo = array();
$tableInfo['u_id'] 			= $to_uid;
$tableInfo['money'] 		= $cash;
$tableInfo['log_type'] 		= BankrollChangeType::CASH_API_ADD_DASHANG;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $to_uid;
$objUserAccountLogFront->add($tableInfo);

$objZYAPI->outPutS();
<?php
/**
 * 大乐透扣款
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';




$params = Request::getRequestParams();

//total,单位：分
$cash = ConvertData::toMoney($params['total']/100);
$u_id = $params['u_id'];

$objZYAPI = new ZYAPI();
$objUserAccountFront = new UserAccountFront();
$userAccount = $objUserAccountFront->get($u_id);

if (!$userAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}


$result = $objUserAccountFront->addCash($u_id, $cash);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['money'] 		= $cash;
$tableInfo['log_type'] 		= BankrollChangeType::CASH_API_DLT_REFUND;
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $u_id;
$objUserAccountLogFront->add($tableInfo);

$objZYAPI->outPutS();
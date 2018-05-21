<?php
/**
 * 分红接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_ZHONGCHOU_FH;
$params = Request::getRequestParams();

//total,单位：分
$cash = ConvertData::toMoney($params['total']/100);
$to_uid = $params['u_id'];
$sysId = $params['sysid'];//众筹项目id

$objZYAPI = new ZYAPI();

if (!Verify::int($to_uid)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

if (!Verify::int($sysId)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountFront = new UserAccountFront();

//接受人
$toUserAccount = $objUserAccountFront->get($to_uid);
if (!$toUserAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

$result = $objUserAccountFront->addCash($to_uid, $cash);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountLogFront = new UserAccountLogFront($to_uid);
$tableInfo = array();
$tableInfo['u_id'] 			= $to_uid;
$tableInfo['money'] 		= $cash;
$tableInfo['log_type'] 		= BankrollChangeType::CASH_API_ADD_ZC;
$tableInfo['record_table'] 	= 'q_project';//对应的表
$tableInfo['record_id'] 	= $sysId;
$objUserAccountLogFront->add($tableInfo);

$objZYAPI->outPutS();
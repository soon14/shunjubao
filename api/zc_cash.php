<?php
/**
 * 众筹扣款接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_ZHONGCHOU_CASH;
$params = Request::getRequestParams();

//total,单位：分
$cash = ConvertData::toMoney($params['total']/100);
$u_id = $params['u_id'];
$sysId = $params['sysid'];//众筹项目id

$objZYAPI = new ZYAPI();

if (!Verify::int($u_id)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

if (!Verify::int($sysId)) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountFront = new UserAccountFront();
$userAccount = $objUserAccountFront->get($u_id);

if (!$userAccount) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_UID);
}

if ($userAccount['cash'] < $cash) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_CASH_BZ);
}

$result = $objUserAccountFront->consumeCash($u_id, $cash);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['money'] 		= $cash;
$tableInfo['log_type'] 		= BankrollChangeType::CASH_API_CONSUME_ZC;
$tableInfo['record_table'] 	= 'q_project';//对应的表
$tableInfo['record_id'] 	= $sysId;
$objUserAccountLogFront->add($tableInfo);

$objZYAPI->outPutS();
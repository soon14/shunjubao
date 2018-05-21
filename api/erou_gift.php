<?php
/**
 * 欧洲杯赠送彩金
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$_GET['type'] = ApiItems::API_ITEM_BET_SCORE;
$params = Request::getRequestParams();

//total
$gift = $params['total'];
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

$result = $objUserAccountFront->addGift($to_uid, $gift);

if (!$result->isSuccess()) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_OTHER);
}

$tableInfo = array();
$tableInfo['u_id'] 			= $to_uid;
$tableInfo['gift'] 			= $gift;
$tableInfo['log_type'] 		= BankrollChangeType::ACTIVITY_GIFT;
$tableInfo['old_gift'] 		= $toUserAccount['gift'];//原金额
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $to_uid;
$tableInfo['create_time'] 	= date("Y-m-d H:i:s",time());
//添加账户日志
$objUserGiftLogFront = new UserGiftLogFront();
$tmpResult = $objUserGiftLogFront->add($tableInfo);

$objZYAPI->outPutS();
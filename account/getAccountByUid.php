<?php
/*
 * 根据uid查询账户余额
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$uid = Runtime::getUid();

$objAccountFront = new AccountFront();
$accountInfo = $objAccountFront->get($uid);

if ($accountInfo) {
	$balance = ConvertData::toMoney($accountInfo["balance"]/100);
	ajax_success_exit(array('type'=>'OK','msg'=>'获取账户余额信息成功','balance'=>$balance));
} else {
	ajax_fail_exit('获取账户余额信息失败');
}
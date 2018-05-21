<?php
/**
 * 世界杯期间充值赠送彩金
 * 一，首次充值送彩金
1，活动时间：2014-6-13 0:00——2014-7-14 23:59 （注：以充值成功时间为准）
2，凡是智赢网会员在活动期间充值可得相应购彩金
3，充值送彩金，具体充值数额和赠送购彩金数额为：
充值1000元——可得100元购彩金
充值5000元——可得800元购彩金
充值10000元及以上——可得2000元购彩金
4，活动期间，每个用户的充值赠仅有一次机会（以活动期间第一次充值额度计算赠送彩金）。
5，彩金分两次赠送，每次赠送彩金额度的一半，第一次赠送为充值结束后，第二次赠送时间为2014-07-15 00:00:00
6，如遇特殊情况终止活动，智赢网返还充值本金，购彩金不做返还。
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
exit;
$objUserGiftLogFront = new UserGiftLogFront();
$results = $objUserGiftLogFront->getsByCondition(array('log_type'=>BankrollChangeType::ACTIVITY_GIFT_CHARGE_WORLDCUP), null, 'create_time asc');

if (!$results) {
	echo_exit('no result');
}
$r = array();
$r['total_amount'] = 0;//赠送总人数
$r['total_gift'] = 0;//赠送总彩金
foreach ($results as $value) {
	
	if (strtotime($value['create_time']) > strtotime('2014-07-15 00:00:00')) {
		echo 'create_time wrong|';
		continue;
	}
	
	$gift = $value['gift'];//已经赠送的彩金，恰好为未赠送的数额
	$u_id = $value['u_id'];
	
	$objDBTransaction = new DBTransaction();
	$strTransactionId = $objDBTransaction->start();
	
	$objUserAccountFront = new UserAccountFront();
	$objUserMemberFront = new UserMemberFront();
	$userInfo = $objUserMemberFront->get($u_id);
	$tmpResult = $objUserAccountFront->addGift($u_id, $gift);
	
	if (!$tmpResult->isSuccess()) {
		echo 'add gift wrong|';continue;
	}
	
	$userAccountInfo = $objUserAccountFront->get($u_id);
	
	$tableInfo = array();
	$tableInfo['u_id'] 			= $u_id;
	$tableInfo['gift'] 			= $gift;
	$tableInfo['log_type'] 		= BankrollChangeType::ACTIVITY_GIFT_CHARGE_WORLDCUP;
	$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
	$tableInfo['record_table'] 	= 'user_account';//对应的表
	$tableInfo['record_id'] 	= $u_id;
	$tableInfo['create_time'] 	= getCurrentDate();
	//添加账户日志
	
	$tmpResult = $objUserGiftLogFront->add($tableInfo);
		
	if (!$tmpResult) {
		$objDBTransaction->rollback($strTransactionId);
		echo 'add gift_log wrong|';continue;
	}
	
	if (!$objDBTransaction->commit($strTransactionId)) {
		echo DbException::COMMIT_TRANSACTION_FAIL;
	}
	$r['total_gift'] += $gift;
	$r['total_amount']++;
	$r['users'][] = array(
		'uid'=>$u_id,
		'uname'=>$userInfo['u_name'],
		'gift'=>$gift,
		'charge_time'=>$value['create_time'],
	);
}
pr($r);
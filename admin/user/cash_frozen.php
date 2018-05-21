<?php
/**
 * 账户资金解冻
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$tpl = new Template();
$u_name = Request::r('u_name');
$frozen = Request::r('frozen_cash');//待转移的冻结资金

$objUserMemberFront = new UserMemberFront();
$user = $objUserMemberFront->getByName($u_name);
if ($user) {
	$u_id = $user['u_id'];
	$objUserAccountFront = new UserAccountFront();
	
	$userAccountInfo = $objUserAccountFront->get($u_id);
	$tpl->assign('user', $user);
	$tpl->assign('userAccountInfo', $userAccountInfo);
}

if (!$frozen) {
	echo_exit($tpl->r('../admin/user/cash_frozen'));
}

if ($frozen < 0) {
	fail_exit('申请转移的冻结资金:'.$frozen.'不正确');
}

if ($userAccountInfo['frozen_cash'] < $frozen) {
	fail_exit('申请转移的冻结资金:'.$frozen.'大于账户内的冻结资金:'.$userAccountInfo['frozen_cash']);
}

$objDBTransaction = new DBTransaction();
$strTransactionId = $objDBTransaction->start();

$tmpResult = $objUserAccountFront->frozenToMoney($u_id, $frozen);

if (!$tmpResult->isSuccess()) {
	fail_exit('冻结资金转余额，操作失败，原因:'.$tmpResult->getData());
}

//记录日志
$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['money'] 		= $frozen;
$tableInfo['log_type'] 		= BankrollChangeType::FROZEN_TO_CASH;
$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
$tableInfo['record_table'] 	= 'user_account';//对应的表
$tableInfo['record_id'] 	= $u_id;
$tableInfo['create_time'] 	= getCurrentDate();
			
$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tmpResult = $objUserAccountLogFront->add($tableInfo);

if (!$tmpResult) {
	$objDBTransaction->rollback($strTransactionId);
	fail_exit('记录日志，操作失败，原因:'.$tmpResult->getData());
}

if (!$objDBTransaction->commit($strTransactionId)) {
	$objDBTransaction->rollback($strTransactionId);
	fail_exit('提交信息失败');
}
success_exit();
<?php
/**
 * 后台之：提现审核
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
		Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$operate = Request::r('operate');

$tpl = new Template();
$objUserEncashFront = new UserEncashFront();
switch ($operate) {
	case 'cancel':
		$id = Request::r('userEncashId');
		$cashInfo = $objUserEncashFront->get($id);
		if (!$cashInfo) {
			ajax_fail_exit('没找到提款申请记录');
		}
		
		//修改提现申请
		$pms_msg = Request::r('pms_msg');
		$process_message = $pms_msg?$pms_msg:'提现撤销';
		
		$tableInfo = array();
		$tableInfo['encash_status'] 	= UserEncash::ENCASH_STATUS_ENCASH_CANCEL;
		$tableInfo['process_message'] 	= $process_message;
		$tableInfo['process_time'] 		= getCurrentDate();
		$tableInfo['process_uid'] 		= Runtime::getUid();
		
		$tmpResult = $objUserEncashFront->modify($tableInfo, array('encash_id'=>$id));
		if (!$tmpResult->isSuccess()) {
			fail_exit($tmpResult->getData());
		}
		
		//撤销体现时的站内短信
		if ($pms_msg) sendUserPms($cashInfo['u_id'], '提现申请撤销', $pms_msg);
		
		ajax_success_exit('操作成功');
		
		//冻结资金恢复
		$u_id = $cashInfo['u_id'];
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($u_id);
		$frozen = $cashInfo['money'];
		
		if (!$frozen || $frozen <= 0) {
			ajax_fail_exit('申请转移的冻结资金:'.$frozen.'不正确');
		}
		
		if ($userAccountInfo['frozen_cash'] < $frozen) {
			ajax_fail_exit('申请转移的冻结资金:'.$frozen.'大于账户内的冻结资金:'.$userAccountInfo['frozen_cash']);
		}
		
		$tmpResult = $objUserAccountFront->frozenToMoney($u_id, $frozen);
		
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit('冻结资金转余额，操作失败，原因:'.$tmpResult->getData());
		}
		
		//记录日志
		$objUserAccountLogFront = new UserAccountLogFront($u_id);
		$userAccountInfo = $objUserAccountFront->get($u_id);
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['money'] 		= $frozen;
		$tableInfo['log_type'] 		= BankrollChangeType::FROZEN_TO_CASH;
		$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
			
		$tmpResult = $objUserAccountLogFront->add($tableInfo);
		
		if (!$tmpResult) {
			ajax_fail_exit('记录日志，操作失败');
		}
		
		ajax_success_exit('操作成功');
		break;
	case 'encash':
		
		$id = Request::r('userEncashId');
		$cashInfo = $objUserEncashFront->get($id);
		if (!$cashInfo) {
			ajax_fail_exit('没找到提款申请记录');
		}
		
		$u_id = $cashInfo['u_id'];//提款人
		$money = $cashInfo['money']; 
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($cashInfo['u_id']);
		if (!$userAccountInfo) {
			ajax_fail_exit('账户未找到');
		}
		
		$objDBTransaction = new DBTransaction();
		$strTransactionId = $objDBTransaction->start();
		
		//修改提现申请
		$tableInfo = array();
		$tableInfo['encash_status'] 	= UserEncash::ENCASH_STATUS_ENCASH;
		$tableInfo['process_message'] 	= '确认提现';//Request::r('process_message');
		$tableInfo['process_time'] 		= getCurrentDate();
		$tableInfo['process_uid'] 		= Runtime::getUid();
		
		$tmpResult = $objUserEncashFront->modify($tableInfo, array('encash_id'=>$id));
		
		if (!$tmpResult->isSuccess()) {
			$objDBTransaction->rollback($strTransactionId);
			ajax_fail_exit($tmpResult->getData());
		}
		
		//修改账户
		$tmpResult = $objUserAccountFront->frozenTOEncash($u_id, $money);
		if (!$tmpResult->isSuccess()) {
			$objDBTransaction->rollback($strTransactionId);
			ajax_fail_exit($tmpResult->getData());
		}
		
		$record_table = 'user_encash';
    	
    	$tableInfo = array();
    	$tableInfo['u_id'] 			= $u_id;
    	$tableInfo['money'] 		= $money;
    	$tableInfo['log_type'] 		= BankrollChangeType::ENCASH;
    	$tableInfo['old_money'] 	= $userAccountInfo['cash'];
    	$tableInfo['record_table'] 	= $record_table;//对应的表
    	$tableInfo['record_id'] 	= $id;
    	$tableInfo['create_time'] 	= getCurrentDate();
    	
    	//添加账户日志，已有专门的表记录，不需要再次记录了
//     	$objUserAccountLogFront = new UserAccountLogFront($u_id);
//     	$tmpResult = $objUserAccountLogFront->add($tableInfo);
    	
//     	if (!$tmpResult) {
//     		$objDBTransaction->rollback($strTransactionId);
//     		ajax_fail_exit('添加账户日志失败');
//     	}
    	
		if (!$objDBTransaction->commit($strTransactionId)) {
			ajax_fail_exit('commit fail');
		}
		
		ajax_success_exit('操作成功');
		break;
	case 'verify':
		
		$id = Request::r('userEncashId');
		$cashInfo = $objUserEncashFront->get($id);
		if (!$cashInfo) {
			ajax_fail_exit('没找到提款申请记录');
		}
		
		$tableInfo = array();
		$tableInfo['encash_status'] 	= UserEncash::ENCASH_STATUS_VERIFIED;
		$tableInfo['process_message'] 	= '审核通过';//Request::r('process_message');
		$tableInfo['process_time'] 		= getCurrentDate();
		$tableInfo['process_uid'] 		= Runtime::getUid();
		
		$tmpResult = $objUserEncashFront->modify($tableInfo, array('encash_id'=>$id));
		if (!$tmpResult->isSuccess()) {
			fail_exit($tmpResult->getData());
		}
		
		sendUserPms($cashInfo['u_id'], '赠送彩金', '尊敬的会员，您的提款信息已审核通过，资金已进入您绑定银行流程，请等待查收！');
		ajax_success_exit('操作成功');
		break;
	default:
		$u_name = Request::r('u_name');

		//待查询的日期，允许精确到秒
		$start_date = Request::r('start_date');
		$start_time = Request::r('start_time');
		$end_date = Request::r('end_date');
		$end_time = Request::r('end_time');
		if($start_date<'2018-01-01'){
			$start_date='2018-01-01';
		}
		if($start_date>$end_date){
			$end_date=$start_date;
		}
		$start = $start_date . ' ' . $start_time;
		$end = $end_date . ' ' . $end_time;
		
		//验证时间格式
		if (!$start_date || !$start_time || !$end_date || !$end_time || !strtotime($start) || !strtotime($end)) {
			$start_time = '00:00:00';
			$end_time = '23:59:59';
			$start_date = date('Y-m-d', time() - 7 * 24 * 3600);
			$end_date = date('Y-m-d', time());
			$start = $start_date . ' ' . $start_time;
			$end = $end_date . ' ' . $end_time;
		}
		
		if($start_date<'2018-01-01'){
			$start_date='2018-01-01';
		}
		if($start_date>$end_date){
			$end_date=$start_date;
		}
		
		$tpl->assign('start_date', $start_date);
		$tpl->assign('start_time', $start_time);
		$tpl->assign('end_date', $end_date);
		$tpl->assign('end_time', $end_time);
				
		$encash_status = Request::r('encash_status')?Request::r('encash_status'):1;
		
		$condition = array();
		$condition['encash_status'] = $encash_status;
		
		if ($encash_status == 'all') {
			unset($condition['encash_status']);
		}
		
		if ($u_name) {
			$objUserMemberFront = new UserMemberFront();
			$search_user = $objUserMemberFront->getByName($u_name);
			$condition['u_id'] = $search_user['u_id'];
		}
//		$encashInfos = $objUserEncashFront->getsByCondition($condition, null, 'create_time asc');
		
		$encashInfos = $objUserEncashFront->getsByCondtionWithField($start , $end, 'create_time', $condition, null, 'create_time asc');
		
		$uids = array();
		foreach ($encashInfos as $value) {
			$uids[] = $value['u_id'];
		}
		
		$objUserAccountFront = new UserAccountFront();
		$objUserRealInfoFront = new UserRealInfoFront();
		$objUserMemberFront = new UserMemberFront();
		$objUserPaymentFront = new UserPaymentFront();
		
		$payTypeDesc = UserPayment::getPayTypeDesc();
		$userPaymentInfos = $objUserPaymentFront->getsByCondition(array('u_id'=>$uids,'default' => UserPayment::DEFAULT_PAY_TYPE));
		foreach ($userPaymentInfos as $key=>$userPaymentInfo) {
			unset($userPaymentInfos[$key]);
			//以用户id为key重构
			$userPaymentInfos[$userPaymentInfo['u_id']] = $userPaymentInfo;
		}
		
		$EncashPaymentDesc = UserEncash::getEncashPaymentDesc();
		$tpl->assign('EncashPaymentDesc', $EncashPaymentDesc);
		
		$tpl->assign('payTypeDesc', $payTypeDesc);
		$tpl->assign('userPaymentInfos', $userPaymentInfos);
		
		$userInfos = $objUserMemberFront->gets($uids);
		$tpl->assign('userInfos', $userInfos);
		$userAccountInfos = $objUserAccountFront->gets($uids);
		$userRealInfos = $objUserRealInfoFront->gets($uids);
		$tpl->assign('userAccountInfos', $userAccountInfos);
		$tpl->assign('userRealInfos', $userRealInfos);
		
		$encashStatusDesc = UserEncash::getEncashStatusDesc();
		$tpl->assign('encashStatusDesc', $encashStatusDesc);
		$tpl->assign('encashInfos', $encashInfos);
		$tpl->assign('start_time', $start_time);
		$tpl->assign('end_time', $end_time);
		$tpl->assign('encash_status', $encash_status);
		$tpl->assign('u_name', $u_name);
		echo_exit($tpl->r('../admin/user/encash'));
}
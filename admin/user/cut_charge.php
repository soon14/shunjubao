<?php
/**
 * 扣除余额，积分等 
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$userInfo = Runtime::getUser();

$tpl = new Template();

$info = $_POST;
if ($info['cash'] && $info['u_name']) {
	#TODO对信息进行过滤处理
	$cash = $info['cash'];
	if (!Verify::money($cash)) {
		fail_exit("金额数量不正确");
	}
	
	$u_name = $info['u_name'];//用户名称，非操作者
	$desc = Request::r('desc');
	$objUserMemberFront = new UserMemberFront();
	$user = $objUserMemberFront->getByName($u_name);
	if (!$user) {
		fail_exit('未找到用户:'.$u_name);
	}
	$u_id = $user['u_id'];
	$objUserAccountFront = new UserAccountFront();
	$userAccountInfo = $objUserAccountFront->get($u_id);
	
	
	
	switch ($info['type']) {
		case 'cash':
		
			$balance = $userAccountInfo["cash"];
			if($balance<$cash){
				fail_exit('余额不足，用户扣除余额失败');
				exit();
			}
			
		
		
			$tmpResult = $objUserAccountFront->consumeCash($user['u_id'], $cash);
		
			if (!$tmpResult->isSuccess()) {
				fail_exit('扣除余额失败，原因'.$tmpResult->getData());
			}
			
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['money'] 		= $cash;
			$tableInfo['log_type'] 		= BankrollChangeType::CASH_CONSUME_CUT;
			$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			
	
			
			
			//添加账户日志
			$objUserAccountLogFront = new UserAccountLogFront($u_id);
			$tmpResult = $objUserAccountLogFront->add($tableInfo);
		
			if (!$tmpResult) {
				fail_exit('用户扣除余额失败');
			}
			$type = '余额';
			$op_type = OperateRecord::OPTYPE_COMSUME_CASH;
			break;
		case 'gift':
		
			$gift = $userAccountInfo["gift"];
			if($gift<$cash){
				fail_exit('彩金不足，扣除彩金失败');
				exit();
			}
		
			$tmpResult = $objUserAccountFront->consumeGift($user['u_id'], $cash);
			
			if (!$tmpResult->isSuccess()) {
				fail_exit('扣除彩金失败，原因'.$tmpResult->getData());
			}
			
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['gift'] 			= $cash;
			$tableInfo['log_type'] 		= BankrollChangeType::GIFT_CONSUME_CUT;
			$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			//添加账户日志
			$objUserAccountLogFront = new UserGiftLogFront();
			$tmpResult = $objUserAccountLogFront->add($tableInfo);
		
			if (!$tmpResult) {
				fail_exit('用户扣除彩金失败');
			}
			$op_type = OperateRecord::OPTYPE_COMSUME_GIFT;
			$type = '彩金';
			break;
		case 'score':
		
			$score = $userAccountInfo["score"];
			if($score<$cash){
				fail_exit('彩金不足，扣除彩金失败');
				exit();
			}
		
			$tmpResult = $objUserAccountFront->consumeScore($user['u_id'], $cash);
					
			if (!$tmpResult->isSuccess()) {
				fail_exit('扣除积分失败，原因'.$tmpResult->getData());
			}
					
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['score'] 		= $cash;
			$tableInfo['log_type'] 		= BankrollChangeType::SCORE_CONSUME_CUT;
			$tableInfo['old_score'] 	= $userAccountInfo['score'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			//添加账户日志
			$objUserScoreLogFront = new UserScoreLogFront();
			$tmpResult = $objUserScoreLogFront->add($tableInfo);
			
			if (!$tmpResult) {
				fail_exit('用户扣除积分失败');
			}
			$type = '积分';
			$op_type = OperateRecord::OPTYPE_COMSUME_SCORE;
			break;
		default:
			fail_exit('错误的资金类型');
	}
	$objOperateRecordFront = new OperateRecordFront();
	$tableInfo['type'] = $op_type;
	$tableInfo['desc'] = $desc;
	$objOperateRecordFront->add($tableInfo);
	
	
	$url = "cut_charge.php";
	echo "<a href=\"".$url."\">3秒后自动跳转，如果没有跳转，请点这里跳转</a>\n";
    echo "<script language=\"javascript\">setTimeout(\"window.location.href='".$url."'\",3000)</script>\n";
	
	success_exit('为用户：' . $user['u_name'].'扣除'.$type . $cash. '元');
}

echo_exit($tpl->r('../admin/user/cut_cash'));
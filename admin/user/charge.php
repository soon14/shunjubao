<?php
/**
 * 给用户充值
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

$getCHARGEmanuincomeDesc = UserCharge::getCHARGEmanuincomeDesc();

$tpl->assign('getCHARGEmanuincomeDesc', $getCHARGEmanuincomeDesc);
$info = $_POST;
if ($info['cash'] && $info['u_name']) {
	#TODO对信息进行过滤处理
	$cash = $info['cash'];
	if (!Verify::money($cash)) {
		fail_exit("金额数量不正确");
	}
	
	$u_name = $info['u_name'];//用户名称，非操作者
	$desc = Request::r('desc');
	$manu_income = Request::r('manu_income');	
	
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
			$tmpResult = $objUserAccountFront->addCash($user['u_id'], $cash);
			
			if (!$tmpResult->isSuccess()) {
				fail_exit('充值余额失败，原因'.$tmpResult->getData());
			}
			
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['money'] 		= $cash;
			$tableInfo['log_type'] 		= BankrollChangeType::ADMIN_CHARGE;
			$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			//添加账户日志
			$objUserAccountLogFront = new UserAccountLogFront($u_id);
			$tmpResult = $objUserAccountLogFront->add($tableInfo);
		
			if (!$tmpResult) {
				fail_exit('用户充值余额失败');
			}
			$type = '余额';
			$op_type = OperateRecord::OPTYPE_ADD_CASH;
			
			//记录日志
			
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['money'] 		= $cash;
			$tableInfo['create_time'] 	= getCurrentDate();
			$tableInfo['charge_status'] = '2';
			$tableInfo['charge_type']   = '2';
			$tableInfo['charge_source']   = '1';//主站
			$tableInfo['o_uid'] = $userInfo["u_id"];
			$tableInfo['o_uname'] = $userInfo["u_name"];
		    $tableInfo['manu_income'] = $manu_income;
			$tableInfo['manu_desc'] = $desc;
			$objUserChargeFront = new UserChargeFront();
			$tmpChargeResult = $objUserChargeFront->add($tableInfo);
			
			
			
			break;
		case 'gift':
			$tmpResult = $objUserAccountFront->addGift($user['u_id'], $cash);
			
			if (!$tmpResult->isSuccess()) {
				fail_exit('充值彩金失败，原因'.$tmpResult->getData());
			}
			
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['gift'] 			= $cash;
			$tableInfo['log_type'] 		= BankrollChangeType::ADMIN_GIFT;
			$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			//添加账户日志
			$objUserAccountLogFront = new UserGiftLogFront();
			$tmpResult = $objUserAccountLogFront->add($tableInfo);
		
			if (!$tmpResult) {
				fail_exit('用户充值彩金失败');
			}
			$op_type = OperateRecord::OPTYPE_ADD_GIFT;
			$type = '彩金';
			break;
		case 'score':
			$tmpResult = $objUserAccountFront->addScore($user['u_id'], $cash);
					
			if (!$tmpResult->isSuccess()) {
				fail_exit('充值积分失败，原因'.$tmpResult->getData());
			}
					
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['score'] 		= $cash;
			$tableInfo['log_type'] 		= BankrollChangeType::ADMIN_CHARGE_SCORE;
			$tableInfo['old_score'] 	= $userAccountInfo['score'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			//添加账户日志
			$objUserScoreLogFront = new UserScoreLogFront();
			$tmpResult = $objUserScoreLogFront->add($tableInfo);
			
			if (!$tmpResult) {
				fail_exit('用户充值积分失败');
			}
			$type = '积分';
			$op_type = OperateRecord::OPTYPE_ADD_SCORE;
			break;
		default:
			fail_exit('错误的资金类型');
	}
	$objOperateRecordFront = new OperateRecordFront();
	$tableInfo['type'] = $op_type;
	$tableInfo['desc'] = $desc;
	$objOperateRecordFront->add($tableInfo);
	$url = "charge.php";
	echo "<a href=\"".$url."\">3秒后自动跳转，如果没有跳转，请点这里跳转</a>\n";
    echo "<script language=\"javascript\">setTimeout(\"window.location.href='".$url."'\",3000)</script>\n";
	success_exit('为用户：' . $user['u_name'].'充值'.$type . $cash. '元');
}

echo_exit($tpl->r('../admin/user/cash'));
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



$info = $_POST;

if ($info['cash'] && $info['u_name']) {

	#TODO对信息进行过滤处理

	$cash = $info['cash'];

	if (!Verify::money($cash)) {

		fail_exit("金额数量不正确");

	}

	

	$u_name = $info['u_name'];//用户名称，非操作者

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

			$type = '彩金';

			break;

		default:

			fail_exit('错误的资金类型');

	}

	success_exit('为用户：' . $user['u_name'].'充值'.$type . $cash. '元');

}



echo_exit($tpl->r('../admin/user/cash'));
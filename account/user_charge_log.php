<?php
/**
 * 用户中心账户明细页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$condition = array();
$condition['u_id'] = $u_id;
$condition['log_type'] = array(BankrollChangeType::ADMIN_CHARGE,BankrollChangeType::CHARGE);

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 90 * 24 * 3600);
	$end_time = date('Y-m-d', time());
}

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 12;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$field = 'create_time';
$order = $field . ' desc';
$limit = " {$offset},{$real_size} ";

$objUserChargeFront = new UserChargeFront();

#账户日志信息4
$objUserAccountLogFront = new UserAccountLogFront($u_id);
$userAccountLogInfos = $objUserAccountLogFront->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . ' 23:59:59', $field, $condition, $limit, $order);
$chargeIds = array();
foreach ($userAccountLogInfos as $key=>$value) {
	if ($value['record_table'] == 'user_charge') {
		$chargeId = $value['record_id'];
		$userChargeInfo = $objUserChargeFront->get($chargeId);
		$userAccountLogInfos[$key]['pay_order_id'] = $userChargeInfo['pay_order_id'];
	}
}

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_charge_log.php", $args);
}
$nextPage = false;
if (count($userAccountLogInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userAccountLogInfos);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_charge_log.php", $args);
}

$bankrollChangeType = UserAccountLog::getsBankrollChangeType();

$trade_money_in = 0;
$trade_amount_in = 0;
foreach ($userAccountLogInfos as $key=>$value) {
	$direction = $bankrollChangeType[$value['log_type']]['direction'];
	if ($direction == BankrollChangeType::ACCOUNT_DIRECTION_IN) {
		$trade_money_in += $value['money'];
		$trade_amount_in++;
	}
}

$tpl->assign('trade_money_in', $trade_money_in);
$tpl->assign('trade_amount_in', $trade_amount_in);
$tpl->assign('bankrollChangeType', $bankrollChangeType);
#标题
$TEMPLATE ['title'] = "智赢网用户账户充值明细 ";
$TEMPLATE['keywords'] = '智赢竞彩,智赢网,智赢用户中心';
$TEMPLATE['description'] = '智赢网用户账户充值明细。';
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userChargeInfos', $userAccountLogInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('user_charge_log'));
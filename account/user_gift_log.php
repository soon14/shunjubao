<?php
/**
 * 彩金记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$condition = array();
$condition['u_id'] = $u_id;

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = $end_time = date('Y-m-d', time());
}

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 8;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$field = 'create_time';
$order = $field . ' desc';
$limit = " {$offset},{$real_size} ";

$field = 'create_time';
$order = $field . ' desc';
//$limit = null;

#彩金记录7
$objUserGiftLogFront = new UserGiftLogFront();
$userGiftLogInfos = $objUserGiftLogFront->getsByCondtionWithField($start_time .' 00:00:00', $end_time . ' 23:59:59', $field, $condition, $limit, $order);
//pr($userGiftLogInfos);
$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_gift_log.php", $args);
}
$nextPage = false;
if (count($userGiftLogInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userGiftLogInfos);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_gift_log.php", $args);
}

$bankrollChangeType = UserAccountLog::getsBankrollChangeType();

$trade_money_in = 0;
$trade_money_out = 0;
foreach ($userGiftLogInfos as $key=>$value) {
	$direction = $bankrollChangeType[$value['log_type']]['direction'];
	if ($direction == BankrollChangeType::ACCOUNT_DIRECTION_IN) {
		$trade_money_in += $value['money'];
	} elseif ($direction == BankrollChangeType::ACCOUNT_DIRECTION_OUT) {
		$trade_money_out += $value['money'];
	}
}

$tpl->assign('bankrollChangeType', $bankrollChangeType);
#标题
$TEMPLATE ['title'] = "聚宝网用户账户明细 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户账户明细。';
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userGiftLogInfos', $userGiftLogInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $start_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('trade_money_in', $trade_money_in);
$tpl->assign('trade_money_out', $trade_money_out);
echo_exit($tpl->r('user_gift_log'));
<?php
/**
 * 用户中心账户明细页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
redirect(ROOT_DOMAIN.'/account/user_account_log.php');
#必须登录
Runtime::requireLogin();

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
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$field = 'create_time';
$order = $field . ' desc';
$limit = " {$offset},{$real_size} ";

#账户日志信息4
$objUserAccountLogFront = new UserAccountLogFront($u_id);
$userAccountLogInfos = $objUserAccountLogFront->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);
#用户充值信息5
$objUserChargeFront = new UserChargeFront();
$userChargeInfos = $objUserChargeFront->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);
#返点记录6
$objUserRebateFront = new UserRebateFront();
$userRebateInfos = $objUserRebateFront->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);
#彩金记录7
$objUserGiftLogFront = new UserGiftLogFront();
$useGiftLogInfos = $objUserGiftLogFront->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_account.php", $args);
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
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_account.php", $args);
}

#标题
$TEMPLATE ['title'] = "账户明细 - ";
$tpl->assign('userInfo', $userInfo);
//$tpl->assign('userRealInfo', $userRealInfo);
//$tpl->assign('userAccountInfo', $userAccountInfo);
$tpl->assign('userAccountLogInfos', $userAccountLogInfos);
$tpl->assign('userChargeInfos', $userChargeInfos);
$tpl->assign('userRebateInfos', $userRebateInfos);
$tpl->assign('useGiftLogInfos', $useGiftLogInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $start_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
//$tpl->assign('useScoreLogInfo', $useScoreLogInfo);
//$tpl->assign('userEncashInfos', $userEncashInfos);
echo_exit($tpl->r('user_account'));
<?php
/**
 * 用户提现记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
#会员基本信息
$objUserMemberFront = new UserMemberFront();
$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($u_id);
$objUserEncashFront = new UserEncashFront();
$EncashStatusDesc = UserEncash::getEncashStatusDesc();
$tpl = new Template();

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";
$order = ' create_time desc ';
$field = 'create_time';

$condition = array();
$condition['u_id'] = $u_id;
//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = $end_time = date('Y-m-d', time());
}

$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
//转换为具体时间
$userEncashInfos = $objUserEncashFront->getsByCondtionWithField($start_time. ' 00:00:00', $end_time. ' 23:59:59', $field, $condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_encash.php", $args);
}
$nextPage = false;
if (count($userEncashInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userEncashInfos);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_encash.php", $args);
}

$TEMPLETE['title'] = '聚宝网用户提现记录';
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户提现记录。';

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('EncashStatusDesc', $EncashStatusDesc);
$tpl->assign('userAccountInfo', $userAccountInfo);
$tpl->assign('userEncashInfos', $userEncashInfos);
echo_exit($tpl->r('user_encash'));
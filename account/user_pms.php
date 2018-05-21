<?php
/**
 * 用户中心用户短消息页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$status = Request::r('status');

$tpl = new Template();

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$condition = array();
$condition['receive_uid'] = $u_id;

if (!Verify::int($status)) {
	$condition['status'] = UserPMS::STATUS_NOT_RECEIVING;
} else {
	$condition['status'] = $status;
}

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 30 * 24 * 60 *60);
	$end_time = date('Y-m-d', time());
}

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 11;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$field = 'create_time';
$order = $field . ' desc';
$limit = "{$offset},{$real_size}";

#账户日志信息4
$objUserPMSFront = new UserPMSFront();
$userPMSInfos = $objUserPMSFront->getsByCondition($condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array('status'=>$status);
if ($previousPage) {
	$args['page'] = $previousPage;
// 	$args['start_time'] = $start_time;
// 	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_pms.php", $args);
}
$nextPage = false;
if (count($userPMSInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userAccountLogInfos);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
// 	$args['start_time'] = $start_time;
// 	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_pms.php", $args);
}
$unRecieviSum = $objUserPMSFront->getUnRecieviSum($u_id);

#标题
$TEMPLATE ['title'] = "站内信 - ";
$tpl->assign('unRecieviSum', $unRecieviSum);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('status', $status);
$tpl->assign('userPMSInfos', $userPMSInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $start_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('user_pms'));

<?php
/**
 * 留言列表
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$tpl = new Template();

$condition = array();
$status = Request::r('status');

if (!$status) {
	$status = 'all';
}

if ($status && $status !='all') {
	$condition['status'] = $status;
}

$u_name = Request::r('u_name');
if ($u_name) {
	$condition['u_name'] = $u_name;
}
$objUserMessageFront = new UserMessageFront();
$messages = $objUserMessageFront->getsByCondition($condition, null,'id desc');

$statusDesc = UserMessage::getStatusDesc();
$tpl->assign('statusDesc', $statusDesc);
$tpl->assign('u_name', $u_name);
$tpl->assign('status', $status);
$tpl->assign('messages', $messages);
$tpl->d('../admin/user/message_list');
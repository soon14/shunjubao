<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$user = Runtime::getUser();
if (!$user['u_id']) {
	fail_exit('您未登录');
}

$objUserMessageFront = new UserMessageFront();
$title = Request::r('title');
$message = Request::r('message');


if (!$title || !$message) {
	fail_exit('信息或标题未填');
}

if (strlen($title) > 40) {
	fail_exit('标题过长');
}



$info = array();
$info['title'] = $title;
$info['message'] = nl2br($message);


$id = $objUserMessageFront->add($info);
if (!$id) {
	fail_exit('添加失败');
}

redirect(ROOT_DOMAIN.'/message/show.php');
// ajax_success_exit('添加成功!客服妹子审核中...');
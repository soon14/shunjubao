<?php
/**
 * 给用户退票
 * 规则：
 * 1、只能退还未出票，出票失败，部分出票失败，投注失败，部分投注失败的用户票
 * 2、
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$userTicketId = Request::r('userTicketId');


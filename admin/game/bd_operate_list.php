<?php
/**
 * bd_operate_list.php
 * 北单操作列表页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::GAME_MANAGER,
);

if (!Runtime::requireRole($roles)) {
	fail_exit("该页面不允许查看");
}

$tpl = new Template();

echo_exit($tpl->r('../admin/game/bd_operate_list'));
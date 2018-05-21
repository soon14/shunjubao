<?php
/**
 * 后台管理之：管理框架之顶部
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$title = "管理框架之顶部";

$roleTypes = Runtime::getsRoles();
$show_message = false;
if($roleTypes) {
	foreach ($roleTypes as $roleType) {
		if($roleType == Role::CUSTOMER_SERVICE) {
			$ns = 'gj_kefu';
			$show_message = true;
			break;
		}
	}
}

$tpl->assign('roleDesc', Role::getRoleDesc());
$tpl->assign('uname', Runtime::getUname());
$tpl->assign('roleType', $roleType);
$tpl->assign('ns', $ns);
$tpl->assign('show_message', $show_message);
$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('../admin/top');
echo_exit($YOKA['output']);
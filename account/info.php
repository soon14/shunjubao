<?php 
/**
 * 个人信息查看修改页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#需要登录
Runtime::requireLogin();

$u_id = Runtime::getUid();

$condition = array();
$condition['u_id'] = $u_id;


$objUserAccountFront = new UserAccountFront();
$account = $objUserAccountFront->get($u_id);//账户信息

$objUserRealInfoFront = new UserRealInfoFront();
$real_info = $objUserRealInfoFront->get($u_id);//扩展信息

$tpl = new Template();

$title = "";

$TEMPLATE['title'] = $title;
$tpl->assign('real_info',$real_info);
$tpl->assign('account',$account);

echo_exit($tpl->r('info'));

?>
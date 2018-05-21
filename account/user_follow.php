<?php
/**
 * 跟单记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();
$tpl = new Template();

$tpl->assign('userInfo', $userInfo);

$YOKA ['output'] = $tpl->r ( 'user_follow' );
echo_exit ( $YOKA ['output'] );
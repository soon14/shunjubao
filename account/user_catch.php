<?php
/**
 * 追号记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();
$tpl = new Template();

$tpl->assign('userInfo', $userInfo);

$YOKA ['output'] = $tpl->r ( 'user_catch' );
echo_exit ( $YOKA ['output'] );
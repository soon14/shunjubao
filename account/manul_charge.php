<?php
/**
 * 用户中心充值页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
Runtime::requireLogin();
$tpl = new Template();
#标题
$TEMPLATE ['title'] = "智赢网充值中心 ";
$TEMPLATE['keywords'] = '智赢竞彩,智赢网,智赢用户中心';
$TEMPLATE['description'] = '智赢网充值中心。';


$YOKA ['output'] = $tpl->r ( 'manul_charge' );
echo_exit ( $YOKA ['output'] );
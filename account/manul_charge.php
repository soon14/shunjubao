<?php
/**
 * 用户中心充值页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
Runtime::requireLogin();
$tpl = new Template();
#标题
$TEMPLATE ['title'] = "聚宝网充值中心 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网充值中心。';


$YOKA ['output'] = $tpl->r ( 'manul_charge' );
echo_exit ( $YOKA ['output'] );
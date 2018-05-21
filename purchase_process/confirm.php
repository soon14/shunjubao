<?php
/**
 * 购买流程之：确认
 * 收集用户的发货信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$uid = Runtime::getUid();

$tpl = new Template();
$TEMPLATE['title'] = "订单确认 - ";

$tpl->assign('expressfee', 1);

$YOKA['output'] = $tpl->r('purchase_confirm');
echo_exit($YOKA['output']);

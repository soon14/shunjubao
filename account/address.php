<?php
/**
 * account之：用户管理界面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . 'init.php';
#判断用户是否登录
Runtime::requireLogin();
#用户id
$uid = Runtime::getUid();
$tpl = new Template();
# 发货地址
$objConsigneeInfoFront = new ConsigneeInfoFront();
$address = $objConsigneeInfoFront->getsByUid($uid);
$address_default = $objConsigneeInfoFront->getDefault($uid);
$tpl->assign('address', $address);
$tpl->assign('address_default', $address_default);
$tpl->assign('cur_tab', 'account_address');
$TEMPLATE['title'] = '收货地址-';
$YOKA['output'] = $tpl->r('account_address');
echo_exit($YOKA['output']);
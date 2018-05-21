<?php
/**
 * 投注确认页结果
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

//Runtime::requireLogin();

$tpl = new Template();

$type = $_REQUEST['type'];
$from = $_REQUEST['from'];
$msg = $_REQUEST['msg'];

$tpl->assign('msg', $msg);
$tpl->assign('type', $type);
$tpl->assign('from', $from);
echo_exit($tpl->r('confirm/confirm_result'));
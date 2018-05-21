<?php
/*
 * 用户协议
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$tpl = new Template();

$title = "高街";
$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('help/agreement');
echo_exit($YOKA['output']);
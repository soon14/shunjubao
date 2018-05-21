<?php
/**
 * 404错误页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$TEMPLATE['title'] = "提示信息 - ";

$YOKA['output'] = $tpl->r('404');
echo_exit($YOKA['output']);
<?php
/**
 * 后台管理之：管理框架之中间
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$title = "管理框架之中间";

$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('../admin/center');
echo_exit($YOKA['output']);
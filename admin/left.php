<?php
/**
 * 后台管理之：管理框架之左边
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$title = "管理框架之左边";

$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('../admin/left');
echo_exit($YOKA['output']);
<?php
/**
 * 后台管理之：管理框架之底部
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$title = "管理框架之底部";

$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('../admin/down');
echo_exit($YOKA['output']);
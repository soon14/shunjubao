<?php
/**
 * 后台管理之：管理框架之首页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$title = "特卖后台管理工作平台";

$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('../admin/index');
echo_exit($YOKA['output']);
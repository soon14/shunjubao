<?php
/*
 * 帮助页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$type = $_GET['type'];
$tpl = new Template();

switch($type)
{
	case "promotions":
		 $tpl->assign('data','promotions');
		break;
	case "promotion1":
		$tpl->assign('data','promotion1');
		break;
	case "promotion2":
		$tpl->assign('data','promotion2');
		break;
	default :
		break;
}

$title = "最新活动 - ";
$TEMPLATE['title'] = $title;

$YOKA['output'] = $tpl->r('help/promotions');
echo_exit($YOKA['output']);
<?php
/*
 * 帮助页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$type = $_GET['type'];
$tpl = new Template();

switch($type)
{
	case "help":
		 $tpl->assign('data','help');
		break;
	case "buy":
		$tpl->assign('data','buy');
		break;
	case "faq":
		$tpl->assign('data','faq');
		break;
	case "payment":
		 $tpl->assign('data','payment');
		break;
	case "shipping":
		 $tpl->assign('data','shipping');
		break;
	case "service":
		 $tpl->assign('data','service');
		break;
	case "bulkbuy":
		$tpl->assign('data','bulkbuy');
		break;
	case "size":
		 $tpl->assign('data','size');
		break;
	case "washing":
		 $tpl->assign('data','washing');
		break;
	case "agreement":
		 $tpl->assign('data','agreement');
		break;
	case "vip":
		 $tpl->assign('data','vip');
		break;
	case "Partner":
		 $tpl->assign('data', 'Partner');
		 break;
	default :
		break;
}

$title = "帮助中心 - ";
$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('help/help');
echo_exit($YOKA['output']);
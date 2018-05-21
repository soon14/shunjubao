<?php
/*
 * 关于我们
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$type = $_GET['type'];
$tpl = new Template();

switch($type)
{
	case "about":
		 $tpl->assign('data','about');
		break;
	case "bd":
		$tpl->assign('data','bd');
		break;
	case "contact":
		$tpl->assign('data','contact');
		break;
	case "media":
		$tpl->assign('data', 'media');
		break;
	/*case "recruitment":   //此页面暂时不用
		$tpl->assign('data','recruitment');
		break;*/
	case "links":
		$tpl->assign('data', 'links');
		break;
}

$title = "关于我们 - ";
$TEMPLATE['title'] = $title;
$YOKA['output'] = $tpl->r('help/about');
echo_exit($YOKA['output']);
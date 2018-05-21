<?php
/**
 * 外站来源创建
 */
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,false)) {
	echo_exit("该页面不允许查看");
}
//操作类型
$operate = Request::r('operate');

if (!$operate) {
	$operate = 'show';
}

$objSiteFrom = new SiteFrom();
$uname = Runtime::getUname();

switch ($operate) {
	case 'show':
		//获取全部代理人信息
		$results = $objSiteFrom->getsByCondition(array('type'=>SiteFrom::SITE_FROM_TYPE_OUT));
		$tpl = new Template();
		$tpl->assign('results', $results);
		$tpl->assign('uname', $uname);
		echo_exit($tpl->r('../admin/business/site_from_create'));
		break;
	case 'add':
		$info = array();
		$info = $_REQUEST;
		$info['describe'] = Request::r('describe');
		$info['type'] = SiteFrom::SITE_FROM_TYPE_OUT;
		$result = $objSiteFrom->addSFRecord($info);
		if (!$result->isSuccess()) {
			fail_exit($result->getData());
		}
		success_exit();
		break;
	case 'modify':
		$info = array();
		$info = $_REQUEST;
		$info['describe'] = Request::r('describe');
		$result = $objSiteFrom->modify($info);
		if (!$result->isSuccess()) {
			fail_exit($result->getData());
		}
		success_exit();
		break;
	case 'del':
		break;
	default:
		echo_exit('无效参数');
		break;
}
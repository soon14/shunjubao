<?php
/**
 * 数据源监控程序
 */
 include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
 
 $roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$action = Request::r('action');

$tpl = new Template();
$template = '../admin/system/data_monitor';

$return = array();
switch ($action) {
	case 'show':
		
		$objZYFTP = new ZYFTP();
		$objBetting = new Betting('fb');
		$xmlList = $objBetting->getXmlListDesc();
		//数据源的情况
		//数据源是否可用
		$res = ZYFTP::isFtpAvaliable();
		if (!$res->isSuccess()) {
			$status = '<fronts style="color:red">'.$res->getData().'</fronts>';
		} else {
			$status = '<fronts style="color:green">'.$res->getData().'</fronts>';
		}
		$return['source'][] = array(
			'desc'	=> '数据源',
			'status'=> $status,
		);
		//数据文件情况
		$return['files'] = array();
		foreach ($xmlList as $xml=>$desc) {
			$status = ZYFTP::isXmlFileExist($xml);
			
			if (!$status) {
				$status = '<fronts style="color:red">文件不存在</fronts>';
				$updatetime = '';
			} else {
				$status = '<fronts style="color:green">正常</fronts>';
				$updatetime = ZYFTP::getFileLastUpdatTime($xml);
			}
			
			$return['files'][$xml] = array(
				'desc'	=> $desc, 
				'updatetime'=> $updatetime,
				'status'=> $status,
			);
		}
		break;
}
$tpl->assign('return', $return);
echo_exit($tpl->r($template));
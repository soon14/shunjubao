<?php
/**
 * 后台之:修改文章推荐
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#判断角色
$users = include_once ROOT_PATH . '/include/user_recommend.php';
$code = Request::r('code');
foreach ($users as $key=>$value) {
	if ($code == $value['code']) {
		$u_id = $value['id'];
	}
}

if (!$u_id) {
	fail_exit('access denied');
}

$cms_id = Request::r('id'); 
$tpl = new Template();
$objCms = new Cms();

$cms = $objCms->get($cms_id);
	
if (!$cms) {
	fail_exit('没有推荐信息');
}
$batch = $cms['batch'];
$batchInfos = $objCms->getsByCondition(array('batch'=>$batch));
$info = $_POST;

if ($info['submit']) {
	#TODO对信息进行过滤处理
	unset($info['submit']);

	$info['id'] = $cms_id;
	$info['update_time'] = getCurrentDate();//添加修改时间
	$tmpResult = $objCms->modify($info);
	if (!$tmpResult) {
		fail_exit('保存失败');
	}
	success_exit();
}
#查询当前批次
#标题
$TEMPLATE ['title'] = "后台 - 创建文章推荐";

$cmsTypeDesc =Cms::getCmsTypeDesc();
$tpl->assign ('cmsTypeDesc', $cmsTypeDesc);
$tpl->assign('batchInfos', $batchInfos);
$tpl->assign('code', $code);
$tpl->assign('tableInfo', $cms);
$tpl->assign('users', $users);
$tpl->assign('batch', $batch);
$YOKA ['output'] = $tpl->r ( '../admin/cms/create' );
echo_exit ( $YOKA ['output'] );
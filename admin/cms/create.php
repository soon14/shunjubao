<?php
/**
 * 后台之:创建文章推荐
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#判断角色

$roles = array(
	Role::RECOMMEND_SPECIAL,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit_g("该页面不允许查看");
}

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

//批次开始日期，每周算作一个批次
$batch = getBatch();
//本周第一天和最后一天
$sunday = getSpecialDate(0). " 00:00:00";
$saturday = getSpecialDate(6). " 23:59:59";

$tpl = new Template();
$objCms = new Cms();

$info = $_POST;
if ($info['submit']) {
	#TODO对信息进行过滤处理
	
	$info['u_id'] = $u_id;
	$info['create_time'] = getCurrentDate();
	if (isset($info['code'])) unset($info['code']);
	unset($info['submit']);
	
	$info['start_time'] = trim($info['start_time']);
	$info['end_time'] = trim($info['end_time']);
	
	$tmpResult = $objCms->add($info);
	if (!$tmpResult) {
		fail_exit();
	}
	success_exit();
}
#查询当前批次
$batchInfos = $objCms->getsByCondition(array('batch'=>$batch));
#标题
$TEMPLATE ['title'] = "后台 - 创建文章推荐";

$cmsTypeDesc =Cms::getCmsTypeDesc();
$tpl->assign ('cmsTypeDesc', $cmsTypeDesc);
$tpl->assign('batchInfos', $batchInfos);
//$tpl->assign('code', $code);
$tpl->assign('batch', $batch);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('sunday', json_encode($sunday));
$tpl->assign('saturday', json_encode($saturday));
$YOKA ['output'] = $tpl->r ('../admin/cms/create');
echo_exit ( $YOKA ['output'] );
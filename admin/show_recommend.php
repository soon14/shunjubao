<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#判断角色
$users = include_once ROOT_PATH . '/include/user_recommend.php';
$code = Request::r('code');
$id = Request::r('id');
$u_id = false;
foreach ($users as $key=>$value) {
	if ($code == $value['code']) {
		$u_id = $value['id'];
	}
}

if (!$u_id) {
//	fail_exit('access denied');
}
if (!$id) {
//	fail_exit('access denied');
}

$tpl = new Template();
$objCms = new Cms();

$info = $objCms->get($id);
#标题
$TEMPLATE['title'] = "后台 - 创建文章推荐";

$tpl->assign('infos', array($info));
$tpl->assign('code', $code);
$YOKA ['output'] = $tpl->r ( 'fufeituijian' );
echo_exit ( $YOKA ['output'] );
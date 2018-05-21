<?php
/**
 * 我的消息--删除消息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$uid = Runtime::getUid();

$pms_id = Request::p('pms_id');

$objUserPMSFront = new UserPMSFront();
$condition = array(
	'msgtoid'	=> $uid,
	'id'	=> $pms_id,
);
$pms = $objUserPMSFront->findIdsByPMS($condition);

if (!$pms) {
	ajax_fail_exit('删除失败！');
}

$tmpResult = $objUserPMSFront->delOnePMS($pms_id);

if ($tmpResult) {
	ajax_success_exit();
} else {
    ajax_fail_exit('删除失败！');
}
<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if (!Runtime::requireLogin(false)) {
	ajax_fail_exit('未登录');
}

$u_id = Runtime::getUid();
$type = Request::r('type');
$objUserPMSFront = new UserPMSFront();

switch ($type) {
	case 'getNewPms'://获取未读的短消息，用在顶部显示
		
		$condition = array();
		$condition['receive_uid'] = $u_id;
		$condition['status'] = UserPMS::STATUS_NOT_RECEIVING;
		$userPmsInfos = $objUserPMSFront->getsByCondition($condition, 1, 'create_time desc');
		if (!$userPmsInfos) {
			ajax_fail_exit('参数不正确');
		}
		ajax_success_exit(array_pop($userPmsInfos));
		
		break;
	case 'getNewPmsNum'://获取未读的短消息总数，用在顶部显示

		$condition = array();
		$condition['receive_uid'] = $u_id;
		$condition['status'] = UserPMS::STATUS_NOT_RECEIVING;
		$allIds = $objUserPMSFront->findIdsByPMS($condition);
		if (!$allIds) {
			ajax_fail_exit(0);
		}
		ajax_success_exit(count($allIds));

		break;
	case 'delPms':
		$id = Request::r('id');
		$userPmsInfo = $objUserPMSFront->getOnePMS($id);
		if (!$userPmsInfo) {
			ajax_fail_exit('参数不正确');
		}
		//不允许操作别人的pms
		if (!$userPmsInfo['receive_uid'] != Runtime::getUid()) {
			ajax_fail_exit('不允许的操作');
		}
		$tmpResult = $objUserPMSFront->delOnePMS($id);
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit($tmpResult->getData());
		}
		ajax_success_exit('');
		break;
	case 'PmsToReceive'://短消息置已读
		$pmsId = Request::r('pmsId');
		if (!Verify::int($pmsId)) {
			ajax_fail_exit('pmsId wrong');
		}
		
		$objUserPMSFront = new UserPMSFront();
		$pmsInfo = $objUserPMSFront->getOnePMS($pmsId);
		
		if (!$pmsInfo) {
			ajax_fail_exit('pms wrong');
		}
		
		if ($pmsInfo['receive_uid'] != $u_id) {
			ajax_fail_exit('operate denied');
		}
		
		$tmpResult = $objUserPMSFront->updatePMSsToReceive(array($pmsId));
		if (!$tmpResult) {
			ajax_fail_exit('操作失败');
		}
		
		ajax_success_exit('操作成功');
		
		break;
		
	case 'PmsToDelete'://短消息置删除
		$pmsId = Request::r('pmsId');
		if (!Verify::int($pmsId)) {
			ajax_fail_exit('pmsId wrong');
		}
		
		$objUserPMSFront = new UserPMSFront();
		$pmsInfo = $objUserPMSFront->getOnePMS($pmsId);
		
		if (!$pmsInfo) {
			ajax_fail_exit('pms wrong');
		}
		
		if ($pmsInfo['receive_uid'] != $u_id) {
			ajax_fail_exit('operate denied');
		}
		
		$tmpResult = $objUserPMSFront->updatePMSsToDelete(array($pmsId));
		if (!$tmpResult) {
			ajax_fail_exit('操作失败');
		}
		
		ajax_success_exit('操作成功');
		
		break;	
	default:
		ajax_fail_exit('错误的操作');
		break;
}
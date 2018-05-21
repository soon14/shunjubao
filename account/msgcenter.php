<?php
/**
 * 我的消息
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

$uid = Runtime::getUid();

if ($uid) {

	//判断是否上一页时用到了$firstPage
	$firstPage = 1;
	$page = Request::varGetInt('page', $firstPage);
	//判断是否下一页时用到了$size
	$size = 10;
	$offset = ($page-1) * $size;
	$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录
	$limit = "{$offset}, {$real_size}";

	$objUserPMSFront = new UserPMSFront();
	$objUserRemindFront = new UserRemindFront();

	$condition = array(
		'msgtoid'	=> $uid,
	);
	$ids = $objUserPMSFront->findIdsByPMS($condition, $limit, 'send_time desc');

	$userPMS = $objUserPMSFront->getPMSs($ids);

	$pms_ids = array();
	foreach ($userPMS as $pms) {
		if (!$pms['new']) {
			$pms_ids[] = $pms['id'];
		}
	}
	$objUserPMSFront->updatePMSs($pms_ids, $uid);
	$objUserRemindFront->clearRemind_Pms($uid);
}

$tpl = new Template();

$frombaidu = false;
if (Request::g('frombaidu') == 1 && !$uid) {
	$frombaidu = true;
}

if (!$frombaidu) {
	Runtime::requireLogin();
}

//分页
$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
if ($previousPage) {
	$previousUrl = ROOT_DOMAIN."/account/msgcenter.php?page={$previousPage}";
}
$nextPage = false;
if (count($userPMS) > $size) {
	$nextPage = $page+1;
	array_pop($userPMS);// 删除多取的一个
}
if ($nextPage) {
	$nextUrl = ROOT_DOMAIN."/account/msgcenter.php?page={$nextPage}";
}

$tpl->assign('cur_tab', 'account_msgcenter');
$tpl->assign('userPMS', $userPMS);
$tpl->assign('previousPage', $previousPage);
$tpl->assign('nextPage', $nextPage);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('msgcenter_page', true); # 不显示小提示
$tpl->assign('frombaidu', $frombaidu);

$YOKA['output'] = $tpl->r('account_msgcenter');

echo_exit($YOKA['output']);
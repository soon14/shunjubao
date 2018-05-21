<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#判断角色
$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit_g("该页面不允许查看");
}

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$objCms = new Cms();
$tpl = new Template();
$TEMPLATE['title'] = '后台-批量订阅邮箱';
#订阅的期数，最后一期
$lastbatch = $objCms->getLastBatch();
#新的一期
$newbatch = $lastbatch + 1;
#订阅类型
$type = Request::r('type');
#选择的期数
$batch = Request::r('batch');

$old_sunday 	= getSpecialDate(0);
$old_saturday 	= getSpecialDate(6);
$new_sunday 	= getSpecialDate(7);
$new_saturday 	= getSpecialDate(13);

if(!$_POST['emails']) {
	$cmsTypeDesc =Cms::getCmsTypeDesc();
	$tpl->assign ('cmsTypeDesc', $cmsTypeDesc);
	$tpl->assign ('newbatch', $newbatch);
	$tpl->assign ('oldbatch', $lastbatch);
//	$tpl->assign ('code', $code);
	
	$tpl->assign ('old_sunday', $old_sunday);
	$tpl->assign ('old_saturday', $old_saturday);
	$tpl->assign ('new_sunday', $new_sunday);
	$tpl->assign ('new_saturday', $new_saturday);
	echo_exit($tpl->r('../admin/cms/subscribe_email'));
}

$emails = $_POST['emails'];;
$emails = explode("\n", $emails);
$count = count($emails);

$objSubscribeEmailFront = new SubscribeEmailFront();
$objDBTransaction = new DBTransaction();
$strTransactionId = $objDBTransaction->start();

#获取订阅时间区间
$recommends = $objCms->getsByCondition(array('batch'=>$batch));
if (!$recommends) {
	//说明是新的一期
	$recommends = $objCms->getsByCondition(array('batch'=>$lastbatch));
} 
	//旧的一期
	$recommend = array_pop($recommends);
	$start_time = $recommend['start_time'];
	$end_time = $recommend['end_time'];


for ($row = 0;$row < $count;$row++) {
	
	$this_email = trim($emails[$row]);
	
    if (!Verify::email($this_email)) {
    	$error_emails[] = $this_email;
    	continue;
    }
    
    $info['create_time'] 	= getCurrentDate();
    $info['start_time'] 	= $start_time;
    $info['end_time'] 		= $end_time;
    $info['type'] 			= $type;
	$info['email'] 			= $this_email;
    $info['batch']			= $batch;

    $result = $objSubscribeEmailFront->add($info);
    if(!$result->isSuccess()) {
    	$objDBTransaction->rollback($strTransactionId);
    	fail_exit('创建订单信息失败,原因:'.$result->getData());
    }

}

if(!$objDBTransaction->commit($strTransactionId)) {
	fail_exit('提交信息失败');
}

if($error_emails) {
	$tips = '部分导入失败，邮箱：';
	foreach ($error_emails as $value) {
		$tips .= '</br>';
		$tips .= $value;
	}
} else {
	$tips = '订单导入成功';
}
success_exit($tips);
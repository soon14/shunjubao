<?php
/**
 * 收货地址处理
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$action = strtolower($_GET['action']);
$uid = Runtime::getUid();
$objConsigneeInfoFront = new ConsigneeInfoFront();
$default_id = $objConsigneeInfoFront->getDefault($uid);
if ($action == 'delete') {
	$id = Request::varRequestInt('id');
	$data = $objConsigneeInfoFront->get($id);
	if ($data && $data['uid'] == $uid) {
		$objConsigneeInfoFront->delete($id);
		if($id == $default_id)    #如果该地址是默认地址，那么也删除
		{
			$objConsigneeInfoFront->deleteDefault($uid, $id);
		}
		alert_back(NULL, true);
	} else {
		alert_back('删除失败！');		# 通常是乱输ID删除，不需要友好提示
	}
}

$tableInfo = $_POST['f'];

if ($tableInfo['name']=='') {
	alert_back('请输入姓名！');
} elseif ($tableInfo['province'] == '' || $tableInfo['city'] == '' || $tableInfo['county'] == '') {
	alert_back('请选择所在地区！');
} elseif ($tableInfo['address'] == '') {
	alert_back('请输入详细地址！');
} elseif ($tableInfo['postcode'] == '') {
	alert_back('请输入邮政编码！');
} elseif (!preg_match('/^\d{6}$/', $tableInfo['postcode'])) {
	alert_back('请输入正确的邮政编码！');
} elseif ($tableInfo['phone'] == '' && $tableInfo['mobile'] == '') {
	alert_back('电话和手机请至少填写一个！');
} elseif ($tableInfo['email'] == '') {
	alert_back('请输入邮箱地址！');
} elseif (!preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $tableInfo['email'])) {
	alert_back('请输入正确的邮箱地址！');
}
$phone = explode('-', $tableInfo['phone']);//对电话号码进行简单的判断，只允许有数字
if (is_array($phone)) {
	if ( !is_numeric($phone[0]) ) {
		unset($phone[0]);
	}
	if ( !is_numeric($phone[1]) ) {
		unset($phone[1]);
	}
	if ( !is_numeric($phone[2]) ) {
		unset($phone[2]);
	}
	$tableInfo['phone'] = implode('-', $phone);
} elseif (!is_numeric($tableInfo['phone'])) {
	$tableInfo['phone'] = '';
} else {
	$tableInfo['phone'] = '';
}

//
$tableInfo['name'] = htmlspecialchars(trim($tableInfo['name']), ENT_QUOTES, "UTF-8");
$tableInfo['province'] = htmlspecialchars(trim($tableInfo['province']), ENT_QUOTES, "UTF-8");
$tableInfo['city'] = htmlspecialchars(trim($tableInfo['city']), ENT_QUOTES, "UTF-8");
$tableInfo['county'] = htmlspecialchars(trim($tableInfo['county']), ENT_QUOTES, "UTF-8");
$tableInfo['address'] = htmlspecialchars(trim($tableInfo['address']), ENT_QUOTES, "UTF-8");
$tableInfo['postcode'] = htmlspecialchars($tableInfo['postcode'], ENT_QUOTES, "UTF-8");
$tableInfo['phone'] = htmlspecialchars($tableInfo['phone'], ENT_QUOTES, "UTF-8");
$tableInfo['mobile'] = htmlspecialchars($tableInfo['mobile'], ENT_QUOTES, "UTF-8");
$tableInfo['email'] = htmlspecialchars(trim($tableInfo['email']), ENT_QUOTES, "UTF-8");
//

$tableInfo['uid'] = $uid;
$id = intval($tableInfo['id']);//出现id说明是修改地址，没有id则是产生新地址

if ($id > 0) {
	$result = $objConsigneeInfoFront->modify($tableInfo);
} else {
	$id = $objConsigneeInfoFront->add($tableInfo);
	if ($id)	$result = InternalResultTransfer::success();
	else $result = InternalResultTransfer::fail('插入数据失败');
}

if ($result->isSuccess()) {
	if ($_POST['setDefault'] == 'on') {
		$objConsigneeInfoFront->setDefault($uid, $id);
	}
	else     #如果恰好是默认地址，但是在更改后，不再设置为默认地址，那么删除该默认地址
	{
		if($id == $default_id)
		{
			$objConsigneeInfoFront->deleteDefault($uid, $id);
		}
	}
		redirect(Request::getReferer());
} else {
	fail_exit_g($result->getData());
}

function alert_back($msg = NULL, $reload = false) {
	header('Content-type: text/html; charset=UTF-8');
	$js_back = 'history.go(-1)';
	if ($reload) {
		$referer = Request::getReferer();
		$js_back = "location = '$referer'";
	}
	echo <<<HTML
		<script>
		if ('$msg')	alert('$msg');
		$js_back;
		</script>
HTML;
	exit;
}


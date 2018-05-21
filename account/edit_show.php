<?php
/**
 *
 * 修改密码
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if (!Request::isPost()) {
	ajax_fail_exit("只接受post行为");
}

$action = $_POST['action'];
switch ($action) {
	case 'editpas' :
		empty($_POST['nowpas']) && ajax_fail_exit('目前的登录密码 不能为空');
		empty($_POST['newpas']) && ajax_fail_exit('新密码 不能为空');
		empty($_POST['repas']) && ajax_fail_exit('确认密码 不能为空');
		($_POST['newpas'] != $_POST['repas']) && ajax_fail_exit('两次填写的密码不一致');
		$uname = Runtime::getUname();
		$objUserFront = new UserFront();
		$tmpResult = $objUserFront->getByNameAndPassword($uname, $_POST['nowpas']);
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit($tmpResult->getData());
		}
		$result = $objUserFront->updatePasByName($uname, $_POST['newpas']);
		if ($result) {
			ajax_success_exit('密码设置成功！');
		} else {
			ajax_fail_exit('密码设置失败！');
		}
		break;
	default:
		ajax_fail_exit("不支持的action");
		break;
}

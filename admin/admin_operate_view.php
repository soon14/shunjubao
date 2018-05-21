<?php
/**
 * 管理操作页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
);

if (!Runtime::requireRole($roles,false)) {
	fail_exit("该页面不允许查看");
}

$type = Request::r('type');
$operate = Request::r('operate');
$status = Request::r('status');

$operate_array = array('show','add','edit','del','leitai');//操作集合
$adminOperateTypeDesc = AdminOperate::getAdminOperateTypeDesc();//类型集合

if (!array_key_exists($type, $adminOperateTypeDesc)) {
	fail_exit('未知的操作类型');
}

$tpl = new Template();
$tpl->assign('adminOperateTypeDesc', $adminOperateTypeDesc);
$tpl->assign('type', $type);

if (!in_array($operate, $operate_array)) {
	$operate = 'show';
}
$tpl->assign('operate', $operate);

$objAdminOperate = new AdminOperate();

switch ($operate) {
	case 'leitai':
		$id = Request::r('id');
		$leitai = Request::r('leitai');
		$objMySQLite = new MySQLite($CACHE['db']['default']);
		$usql = "update admin_operate set leitai = '".$leitai."' where id='".$id."'";
		$tmpResult = $objMySQLite->query($usql);	
		if(!$tmpResult) {
			fail_exit('修改失败');
		}
		success_exit('修改成功');
		break;
	
	
	case 'show':
		$condition = array();
		$condition['type'] = $type;
		$condition['status'] = $status;
		$results = $objAdminOperate->getsByCondition($condition);
		$tpl->assign('results', $results);
		$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
		unset($sportAndPoolDesc[UserTicketAll::FB_CROSSPOOL]);
		unset($sportAndPoolDesc[UserTicketAll::BK_CROSSPOOL]);
		$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);
		break;
	case 'add':
		$tableInfo = array();
		$tableInfo = $_POST;
		if ($type == AdminOperate::TYPE_SHOW_TICKET) {
			$u_name = $_POST['u_name'];
			$objUserMemberFront = new UserMemberFront();
			$show_user = $objUserMemberFront->getByName($u_name);
			if (!$show_user) {
				fail_exit('添加失败，用户:'.$u_name.'  不存在');
			}
			$tableInfo['show_uid'] = $show_user['u_id'];
		}
		$tableInfo['start_time'] = $tableInfo['end_time'] = getCurrentDate();
		$id = $objAdminOperate->add($tableInfo);
		if (!$id) {
			fail_exit('添加失败');
		}
		success_exit('添加成功');
		break;
	case 'edit':
		$tableInfo = array();
		$tableInfo = $_POST;
		$tmpResult = $objAdminOperate->modify($tableInfo);
		if (!$tmpResult->isSuccess()) {
			fail_exit('添加失败');
		}
		success_exit('修改成功');
		break;
		
	case 'del':
		$id = Request::r('id');
		$tmpResult = $objAdminOperate->update(array('status'=>AdminOperate::STATUS_NOT_AVILIBALE), array('id'=>$id));
		if (!$tmpResult) {
			fail_exit('删除失败');
		}
		success_exit('删除成功');
		break;
}

echo_exit($tpl->r('../admin/admin_operate'));

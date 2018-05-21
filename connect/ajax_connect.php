<?php
/**
 * 联合登录ajax处理脚本
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$type = Request::r('type');
$connect_id = Request::r('connect_id');

if (!Verify::int($connect_id)) {
	ajax_fail_exit('参数错误');
}

$objUserConnect = new UserConnect();
$connect_info = $objUserConnect->get($connect_id);

if (!$connect_info) {
	ajax_fail_exit('绑定信息未找到');
}

$new_user_info = array();

$objTMPassport = new TMPassport();

switch ($type) {
	//直接创建一个新帐号，但用户名可能不同
	case 'create_new':
		
		if ($connect_info['status'] != UserConnect::CONNECT_STATUS_NOT_BIND) {
			ajax_fail_exit('帐号已绑定');
		}
		
		$u_name = Request::r('u_name');
		
		$objUserFront = new UserMemberFront();
		$UserInfo = $objUserFront->getByName($u_name);
		if ($UserInfo) {
			ajax_fail_exit('用户名已存在');
		}
		
		$password = UserConnect::getConnectUserPW();
		$tableInfo =  array(
				'u_name'            => $u_name,
				'u_pwd'          	=> $password,
		);
		//绑定用户头像
		if ($connect_info['headimgurl']) {
			$tableInfo['u_img'] = $connect_info['headimgurl'];
		}
		$result = $objTMPassport->register($tableInfo);
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		
		$new_user_info = $result->getData();
		
		//绑定操作
		$result = $objUserConnect->bindUser($connect_info['id'], $new_user_info);
		if (!$result->isSuccess()) {
			#TODO，绑定不成功时，刚生成的用户需要做删除处理
			ajax_fail_exit($result->getData());
		}
		
		ajax_success_exit('帐号创建成功');
		break;
	//绑定已有的用户：必须是当前connect类型未绑定过的用户
	case 'bind_user':
		
		if ($connect_info['status'] != UserConnect::CONNECT_STATUS_NOT_BIND) {
			ajax_fail_exit('帐号已绑定');
		}
		
		//验证用户名和密码
		$u_name = Request::r('u_name');
		$u_pwd = Request::r('u_pwd');
		$objUserMemberFront = new UserMemberFront();
		$result = $objUserMemberFront->getByNameAndPassword($u_name, $u_pwd);
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		$user = $result->getData();
		//绑定操作
		$result = $objUserConnect->bindUser($connect_info['id'], $user);
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		//用户登录
		$objTMPassport->loginByUserInfo($user);
		ajax_success_exit('帐号绑定成功');
		
		break;
		//验证已经有网站用户的信息
	case 'verify_pwd':
		
		$u_name = Request::r('u_name');
		$u_pwd = Request::r('u_pwd');
		
		$objUserMemberFront = new UserMemberFront();
		$result = $objUserMemberFront->getByNameAndPassword($u_name, $u_pwd);
		if (!$result->isSuccess()) {
			ajax_fail_exit('用户名和密码不匹配');
		}
		
		ajax_success_exit('用户名和密码匹配');
		
		break;
		//验证用户名是否存在,此处的处理逻辑跟用户注册时不一样,需要注意
	case 'verify_uname':
		$u_name = Request::r('u_name');
		$objUserFront = new UserMemberFront();
		$UserInfo = $objUserFront->getByName($u_name);
		if ($UserInfo) {
			ajax_fail_exit('用户名已存在');
		}
		ajax_success_exit('用户名未被注册可以使用');
		break;
	default:
		ajax_fail_exit('操作类型错误');
		break;
}

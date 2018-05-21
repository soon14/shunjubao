<?php
/**
 * passport之：注册界面
 */
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';

$refer = Request::getReferer();

//防止从登录页过来，导致
//if (stripos($refer, 'login.php') !== false || !$refer) {
//	$refer = ROOT_DOMAIN;
//}

#已登录用户跳转
/*if (Runtime::isLogin()) {
	redirect($refer);
}*/

$tpl = new Template ();

/*if (Request::isPost()) {
	$submitInfo = array();
	
	if (isset($_POST['submit'])) {
		$msg = array();
		do {
			#验证用户名
			$u_name = Request::p('u_name');
			$submitInfo['u_name'] = $u_name;
			#1、是否合法
			$tmpVerifyResult = UserMemberFront::verifyName($u_name);
			if (!$tmpVerifyResult->isSuccess()) {
				$msg['u_name'] = $tmpVerifyResult->getData();
			}
			#2、是否已经注册
			$objUserMemberFront = new UserMemberFront();
			$tmpResult = $objUserMemberFront->getByName($u_name);
			if ($tmpResult) {
				$msg['u_name'] = '用户已存在';
			}
			#3、手机是否合法
			$mobile = Request::r('mobile');
			$submitInfo['mobile'] = $mobile;
			if (!Verify::mobile($mobile)) {
				$msg['mobile'] = '手机号不合法';
			}
			#验证密码
			$submitInfo['u_pwd'] = $_POST['u_pwd'];
			if (empty ( $submitInfo['u_pwd'] )) {
				$msg['newpas'] = "密码不能为空";
			}
			#验证确认密码
			$repas = $_POST['repas'];
			if (empty ( $repas )) {
				$msg['repas'] = "密码不能为空";
			}
			#密码不一致
			if ($submitInfo['u_pwd'] != $repas ) {
				$msg['repas'] = "密码不一致";
			}
			#密码长度
			if ($submitInfo['u_pwd'] == $repas && strlen ( $repas )<6 ) {
				$msg['newpas'] = "密码长度不能小于6位";
			}
			
		} while ( FALSE );

        
        #注册用户
		if (!$msg) {
			$objTMPassport = new TMPassport();
			//记录外站来源，加入u_source
			$sourceFrom = TMCookie::get(UserMember::OTHER_SITES_FROM_COOKIE_KEY);
			$sourceId = UserMember::verifySiteFrom($sourceFrom);
			if ($sourceId) {
				$submitInfo['u_source'] = $sourceId;
			}
			$result = $objTMPassport->register($submitInfo);
			if ($result->isSuccess()) {
				$userInfo = $result->getData();
				//注册送彩金
				addGift($userInfo['u_id'], 3);
				$tpl->assign('userInfo', $userInfo);
				$tpl->assign ('refer', $refer);
				$YOKA ['output'] = $tpl->r ('reg_success');
				echo_exit( $YOKA ['output'] );
			} else {
				$msg = $result->getData();
			}
		}
//		pr($msg);exit;
	}*/
//}
#标题
$TEMPLATE ['title'] = "专家列表 - ";

/*#post提交数据
$tpl->assign ( 'submitInfo', $_POST );
#错误信息
if($msg) {
	$tpl->assign ( 'msg', $msg );
}
*/
#埋藏跳转页面
$tpl->assign ('refer',$refer );

$YOKA ['output'] = $tpl->r ('zhuanjia/zhuanjia');
echo_exit ( $YOKA ['output'] );


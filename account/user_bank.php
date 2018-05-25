<?php
/**
 * 用户中心绑定银行信息页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();

$msg_error = '';
$msg_success = '';
$userRealInfo = array();

$tpl = new Template();
$objUserRealInfoFront = new UserRealInfoFront();

if ($_POST) {
//	$realname = Request::p('realname');
	
	$address 	= $_POST['f'];
	$province 	= $address['province'];
    $city 		= $address['city'];
    $county 	= $address['county'];
    
    $bank 		= Request::p('bank');
    $bankcard 	= Request::p('bankcard');
    $rebankcard = Request::p('rebankcard');
    $bank_branch = Request::p('bank_branch');
    
    do {
    	#realname40 idcard 20 bankcard 20 bank40 bank_province40 bank_city40 bank_branch100
//    	if(mb_strlen($realname) > 40){
//    		$msg_error = '真实姓名过长';
//    		break;
//    	}
    	if(!$bank){
    		$msg_error = '银行名称不能为空';
    		break;
    	}
    	if(!$province){
    		$msg_error = '请选择省信息';
    		break;
    	}
    	if(!$city){
    		$msg_error = '请选择市信息';
    		break;
    	}
    	if(!$bankcard){
    		$msg_error = '银行卡号不能为空';
    		break;
    	}
    	if(!$bank_branch){
    		$msg_error = '支行不能为空';
    		break;
    	}
    	
    	if(mb_strlen($bankcard) > 40){
    		$msg_error = '银行卡号过长';
    		break;
    	}
    	if(mb_strlen($bank) > 40){
    		$msg_error = '开户行名称过长';
    		break;
    	}
    	if(mb_strlen($province) > 40){
    		$msg_error = '省名称过长';
    		break;
    	}
    	if(mb_strlen($city) > 40){
    		$msg_error = '市名称过长';
    		break;
    	}
    	if(mb_strlen($bank_branch) > 100){
    		$msg_error = '支行名称过长';
    		break;
    	}
    	if ($bankcard != $rebankcard) {
    		$msg_error = '两次卡号不一致';
    		break;
    	}
    	
	    $tableInfo = array();
	    $tableInfo['u_id'] 			= $userInfo['u_id'];
//	    $tableInfo['realname'] 		= $realname;
	    $tableInfo['bank'] 			= $bank;
	    $tableInfo['bank_province'] = $province;
	    $tableInfo['bank_city'] 	= $city;
	    $tableInfo['bankcard'] 		= $bankcard;
	    $tableInfo['bank_branch'] 	= $bank_branch;
	    
	    $tmpResult = $objUserRealInfoFront->modify($tableInfo);
	    if (!$tmpResult->isSuccess()) {
	    	$msg_error = '更新信息失败';
	    	break;
	    }
	    
	    $msg_success = '更新成功';
     }while (false);
} 
$userRealInfo = $objUserRealInfoFront->get($userInfo['u_id']);

//pr($userRealInfo);
#标题
$TEMPLATE ['title'] = "聚宝网用户绑定银行 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户绑定银行。';
$tpl->assign('msg_error', $msg_error);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userRealInfoJson', json_encode($userRealInfo));
echo_exit($tpl->r('user_bank'));
<?php
/**
 * 批量支付的通知回调页
 * 1、验证交易号
 * 2、为用户充值
 * 3、记录交易日志
 * http://test.zhiying.com/zy/services/notify_pay.php?
 * buyer_email=hushiyu008%40163.com&
 * buyer_id=2088002949743499&
 * exterface=create_direct_pay_by_user&
 * is_success=T&
 * notify_id=RqPnCoPT3K9%252Fvwbh3I74lyXDq2iVnxXJeLN%252Be0VBwnAWMu8Blk21hLDQqTU2h8Awy0Fa&
 * notify_time=2014-05-07+17%3A55%3A44&
 * notify_type=trade_status_sync
 * &out_trade_no=140507137011&
 * payment_type=1&
 * seller_email=zhiwin365%40126.com&
 * seller_id=2088311949386932&
 * subject=%E6%89%B9%E9%87%8F%E6%94%AF%E4%BB%98&
 * total_fee=0.01&
 * trade_no=2014050740786649&
 * trade_status=TRADE_SUCCESS&
 * sign=3d778f66918be91cc93c244ee5276fc7&
 * sign_type=MD5
 */

include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

//$objPayCenterClient = new PayCenterClient();
$params = Request::getRequestParams();
#记录下回调信息
$msg = 'params值：';
$msg .= "\n";
$msg .= var_export($params, true);
log_result($msg, 'notify_callback');

// $params = Request::getRequestParams();
if (!verifyTwjAlipayParams($params, $params['sign'])) {
	log_result_error('该请求未通过校验'.$msg);
	failExit('该请求未通过校验');
}

//if (!$objPayCenterClient->verifySign($params, $params['sign'])) {
//	failExit('该请求未通过校验');
//}

$out_trade_no = $params['out_trade_no'];

#1验证
#交易号
$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);

if(!$tmpChargeResult->isSuccess()) {
	failExit($tmpChargeResult->getData());
}

$userChargeInfo = $tmpChargeResult->getData();
if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_SUCCESS) {
	failExit('success');
}

if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_FAILED) {
	failExit('订单已经充值失败，不允许充值');
}

#金额 单位是元
$total_fee = $params['total_fee'];
//$total_fee = 123.56;
if (!Verify::money($total_fee)) {
	failExit("金额total_fee格式不正确");
}

if ($total_fee <= 0) {
	failExit("金额total_fee不可能小于0");
}

#用户
//$u_id = $params['yoka_user_id'];
//if (!Verify::unsignedInt($u_id)) {
//	failExit("用户id不正确");
//}
//
//if ($u_id != $userChargeInfo['u_id']) {
//	failExit("回调用户uid与系统用户uid不一致");
//}
$u_id = $userChargeInfo['u_id'];
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);
if (!$userInfo) {
	failExit('用户信息未找到');
}

# 获取支付商
$provider = $params['provider'];
//$log_type = UserAccountLog::PAY_ALIPAY;

if ($provider == 'tenpay') {
//	$log_type = UserAccountLog::PAY_TENPAY;
}

#2第三方充值
$objUserAccountFront = new UserAccountFront();
$accountResult = $objUserAccountFront->addCash($u_id, $total_fee);
if (!$accountResult->isSuccess()) {
	#记录充值失败的日志
	$logMsg = '第三方充值失败,时间：'.getCurrentDate();
	$logMsg .= 'uid:'.$u_id;
	$logMsg .= '金额:'.$total_fee;
	$logMsg .= "\n";
	$logMsg .= 'params值：';
	$logMsg .= "\n";
	$logMsg .= var_export($params, true);
	$logMsg .= "\n";
	$logMsg .= "错误描述：";
	$logMsg .= "\n";
	log_result($logMsg, $params['provider'], true);
	failExit('用户充值失败');
}

$userAccountInfo = $objUserAccountFront->get($u_id);

$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['money'] 		= $total_fee;
$tableInfo['log_type'] 		= BankrollChangeType::CHARGE;
$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
$tableInfo['record_table'] 	= 'user_charge';//对应的表
$tableInfo['record_id'] 	= $userChargeInfo['charge_id'];
$tableInfo['create_time'] 	= getCurrentDate();
//添加账户日志
$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tmpResult = $objUserAccountLogFront->add($tableInfo);

if (!$tmpResult) {
	$logMsg = '添加账户日志失败，pay_order_id:'.$out_trade_no;
	log_result($logMsg, 'add_account_log', true);
	failExit('用户充值失败');
}

#3充值日志
$userChargeInfo['charge_status'] 	= UserCharge::CHARGE_STATUS_SUCCESS;
$userChargeInfo['return_time'] 		= getCurrentDate();
$userChargeInfo['return_code']		= $params['trade_no'];
$userChargeInfo['return_message']	= $params['trade_status'];
$tmpResult = $objUserChargeFront->modify($userChargeInfo);
if (!$tmpResult->isSuccess()) {
	failExit('用户充值失败');
}

//充值送彩金活动
chargeGift($u_id, $total_fee);
//chargeAddGift($u_id, $total_fee);
echo 'success';
exit;

function failExit($msg) {
//	header('Content-Type: text/xml;charset=utf-8');
    echo $msg;
    exit;
}
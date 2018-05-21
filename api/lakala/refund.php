<?php
/**
 * 向拉卡拉发送退款请求
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
if (!Verify::unsignedInt(Request::g('out_trade_no'))) {
	ajax_fail_exit("订单号输入错误！");
}
if (!Verify::money(Request::g('money'))) {
	ajax_fail_exit("退款金额输入错误！");
}
if (!Request::g('reason')) {
	ajax_fail_exit("请输入退款原因！");
}

$out_trade_no = Request::g('out_trade_no');
$refound_money = Request::g('money');
$reason = Request::g('reason');

# 验证订单
$objUserOrderFront = new UserOrderFront();
$userOrder = $objUserOrderFront->getByOutTradeNo($out_trade_no);
if (!$userOrder) {
	ajax_fail_exit("该订单不存在！");
}

$objLakalaRefundLog = new LakalaRefundLog();
$tmpR = $objLakalaRefundLog->findIdsBy(array(
	'out_trade_no' 	=> $out_trade_no,
	'status'		=> LakalaRefundLog::STATUS_SUCCESS,
));
if ($tmpR) {
	ajax_fail_exit("该订单已经申请退款！");
}

# 记录退款操作信息
$tableInfo = array(
	'out_trade_no'	=> $out_trade_no,
	'refound_money'	=> $refound_money,
	'operator_uid'	=> Runtime::getUid(),
	'refound_desc'	=> $reason,
	'create_time' => time(),
);
$tmpResult = $objLakalaRefundLog->insertDuplicate($tableInfo);
if (!$tmpResult) {
	ajax_fail_exit('记录退款信息失败！');
}

# 处理退款请求
$params = array(
	'bill_num'	=> FIXEDBILL.$out_trade_no,
	'macType'	=> 'MD5',
	'merId'		=> MERID,
	'partner_bill_no'	=> $out_trade_no,
	'refound_amount'	=> $refound_money,
	'refound_desc'		=> '',
	'ver'		=> '1.1'
);

foreach ($params as $tmpK => $tmpV) {
	if (isset($sign)) { 
		$sign .= "&";
	}
	$sign .= $tmpK.'='.$tmpV;
}
$params['sign']	= md5($sign.MACKEY);

$objCurl = new Curl(REFUND_URL);
$tmpResult = iconv('gbk', 'utf-8', $objCurl->post($params));

# 处理返回信息
parse_str($tmpResult, $params);
if ($params['ret_code'] === '000') {
	$objLakalaRefundLog->insertDuplicate(array(
		'out_trade_no' => $out_trade_no,
		'status' => LakalaRefundLog::STATUS_SUCCESS,
	));
	ajax_success_exit('退款请求成功！');
} else {
	$objLakalaRefundLog->insertDuplicate(array(
		'out_trade_no' => $out_trade_no,
		'status' => LakalaRefundLog::STATUS_FAILURE
	));
	ajax_fail_exit("退款请求失败！原因：ret_code:{$params['ret_code']} msg:{$params['ret_msg']}");
}
exit;
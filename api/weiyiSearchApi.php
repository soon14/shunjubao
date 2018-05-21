<?php
/**
 * 唯一查询接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$unionId = 'weiyi'; # 唯一联盟在广告主系统中的ID编号
if (Request::g('unionId') != $unionId) {
	echo '参数错误！';
	exit;
}

$pwd = '888888'; # 唯一联盟在广告主系统中的帐户密码
if (Request::g('pwd') != $pwd) {
	echo '参数错误！';
	exit;
}

if (strlen(Request::g('starttime')) != 10 || strlen(Request::g('endtime')) != 10) {
	echo '时间格式错误！';# 时间格式2008-08-08
	exit;
}

$starttime = Request::g('starttime');
$endtime = Request::g('endtime');
$condition['start_time'] = strtotime($starttime.'00:00:00');
$condition['end_time'] = strtotime($endtime.'23:59:59') - 86400; # 结束时间为前一天的最后一秒(查询 2010-7-21 这1天产生的订单 参数设置为starttime=2010-07-21&endtime=2010-07-22)

$objUserOrderFront = new UserOrderFront();
$objOrderAttrIdxFront = new OrderAttrIdxFront();

$ids = $objUserOrderFront->getsByCondition($condition, null);
if (!$ids) {
	$ids = array();
}
$userOrders = $objUserOrderFront->gets($ids);
if (!$userOrders) {
	$userOrders = array();
}

$result = array();
foreach ($userOrders as $userOrder) {
	if (!isset($userOrder['weiyi'])) {
		continue;
	}

	foreach ($userOrder['orderIds'] as $orderId) {
		$orderAttr = $objOrderAttrIdxFront->getsByOrderId($orderId);
		if (!$orderAttr) {
			$orderAttr = array();
		}
		foreach ($orderAttr as $tmpV) {
			$result[] = array(
				'odate'	=> date('Y-m-d H:i:s', $userOrder['create_time']),
				'cid'	=> $userOrder['weiyi'],
				'bid'	=> $userOrder['uname'],
				'oid'	=> $userOrder['out_trade_no'],
				'pid'	=> $tmpV['ssProdAttr']['prodAttr']['id'],
				'ptype'	=> '', # 佣金标准编号
				'amount'=> $tmpV['amount'],
				'price'	=> $tmpV['ssProdAttr']['unit_price'],
				'ostat'	=> $tmpV['status'],
			);
		}
	}
}

$output = '';
foreach ($result as $tmpV) {
	$output .= "{$tmpV['odate']}\t{$tmpV['cid']}\t{$tmpV['bid']}\t{$tmpV['oid']}\t{$tmpV['pid']}\t{$tmpV['ptype']}\t{$tmpV['amount']}\t{$tmpV['price']}\t{$tmpV['ostat']}\t\n";
}

echo $output;













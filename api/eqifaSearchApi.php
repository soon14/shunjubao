<?php
/**
 * 提供给亿起发订单查询接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if(!Request::g('src') || !Request::g('cid') || !Request::g('d')){
	echo '缺少有效参数！';
	exit;
}

if(Request::g('src') != 'ymcps'){
	echo '错误标识！';
	exit;
}

if( !Verify::unsignedInt(Request::g('d')) || strlen(Request::g('d')) != 8) {
	echo '时间格式错误！正确格式如(20111009)';
	exit;
}else{
	$d = Request::g('d');
}

if( !Verify::unsignedInt(Request::g('cid')) ){
	echo '请输入正确的渠道id！';
	exit;
}else{
	$cid = Request::g('cid');
}

$condition['start_time'] = strtotime($d.'00:00:00');
$condition['end_time'] = strtotime($d.'23:59:59');

$objUserOrderFront = new UserOrderFront();
$ids = $objUserOrderFront->getsByCondition($condition, null);
$userOrders = $objUserOrderFront->gets($ids);

$result = array();
foreach ($userOrders as $tmpV) {
	if ($tmpV['eqifa_src']){
		if( $tmpV['eqifa_cid'] != $cid){
			break;
		}
		$result[$tmpV['id']] = array(
			'wi'	=> $tmpV['eqifa_wi'],
			'sd'	=> date('Y-m-d H:i:s', $tmpV['create_time']),
			'on'	=> $tmpV['out_trade_no'],
			'pp'	=> $tmpV['ordersMoney'],
		);
	}
}

$tmp = '';
foreach ($result as $V) {
	$tmp .= $V['wi'].'||'.$V['sd'].'||'.$V['on'].'||'.$V['pp'].'<br>';
}

echo $tmp;

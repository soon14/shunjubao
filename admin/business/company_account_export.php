<?php
/**
 * 出票公司对帐导出
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


$start_time 	= Request::r('start_time');
$end_time 		= Request::r('end_time');
$company_id 	= Request::r('company_id');

if (!strtotime($start_time) || !strtotime($end_time) || !$company_id) {
	echo_exit('参数不正确');
}
$exclude_virtual = Request::r('exclude_virtual');

$companys = TicketCompany::getTicketCompany();

$print_state_desc = UserTicketAll::getPrintStateDesc();

$print_array = array();//最终展示的数组，按出票状态分组

//出票时间 B2B渠道号 票号 B2B订单号 销量	中奖
//2014/07/06 10:16:03	10,000,662	140706101510678013	20140706101232773724	2	0.00
$date = $start_time .'~' .$end_time;
############发送头部信息############
$fileName = "出票公司_{$companys[$company_id]['desc']}_对帐：".$date.".csv";
$fileName = iconv('utf-8', 'gb2312', $fileName);
header("Content-type:text/csv");
header("Content-Disposition:attachment;filename=".$fileName);
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0');
header('Pragma:public');
###################################
# 标题

$title = "出票时间,B2B渠道号,票号,B2B订单号,销量,中奖,用户订单ID,订单状态,订单详情\r\n";

echo $title;

for ($i = 0 ;$i<10 ; $i++) {
	$objUserTicketLog = new UserTicketLog($i);
	$condition = array();
	if ($company_id == TicketCompany::COMPANY_HUAYANG) {
		$company_id = array($company_id, 0);//兼容之前没有区分出票公司的情况
	}
	$condition['company_id'] = $company_id;
	$results = $objUserTicketLog->getsByCondtionWithField($start_time.' 00:00:00', $end_time.' 23:59:59', 'datetime' ,$condition, null, 'datetime asc');
	foreach ($results as $result) {
		if ($exclude_virtual && $result['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU) {
			continue;
		}
		$link = ROOT_DOMAIN.'/admin/order/orders.php?userTicketId='.$result['ticket_id'];
		$info = "{$result['datetime']},10000662,'{$result['return_id']},'{$result['return_str']},{$result['money']},{$result['prize']},{$result['ticket_id']},{$print_state_desc[$result['print_state']]['desc']},{$link}";
		$info .= "\r\n";
		echo $info;
	}
}
exit;
?>





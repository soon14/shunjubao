<?php
/**
 * 1、处理人工出票的系统票返奖
 * 2、处理投注失败的系统票返奖
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';
//人工出票
$step = 500;//发送票的个数最大值
$order = 'datetime desc';
$condition = array();
$condition['print_state'] 	= UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
$condition['company_id'] 	= array(TicketCompany::COMPANY_MANUAL, TicketCompany::COMPANY_ZHIYING);
$condition['prize_state'] 	= UserTicketAll::PRIZE_STATE_NOT_OPEN;
$condition['return_time'] 	= SqlHelper::addCompareOperator('<=', date('Y-m-d H:i:s', time() + 90 * 60));

for ($i=0; $i<10; $i++) {

	$objUserTicketLog = new UserTicketLog($i);
	$offset = 0;
	
	do{
		$limit = "{$offset},{$step}";
		
		$orderTickets = $objUserTicketLog->getsByCondition($condition, $limit, $order);
		if (!$orderTickets) {
			break;
		}
		
		foreach ($orderTickets as $orderTicket) {
			$tmpResult = manul_prize($orderTicket);
			$text = $tmpResult->getData();
			if (!$tmpResult->isSuccess()) {
				if(!strstr($text,'无赛果')) log_result_error($text);
			} else {
				log_result($text);
			}
		}
		
		$offset += $step;

	}while (true);
}
exit;
?>

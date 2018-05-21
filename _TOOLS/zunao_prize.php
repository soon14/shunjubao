<?php
/**
 * 尊傲出票之反奖
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objUserTicketAllFront = new UserTicketAllFront();
$condition = array();
$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS);
$condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
$condition['company_id'] = TicketCompany::COMPANY_ZUNAO;
$order = 'datetime asc';

$queryPrize = array();

$k = 0;//计数器
$max = 20;//发送票的个数最大值

for ($i=0; $i<10; $i++) {
		
	$objUserTicketLog = new UserTicketLog($i);
	$offset = 0;
	$step = $max;
	
	do{
		$limit = "{$offset},{$step}";
	
		$orderTicketInfos = $objUserTicketLog->getsByCondition($condition, $limit, $order);
		if (!$orderTicketInfos) {
			break;
		}
		
		foreach ($orderTicketInfos as $orderTicketInfo) {
			if ($k == $max) {
				pushZunaoPrizeInfo($queryPrize);
				$queryPrize = array();//发送结束清空数组
				$k = 0;//重新计数
			}
			$queryPrize[$orderTicketInfo['return_id']] = array('i'=>$i, 'orderTicketId'=>$orderTicketInfo['id']);
			$k++;
		}
		$offset += $step;
		
	}while (true);
	//发送残留的数据
	if ($queryPrize) {
		pushZunaoPrizeInfo($queryPrize);
		$queryPrize = array();//发送结束清空数组
		$k = 0;//重新计数
	}
}
exit;
/**
 * 发送给接口返奖数据
 * @param unknown $queryPrize array($ticketId 订单号=>array(i=>系统订单表后缀，orderTicketId=>系统订单id));
 */
function pushZunaoPrizeInfo($queryPrize) {
	
	$objZunAoTicketClient = new ZunAoTicketClient();
	$transcode = ZunAoTicketClient::TRANSCODE_QUERY_PRIZE;
	
	$head = array('transcode' => $transcode);
	$body = array();
	$body['queryPrize'] = array_keys($queryPrize);
	$xml = $objZunAoTicketClient->formXml($head, $body);
	$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);
	
	if (!$isSendOk) {
		$word = 'send is not ok';
		log_result_error($word);
	} else {
			$tmpResult = $objZunAoTicketClient->analysisRes();
			if (!$tmpResult) {
				//有错误出现
				$word = 'error!!!:'.$objZunAoTicketClient->getErrorCode() .' continue to next lottertId';
				log_result_error($word);
				return false;
			}
			$resArray = $objZunAoTicketClient->getResponseArray();
// 	 		pr($resArray);
			if (!isset($resArray['msg']['index']['WONTICKET'])) {//PRIZERESULT为总览
				$word = 'WONTICKET not exist continue to next';
				log_result_error($word);
				return false;
			}
			
			$ticketIndexs = $resArray['msg']['index']['WONTICKET'];//索引包含两部分：1、WONTICKET开始;2、WONTICKET结束
			//pr($ticketIndexs);
			//处理返回值
			foreach ($ticketIndexs as $value) {
				
				if ($resArray['msg']['vals'][$value]['type'] != 'open') {//不是开始标签
					continue;
				}
				
				$attributes= array();
				$attributes = $resArray['msg']['vals'][$value]['attributes'];
					
				$status = $attributes['STATE'];
				$ticketId = $attributes['TICKETID'];
				$isAwards = $attributes['ISAWARDS'];//是不是大奖1 为大奖 0 为小奖
				$preTaxPrice = $attributes['PRETAXPRICE'];//税前奖金
				$prize = $attributes['PRIZE'];//投注得到的中奖税后奖金
				
				$info = array();
					
				$info['id'] = $queryPrize[$ticketId]['orderTicketId'];
				$i = $queryPrize[$ticketId]['i'];//uid最后一位
				$objUserTicketLog = new UserTicketLog($i);
				 
				$continue = false;//#TODO是否继续下一个index；当状态为除中奖或未中奖外的状态时不需要更新，减少数据库操作
				switch ($status) {
					
					case '0'://0 : 撤单#TODO
						$info['return_str'] = '撤单';
						break;
						
					case '1'://1 : 未开奖
						$continue = true;
						break;
						
					case '2'://2: 已中奖
						$info['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
						$info['prize'] = $prize;
						break;
					case '3'://3 : 未中奖
						$info['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_WIN;
						break;
						
					case '4'://4 : 订单不存在，可能是订单导入进了历史数据，需要手动修改
						$word = 'i:'.$i.' orderid:'.$info['id'].' 4  order not exist';
						log_result_error($word);
						$continue = true;
						break;
					default:
						$info['return_str'] = 'unknow reason';
						break;
				}
				
				if ($continue) {
					continue;
				}
				
				$tmpResult = $objUserTicketLog->modify($info);
				if (!$tmpResult->isSuccess()) {
					$word = 'i:'.$i.' orderid:'.$info['id'].' modify orderTicket to error failed :'.$tmpResult->getData();
					log_result_error($word);
				}
			}
		}
}
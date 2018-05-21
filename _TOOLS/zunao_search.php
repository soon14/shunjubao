<?php
/**
 * 尊傲出票之查询票状态
 * 1、一次性只能查询50张票
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$processId = realpath(__FILE__) . "--{za_search}";
$timeout = 30 * 60;//30分钟
$alive_time = 2 * 60 * 60;//脚本存活时间为2小时

$objSingleProcess = new SingleProcess($processId, $timeout, true);

if ($objSingleProcess->isRun()) {
// 	echo "已经有进程在跑了\r\n";
	exit();
}
$objSingleProcess->run();

do {
	if (!isAlive($alive_time)) {
		break;
	}
	
$objUserTicketAllFront = new UserTicketAllFront();
$objZunAoTicketClient = new ZunAoTicketClient();
$condition = array();
$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU, UserTicketAll::TICKET_STATE_LOTTERY_ING);
$condition['company_id'] = TicketCompany::COMPANY_ZUNAO;
$order = 'datetime asc';

$step = 20;
$offset = 0;
$lotteryNumber = array();//按玩法分类的票数量
$queryTicket = array();

$ticketId_uid_orderId = array();//系统票和出票ID对照表

//查找系统票#TODO出票量巨大时会有性能问题
for ($i=0; $i<10; $i++) {
	
	$objUserTicketLog = new UserTicketLog($i);
	$orderTicketInfos = $objUserTicketLog->getsByCondition($condition , null, $order);
	if (!$orderTicketInfos) {
		continue;
	}
	foreach ($orderTicketInfos as $orderTicketInfo) {
		
		$lotteryId = strtoupper($orderTicketInfo['pool']);
		$TicketId = $orderTicketInfo['return_id'];
		if (!$TicketId) {
			continue;
		}
		
		if ($lotteryNumber[$lotteryId] == 50) {
			//集满50张票
			break 2;
		}
		
		$queryTicket[$lotteryId][] = $TicketId;
		$ticketId_uid_orderId[$TicketId] = array('i' =>$i, 'orderTicketId'=>$orderTicketInfo['id']);
		$lotteryNumber[$lotteryId]++;
	}
}
//没有需要处理的数据
if (!$ticketId_uid_orderId) {
// 	echo 'no ticketId exist';
// 	enter_newline();
	usleep(500000);
	continue;
}

$transcode = ZunAoTicketClient::TRANSCODE_QUERY_TRADE;
$head = array('transcode' => $transcode);
$lotteryIds = ZunAoTicketClient::getAllLottery();
$errorCodes = ZunAoTicketClient::errorCodeDesc();
foreach ($lotteryIds as $lotteryId) {
	//可能这个玩法没有投注
	if (!array_key_exists($lotteryId, $queryTicket)) {
		continue;
	}
	$body = array();
	$body['queryTicket'] = $queryTicket[$lotteryId];
	$xml = $objZunAoTicketClient->formXml($head, $body);
	$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);
	if (!$isSendOk) {
		$word = 'send is not ok';
		log_result_error($word);
	} else {
		$tmpResult = $objZunAoTicketClient->analysisRes();
		if (!$tmpResult) {
			//有错误出现
			$word = $lotteryId.' error!!!:'.$objZunAoTicketClient->getErrorCode() .' continue to next lottertId';
			log_result_error($word);
			continue;
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
// 		pr($resArray);
		if (!isset($resArray['msg']['index']['TICKETRESULT'])) {
			$word = $lotteryId.' TICKET not exist continue to next lottertId';
			log_result_error($word);
			continue;
		}
		
		$ticketIndexs = $resArray['msg']['index']['TICKETRESULT'];//索引
		//处理返回值
		foreach ($ticketIndexs as $value) {
			$attributes= array();
			$attributes = $resArray['msg']['vals'][$value]['attributes'];
			
			$status = $attributes['STATUSCODE'];
			$ticketId = $attributes['TICKETID'];
			
			$info = array();
			$info['return_id'] = $ticketId;
			
			$info['id'] = $ticketId_uid_orderId[$ticketId]['orderTicketId'];
			$i = $ticketId_uid_orderId[$ticketId]['i'];//uid最后一位
			$objUserTicketLog = new UserTicketLog($i);
                           
			switch ($status) {
				//000 : 订单不存在
				case '000':
					$info['return_str'] = $attributes['msg'];
					break;
				//001 : 等待交易#TODO
				case '001':
					
					break;
				//002: 交易中
				case '002':
					$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_ING;
					break;
				//003 : 交易成功
				case '003':
					$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
					$info['print_time'] = getCurrentDate();//出票时间
					$info['return_str'] = $attributes['PRINTNO'];
					$info['odds'] = $attributes['PRINTODD'];
					break;
				//004 : 交易失败
				case '004':
					$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_FAILED;
					$info['return_str'] = $attributes['msg'];
					break;
				default:
					$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_FAILED;
					$info['return_str'] = 'unknow reason';
					break;
         	}
         	//此时的系统票状态必为出票失败、出票成功或出票中三者之一
         	//出票中只是临时状态，最终还是会变为出票成功或出票失败之一
			$tmpResult = $objUserTicketLog->modify($info);
			if (!$tmpResult->isSuccess()) {
				$word = 'i:'.$i.' orderid:'.$info['id'].' modify orderTicket to error failed :'.$tmpResult->getData();
				log_result_error($word);
				continue;
			}
		}
	}
}

$objSingleProcess->active();

usleep(500000);
// echo "休息...\r\n";
} while (true);

$objSingleProcess->complete();

// echo "done\r\n";
exit;
<?php
/**
 * 北单投注
 * 策略：
 * 1、搜索所有10张用户投注记录表中的记录
 * 2、集满50票
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$processId = realpath(__FILE__) . "--{za_tickets}";
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
$condition['print_state'] = array(UserTicketAll::TICKET_STATE_NOT_LOTTERY);//未出票状态的
$condition['company_id'] = TicketCompany::COMPANY_ZUNAO;
$order = 'datetime asc';

$step = 20;
$offset = 0;
$lotteryNumber = array();//按玩法分类的票数量
$ticketorder = $tickets = array();
//获取最新的一期期数
$objBDIssueInfos = new BDIssueInfos();
$cond = array();
$lotteryIssueInfo = array();
$cond['status'] = BDIssueInfos::STATUS_SELLING;
$bdIssueInfos = $objBDIssueInfos->getsByCondition($cond, null, 'id desc');
if (!$bdIssueInfos) {
	echo 'issueinfo not exist';
	enter_newline();
	exit;
}

foreach ($bdIssueInfos as $bdIssueInfo) {
	$lotteryIssueInfo[$bdIssueInfo['lotteryId']] = $bdIssueInfo['issueNumber'];
}

$ticketId_uid_orderId = array();//系统票和出票ID对照表

//查找系统票#TODO出票量巨大时会有性能问题
for ($i=0; $i<10; $i++) {
	
	$objUserTicketLog = new UserTicketLog($i);
	$orderTicketInfos = $objUserTicketLog->getsByCondition($condition , 50, $order);
	
	if (!$orderTicketInfos) {
		continue;
	}
	
	foreach ($orderTicketInfos as $orderTicketInfo) {
		
		$lotteryId = strtoupper($orderTicketInfo['pool']);
		
		if ($lotteryNumber[$lotteryId] == 50) {
			//集满50张票
			break 2;
		}
		//获取期数信息，从串关选项中找任意场比赛，这场比赛的期数即是
		$combination = $orderTicketInfo['combination'];
		$m_1 = explode(',', $combination);
		$m_2 = explode('|', $m_1[0]);
		$match_id = $m_2[1];
		$objBettingBD = new BettingBD();
		$bettingInfo = $objBettingBD->get($match_id);
		if ($bettingInfo['issueNumber']) {
			$issueNumber = $bettingInfo['issueNumber'];
		} else {
			//以防万一
			$issueNumber = $lotteryIssueInfo[$lotteryId];
		}
		
		$ticketorder[$lotteryId]['lotteryId'] = $lotteryId;
		$ticketorder[$lotteryId]['ticketsnum']++;//订单数量
		$ticketorder[$lotteryId]['totalmoney'] += $orderTicketInfo['money'];//订单总金额，单位：元
		$TicketId = $objZunAoTicketClient->getTicketId();
		$tickets[$lotteryId][] = array(
				'ticketId' 		=> $TicketId,
				'issueNumber'	=> $issueNumber,//由于N场比赛里期数是固定的，因此只找到一场比赛的期数即可
				'multiple'		=> $orderTicketInfo['multiple'],
				'betType'		=> $objZunAoTicketClient->getBetType($orderTicketInfo['select']),
				'betUnits'		=> $orderTicketInfo['money']/(2 * $orderTicketInfo['multiple']),
				'betMoney'		=> $orderTicketInfo['money'],//最大值为20000
				'betContent'	=> $objZunAoTicketClient->getBetContent($orderTicketInfo['combination'])
		);
		
		$lotteryNumber[$lotteryId]++;
		$ticketId_uid_orderId[$TicketId] = array('i' =>$i, 'orderTicketId'=>$orderTicketInfo['id']);
	}
}
//没有需要处理的数据
if (!$ticketId_uid_orderId) {
// 	echo 'no tickets exit';
// 	enter_newline();
	usleep(500000);
	continue;
}

$transcode = ZunAoTicketClient::TRANSCODE_QUERY_TICKET;
$head = array('transcode' => $transcode);
$lotteryIds = ZunAoTicketClient::getAllLottery();
$errorCodes = ZunAoTicketClient::errorCodeDesc();
foreach ($lotteryIds as $lotteryId) {
	//可能这个玩法没有投注
	if (!array_key_exists($lotteryId, $ticketorder)) {
		continue;
	}
	$body = array();
	$body['ticketorder'] = $ticketorder[$lotteryId];
	$body['tickets'] = $tickets[$lotteryId];
	$xml = $objZunAoTicketClient->formXml($head, $body);
	$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);
	if (!$isSendOk) {
		$word = 'send is not ok';
		log_result_error($word);
		continue;
	} else {
		$tmpResult = $objZunAoTicketClient->analysisRes();
		if (!$tmpResult) {
			$error_code = $objZunAoTicketClient->getErrorCode();
			//有错误出现
			$word = $lotteryId.' error!!!:'.$objZunAoTicketClient->getErrorCode() .' continue to next lottertId';
			if ($error_code != 924) {//停售异常不需要记录日志
				log_result_error($word);
			}
			continue;
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
		if (!isset($resArray['msg']['index']['TICKET'])) {
			$word = $lotteryId.' TICKET not exist continue to next lottertId';
			log_result_error($word);
			continue;
		}
		$ticketIndexs = $resArray['msg']['index']['TICKET'];//game索引
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
				
			if (array_key_exists($status, $errorCodes)) {
				//一般出错提示
				$info['return_str'] = $errorCodes[$status]['desc'];
				//出错的详细说明
				if ($attributes['DETAILMESSAGE']) {
					$info['return_str'] .= ';DETAILMESSAGE:'.$attributes['DETAILMESSAGE'];
				}
				$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED;
				
				$word = '投注失败;ZYparams:'.var_export($body,true).';ZAparams:'.var_export($attributes, true);
				log_result_error($word);
				
			} elseif ($status === '000') {
				//没有出现异常
				$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU;
			} else {
				//未知的异常处理
				$info['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED;
				$info['return_str'] = 'unknow error happened';
				
				$word = '投注失败;ZYparams:'.var_export($body,true).';ZAparams:'.var_export($attributes, true);
				log_result_error($word);
				
			}
			//此时的出票状态必为投注成功或投注失败之一
			$tmpResult = $objUserTicketLog->modify($info);
			if (!$tmpResult->isSuccess()) {
				$word = 'i:'.$i.' orderid:'.$info['id'].' modify orderTicket to error failed :'.$tmpResult->getData();
				log_result_error($word);
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
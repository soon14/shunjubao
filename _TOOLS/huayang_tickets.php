<?php
/**
 * 华阳出票接口之投注
 * 1、按状态找出待出票订单
 * 2、尝试为待出票订单出票
 * 3、出票成功：修改订单状态；
 * 4、出票失败：什么都不做
 * 5、记录每次接口通信的所有信息，包括发送和接受信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$processId = realpath(__FILE__) . "--{hy_tickets}";
$timeout = 30 * 60;//30分钟
$alive_time = 2 * 60 * 60;//脚本存活时间为2小时

$objSingleProcess = new SingleProcess($processId, $timeout, true);

if ($objSingleProcess->isRun()) {
    exit();
}
$objSingleProcess->run();

do {
    if (!isAlive($alive_time)) {
    	break;
    }

	$objUserTicketAllFront = new UserTicketAllFront();
	$objHY = new HuaYangTicketClient();
	
	$condition = array();
	$condition['print_state'] = array(UserTicketAll::TICKET_STATE_NOT_LOTTERY, UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_PART);//未出票状态的
	$condition['company_id'] = TicketCompany::COMPANY_HUAYANG;
	$order = 'datetime asc';
	$step = 20;
	$offset = 0;
	
	$HYconfigs = include ROOT_PATH . '/include/ticket_config.php';
	$username = $HYconfigs['huayang']['username'];//计费账户用户名
	$ticketuser = '王忠仓';//彩票持有人真实姓名
	$identify = '130684198401098893';//身份证号码
	$phone = '13716778164';//
	$email = '328378851@qq.com';//
	$transactiontype = 13010;

do{
	$limit = "{$offset}, {$step}";
	$all_tickets = $objUserTicketAllFront->getsByCondition($condition, $limit, $order);//用户票

	if (empty($all_tickets)) {
		break;
	}
	
	$combination = array();//玩法
	$issue = array();//当前的奖期
	
	foreach ($all_tickets as $key=>$ticket) {
		
		$ticketId = $ticket['id'];
		$ticket_uid = $ticket['u_id'];
		
		$objUserTicketLog = new UserTicketLog($ticket_uid);
		$condition_this = array();
		$condition_this['ticket_id'] 		= $ticketId;
		$condition_this['u_id'] 			= $ticket_uid;
		$condition_this['print_state'] 		= UserTicketAll::TICKET_STATE_NOT_LOTTERY;
		$condition_this['company_id'] 		= TicketCompany::COMPANY_HUAYANG;
		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, 500, $order);//所有系统票
		
		if (empty($order_tickets)) {
			//未找到当前系统票
			continue;
		}
		
		//是否所有的系统票均成功
		$OrderTicketSuccessNum = 0;//成功出票个数
		foreach ($order_tickets as $order_ticket) {
			
			$ID = getUniqueOrderId();//代理发起投注时产生的流水号20位
			//组装出票数据
			$sport 		= $order_ticket['sport'];//彩种
			$pool 		= $order_ticket['pool'];//玩法
			$select 	= $order_ticket['select'];//串关方式
			
			$lotteryid = getLotteryIdByPoolHY($sport, $pool);//玩法代码
			$childtype = getChildtypeBySelectHY($sport, $select);//子玩法代码
			$saletype = 0;//销售方式
			$lottery = combinationToLotterycode($sport, $pool, $order_ticket['combination']);//投注号码
			$issue = 20000;//期号固定
			$appnumbers = $order_ticket['multiple'];//倍数
			$lotterynumber = 1;//注数
			$lotteryvalue = $order_ticket['money'] * 100;//投注金额，单位：分
			
			$data = array();
			$element = array();
			$element['username'] 		= $username;
			$element['ticketuser'] 		= $ticketuser;
			$element['identify'] 		= $identify;
			$element['phone'] 			= $phone;
			$element['email'] 			= $email;
			$element['id']				= $ID;
			$element['lotteryid'] 		= $lotteryid;
			$element['childtype'] 		= $childtype;
			$element['saletype'] 		= $saletype;
			$element['lotterycode'] 	= $lottery['lotterycode'];
			$element['issue'] 			= $issue;
			$element['appnumbers'] 		= $appnumbers;
			$element['lotterynumber'] 	= $lotterynumber;
			$element['lotteryvalue'] 	= $lotteryvalue;
			$element['betlotterymode']	= $lottery['betlotterymode'];
			$data[] = $element;
			
			$header_needle = array('transactiontype'=>$transactiontype);
			$xml = $objHY->formMessage($data, $header_needle);
			
			$objHY->sent($xml);
			$isSendOk = $objHY->isSendOk();
			$resParams = $objHY->getResponseParams();
			
//			//发送情况错误信息
			$errorCode = $objHY->getErrorCode();
			$errorMessage = $objHY->getErrorMessage();
//			//出错代码集合
			$errorCodeDesc = HuaYangTicketClient::getErrorCodeDesc();
//			
			if (!$isSendOk) {
				
				//出现如下情况并不意味着出票失败，这是发送过程中出现问题导致
				if (array_key_exists($errorCode, $errorCodeDesc)) {
					//发送失败
					$word = '用户票:'.$ticketId.';系统票ID:'.$order_ticket['id'].'投注流水发送失败，errorCode:'.$errorCode.';errorMsg'.$errorMessage;
					log_result_error($word);
					continue;
				}
				
				//发送失败
				$word = '用户票:'.$ticketId.';系统票ID:'.$order_ticket['id'].'投注流水发送失败，errorCode:'.$errorCode.';errorMsg'.$errorMessage.';HYparams:'.var_export($resParams, true);
				$word .= 'ZYparams:'.var_export($data, true);
				log_result_error($word);
				
				$order_ticket['return_str'] 	= $errorMessage;
				$order_ticket['print_state'] 	= UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED;
				$order_ticket['print_time']		= getCurrentDate();
				$tmpResult = $objUserTicketLog->modify($order_ticket);
				if (!$tmpResult->isSuccess()) {
					$word = '用户票:'.$ticketId.';系统票ID:'.$order_ticket['id'].'更新系统票状态为投注失败-失败，原因:'.$tmpResult->getData();
					log_result_error($word);
				}
				
				continue;
			}
			//发送成功才能分析出数组
			$resInfo = $objHY->getResponseArray();
			
			$word = $ID.'--系统票投注流水发送成功，u_id:'.$ticket_uid.';HYparams:'.var_export($resInfo, true);
			$word .= 'ZYparams:'.var_export($data, true);
			log_result($word, 'touzhu_send_success');
			
			$res_element = $resInfo['body']['elements']['element'];
			//其他原因投注失败
			if ($res_element['errorcode'] != 0) {
				
				$word = '用户票ID:' . $ticket['id'] . '系统票ID:' . $order_ticket['id'] . '投注失败，原因：' . $res_element['errorcode'].':'.$res_element['errormsg'];
				log_result_error($word);
				
				//发送失败，票号重复；此时需要重新出一次，概率很小，但依然存在
				if ($res_element['errorcode'] == 10032) {
					continue;
				}
				
				$order_ticket['return_id'] 		= $ID;//
				$order_ticket['return_str'] 	= 'errorcode:'.$res_element['errorcode'].';errormsg:'.$res_element['errormsg'];
				$order_ticket['print_state'] 	= UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED;
				$order_ticket['print_time']		= getCurrentDate();
				$tmpResult = $objUserTicketLog->modify($order_ticket);
				if (!$tmpResult->isSuccess()) {
					$word = '用户票:'.$ticketId.';系统票ID:'.$order_ticket['id'].'更新系统票状态为投注失败-失败，原因:'.$tmpResult->getData();
					log_result_error($word);
				}
				continue;
			}
			
			//至此为投注成功
			$OrderTicketSuccessNum++;
			
			//记录当前的流水,用此id来查询是否出票和中奖
			//更改系统票状态为出票中
			$order_ticket['return_id'] 		= $ID;
			$order_ticket['print_state'] 	= UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU;
			$order_ticket['print_time']		= getCurrentDate();
			$tmpResult = $objUserTicketLog->modify($order_ticket);
			if (!$tmpResult->isSuccess()) {
				$word = '用户票ID:' . $ticket['id'] . '系统票ID:'.$order_ticket['id'].'流水投注流水保存失败，原因：'.$tmpResult->getData();
				$word .= ';ID:'.$ID;
				log_result_error($word);
			}
			//到此表明发送成功，更新系统票成功
		}
	}
	$offset += $step;
}while (true);

	$objSingleProcess->active();

	usleep(500000);
} while (true);

$objSingleProcess->complete();
exit;
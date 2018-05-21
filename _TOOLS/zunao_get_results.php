<?php
/**
 * 尊傲出票之获取赛果
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

echo getCurrentDate().' start get resluts';
enter_newline();

$objBDIssueInfos = new BDIssueInfos();
$objZunAoTicketClient = new ZunAoTicketClient();
$objPoolResultBD = new PoolResultBD();
$transcode = ZunAoTicketClient::TRANSCODE_QUERY_GAMES_RESULT;

//只需查询最新一期赛果
$lottery_codes = ZunAoTicketClient::getAllLottery();
foreach ($lottery_codes as $lotteryId) {

// 	echo 'now is getting '.$lotteryId.' game results please waiting...';
// 	enter_newline(1);

	$head = array('transcode'	=> $transcode);
	
	$condition = $issueInfo = array();
	$condition['lotteryId'] = $lotteryId;
	//取两期赛果，如果只找最新一期，会出现前一期赛果未获取到的情况
	$issueInfos = $objBDIssueInfos->getsByCondition($condition, 2, 'id desc');
	if (!$issueInfos) {
		continue;
	}
	
	foreach ($issueInfos as $issueInfo) {
		$issueNumber = $issueInfo['issueNumber'];
		if (!$issueNumber) {
			// 		echo $lotteryId.' issueNumber not find continue...';
			continue;
		}
		$body = array('issueNumber' => $issueNumber, 'lotteryId'=>$lotteryId);
		$xml = $objZunAoTicketClient->formXml($head, $body);
		$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);
		if (!$isSendOk) {
			$word = 'send is not ok';
			log_result_error($word);
		} else {
			//发送成功，检验是否有错误
			$tmpResult = $objZunAoTicketClient->analysisRes();
			if (!$tmpResult) {
				//有错误出现
				$error_code = $objZunAoTicketClient->getErrorCode();
				if ($error_code != 924) {//停售的不用记录日志了
					$word = $lotteryId.'error!!!:'.$objZunAoTicketClient->getErrorCode() .' continue to next lottertId';
					log_result_error($word);
				}
				continue;
			}
			$resArray = $objZunAoTicketClient->getResponseArray();
	// 		pr($resArray);
			if (!isset($resArray['msg']['index']['RESULT'])) {
				$word = $lotteryId.' RESULT not exist continue to next lottertId';
	// 			log_result_error($word);
				continue;
			}
			$resultInfoIndexs = $resArray['msg']['index']['RESULT'];//期号索引
	
			foreach ($resultInfoIndexs as $value) {
				$info = array();
				$info = $resArray['msg']['vals'][$value]['attributes'];
				//[MATCHID] => 77
	            //[VALUE] => 0,2,2,2
	            //[SP] => 3.875568,5.648596,4.991521,12.956757,24.691717
				foreach ($info as $key=>$value) {
					$key = strtolower($key);
					$info[$key] = $value;
				}
				$info['datetime'] = getCurrentDate();
				$info['issueNumber'] = $issueNumber;
				$info['lotteryId'] = $lotteryId;
				
				//赛果
				$combination = PoolResultBD::getCombinationByValue($lotteryId, $info['value']);
				$info['combination_game'] = $combination;
				//彩果值，非让球时跟赛果一致，让球时需要计算让球数
				$info['combination'] = $combination;
				
				if ($lotteryId == ZunAoTicketClient::LOTTERY_CODE_SPF) {
					//获取让球数;自行计算彩果
					$objBettingBD = new BettingBD();
					$condition = array();
					$condition['lotteryId'] = $lotteryId;
					$condition['matchid'] = $info['matchid'];
					$condition['issueNumber'] = $issueNumber;
					$bettingInfos = $objBettingBD->getsByCondition($condition,1);
					if ($bettingInfos) {
						$bettingInfo = array_pop($bettingInfos);
						$remark = $bettingInfo['remark'];
						$info['remark'] = $remark;
						$info['combination'] = PoolResultBD::getCombinationByValue($lotteryId, $info['value'], $remark);
					}
				}
				
				//添加一个赛果
				$cond = array();
				$cond['issueNumber'] 	= $issueNumber;
				$cond['matchid'] 		= $info['matchid'];
				$cond['lotteryId'] 		= $lotteryId;
				$resultInfos = $objPoolResultBD->getsByCondition($cond, 1);
				if ($resultInfos) {
					//有赛果就不需要更新了
					continue;
				} else {
					$tmpResult = $objPoolResultBD->add($info);
					if (!$tmpResult) {
						$word = 'add wrong';
						log_result_error($word);
					}
				}
			}
		}
	}
}

echo  getCurrentDate().' success';
enter_newline();
exit;
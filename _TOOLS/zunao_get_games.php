<?php
/**
 * 尊傲出票之获取赛事信息
 * 1、北单信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

echo getCurrentDate().' start get games';
enter_newline();

$lottery_codes = ZunAoTicketClient::getAllLottery();
foreach ($lottery_codes as $lotteryId) {
	$transcode = ZunAoTicketClient::TRANSCODE_QUERY_GAMES_BEIDAN;
	$objZunAoTicketClient = new ZunAoTicketClient();
	$head = array('transcode' => $transcode);
	
	//取最新的issueNumber
	$objBDIssueInfos = new BDIssueInfos();
	$condition = array();	
	$condition['lotteryId']= $lotteryId;
	$condition['status'] = BDIssueInfos::STATUS_SELLING;
	$issueInfos = $objBDIssueInfos->getsByCondition($condition, 1, 'id desc');
	if (!$issueInfos) {
		$word = 'selling issueInfos not exist lotteryId:'.$lotteryId;
		log_result_error($word);
		continue;
	}
	
	$issueInfo = array_pop($issueInfos);
	$issueNumber = $issueInfo['issueNumber'];
	if (!$issueNumber) {
		$word = 'selling issueNumber not exist lotteryId:'.$lotteryId;
		log_result_error($word);
		continue;
	}
	
	$body = array('issueNumber' => $issueNumber,'lotteryId'=>$lotteryId);
	$xml = $objZunAoTicketClient->formXml($head, $body);
	$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);
	if (!$isSendOk) {
		$word = 'send is not ok';
		log_result_error($word);
		continue;
	} else {
		//发送成功，检验是否有错误
		$tmpResult = $objZunAoTicketClient->analysisRes();
		if (!$tmpResult) {
			$error_code = $objZunAoTicketClient->getErrorCode();
			//有错误出现
			$word = $lotteryId.'--error_code:'. $error_code  .';error_msg:'.$objZunAoTicketClient->getErrorMsg().'continue to next lottertId';
			if ($error_code != 924) {//停售异常不需要记录日志
				log_result_error($word);
			}
			continue;
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
		//pr($resArray);
		if (!isset($resArray['msg']['index']['GAME'])) {
			$word = $lotteryId.' games not exist continue to next lottertId';
			log_result_error($word);
			continue;
		}
		$gamesIndexs = $resArray['msg']['index']['GAME'];//game索引
		$objBettingBD = new BettingBD();
	
		foreach ($gamesIndexs as $value) {
			$info = array();
			$info = $resArray['msg']['vals'][$value]['attributes'];
			foreach ($info as $key=>$value) {
					
				$key = strtolower($key);
				//需要处理的字段，两个时间戳
				if ($key == 'matchtime' || $key == 'sellouttime') {
					$value = BettingBD::tranTimeTo14($value);
					//时间格式：YYYY-MM-dd HH:ii:ss
				}
				$info[$key] = $value;
			}
			$info['issueNumber'] = $issueNumber;
			$info['lotteryId'] = $lotteryId;
			$info['date'] = substr($info['matchtime'], 0, 10);
			$info['time'] = substr($info['matchtime'], 11);
			$info['num'] = date('N',strtotime($info['matchtime'])).$info['matchid'];
			//获取联赛颜色
			$info['l_color'] = getLColor($info['name']);
			$info = changeBDName($info);
			
			//存在的比赛更新，不存在的比赛添加
			$matchid = $info['matchid'];
			
			$condition  = array();
			$condition['matchid'] = $matchid;
			$condition['issueNumber'] = $issueNumber;
			$condition['lotteryId'] = $lotteryId;
			//取一场即可
			$matchInfo = $objBettingBD->getsByCondition($condition, 1);
			if ($matchInfo) {
				$matchInfo = array_pop($matchInfo);
				$tmpResult = $objBettingBD->modify($info, array('id'=>$matchInfo['id']));
				if (!$tmpResult->isSuccess()) {
					$word = 'modify error';
					log_result_error($word);
				}
			} else {
				$tmpResult = $objBettingBD->add($info);
				if (!$tmpResult) {
					$word = 'add error';
					log_result_error($word);
				}
			}
		}
	}
}
echo getCurrentDate().'success';
enter_newline();
exit;
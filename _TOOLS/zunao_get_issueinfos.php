<?php
/**
 * 尊傲出票之获取赛事期数信息
 * 1、查找当前期
 * 2、更新往期
 * 3、每天执行一次即可
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

echo getCurrentDate().' start get issueinfo';
enter_newline();

$objBDIssueInfos = new BDIssueInfos();
$objZunAoTicketClient = new ZunAoTicketClient();
$transcode = ZunAoTicketClient::TRANSCODE_QUERY_ISSUE;

//查找当前期信息
$lottery_codes = ZunAoTicketClient::getAllLottery();
foreach ($lottery_codes as $lotteryId) {
	
// 	echo 'now is getting '.$lotteryId.' issueinfo please waiting...';
// 	enter_newline(1);
	
	$head = array('transcode'	=> $transcode);
	$issueNumber = '';//表示当前期
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
// 		print_r($resArray);
		if (!isset($resArray['msg']['index']['ISSUEINFO'])) {
			$word = $lotteryId.' ISSUEINFO not exist continue to next lottertId';
			log_result_error($word);
			continue;
		}
		$issueInfoIndexs = $resArray['msg']['index']['ISSUEINFO'];//期号索引
	
		foreach ($issueInfoIndexs as $index) {
			$info = array();
			$info = $resArray['msg']['vals'][$index]['attributes'];
			if (!$info) {
// 				echo $lotteryId.' attributes not exist continue to next Indexs';
// 				enter_newline();
// 				continue;
			}
			foreach ($info as $key=>$value) {
				$info[strtolower($key)] = $value;
				//改下这个key
				if ($key == 'ISSUENUMBER') $info['issueNumber'] = $value;
			}
			$info['lotteryId'] = $lotteryId;
			//存在的比赛更新，不存在的比赛添加
			$condition  = array();
			$condition['issueNumber'] = $info['issueNumber'];
			$condition['lotteryId'] = $lotteryId;
			//取一场即可
			$matchInfo = $objBDIssueInfos->getsByCondition($condition, 1);
			if ($matchInfo) {
				$matchInfo = array_pop($matchInfo);
				$tmpResult = $objBDIssueInfos->modify($info, array('id'=>$matchInfo['id']));
				if (!$tmpResult->isSuccess()) {
					$word = 'modify error:'.$tmpResult->getData();
					log_result_error($word);
				}
			} else {
				$tmpResult = $objBDIssueInfos->add($info);
				if (!$tmpResult) {
					$word = 'add error';
					log_result_error($word);
				}
			}
		}
	}
}

// echo 'current issueinfo success';
// enter_newline(1);

//查询往期信息
$condition = array();
$condition['status'] = array(BDIssueInfos::STATUS_NOT_SELLING, BDIssueInfos::STATUS_SELLING);
$BDIssueInfos = $objBDIssueInfos->getsByCondition($condition, null, 'id asc');
foreach ($BDIssueInfos as $v) {
	
// 	echo 'now is update '.$lotteryId.' issueinfo please waiting...';
// 	enter_newline(1);
	
	$issueNumber = $v['issueNumber'];
	$lotteryId = $v['lotteryId'];
	$head = array('transcode'	=> $transcode);
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
			//有错误出现
			$word = $lotteryId.'--error_code:'.$objZunAoTicketClient->getErrorCode() .';error_msg:'.$objZunAoTicketClient->getErrorMsg().'continue to next';
			log_result_error($word);
			continue;
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
		// 	pr($resArray);
		if (!isset($resArray['msg']['index']['ISSUEINFO'])) {
			$word = $lotteryId.' ISSUEINFO not exist continue to next';
			log_result_error($word);
			continue;
		}
		$issueInfoIndexs = $resArray['msg']['index']['ISSUEINFO'];//期号索引
	
		foreach ($issueInfoIndexs as $index) {
			$info = array();
			$info = $resArray['msg']['vals'][$index]['attributes'];
			foreach ($info as $key=>$value) {
				$info[strtolower($key)] = $value;//实际上只更新期状态
			}
			//更新期数信息
			$tmpResult = $objBDIssueInfos->modify($info, array('id'=>$v['id']));
			if (!$tmpResult->isSuccess()) {
				$word = $lotteryId.' ISSUEINFO update fail continue to next, reason:'.$tmpResult->getData();
				log_result_error($word);
				continue;
			}
		}
	}
}
echo getCurrentDate().' success';
enter_newline();
exit;
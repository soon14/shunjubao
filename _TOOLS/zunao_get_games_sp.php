<?php
/**
 * 尊傲出票之获取赛事sp信息
 * 1、即时配率存储到HIS表
 * 2、最终配率单独存放
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

echo getCurrentDate().' start get games sp';
enter_newline();

$lottery_codes = ZunAoTicketClient::getAllLottery();
$transcode = ZunAoTicketClient::TRANSCODE_QUERY_SP_BEIDAN;
$objZunAoTicketClient = new ZunAoTicketClient();
$objBDIssueInfos = new BDIssueInfos();

foreach ($lottery_codes as $lotteryId) {
	
	$head = array('transcode'	=> $transcode);
	
	$condition = array();	
	$condition['lotteryId']= $lotteryId;
	$issueInfos = $objBDIssueInfos->getsByCondition($condition, 1, 'id desc');
	if (!$issueInfos) {
		echo_exit('issueInfos not exist');
	}
	$issueInfo = array_pop($issueInfos);
	$issueNumber = $issueInfo['issueNumber'];
	
	if (!$issueNumber) {
		echo_exit('issueNumber not exist');
	}
	
	$body = array('issueNumber' => $issueNumber,'lotteryId' => $lotteryId);
	
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
			$word = $lotteryId.'--error_code:'. $error_code  .';error_msg:'.$objZunAoTicketClient->getErrorMsg();
			if ($error_code != 924) {//停售异常不需要记录日志
				log_result_error($word);
			}
			continue;
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
// 		pr($resArray);
		if (!isset($resArray['msg']['index']['SPINFO'])) {
			$word = 'SPINFO not exist lotteryId:'.$lotteryId.' issueNumber:'.$issueNumber;
// 			log_result_error($word);
			continue;
		}
		
		$spInfoIndexs = $resArray['msg']['index']['SPINFO'];//sp索引
		
		$objOddsBD_HIS = new OddsBD($lotteryId, true);
		$fields = $objOddsBD_HIS->getSPFields();//sp值在数据库中的字段
		foreach ($spInfoIndexs as $v) {
			$info = array();
			$attributes = $resArray['msg']['vals'][$v]['attributes'];
			if (!$attributes) {
				$word = 'attributes not exist continue next index';
				log_result_error($word);
				continue;
			}
			foreach ($attributes as $key=>$value) {
					
				$key = strtolower($key);
				//需要处理的字段，两个时间戳
				if ($key == 'matchtime') {
					$value = BettingBD::tranTimeTo14($value);
					//时间格式：YYYY-MM-dd HH:ii:ss
				}
				$info[$key] = $value;
				$spInfos = array();
				if ($key == 'sp') {
					$spInfos = explode(',', $value);//sp值的排列顺序必须跟fields一致
					foreach ($spInfos as $k=>$v) {
						if ($v == 0) {
							$v = '';
						}
						$info[$fields[$k]] = $v;
					}
				} 
			}
			$info['issueNumber'] = $issueNumber;
			$info['date'] = substr($info['matchtime'], 0, 10);
			$info['time'] = substr($info['matchtime'], 11);
			//冗余m_num，星期数+matchid
			$info['m_num'] = date('N', strtotime($info['matchtime'])).$info['matchid'];
			//冗余信息m_id，方便赛事投注时快捷地找到比赛信息
			$m_id = '';
			$objBettingBD = new BettingBD();
			$condition = array();
			$condition['issueNumber'] = $issueNumber;
			$condition['matchid'] = $info['matchid'];
			$condition['lotteryId'] = $lotteryId;
			$results = $objBettingBD->getsByCondition($condition, 1);
			$matchInfo = array_pop($results);
			$m_id = $matchInfo['id'];
			$info['m_id'] = $m_id;
			
			//需要判断下赔率信息是否变化，做这个判断的目的是：由于数据中没有sp变化的时间，盲目地更新数据只能让数据库迅速膨胀，因此需要人工判断下sp的变化，减少数据量
			$is_sp_change = false;
			
			$objOddsBD = new OddsBD($lotteryId);//更新sp表
			$condition = array();
			$condition['issueNumber'] = $issueNumber;
			$condition['matchid'] = $info['matchid'];
			
			$result = $objOddsBD->getsByCondition($condition, 1 , 'id desc');
			
			if ($result) {//已存在的且赔率值改变的情况下更新
				
				$old_info = array_pop($result);
				
				foreach ($fields as $field) {
					if ($info[$field] != $old_info[$field]) {
						$is_sp_change = true;//赔率有变化
						break;
					}
				}
				
				if ($is_sp_change) {
					$tmpResult = $objOddsBD->modify($info, array('id'=>$old_info['id']));
					if (!$tmpResult->isSuccess()) {
						$word = 'modify sp error:'.$tmpResult->getData();
						log_result_error($word);
					}
				}
				
			} else {//不存在的添加
				$tmpResult = $objOddsBD->add($info);
				if (!$tmpResult) {
					$word = 'add sp error';
					log_result_error($word);
				}
				$is_sp_change = true;//表示赔率从无到有，也是有变化的
			}
			
			if ($is_sp_change) {
				$objOddsBD_HIS = new OddsBD($lotteryId, true);//更新HIS类表
				$tmpResult = $objOddsBD_HIS->add($info);
				if (!$tmpResult) {
					$word = 'add sp_HIS error';
					log_result_error($word);
				}
			}
			
		}
	}
}
echo getCurrentDate().' success';
enter_newline();
exit;

<?php
/**
 * bd_get_game_sp.php
 * 更新北单赛程
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
		Role::GAME_MANAGER,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$lotteryId = Request::r('lotteryId');
$issueNumber = Request::r('issueNumber');

$objBDIssueInfos = new BDIssueInfos();
if (!$issueNumber) {
	$condition = array();
	$condition['lotteryId']= $lotteryId;
	$condition['status'] = BDIssueInfos::STATUS_SELLING;
	$issueInfos = $objBDIssueInfos->getsByCondition($condition, 1, 'id desc');
	if (!$issueInfos) {
		$word = '参数错误';
		fail_exit($word);
	}
	$issueInfo = array_pop($issueInfos);
	$issueNumber = $issueInfo['issueNumber'];//表示当前期
} else {
	$condition = array();
	$condition['lotteryId']= $lotteryId;
	$condition['issueNumber'] = $issueNumber;
	$issueInfos = $objBDIssueInfos->getsByCondition($condition, 1);
	if (!$issueInfos) {
		$word = '参数错误';
		fail_exit($word);
	}
}

$transcode = ZunAoTicketClient::TRANSCODE_QUERY_SP_BEIDAN;
$objZunAoTicketClient = new ZunAoTicketClient();

	$head = array('transcode'	=> $transcode);
	$body = array('issueNumber' => $issueNumber,'lotteryId' => $lotteryId);

	$xml = $objZunAoTicketClient->formXml($head, $body);
	$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);

	if (!$isSendOk) {
		$word = 'send is not ok';
		fail_exit($word);
	} else {
		//发送成功，检验是否有错误
		$tmpResult = $objZunAoTicketClient->analysisRes();
		if (!$tmpResult) {
			//有错误出现
			$word = $lotteryId.'--error_code:'.$objZunAoTicketClient->getErrorCode() .';error_msg:'.$objZunAoTicketClient->getErrorMsg();
			fail_exit($word);
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
		// 		pr($resArray);
		if (!isset($resArray['msg']['index']['SPINFO'])) {
			$word = 'SPINFO not exist lotteryId:'.$lotteryId.' issueNumber:'.$issueNumber;
			fail_exit($word);
		}

		$spInfoIndexs = $resArray['msg']['index']['SPINFO'];//sp索引

		$objOddsBD_HIS = new OddsBD($lotteryId, true);
		$fields = $objOddsBD_HIS->getSPFields();//sp值在数据库中的字段
		foreach ($spInfoIndexs as $v) {
			$info = array();
			$attributes = $resArray['msg']['vals'][$v]['attributes'];
			if (!$attributes) {
				$word = 'attributes not exist continue next index';
				fail_exit($word);
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
						fail_exit($word);
					}
				}

			} else {//不存在的添加
				$tmpResult = $objOddsBD->add($info);
				if (!$tmpResult) {
					$word = 'add sp error';
					fail_exit($word);
				}
				$is_sp_change = true;//表示赔率从无到有，也是有变化的
			}
				
			if ($is_sp_change) {
				$objOddsBD_HIS = new OddsBD($lotteryId, true);//更新HIS类表
				$tmpResult = $objOddsBD_HIS->add($info);
				if (!$tmpResult) {
					$word = 'add sp_HIS error';
					fail_exit($word);
				}
			}
				
		}
	}
success_exit();
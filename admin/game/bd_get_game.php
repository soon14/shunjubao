<?php
/**
 * bd_get_game.php
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

	$transcode = ZunAoTicketClient::TRANSCODE_QUERY_GAMES_BEIDAN;
	$objZunAoTicketClient = new ZunAoTicketClient();
	$head = array('transcode' => $transcode);
	$body = array('issueNumber' => $issueNumber,'lotteryId'=>$lotteryId);
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
			$word = $lotteryId.'--error_code:'.$objZunAoTicketClient->getErrorCode() .';error_msg:'.$objZunAoTicketClient->getErrorMsg().'continue to next lottertId';
			fail_exit($word);
		}
		$resArray = $objZunAoTicketClient->getResponseArray();
		//pr($resArray);
		if (!isset($resArray['msg']['index']['GAME'])) {
			$word = $lotteryId.' games not exist continue to next lottertId';
			fail_exit($word);
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
					fail_exit($word);
				}
			} else {
				$tmpResult = $objBettingBD->add($info);
				if (!$tmpResult) {
					$word = 'add error';
					fail_exit($word);
				}
			}
		}
	}
success_exit();
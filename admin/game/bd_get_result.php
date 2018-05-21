<?php
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

$objZunAoTicketClient = new ZunAoTicketClient();
$objPoolResultBD = new PoolResultBD();
$transcode = ZunAoTicketClient::TRANSCODE_QUERY_GAMES_RESULT;

		$head = array('transcode'	=> $transcode);
		$body = array('issueNumber' => $issueNumber, 'lotteryId'=>$lotteryId);
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
				$word = $lotteryId.'error!!!:'.$objZunAoTicketClient->getErrorCode() .' continue to next lottertId';
				fail_exit($word);
			}
			$resArray = $objZunAoTicketClient->getResponseArray();
			// 		pr($resArray);
			if (!isset($resArray['msg']['index']['RESULT'])) {
				$word = $lotteryId.' RESULT not exist continue to next lottertId';
				fail_exit($word);
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
				$info['combination'] = PoolResultBD::getCombinationByValue($lotteryId, $info['value']);
					
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
						fail_exit($word);
					}
				}
			}
		}
		success_exit();
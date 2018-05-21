<?php
/**
 * 尊傲出票之获取赛事期数信息
 * 查找当前期
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
	$issueNumber =  '';//表示当前期
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
$transcode = ZunAoTicketClient::TRANSCODE_QUERY_ISSUE;

//查找当前期信息
	$head = array('transcode'	=> $transcode);
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
		// 		print_r($resArray);
		if (!isset($resArray['msg']['index']['ISSUEINFO'])) {
			$word = $lotteryId.' ISSUEINFO not exist continue to next lottertId';
			fail_exit($word);
		}
		$issueInfoIndexs = $resArray['msg']['index']['ISSUEINFO'];//期号索引

		foreach ($issueInfoIndexs as $index) {
			$info = array();
			$info = $resArray['msg']['vals'][$index]['attributes'];
			if (!$info) {
				$word = $lotteryId.' attributes not exist continue to next Indexs';
				fail_exit($word);
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
					fail_exit($word);
				}
			} else {
				$tmpResult = $objBDIssueInfos->add($info);
				if (!$tmpResult) {
					$word = 'add error';
					fail_exit($word);
				}
			}
		}
	}
success_exit();
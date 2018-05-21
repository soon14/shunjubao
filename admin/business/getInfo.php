<?php
/**
 * 获取信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}


$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$tpl = new Template();

$info = $_POST;
if ($info['submit']) {
	
	$infoType = $info['type'];
//	$infoType = 'huayang_account';
	switch ($infoType) {
		case 'huayang_account'://查询华阳的账户余额
			$objHuaYangTicketClient = new HuaYangTicketClient();
			$data = array();
			$header = array('transactiontype'=>'13002');
			$xml = $objHuaYangTicketClient->formMessage($data, $header);
			$objHuaYangTicketClient->sent($xml);
			$sumMoney = $objHuaYangTicketClient->getSumMoney();
			if ($sumMoney) {
				$actmoney = $sumMoney['actmoney']/100;
				$bonusmoney = $sumMoney['bonusmoney']/100;
				success_exit('华阳账户投注金余额为:'. $actmoney .'元,奖金账户余额：'.$bonusmoney.'元');
			} else {
				fail_exit('查询失败，原因:'.$objHuaYangTicketClient->getErrorMessage());
			}
			break;
		case 'zunao_account'://查询华阳的账户余额
			$objZunAoTicketClient = new ZunAoTicketClient();
			$transcode = ZunAoTicketClient::TRANSCODE_QUERY_PARTNER_ACCOUNT;
				
			$head = array('transcode' => $transcode);
				$body = array();
				$xml = $objZunAoTicketClient->formXml($head, $body);
				$isSendOk = $objZunAoTicketClient->sent($transcode, $xml);
				
				if (!$isSendOk) {
					fail_exit('查询失败，原因:发送消息失败');
				} 
				$tmpResult = $objZunAoTicketClient->analysisRes();
				if (!$tmpResult) {
					//有错误出现
					fail_exit('查询失败，原因:'.$objZunAoTicketClient->getErrorCode());
				}
				$resArray = $objZunAoTicketClient->getResponseArray();
	// 	 		pr($resArray);
				if (!isset($resArray['msg']['index']['PARTNERACCOUNT'])) {//PRIZERESULT为总览
					fail_exit('查询失败，原因:无返回值index');
				}
				
				$ticketIndex = $resArray['msg']['index']['PARTNERACCOUNT'][0];//索引包含两部分：1、WONTICKET开始;2、WONTICKET结束
				//pr($ticketIndexs);
				$sumMoney = $resArray['msg']['vals'][$ticketIndex]['attributes']['BALANCE'];
				if ($sumMoney) {
					success_exit('尊傲账户投注金余额为:'. $sumMoney .'元');
				} else {
					fail_exit('查询失败，原因:原因:无返回值money');
				}
				break;
		default:
			fail_exit('@');
			break;
	}
}

$tpl->assign('end_time', 1);
echo_exit($tpl->r('../admin/business/getInfo'));
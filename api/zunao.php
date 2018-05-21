<?php
/**
 * 自动接收接口之尊傲
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$params = Request::getRequestParams();

if (!$params) {
	echo_exit('params not exists');
}

//'transcode=107&msg=<?xmlversion=”1.0”encoding=”utf-8”...&key=7dfu38dsf0fdds89fdsafsa78qa7eu8&partnerid=100031'

$transcode = $params['transcode'];
$msg = $params['msg'];
$key = $params['key'];
$partnerid = $params['partnerid'];

//验证消息
$configs = include ROOT_PATH . '/include/ticket_config.php';
$config = $configs['zunao'];

if ($partnerid != $config['partnerid']) {
	echo_exit('partnerid not match');
}

$objZunAoTicketClient = new ZunAoTicketClient();
$this_key = $objZunAoTicketClient->getKey($transcode, $msg);

if ($this_key != $key) {
	echo_exit('key not match');
}

$resArray = $objZunAoTicketClient->xmlToArray($msg);
// pr($resArray);
$body = array();
$head = array('transcode' => $transcode);

$objUserTicketAll = new UserTicketAll();


switch ($transcode) {
	case ZunAoTicketClient::TRANSCODE_AUTO_GET_TRADE:
		
		if (!isset($resArray['msg']['index']['TICKETSRESULT'])) {
			echo_exit('TICKETSRESULT not exist');
		}
		
		$Indexs = $resArray['msg']['index']['TICKETSRESULT'];//game索引
		$returnticketresults = array();
		
		foreach ($Indexs as $value) {
			$info = $returnticketresult = array();
			$info = $resArray['msg']['vals'][$value]['attributes'];
		
			$lotteryId 	= $info['lotteryId'];
			$ticketId	= $info['ticketId'];
			$palmId 	= $info['palmId'];//彩票平台序列号
			$statusCode = $info['statusCode'];//003 : 交易成功;004 : 交易失败
			$message	= $info['message'];
			$printodd	= $info['printodd'];//出票赔率
			$Unprintodd = $info['Unprintodd'];//未做处理赔率
			$maxBonus	= $info['maxBonus'];//最高中奖奖金
			$printNo	= $info['printNo'];//实体编号（出票）
		
			$returnticketresult['lotteryId'] = $lotteryId;
			$returnticketresult['palmId'] = $palmId;
		
			$returnticketresults[] = $returnticketresult;
			$userTicketInfo = $objUserTicketAll->getUserTicetInfoByTicketId($ticketId);
		}
		#TODO处理出票
		
		$body['returnticketresults'] = $returnticketresults;
		
		break;
	case ZunAoTicketClient::TRANSCODE_AUTO_GET_PRIZE:
		if (!isset($resArray['msg']['index']['WONTICKET'])) {
			echo_exit('WONTICKET not exist');
		}
		
		$Indexs = $resArray['msg']['index']['WONTICKET'];//game索引
		$returnwontickets = array();
		
		foreach ($Indexs as $value) {
			$info = $returnwonticket = array();
			$info = $resArray['msg']['vals'][$value]['attributes'];
		
			$lotteryId 	= $info['lotteryId'];
			$ticketId	= $info['ticketId'];
			$palmId 	= $info['palmId'];//彩票平台序列号
			$state 		= $info['state'];//2:已结算
			$message	= $info['message'];
			$pretaxPrice= $info['pretaxPrice'];//税前奖金
			$prize 		= $info['prize'];//投注得到的中奖税后奖金
			$IsAwards	= $info['IsAwards'];//是不是大奖1为大奖 0为小奖
			$gradid		= $info['gradid'];//中奖等级 一等奖；二等奖...
			$awardCount = $info['awardCount'];//该等级中奖注数
			$awardMoney = $info['awardMoney'];//该等级的总中奖金额 税前
			
			$returnwonticket['lotteryId'] = $lotteryId;
			$returnwonticket['palmId'] = $palmId;
		
			$returnwontickets[] = $returnwonticket;
		}
		#TODO处理返奖
		$body['returnwontickets'] = $returnwontickets;
		break;
	default:
		echo_exit('transcode not exist');
}

//发送反馈
$xml = $objZunAoTicketClient->formXml($head, $body);
$objZunAoTicketClient->sent($transcode, $xml);
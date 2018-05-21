<?php
/**
 * 快速投注iframe页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objAdminOperate = new AdminOperate();
$condition['type'] = AdminOperate::TYPE_TOUZHU_INDEX;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$result = $objAdminOperate->getsByCondition($condition, 1);
$result = array_pop($result);
$num = $result['week'].$result['num'];
$pool = $result['pool'];

$all_bd_pool = UserTicketAll::$allBDPoolDesc;
if (in_array($pool, $all_bd_pool)) {
	$sport = UserTicketAll::SPORT_BEIDAN;
}
$all_bk_pool = UserTicketAll::$allBKPoolDesc;
if (in_array($pool, $all_bk_pool)) {
	$sport = UserTicketAll::SPORT_BASKETBALL;
}
$all_fb_pool = UserTicketAll::$allFBPoolDesc;
if (in_array($pool, $all_fb_pool)) {
	$sport = UserTicketAll::SPORT_FOOTBALL;
}

// $sport = Request::r('sport');//彩种
// $pool = Request::r('pool');//玩法
// $matchid = Request::r('matchid');

//默认选择当前期胜平负第一场在售赛事
if (!$sport || !$pool || !$num) {
	$sport = UserTicketAll::SPORT_BEIDAN;
	$pool = UserTicketAll::BD_SPF;
	$num = '11';
}

$return = array();
$return['sport'] = $sport;
$return['pool'] = $pool;

switch ($sport) {
	case UserTicketAll::SPORT_BASKETBALL:case UserTicketAll::SPORT_FOOTBALL:
		
		$objBetting = new Betting($sport);
		$condition = array();
		$condition['num'] = $num;
		$results = $objBetting->getsByCondition($condition, 1,'id desc');
		$matchInfo = array_pop($results);
		$matchInfo['h_cn'] = gb2312toU8($matchInfo['h_cn']);
		$matchInfo['a_cn'] = gb2312toU8($matchInfo['a_cn']);
		$objOdds = new Odds($sport, $pool);
		$condition = array();
		$condition['m_id'] 		= $matchInfo['id'];
		$results = $objOdds->getsByCondition($condition, 1);
		$spInfo = array_pop($results);
		
		$return['matchid'] = $matchInfo['id'];
		$return['matchInfo'] = $matchInfo;
		$return['status'] = $matchInfo['status'];
		$return['spInfo'] = $spInfo;
		$return['prize'] = round(200*$spInfo['h'])/100;
		$return['confirmphp'] = 'confirm.php';
		break;
	case UserTicketAll::SPORT_BEIDAN:
		
		$lotteryId = $pool;
		
		$objBetting = new BettingBD();
		$condition = array();
		$condition['lotteryId'] 	= $lotteryId;
		$condition['num'] 			= $num;
// 		$condition['matchstate'] 	= BettingBD::MATCH_STATE_SELLING;
		$results = $objBetting->getsByCondition($condition, 1,'id desc');
		$matchInfo = array_pop($results);
		$matchInfo['h_cn'] = $matchInfo['hometeam'];
		$matchInfo['a_cn'] = $matchInfo['guestteam'];
		$objOddsBD = new OddsBD($lotteryId);
		$condition = array();
		$condition['matchid'] 		= $matchInfo['matchid'];
		$condition['issueNumber'] 	= $matchInfo['issueNumber'];
		$results = $objOddsBD->getsByCondition($condition, 1);
		$spInfo = array_pop($results);
		
		$return['matchid'] = $matchInfo['id'];
		$return['matchInfo'] = $matchInfo;
		$return['status'] = $matchInfo['matchstate'];
		$return['spInfo'] = $spInfo;
		$return['prize'] = round(200*$spInfo['h']*0.65)/100;
		$return['confirmphp'] = 'confirm_bd.php';
		break;
	default:
		echo_exit('error');
}

$tpl = new Template();
$return['matchInfo']['h_cn'] = mb_substr($return['matchInfo']['h_cn'], 0, 18);
$return['matchInfo']['a_cn'] = mb_substr($return['matchInfo']['a_cn'], 0, 18);
$tpl->assign('return', $return);
echo_exit($tpl->r('quick_ticket_iframe'));
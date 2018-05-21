<?php
/**
 * 获取用户票内的赛事信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userTicketId = Request::r('id');
//$userTicketId = 1;

if (!Verify::int($userTicketId)) {
	ajax_fail_exit('wrong id');
}

// if (!Runtime::isLogin()) {
//	ajax_fail_exit('wrong');
// }

$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfo = $objUserTicketAllFront->get($userTicketId);

if (!$userTicketInfo) {
	ajax_fail_exit('no userTicketInfo');
}

$sport = $userTicketInfo['sport'];

$mids = array();
$return = array();
$matchInfo = array();

$combination = $userTicketInfo['combination'];

$matchs = explode(',', $combination);

foreach($matchs as $k => $v) {
	$match = explode("|", $v);
	$mids[] = $match[1];
}

$company_id = $userTicketInfo['company_id'];
if ($company_id == TicketCompany::COMPANY_MANUAL || $company_id == TicketCompany::COMPANY_ZHIYING) {
	if ($userTicketInfo['sport'] == 'bd') {
		$company_id = TicketCompany::COMPANY_ZUNAO;
	} else {
		$company_id = TicketCompany::COMPANY_HUAYANG;
	}
}

switch ($company_id) {
	//竞彩数据
	case TicketCompany::COMPANY_HUAYANG:
		$objBetting = new Betting($sport);
		$matchInfos = $objBetting->gets($mids);
		
		$objPoolResult = new PoolResult($sport);
		
		$condition = array();
		$condition['m_id'] = $mids;
		$condition['s_code'] = strtoupper($sport);
		$condition['value'] = '';
		$poolResults = $objPoolResult->getsByCondition($condition);//彩果
		
		foreach ($poolResults as $key=>$value) {
			$poolResults[$value['m_id']][strtolower($value['s_code'])][strtolower($value['p_code'])] = $value;
			unset($poolResults[$key]);
		}

		$condition = array();
		$condition['id'] = $mids;
		$condition['s_code'] = strtoupper($sport);
		$condition['status'] = array('Conclude', 'FinalResultIn');
		$objSportResult = new SportResult($sport);
		$sportResults = $objSportResult->getsByCondition($condition);//比分
		
		foreach($matchs as $k => $v) {
			$match = explode("|", $v);//hilo|64338|l#1.75,hdc|64339|h#1.69,hilo|64339|l#1.7
			$mid = $match[1];
			$spool = $match[0];
			$option = explode("&", $match[2]);//h#1.81&a#1.02
			$m_odds = explode('#', $match[2]);
			//赛果值
			$result_combination = $poolResults[$mid][$sport][$match[0]]['combination'];
			
			//赔率
			$cond = $goalline = array();
			$cond['m_id'] = $mid;
			
			$objOdds = new Odds($sport, $spool);
			$oddInfos = $objOdds->getsByCondition($cond);
			foreach ($oddInfos as $odds) {
				if ($match[3]) {//+1.00 -3.50
					//这里的让球数应该获取当时投注时的让球数
					if ($userTicketInfo['id'] >= 21245) {
						$op1 = explode('#', $option[0]);//这场比赛的第一个选项
						$odd = $op1[1];
					//	$goalline_this = getGoallineByOdds($userTicketInfo['odds'], $mid, $odd);
						$goalline_this = $match[3];
					} else {
						$goalline_this = $odds["goalline"];
					}
					$goalline[$mid][$spool] = getShortGoalline($goalline_this);
					//goalline可能会变化：重新获取combination,因为此时的combination可能不是最新的goalline下的数据
					$condition = array();
					$condition['m_id'] = $mid;
					$condition['s_code'] = strtoupper($sport);
					$condition['p_code'] = strtoupper($spool);
					$condition['value'] = '';
					$pRs = $objPoolResult->getsByCondition($condition);
					foreach ($pRs as $pR) {
						$pR_combination = explode(',', $pR['combination']);
						if ($pR_combination[1] == $goalline_this) {
							$result_combination = $pR['combination'];
						}
					}
				}
				//		$goalline[$mid][$spool] = str_replace('0', '', $odds["goalline"]);
			}
			$matchInfo = $matchInfos[$mid];
			
			//var_dump($matchInfo);exit();
			
			$results = $result_combination?getResults($spool, $result_combination):'暂无';
			$this_option = array();
			foreach($option as $k1 => $v1){
				$key = explode("#",$v1);
				$spvalue = $key[1];
				$result_type = '';
				//标红
				$user_option = getChineseByPoolCode($match[0], $key[0]);
				if ($results == $user_option) {
					$result_type = 'red';//中奖
				} else {
					if ($results != '暂无') $result_type = 'black';//未中奖
					else $result_type = 'empty';//暂无赛过
				}
				//比赛取消时的特殊处理
				if ($matchInfo['status'] == Betting::STATUS_CLOSE) {
// 					$result_type = 'red';//中奖
				}

				if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
				$this_option[$result_type][] = $user_option."[{$spvalue}]";
		
			}
		
			
			$score = '暂无';
			if ($sportResults[$mid]['final']) {
				$score = $sportResults[$mid]['final'];
				if ($sport == 'bk') {
					$score_split = explode(':', $score);
					$score = implode(':', array($score_split[1],$score_split[0]));
				}
			}
			
			
			
			//比赛取消时的特殊处理
			if ($matchInfo['status'] == Betting::STATUS_CLOSE) {
 				/*$score = '-:-';
 				$results = '—';*/
			}
			
			if ($matchInfo['status'] == Betting::STATUS_REBACK) {//退款时状态 
 				$score = '无';
 				$results = '无';
				$matchInfo['matchstate']="3";
			}
			
			
			$this_match = array();
			$this_match['id'] 			= $matchInfo['id'];//比赛id
			//$this_match['l_code'] 		= $matchInfo['l_cn'];//联赛id
			
			
			if($matchInfo['date']>='2016-04-10'){
				$this_match['l_code'] 		= $matchInfo['l_cn'];//联赛id
			}else{
				$this_match['l_code'] 		= '';//联赛id
			}
			
			$this_match['date'] 		= $matchInfo['date'];//联赛id
			$this_match['time'] 		= $matchInfo['time'];//联赛id
			$this_match['results'] 		= $results;//赛果
			$this_match['score']		= $score;
			$this_match['prize_state'] 	= $matchInfo['prize_state'];//联赛id
			$this_match['h_cn'] 		= $matchInfo['h_cn'];//主队
			$this_match['a_cn'] 		= $matchInfo['a_cn'];//客队
			$this_match['num'] 			= $matchInfo['num'];//场次
			$this_match['show_num'] 	= show_num($matchInfo['num']);//场次
			$this_match['spool'] 		= getPoolDesc($sport, $match[0]);
			$this_match['pool']			= $match[0];//玩法
			$this_match['multiple'] 	= $userTicketInfo['multiple'];
			$this_match['option'] 		= $this_option;//选项
			$this_match['select'] 		= $userTicketInfo['select'];
			$this_match['user_select'] 	= ConvertData::gb2312ToUtf8($userTicketInfo['user_select']);
			$this_match['sport']		= $userTicketInfo['sport'];
			$this_match['matchstate'] = $matchInfo['matchstate'];
			
		//	var_dump($this_match);exit();
			
			$return[] = $this_match;
		}
		
		break;
	case TicketCompany::COMPANY_ZUNAO:
	//北单数据
		$objBetting = new BettingBD();
		$objPoolResult = new PoolResultBD();
		$matchInfos = $objBetting->gets($mids);
		
		foreach($matchs as $k => $v) {
			
			$match = explode("|", $v);
			$mid = $match[1];
			$spool = $match[0];
			$option = explode("&", $match[2]);
			$m_odds = explode('#', $match[2]);
			
			$matchInfo = $matchInfos[$mid];
			
			//赔率
			$cond = $goalline = array();
			$cond['m_id'] = $mid;
			$lotteryId = $matchInfo['lotteryId'];
			$objOdds = new OddsBD($lotteryId);
			$oddInfos = $objOdds->getsByCondition($cond);
			$remark = $matchInfo["remark"];
			if ($remark != 0) {//+1.00 -3.50
				if ($userTicketInfo['id'] >= 21245) {
					$goalline[$mid][$spool] = getGoallineByOdds($userTicketInfo['odds'], $mid);
				} else {
					$goalline[$mid][$spool] = $remark;
				}
			}
			
			$condition = array();
			$condition['matchid'] = $matchInfo['matchid'];
			$condition['lotteryId'] = $lotteryId;
			$condition['issueNumber'] = $matchInfo['issueNumber'];
			$poolResults = $objPoolResult->getsByCondition($condition);//彩果
			
			$poolResult = array_pop($poolResults);
			$result_combination = $poolResult['combination'];
			$results = $result_combination?getResults($spool, $result_combination):'暂无';
			
			$this_option = array();
			foreach($option as $k1 => $v1){
				$key = explode("#",$v1);
				$spvalue = $key[1];
				$result_type = '';
				//标红
				$user_option = getChineseByPoolCode($match[0], $key[0]);
				if ($results == $user_option) {
					$result_type = 'red';//中奖
				} else {
					if ($results != '暂无') $result_type = 'black';//未中奖
					else $result_type = 'empty';//暂无赛过
				}
				//比赛取消时的特殊处理
				if ($matchInfo['matchstate'] == BettingBD::MATCH_STATE_CANCEL) {
					$result_type = 'red';//中奖
				}
				if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
				$this_option[$result_type][] = $user_option."[{$spvalue}]";
			
			}
			$score = '暂无';
			
			//胜负时的赛果为汉字胜、负，没有比分
			if ($match[0] == ZunAoTicketClient::LOTTERY_CODE_SF) {
				//获取比分;
				$condition = array();
				$condition['matchid'] = $matchInfo['matchid'];
				$condition['issueNumber'] = '1'.$matchInfo['issueNumber'];
				$condition['lotteryId'] = ZunAoTicketClient::LOTTERY_CODE_SPF;
// 				$spfResult = $objPoolResult->getsByCondition($condition, 1);
// 				if ($spfResult) {
// 					$poolResult = array_pop($spfResult);
// 				}
			}
			
			if ($poolResult['value']) {
				$score_split = explode(',', $poolResult['value']);
				$score = $score_split[2].':'.$score_split[3];
			}
			//比赛取消时的特殊处理
			if ($matchInfo['matchstate'] == BettingBD::MATCH_STATE_CANCEL || $matchInfo['matchstate'] == BettingBD::MATCH_STATE_DELAY) {
				$score = '-:-';
				$results = '—';
			}
			$this_match = array();
			$this_match['id'] 			= $matchInfo['id'];//比赛id
			$this_match['date'] 		= $matchInfo['date'];//联赛id
			$this_match['time'] 		= $matchInfo['time'];//联赛id
			$this_match['l_code'] 		= $matchInfo['l_cn']?$matchInfo['l_cn']:'足球';//联赛id
			$this_match['results'] 		= $results;//赛果
			$this_match['score']		= $score;
			$this_match['prize_state'] 	= $matchInfo['prize_state'];//联赛id
			$this_match['h_cn'] 		= $matchInfo['hometeam'];//主队
			$this_match['a_cn'] 		= $matchInfo['guestteam'];//客队
			$this_match['num'] 			= $matchInfo['num'];//场次
			$this_match['show_num'] 	= show_num($matchInfo['num']);//场次
			$this_match['spool'] 		= getPoolDesc($sport, $match[0]);
			$this_match['pool']			= $match[0];//玩法
			$this_match['multiple'] 	= $userTicketInfo['multiple'];
			$this_match['option'] 		= $this_option;//选项
			$this_match['select'] 		= $userTicketInfo['select'];
			$this_match['user_select'] 	= $userTicketInfo['user_select'];
			$this_match['sport']		= $userTicketInfo['sport'];
			$this_match['matchstate'] = $matchInfo['matchstate'];
			$return[] = $this_match;
		}
		break;
	default:
		ajax_fail_exit('company not exist');
}

ajax_success_exit($return);

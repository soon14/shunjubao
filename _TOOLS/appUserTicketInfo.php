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
		
		//var_dump($sportResults);exit();
		
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
			
		
		
			$results = $result_combination?getResults($spool, $result_combination):'暂无';
			$this_option = array();
			
			
		//	var_dump($match[0]);exit();
			$my_option="";
			foreach($option as $k1 => $v1){
				$key = explode("#",$v1);
				$spvalue = $key[1];
				$result_type = '';
				//标红
				$user_option = getChineseByPoolCode($match[0], $key[0]);
				
				if ($results == $user_option) {
					$result_type = '1';//中奖
				} else {
					if ($results != '暂无') $result_type = '0';//中奖
					else $result_type = '-1';//暂无赛过
				}


					//1:1_crs_6.00&2:1_crs_1.50  
				//if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
				///var_dump($spvalue);exit();
				
				if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
				//$this_option[$result_type][] = $user_option."[{$spvalue}]";
				
				
				
				$my_option .= $user_option."_".$match[0]."_".$spvalue."_".$result_type."&";
				

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
			$this_match['my_option'] = substr($my_option,0,-1);
			
			
			
			
		  $lotterycode =$this_match['h_cn']."|".$this_match['a_cn']."|".$this_match['show_num']."|".$this_match['score']."|".$this_match['results']."|".$this_match['my_option'];
		//lotterycode="主队名称|客队名称|周二001|2:1| 1:1|crs|6.00,主队名称|客队名称|周二001|2:1| 1:1|crs|6.00"
			$return[] = $lotterycode;
		}
		
		break;
	
	default:
		ajax_fail_exit('company not exist');
}

//var_dump($return);exit();


echo json_encode($return);exit();



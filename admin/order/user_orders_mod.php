<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
ini_set('memory_limit', '-1');
$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}


$tpl = new Template();

$userTicketId = Request::r('userTicketId');
$showAllUserTicket = false;//后台人员查看某人的用户票功能

if (!$userTicketId) {
	echo_exit('请输入正确ID');
}
$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfo = $objUserTicketAllFront->get($userTicketId);
//var_dump($userTicketInfo);//exit();
if (!$userTicketInfo) {
	echo_exit('请输入正确ID');
}

$action = Request::r('action');
//var_dump($_POST);
if($action=="update"){
	//修改投注记录
	$userTicketId = Request::r('userTicketId');
	$mid = $_POST["mid"];
	
	foreach($mid as $key=>$value){
		 $game_id_array =explode("_",$value);
		$game_id_tmp[] =  $game_id_array[0];
	}
	$repeat_arr = FetchRepeatMemberInArray($game_id_tmp); 

	foreach($mid as $key=>$value){
		
	  $_mid = $value;	
	  $_spool = Request::r($value."_spool");		
	  $_pool = $_POST[$value."_pool"];		  
	  $_sp = Request::r($value."_sp");	
	  $_goalline = Request::r($value."_goalline");	
	  $game_id_array =explode("_",$value);
	  $game_id =  $game_id_array[0];
	  
	  
	  //检查是否同一场比赛选择两种玩法
	  
	  
	  
	  
	  if(empty($_goalline)){//是否有让球
		   $_combination .= $_spool."|".$game_id."|".$_pool."#".$_sp.",";
	  }else{
		  $_combination .= $_spool."|".$game_id."|".$_pool."#".$_sp."|".$_goalline.",";  
	  }
	  
	  $_odds .=$_sp.",";
	  
	}
 echo $_combination;
 die("sdd");


	
	$u_combination =  substr($_combination,0,-1);
	$u_odds =  substr($_odds,0,-1);
	
	//更新数据表
		$objUserTicketAllFront = new UserTicketAllFront();
		$userTicket = $objUserTicketAllFront->get($userTicketId);
		if (!$userTicket) {
				 ajax_fail_exit("userTicket不存在");
			}
		
		//更改用户票状态
		$userTicket['combination'] = $u_combination;
		$userTicket['odds'] = $u_odds;
		
		$tmpResult = $objUserTicketAllFront->modify($userTicket);
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit("更改用户票状态失败，原因：".$tmpResult->getData());
		}

		
		$u_id = $userTicket['u_id'];
		$objUserTicketLog = new UserTicketLog($u_id);
		$cond = array();
		$cond['ticket_id'] = $userTicketId;
		$orderTickets = $objUserTicketLog->getsByCondition($cond);
		if (!$orderTickets) {
			 ajax_fail_exit("orderTicket不存在");
		}
		foreach ($orderTickets as $orderTicket) {
				$orderTicket['combination'] = $u_combination;
				$orderTicket['odds'] = $u_odds;
				$tmpResult2 = $objUserTicketLog->modify($orderTicket);
				
			if (!$tmpResult2->isSuccess()) {
				ajax_fail_exit("修改，原因：".$tmpResult->getData());
			}
		
				
		}
	success_exit('操作成功');
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

$u_id = $userTicketInfo['u_id'];
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);

$tpl->assign('userInfo', $userInfo);

$tpl->assign('userTicketInfo_total', $userTicketInfo);

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
			
			$this_option = "";
			foreach($option as $k1 => $v1){
				
				
				
				$key = explode("#",$v1);
				$spvalue = $key[1];
				$result_type = '';
				//标红
				$user_option = getChineseByPoolCode($match[0], $key[0]);
				
				
				
				if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
				
				$this_option.= $user_option.'<input name="mid[]"  type="hidden" value="'.$mid."_".$key[0].'"><input type="text" name="'.$mid."_".$key[0]."_sp".'" id="'.$mid."_".$key[0]."_sp".'" style="width:40px" value="'.$spvalue.'"><input id="'.$mid."_".$key[0]."_pool".'" name="'.$mid."_".$key[0]."_pool".'" type="hidden" value="'.$key[0].'"><input id="'.$mid."_".$key[0]."_spool".'" name="'.$mid."_".$key[0]."_spool".'"  type="hidden" value="'.$spool.'"><input id="'.$mid."_".$key[0]."_goalline".'" name="'.$mid."_".$key[0]."_goalline".'"  type="hidden" value="'.$goalline[$mid][$match[0]].'">';
		
			}

			
			$this_match = array();
			$this_match['id'] 			= $matchInfo['id'];//比赛id
			//$this_match['l_code'] 		= $matchInfo['l_cn'];//联赛id

			if($matchInfo['date']>='2016-04-10'){
				$this_match['l_code'] 		= $matchInfo['l_cn'];//联赛id
			}else{
				$this_match['l_code'] 		= '';//联赛id
			}
			
			//var_dump($this_option);exit();
			
			
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
			
			//var_dump($this_match);exit();
			
			$return[] = $this_match;
		}
		
		break;
	
	default:
		//ajax_fail_exit('company not exist');
}

$tpl->assign('userTicketId', $userTicketId);
$tpl->assign('userTicketInfo_list', $return);
$YOKA ['output'] = $tpl->r ('../admin/order/user_orders_mod');
echo_exit ( $YOKA ['output'] );


function FetchRepeatMemberInArray($array) { 
    // 获取去掉重复数据的数组 
    $unique_arr = array_unique ( $array ); 
    // 获取重复数据的数组 
    $repeat_arr = array_diff_assoc ( $array, $unique_arr ); 
    return $repeat_arr; 
} 
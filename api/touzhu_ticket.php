<?php
/**
 * 投注接口
 */

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$params = Request::getRequestParams();
/*$s				= $_REQUEST["sport"];
$p				= $_REQUEST["pool"];
$select			= $_REQUEST["select"];
$user_select	= $_REQUEST["user_select"];
$multiple		= $_REQUEST["multiple"];

$money			= $_REQUEST["money"];//投注金额
$c				= $_REQUEST["combination"];//had|55969|d#3.9,hhad|55980|a#2.3&d#2.2
$uid			= Runtime::getUid();
$from 			= $_REQUEST['from'];//页面来源
$partent_id 	= Request::r('partent_id');//是否跟单
$company_id 	= TicketCompany::COMPANY_HUAYANG;//出票公司
$source			= UserMember::getUserSource();//站点来源*/

//$uid = 14777;//红单为王 测试用户
$uid 			= $params['u_id'];
$u_name 		= $params['u_name'];
$s 				= $params['s'];
$p 				= $params['pool'];
$select 		= $params['select'];
$user_select 	= $params['user_select'];
$multiple 		= $params['multiple'];
$money 			= $params['money'];
$c 	= $params['c'];//had|55969|d#3.9,hhad|55980|a#2.3&d#2.2
$from  			= '';
$partent_id  	= '0';////是否跟单
$company_id  	= '0';////
$source  		= '0';////





//=================================投注开始
//投注开关
$objAdminOperate = new AdminOperate();
$condition = array();
$condition['type'] = AdminOperate::TYPE_TOUZHU_LOCK;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$touzhu_lock_results = $objAdminOperate->getsByCondition($condition);
if ($touzhu_lock_results) {
	$touzhu_lock_result = array_pop($touzhu_lock_results);
	$args = array('type' => 'other', 'from' => $from, 'msg' => $touzhu_lock_result['msg']);
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

if(!$uid) {
	$args = array('type' => 'login', 'from' => $from, 'msg' => '');
	$objZYAPI->outPutF($args);
}

//变更出票方
$condition = array();
$condition['type'] = AdminOperate::TYPE_JC_MANUAL;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$touzhu_manul_results = $objAdminOperate->getsByCondition($condition);
if ($touzhu_manul_results) {
	$company_id = TicketCompany::COMPANY_MANUAL;
}

//单关固定暂时关闭
if ($select == '1x1') {
// 	$args = array('type' => 'other', 'from' => $from, 'msg' => '竞彩单关暂时停售');
// 	redirect(jointUrl($url, $args));
}

$datetime = getCurrentDate();



$print_state = UserTicketAll::TICKET_STATE_NOT_LOTTERY;

$is_virtual = false;//是否虚拟投注
$combination_type = UserTicketAll::COMBINATION_TYPE_NOT_OPEN;//跟单类型
//虚拟投注
$virtual_users = array();
$condition = array();
$condition['type'] = AdminOperate::TYPE_VIRTUAL_USERS;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$virtual_users_results = $objAdminOperate->getsByCondition($condition);


foreach ($virtual_users_results as $virtual_users_result) {
	$virtual_users[] = trim($virtual_users_result['u_name']);
}




if (in_array($u_name, $virtual_users)) {
	$is_virtual = true;
	$print_state = UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU;
//	$combination_type = UserTicketAll::COMBINATION_TYPE_OPEN;//逻辑修改：所有人必须自己操作晒单
}

$objUserRealInfoFront = new UserRealInfoFront();
$userRealInfo = $objUserRealInfoFront->get($uid);
if(!$userRealInfo['idcard'] && !$is_virtual){
	$args = array('type' => 'idcard', 'from' => $from, 'msg' => '未进行实名认证');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
	
}
//目前支持竞彩
if($s != "fb" and $s != "bk"){
	$args = array('type' => 'sport', 'from' => $from, 'msg' => '体育类型错误');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

if($money<=0){
	$args = array('type' => 'money', 'from' => $from, 'msg' => '投注金额错误');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

if (!Verify::int($multiple)) {
	$args = array('type' => 'multiple', 'from' => $from, 'msg' => '投注倍数错误');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

if($multiple > TOUZHU_MAX_MULTIPLE){
	$args = array('type' => 'multiple', 'from' => $from, 'msg' => '您的投注倍数大于'.TOUZHU_MAX_MULTIPLE);
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

if(!getPoolDesc($s, $p)){
	$args = array('type' => 'pool', 'from' => $from, 'msg' => '投注玩法错误');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

//今天可以投注的时间
$s_e_time = getSportStartEndTimeArray($s);

if (!$s_e_time) {
	$args = array('type' => 'other', 'from' => $from, 'msg' => '获取赛事开始和结束时间失败');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

$is_in_touzhu_time = false;//是否在可以投注的时间内
foreach ($s_e_time as $time_array) {
	if ($datetime > date('Y-m-d') . ' '. $time_array['start_time'] && $datetime < date('Y-m-d') . ' '. $time_array['end_time']) {
		$is_in_touzhu_time = true;
	}
}

if (!$is_in_touzhu_time) {
	$msg = '当前时间无法投注，抱歉！竞彩足球可出票时间：周一 ～ 周五 9:00-23:52 周六/日 9:00 - 次日00:52。';
	
	if ($s == 'bk') {
		$msg = '当前时间无法投注，抱歉！竞彩篮球可出票时间：周一/二/五 9:00-23:52 周三/四 07:30 - 23:52 周六/日 9:00 - 次日00:52。';
	}

	$args = array('type' => 'start_time', 'from' => $from, 'msg' => $msg);
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

// 验证用户余额
$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($uid);
$user_cash 		= $userAccountInfo['cash'];
$user_rebate 	= $userAccountInfo["rebate"];
$rebate_per 	= $userAccountInfo["rebate_per"];
$user_gift		= $userAccountInfo['gift'];
//余额彩金均不足时
if($user_cash + $user_gift < $money){
	if (!$user_gift || $user_gift < $money) {
		$args = array('type' => 'cash', 'from' => $from, 'msg' => '彩金不足，请充值');
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	} else {
		$args = array('type' => 'cash', 'from' => $from, 'msg' => '余额不足，请充值');
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	}
}

// 验证比赛状态
$objBetting = new Betting($s);





$matchs = explode(',',$c);
$old_time = "";
$odds_str = '';
$first_end_time = '2100-01-01 00:00:00';//用户票的最早比赛的投注截止时间
$new_combination = '';//投注和出票时的赔率不一定一致，会导致返奖不准确问题
$num_array = array();





foreach($matchs as $k => $v){
	$mid = explode("|",$v);//$v:had|55969|d#3.9
	$new_combination .= $mid[0].'|'.$mid[1].'|';//had|55969|
	$bettingInfo = $objBetting->get($mid[1]);
	//计算比赛场次数量
	$num_array[$mid[1]] = $mid[1];
	
	if($bettingInfo){
		if($bettingInfo["status"] != Betting::STATUS_SELLING){
			$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".gb2312toU8($bettingInfo['h_cn'])."VS".gb2312toU8($bettingInfo['a_cn'])." 比赛已开赛");
			$objZYAPI->outPutF($args);
			//redirect(jointUrl($url, $args));
		}
		
		//每场比赛需提前8分钟投注
		$end_up_time = getMatchEndTime_tmp($s, $bettingInfo['b_date'], $bettingInfo['date'], $bettingInfo['time']);
		if($bettingInfo['l_id'] == 72){//世界杯的赛事的投注截止时间为赛前10分钟
			$game_touzhu_end_time = strtotime($bettingInfo["date"] .' ' .$bettingInfo['time']) - 10*60;//世界杯赛事的结束时间为赛前10分钟
			$end_up_time['date'] = date('Y-m-d', $game_touzhu_end_time);
			$end_up_time['time'] = date('H:i:s', $game_touzhu_end_time);//停止投注时间
		}
		if($datetime >= $end_up_time["date"]." ".$end_up_time["time"]){
			$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".gb2312toU8($bettingInfo['h_cn'])."VS".gb2312toU8($bettingInfo['a_cn'])." 比赛投注已截止");
			$objZYAPI->outPutF($args);
			//redirect(jointUrl($url, $args));
		}
		
		// 最后一场比赛开始时间
		$return_time = $bettingInfo["date"]." ".$bettingInfo["time"];
 		if($return_time < $old_time){
			$return_time = $old_time;
		}
		if ($first_end_time > $end_up_time["date"]." ".$end_up_time["time"]) {
			$first_end_time = $end_up_time["date"]." ".$end_up_time["time"];
		}
	} else {
		$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".gb2312toU8($bettingInfo['h_cn'])."VS".gb2312toU8($bettingInfo['a_cn'])." 比赛信息未找到");
		
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	}
	
	// 验证赔率
	$option = explode("&", $mid[2]); //$mid[2]:d#3.9&h#4.5
	$objOdds = new Odds($s, $mid[0]);
	$new_odds = '';
	foreach($option as $k1 => $v1){
		$key = explode("#", $v1);//$v1:d#3.9
 		$oddsInfo = $objOdds->getsByCondition(array('m_id'=>$mid[1]));
 		$oddsInfo = array_pop($oddsInfo);
 		if (!$oddsInfo) {
 			$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".gb2312toU8($bettingInfo['h_cn'])."VS".gb2312toU8($bettingInfo['a_cn'])." 比赛赔率信息未找到");
			$objZYAPI->outPutF($args);
			//redirect(jointUrl($url, $args));
 		}
 		//当前让球数
 		$odds_goalline = $oddsInfo['goalline']; 
		$odds_str .= $oddsInfo[$key[0]] . "&";
		$new_odds .= $key[0] . '#' . $oddsInfo[$key[0]] . '&';
	}
	
	$new_combination .= substr($new_odds, 0 ,-1);//had|55969|d#3.9&a#3.2
	
	//odds里添加让球数
	if ($odds_goalline)  {
		$odds_str = substr($odds_str,0,-1) . "(" .$mid[1]."|".$odds_goalline.")" .",";
		//新版让球数加入到combination里
		$new_combination .= '|'.$odds_goalline;
	} else {
		$odds_str = substr($odds_str,0,-1) . ",";
	}
	$new_combination .= ",";
}

$new_combination = substr($new_combination, 0, -1);
$c = $new_combination;
//var_dump($c);exit();
// 定义串关方式
// 定义可能组合 
$MAX_F[-1] = array("HH","HD","DA","AA");
$MAX_F[+1] = array("HH","DH","AD","AA");

$C = explode(",", $c);
$strs = array();
$match_index = 0;

foreach($C as $k => $v){
	$match=explode("|",$v);
	$M[$match_index]["id"]=$match[1];
	$M[$match_index]["pool"]=$match[0];
	if ($select == '1x1') {
		$p = $match[0];
	}
	if(stripos($match[2],"&")){
		$keys=explode("&",$match[2]);
		$M[$match_index]["key"]["count"]=count($keys);
		foreach($keys as $k1 => $v1){
			$key=explode("#",$v1);
			$M[$match_index]["key"][$k1+1]["value"]=$key[0];
			$M[$match_index]["key"][$k1+1]["odds"]=$key[1];
			$M2[$match[1]][$match[0]][$key[0]]=$key[1];
			if($match[0]=="HHAD"){
				$M2[$match[1]][$match[0]]["goalline"]=$match[3];
			}
		}
	}else{
		$key=explode("#",$match[2]);
		$M[$match_index]["key"]["count"]=1;
		$M[$match_index]["key"][1]["value"]=$key[0];
		$M[$match_index]["key"][1]["odds"]=$key[1];
		$M2[$match[1]][$match[0]][$key[0]]=$key[1];
		if($match[0]=="HHAD"){
			$M2[$match[1]][$match[0]]["goalline"]=$match[3];
		}
	}
	$match_index++;
}

$M = make_c($select,$C);

if((count($M) * $multiple * 2) != $money){
	$args = array('type' => 'other', 'from' => $from, 'msg' => '投注金额错误');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
}

//人工限额逻辑，人工时金额必须大于设定的值
$condition = array();
$condition['type'] = AdminOperate::TYPE_MANUAL_TOUZHU_MONEY_LIMIT;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$touzhu_money_results = $objAdminOperate->getsByCondition($condition);
if ($touzhu_money_results) {
	$touzhu_money_result = array_pop($touzhu_money_results);
	if($money < $touzhu_money_result['limit_money']) {
		$args = array('type' => 'other', 'from' => $from, 'msg' => $touzhu_money_result['msg']);
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	}
}

// 记录投注

$objUserTicketAllFront= new UserTicketAllFront();
$tableInfo = array();
$tableInfo['u_id'] 		= $uid;
$tableInfo['sport'] 	= $s;
$tableInfo['pool'] 		= $p;
$tableInfo['select'] 	= $select;
$tableInfo['multiple'] 	= $multiple;
$tableInfo['money'] 	= $money;
$tableInfo['datetime'] 	= $datetime;
$tableInfo['combination'] = $c;
$tableInfo['odds'] 		= substr($odds_str,0,-1);
$tableInfo['return_time'] = $return_time;
$tableInfo['user_select'] = $user_select;
$tableInfo['num']			= count($num_array);
$tableInfo['print_state'] = $print_state;
$tableInfo['prize'] 		= '0.00';
$tableInfo['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
$tableInfo['endtime'] 		= $first_end_time;//跟单的截止时间
$tableInfo['company_id'] 	= $company_id;
$tableInfo['source']		= $source;
$tableInfo['combination_type'] = $combination_type;
if ($partent_id) {
	$tableInfo['partent_id'] = $partent_id;
	//获取跟单的odds解决让球数错误的bug
//	$partent_ticket = $objUserTicketAllFront->get($partent_id);
//	$tableInfo['odds'] = $partent_ticket['odds'];
}
$ticket_id = $objUserTicketAllFront->add($tableInfo);

if(!$ticket_id){
	$args = array('type' => 'fail', 'from' => $from, 'msg' => '投注失败 请联系客服');
	$objZYAPI->outPutF($args);
	//redirect(jointUrl($url, $args));
	
}

//优先使用彩金
$consumeCash = $money;//需要支付的金额
if ($user_gift>0) {
	if ($user_gift > $consumeCash) {//彩金充足
		$consumeGift = $money;//需要支付的彩金
	} else {//彩金不足
		$consumeGift = $user_gift;//需要支付的彩金
	}
	$consumeCash = $money - $consumeGift;//有彩金时需要支付的金额
	$tmpResult = $objUserAccountFront->consumeGift($uid, $consumeGift);//扣除彩金
	if (!$tmpResult->isSuccess()) {
		$args = array('type' => 'fail', 'from' => $from, 'msg' => '扣除彩金失败');
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	}
	$objUserGiftLogFront = new UserGiftLogFront();
	$tableInfo = array();
	$tableInfo['u_id'] 			= $uid;
	$tableInfo['create_time'] 	= $datetime;
	$tableInfo['gift'] 			= $consumeGift;
	$tableInfo['old_gift'] 		= $user_gift;
	$tableInfo['log_type'] 		= BankrollChangeType::GIFT_CONSUME;
	$tableInfo['record_table'] 	= 'user_ticket_all';
	$tableInfo['record_id'] 	= $ticket_id;
	$ticket_log_id = $objUserGiftLogFront->add($tableInfo);
	if (!$ticket_log_id) {
		$args = array('type' => 'fail', 'from' => $from, 'msg' => '彩金扣除日志记录失败');
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
		
	}
}

$objUserAccountLogFront = new UserAccountLogFront($uid);

if ($consumeCash) {
// 修改余额
	$tmpResult = $objUserAccountFront->consumeCash($uid, $consumeCash);
	if (!$tmpResult->isSuccess()) {
		$args = array('type' => 'fail', 'from' => $from, 'msg' => '修改余额失败');
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	}
	$userAccountInfo = $objUserAccountFront->get($uid);
	// 记录投注流水
	$tableInfo = array();
	$tableInfo['u_id'] 			= $uid;
	$tableInfo['create_time'] 	= $datetime;
	$tableInfo['money'] 		= $consumeCash;
	$tableInfo['old_money'] 	= $userAccountInfo['cash'];
	$tableInfo['log_type'] 		= BankrollChangeType::BUY;
	$tableInfo['record_table'] 	= 'user_ticket_all';
	$tableInfo['record_id'] 	= $ticket_id;
	$ticket_log_id = $objUserAccountLogFront->add($tableInfo);
	
	if (!$ticket_log_id) {
		$args = array('type' => 'fail', 'from' => $from, 'msg' => '记录投注流水失败');
		$objZYAPI->outPutF($args);
		//redirect(jointUrl($url, $args));
	}	
}

	// 记录返点逻辑变更：转移到出票处，出票成功了才给返点
// if($rebate_per > 0){
	
// 	$score = $money * $rebate_per;//返点数量，单位：元
	
// 	$objUserRebateFront = new UserRebateFront();
// 	$tableInfo = array();
// 	$tableInfo['u_id'] 			= $uid;
// 	$tableInfo['create_time'] 	= $datetime;
// 	$tableInfo['u_id']			= $uid;
// 	$tableInfo['rebate_score'] 	= $score;
// 	$tableInfo['percent'] 		= $rebate_per;
// 	$tableInfo['ticket_id'] 	= $ticket_id;
// 	$tableInfo['ticket_money'] 	= $money;
// 	$record_id = $objUserRebateFront->add($tableInfo);
	
// 	if (!$record_id) {
// 		$args = array('type' => 'fail', 'from' => $from, 'msg' => '记录返点失败');
// 		redirect(jointUrl($url, $args));
// 	}

// 	$userAccountInfo = $objUserAccountFront->get($uid);
// 	$tableInfo = array();
// 	$tableInfo['u_id'] 			= $uid;
// 	$tableInfo['create_time'] 	= $datetime;
// 	$tableInfo['money'] 		= $score;
// 	$tableInfo['old_money'] 	= $userAccountInfo['cash'];
// 	$tableInfo['log_type'] 		= BankrollChangeType::REBATE_TO_ACCOUNT;
// 	$tableInfo['record_table'] 	= 'user_rebate';
// 	$tableInfo['record_id'] 	= $record_id;
	
// 	$ticket_log_id = $objUserAccountLogFront->add($tableInfo);
// 	if (!$ticket_log_id) {
// 		$args = array('type' => 'fail', 'from' => $from, 'msg' => '记录返点流水失败');
// 		redirect(jointUrl($url, $args));
// 	}
	
// 	//14-05-19添加：返点自动流入账户
// 	$tmpResult = $objUserAccountFront->addCash($uid, $score);
// 	if (!$tmpResult->isSuccess()) {
// 		$args = array('type' => 'fail', 'from' => $from, 'msg' => '返点自动流入账户失败');
// 		redirect(jointUrl($url, $args));
// 	}
		
// }
//记录系统票
$objUserTicketLog = new UserTicketLog($uid);
$max_multiple = HuaYangTicketClient::MAT_MULTIPLE;
//保证倍数每注最多为99（出票接口限制）
while ($multiple>0) {
	foreach($M as $k => $v){
		
		if ($multiple >= $max_multiple) {
			$this_multiple = $max_multiple;
		} else {
			$this_multiple = $multiple;
		}
		
		$select = explode(",",$v);
		
		$info = array();
		$info['u_id'] 		= $uid;
		$info['sport'] 		= $s;
		$info['pool'] 		= $p;
		$info['select'] 	= count($select) . 'x1';
		$info['multiple'] 	= $this_multiple;
		$info['money'] 		= $this_multiple * 2;
		$info['datetime'] 	= $datetime;
		$info['combination'] = $v;
		$info['return_time'] = $return_time;
		$info['ticket_id'] 	= $ticket_id;
		$info['print_state'] = $print_state;
		$info['prize'] 		= '0.00';
		$info['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
		$info['company_id'] 	= $company_id;
// 		$info['results'] = $goalline;
		$user_ticket_log_id = $objUserTicketLog->add($info);
		if (!$user_ticket_log_id) {
			$args = array('type' => 'fail', 'from' => $from, 'msg' => '记录系统票失败');
			$objZYAPI->outPutF($args);
			//redirect(jointUrl($url, $args));
		}
	}
		$multiple -= $max_multiple;
}

//记录外站来源，统计方式改变为：只统计外站人员带来的注册用户
// $sourceFrom = TMCookie::get(UserMember::OTHER_SITES_FROM_COOKIE_KEY);
// $sourceId = UserMember::verifySiteFrom($sourceFrom);
// if ($sourceId) {
// 	$sourceInfo = array();
// 	$sourceInfo['ticket_id'] 	= $ticket_id;
// 	$sourceInfo['u_id'] 		= $uid;
// 	$sourceInfo['u_name'] 		= Runtime::getUname();
// 	$sourceInfo['source'] 		= $sourceId;
// 	$sourceInfo['money'] 		= $money;
// 	$sourceInfo['create_time'] 	= $datetime;
// 	$objSourceTicket = new SourceTicket();
// 	$objSourceTicket->add($sourceInfo);
// }

$args = array('type' => 'success', 'from' => $from, 'msg' => '投注成功');
$objZYAPI->outPutF($args);

//redirect(jointUrl($url, $args));
 








<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$s				= Request::r("sport");
$p				= Request::r("pool");
$select			= Request::r("select");
$user_select	= Request::r("user_select");
$multiple		= Request::r("multiple");

$money			= Request::r("money");//投注金额
$c				= $_REQUEST["combination"];
$uid			= Runtime::getUid();
$from 			= Request::r('from');//页面来源
$partent_id 	= Request::r('partent_id');//是否跟单
$company_id 	= TicketCompany::COMPANY_ZUNAO;//出票公司
$source			= UserMember::getUserSource();//站点来源

//确认结果提示页
$url = ROOT_DOMAIN . "/confirm/confirm_result.php";

//投注开关
$objAdminOperate = new AdminOperate();
$condition = array();
$condition['type'] = AdminOperate::TYPE_BD_TOUZHU_LOCK;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$touzhu_lock_results = $objAdminOperate->getsByCondition($condition);
if ($touzhu_lock_results) {
	$touzhu_lock_result = array_pop($touzhu_lock_results);
	$args = array('type' => 'other', 'from' => $from, 'msg' => $touzhu_lock_result['msg']);
	redirect(jointUrl($url, $args));
}

if(!$uid) {
	$args = array('type' => 'login', 'from' => $from, 'msg' => '');
	redirect(jointUrl($url, $args));
}

//变更出票方
$condition = array();
$condition['type'] = AdminOperate::TYPE_BD_MANUAL;
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$touzhu_manul_results = $objAdminOperate->getsByCondition($condition);
if ($touzhu_manul_results) {
	$company_id = TicketCompany::COMPANY_MANUAL;
}

$datetime = getCurrentDate();
$print_state = UserTicketAll::TICKET_STATE_NOT_LOTTERY;

$is_virtual = false;//是否虚拟投注
$combination_type = UserTicketAll::COMBINATION_TYPE_NOT_OPEN;//跟单类型
if (isVirtualUser()) {
	$is_virtual = true;
	$print_state = UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU;
	$combination_type = UserTicketAll::COMBINATION_TYPE_OPEN;//跟单人的订单，都默认为公开
}

$objUserRealInfoFront = new UserRealInfoFront();
$userRealInfo = $objUserRealInfoFront->get($uid);
if(!$userRealInfo['idcard'] && !$is_virtual){
	$args = array('type' => 'idcard', 'from' => $from, 'msg' => '未进行实名认证');
	redirect(jointUrl($url, $args));
}
//目前支持竞彩足球和北单
if($s != 'bd'){
	$args = array('type' => 'sport', 'from' => $from, 'msg' => '体育类型错误');
	redirect(jointUrl($url, $args));
}

if($money<=0){
	$args = array('type' => 'money', 'from' => $from, 'msg' => '投注金额错误');
	redirect(jointUrl($url, $args));
}

if (!Verify::int($multiple)) {
	$args = array('type' => 'multiple', 'from' => $from, 'msg' => '投注倍数错误');
	redirect(jointUrl($url, $args));
}

if($multiple > TOUZHU_MAX_MULTIPLE){
	$args = array('type' => 'multiple', 'from' => $from, 'msg' => '您的投注倍数大于'.TOUZHU_MAX_MULTIPLE);
	redirect(jointUrl($url, $args));
}

if(!getPoolDesc($s, $p)){
	$args = array('type' => 'pool', 'from' => $from, 'msg' => '投注玩法错误');
	redirect(jointUrl($url, $args));
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
		redirect(jointUrl($url, $args));
	} else {
		$args = array('type' => 'cash', 'from' => $from, 'msg' => '余额不足，请充值');
		redirect(jointUrl($url, $args));
	}
}

//验证比赛状态
$objBetting = new BettingBD();
$matchs = explode(',',$c);
$old_time = "";
$odds_str = '';
$first_end_time = '2100-01-01 00:00:00';//用户票的最早比赛的投注截止时间
$num_array = array();
foreach($matchs as $k => $v){
	$mid = explode("|",$v);//$v:had|55969|d#3.9
	$bettingInfo = $objBetting->get($mid[1]);
	//计算比赛场次数量
	$num_array[$mid[1]] = $mid[1];
	
	if($bettingInfo){
		if($bettingInfo["matchstate"] != BettingBD::MATCH_STATE_SELLING){
			$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".$bettingInfo['hometeam']."VS".$bettingInfo['guestteam']." 比赛已开赛");
			redirect(jointUrl($url, $args));
		}
		
		//投注截止时间规则：按照赛程停售时间计算
		$sellouttime = $bettingInfo['sellouttime'];
		$st = explode(' ', $sellouttime);
		$end_up_time = array();
		$end_up_time["date"] = $st[0];
		$end_up_time["time"] = $st[1];
		
		if($datetime >= $bettingInfo['sellouttime']){
			$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".$bettingInfo['hometeam']."VS".$bettingInfo['guestteam']." 比赛投注已截止");
			redirect(jointUrl($url, $args));
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
		$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".$bettingInfo['hometeam']."VS".$bettingInfo['guestteam']." 比赛信息未找到");
		redirect(jointUrl($url, $args));
	}
	
	// 验证赔率
	$option = explode("&", $mid[2]); 
	$objOdds = new OddsBD($p);
	
	foreach($option as $k1 => $v1){
		$key = explode("#", $v1);//$v1:d#3.9
		$condition = array();
		$condition['issueNumber'] = $bettingInfo['issueNumber'];
 		$oddsInfos = $objOdds->getsByCondition(array('m_id'=>$mid[1]));
 		if (!$oddsInfos) {
 			$args = array('type' => 'other', 'from' => $from, 'msg' => show_num($bettingInfo["num"])."  ".$bettingInfo['hometeam']."VS".$bettingInfo['guestteam']." 比赛赔率信息未找到");
			redirect(jointUrl($url, $args));
 		}
 		$oddsInfo = array_pop($oddsInfos);
		$odds_str .= $oddsInfo[$key[0]] . "&";
	}
	//odds里添加让球数
	$remark = $bettingInfo['remark'];
	if ($remark)  {
		$odds_str = substr($odds_str,0,-1) . "(" .$mid[1]."|".$remark.")" .",";
	} else {
		$odds_str = substr($odds_str,0,-1) . ",";
	}
} 
$C = explode(",", $c);
$strs = array();
$match_index = 0;

foreach($C as $k => $v){
	$match=explode("|",$v);
	$M[$match_index]["id"]=$match[1];
	$M[$match_index]["pool"]=$match[0]; 
	if(stripos($match[2],"&")){
		$keys = explode("&",$match[2]);
		$M[$match_index]["key"]["count"]=count($keys);
		foreach($keys as $k1 => $v1){
			$key=explode("#",$v1);
			$M[$match_index]["key"][$k1+1]["value"]=$key[0];
			$M[$match_index]["key"][$k1+1]["odds"]=$key[1];
		}
	}else{
		$key=explode("#",$match[2]);
		$M[$match_index]["key"]["count"]=1;
		$M[$match_index]["key"][1]["value"]=$key[0];
		$M[$match_index]["key"][1]["odds"]=$key[1];
	}
	
	$match_index++;
}

/**
 * 按照串关数分别处理
 */
//串关是否大于9
$is_9 = false;
$select_c = explode('|', $select);
$select_array = array();//串关选项集合array(2,3,7,15...)
foreach ($select_c as $sc) {
	$sc_c = explode('x', $sc);
	if ($sc_c[0] > 9 ) {
		$is_9 = true;
	}
	$select_array[] = $sc_c[0];
}

if (!$is_9) {
	$M = make_c($select, $C);
} else {
	$match_index = 0;
	$M = $select_M = array();
	$M2 = array();
	//重组$M2
	foreach($C as $k => $v){
		$match = explode("|", $v);
		if (stripos($match[2],"&")) {
			$keys = explode("&", $match[2]);
			foreach($keys as $k1 => $v1){
				$M2[$match_index][] = $match[0] . '|' . $match[1] . '|' .$v1;
			}
		} else {
			$M2[$match_index][] = $v;
		}
		$match_index++;
	}
	$all_match_keys = array_keys($M2);
	foreach ($select_array as $sa) {
		$res = array();//根据选项获取的串关场次
		combination($all_match_keys, $sa);
		foreach ($res as $sk) {
			$select_M = array();
			$select_keys = explode('|', $sk);//n串1后的$M的key集合
			foreach ($select_keys as $sk1) {
				$select_M[$sk1] = $M2[$sk1];
			}
			$select_M = combinList($select_M);
			foreach ($select_M as & $sm) {
				//去掉末尾的，
				$sm = substr($sm, 0, -1);
			}
			$M = array_merge($M, $select_M);
		}
	}
}

if((count($M) * $multiple * 2) != $money){
	$args = array('type' => 'other', 'from' => $from, 'msg' => '投注金额错误');
	redirect(jointUrl($url, $args));
}
//人工限额逻辑，人工时金额必须大于100
if($company_id == TicketCompany::COMPANY_MANUAL && $money < 50) {
	$args = array('type' => 'other', 'from' => $from, 'msg' => '本时段投注限额，必须大于50元!');
	redirect(jointUrl($url, $args));
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
	$partent_ticket = $objUserTicketAllFront->get($partent_id);
	$tableInfo['odds'] = $partent_ticket['odds'];
}
$ticket_id = $objUserTicketAllFront->add($tableInfo);

if(!$ticket_id){
	$args = array('type' => 'fail', 'from' => $from, 'msg' => '投注失败 请联系客服');
	redirect(jointUrl($url, $args));
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
		redirect(jointUrl($url, $args));
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
		redirect(jointUrl($url, $args));
	}
}

$objUserAccountLogFront = new UserAccountLogFront($uid);

if ($consumeCash) {
// 修改余额
	$tmpResult = $objUserAccountFront->consumeCash($uid, $consumeCash);
	if (!$tmpResult->isSuccess()) {
		$args = array('type' => 'fail', 'from' => $from, 'msg' => '修改余额失败');
		redirect(jointUrl($url, $args));
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
		redirect(jointUrl($url, $args));
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
$max_multiple = ZunAoTicketClient::MAT_MULTIPLE;
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
		$user_ticket_log_id = $objUserTicketLog->add($info);
		if (!$user_ticket_log_id) {
			$args = array('type' => 'fail', 'from' => $from, 'msg' => '记录系统票失败');
			redirect(jointUrl($url, $args));
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
redirect(jointUrl($url, $args));

/**
 * 获取串关方式合集
 * @param array $arr 所有场次
 * @param number $len 选择的场次数
 * @param string $str
 * @return global $res 选择方式按照'|'连接
 */
function combination($arr, $len=0, $str = "") {
	global $res;
	$arr_len = count($arr);
	if($len == 0){
		$res[] = $str;
	}else{
		for($i=0; $i<$arr_len-$len+1; $i++){
			$tmp = array_shift($arr);
			if ($str !== "") combination($arr, $len-1, $str.'|'.$tmp);
			else combination($arr, $len-1, $tmp);
		}
	}
}

/**
 * 计算C(a,1) * C(b, 1) * ... * C(n, 1)的值
 * @param array $CombinList = array(1=>array(选项1，选项2),2=>array()...) 所选场次里所有选项的集合
 * @return Ambigous <multitype:, unknown>
 */
function combinList($CombinList) {
	$result = array();
	$CombineCount = 1;
	foreach($CombinList as $Key => $Value)
	{
		$CombineCount *= count($Value);
	}
	$RepeatTime = $CombineCount;
	foreach($CombinList as $ClassNo => $StudentList)
	{
		// $StudentList中的元素在拆分成组合后纵向出现的最大重复次数
		$RepeatTime = $RepeatTime / count($StudentList);
		$StartPosition = 1;
		// 开始对每个班级的学生进行循环
		foreach($StudentList as $Student)
		{
			$TempStartPosition = $StartPosition;
			$SpaceCount = $CombineCount / count($StudentList) / $RepeatTime;
			for($J = 1; $J <= $SpaceCount; $J ++)
			{
				for($k = 0; $k < $RepeatTime; $k ++)
				{
					$result[$TempStartPosition + $k] .= $Student.',';
				}
				$TempStartPosition += $RepeatTime * count($StudentList);
			}
			$StartPosition += $RepeatTime;
		}
	}
	return $result;
}
?>

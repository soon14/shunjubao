<?php
/**
 * 虚拟比赛投注提交
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$combination	= $_REQUEST["combination"];

$multiple 	= $_REQUEST["multiple"];
$money 		= $_REQUEST["money"];
$from 		= $_REQUEST["from"];
$source		= UserMember::getUserSource();//站点来源

$from?$from:$from = ROOT_DOMAIN;

$u_id 	= Runtime::getUid();
$datetime = getCurrentDate();

//确认结果提示页
$url = ROOT_DOMAIN . "/confirm/confirm_result.php";

if(!$u_id) {
	$args = array('type' => 'login', 'from' => $from, 'msg' => '');
	redirect(jointUrl($url, $args));
}

$objUserRealInfoFront = new UserRealInfoFront();
$userRealInfo = $objUserRealInfoFront->get($u_id);
if(!$userRealInfo['idcard']){
	$args = array('type' => 'idcard', 'from' => $from, 'msg' => '未进行实名认证');
	redirect(jointUrl($url, $args));
}

// 验证用户余额
$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($u_id);
$user_score 		= $userAccountInfo['score'];

//不足时
if($user_score < $money){
	$args = array('type' => 'cash', 'from' => $from, 'msg' => '积分不足');
	redirect(jointUrl($url, $args));
}

//验证比赛状态
$objBettingVirtual = new BettingVirtual();
$match_combination = analyseCombination($combination);
$total_options_sum = 0;//用户选项个数
$score_base = 2;//每一注的投注积分
$odds_str = '';//4.40&1.05,1.70&1.70(63461|-9.50),1.77&1.63(63461|+160.50),1.42
foreach($match_combination as $k => $v){
	$bettingInfo = $objBettingVirtual->get($k);
	
	if (!$bettingInfo) {
		$args = array('type' => 'other', 'from' => $from, 'msg' => '比赛信息未找到');
		redirect(jointUrl($url, $args));
	}
	
	if($bettingInfo['start_time']<$datetime) {
		$args = array('type' => 'other', 'from' => $from, 'msg' => '比赛已经开始');
		redirect(jointUrl($url, $args));
	}
	
	$total_options_sum += count($v);
	
	$odds_str .= implode('&', $v);
	if ($bettingInfo['remark']) {
		$odds_str .= '('.$k.'|'.$bettingInfo['remark'].')';
	}
	$odds_str .= ','; 
}

//验证投注积分
if ($money != $score_base * $total_options_sum * $multiple) {
	$args = array('type' => 'other', 'from' => $from, 'msg' => '投注金额错误');
	redirect(jointUrl($url, $args));
}

// 记录投注
$objVirtualTicket= new VirtualTicket();
$tableInfo = array();
$tableInfo['u_id'] 		= $u_id;
$tableInfo['u_name'] 	= Runtime::getUname();
$tableInfo['status'] 	= VirtualTicket::VIRTUAL_TICKET_STATUS_TOUZHU;
$tableInfo['select'] 	= '1x1';
$tableInfo['multiple'] 	= $multiple;
$tableInfo['money'] 	= $money;
$tableInfo['datetime'] 	= $datetime;
$tableInfo['odds'] 		= substr($odds_str,0,-1);
$tableInfo['prize'] 	= '0.00';
$tableInfo['source']	= $source;
$tableInfo['create_time'] = $datetime;
$tableInfo['combination'] = $combination;
$tableInfo['sport'] = '';

$id = $objVirtualTicket->add($tableInfo);

if (!$id) {
	$args = array('type' => 'fail', 'from' => $from, 'msg' => '投注失败 请联系客服');
	redirect(jointUrl($url, $args));
}
//扣除账号积分
$objUserAccountFront = new UserAccountFront();
$tmpResult = $objUserAccountFront->consumeScore($u_id, $money);
if (!$tmpResult->isSuccess()) {
	$args = array('type' => 'fail', 'from' => $from, 'msg' => '扣除积分失败');
	redirect(jointUrl($url, $args));
}
$userAccountInfo = $objUserAccountFront->get($u_id);
//积分扣除日志
$objUserScoreLogFront = new UserScoreLogFront();
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['create_time'] 	= $datetime;
$tableInfo['score'] 		= $money;
$tableInfo['old_score'] 	= $userAccountInfo['score'];
$tableInfo['log_type'] 		= BankrollChangeType::SCORE_TOUZHU;
$tableInfo['record_table'] 	= 'virtual_ticket';
$tableInfo['record_id'] 	= $id;
$ticket_log_id = $objUserScoreLogFront->add($tableInfo);
if (!$ticket_log_id) {
	$args = array('type' => 'fail', 'from' => $from, 'msg' => '积分扣除日志记录失败');
	redirect(jointUrl($url, $args));
}

$args = array('type' => 'success', 'from' => $from, 'msg' => '投注成功');
redirect(jointUrl($url, $args));

//55969|h#3.9&a#4
/**
 * array(
 * matchid1=>array(
 * 	h=>1,a=>2
 * 	)
 * matchid2=>array(
 * 	h=>2,a=>1
 * 	)
 * )
 *
 *
 */
function analyseCombination($combination) {
	$return = array();
	$m = explode(',', $combination);
	foreach ($m as $key=>$value) {
		$odds = array();
		$m1 = explode('|', $value);
		$m2 = explode('&', $m1[1]);
		foreach ($m2 as $key2=>$value2) {
			$m3 = explode('#', $value2);
			$odds[$m3[0]] = $m3[1];
		}
		$return[$m1[0]] = $odds;
	}
	return $return;
}
<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$id = Request::r('userTicketId');
if (!Verify::int($id)) {
	output_404();
// 	echo_exit('id wrong');
}

$objUserTicketAllFront = new UserTicketAllFront();

$follow_ticket = $objUserTicketAllFront->get($id);

if (!$follow_ticket) {
	fail_exit_g('未发现订单');
}
$follow_ticket['moneyMin'] = $follow_ticket['money']/$follow_ticket['multiple'];
// 验证方案是否显示
$combination_type = $follow_ticket['combination_type'];
//方案是否截止
$lastTouzhuTime = getLastTouzhuTime($follow_ticket['sport']);
if ($follow_ticket['endtime'] <= getCurrentDate()|| getCurrentDate() >= $lastTouzhuTime['date'].' '.$lastTouzhuTime['time']) {
	$is_end = true;
}

if ($follow_ticket['print_state'] != UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS && $follow_ticket['print_state'] != UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU) {
	fail_exit_g('订单未出票无法跟单');
}

if ($follow_ticket['prize_state'] != UserTicketAll::PRIZE_STATE_NOT_OPEN) {
// 	fail_exit_g('订单已算奖无法跟单');
}

$objUserMemberFront = new UserMemberFront();
$follow_ticket_user = $objUserMemberFront->get($follow_ticket['u_id']);

//方案未公开
if($combination_type == UserTicketAll::COMBINATION_TYPE_NOT_OPEN){
//	echo_exit('方案未公开');	
}
//是否允许跟单
$can_follow = false;
$objAdminOperate = new AdminOperate();
$shaidan_users = $objAdminOperate->getsByCondition(array('type'=>AdminOperate::TYPE_SHOW_TICKET, 'status'=>AdminOperate::STATUS_AVILIBALE));

foreach ($shaidan_users as $shaidan_user) {
	if ($shaidan_user['u_name'] == $follow_ticket_user['u_name']) {
		$can_follow = true;
		break;
	}
}
//确认结果提示页
$url = ROOT_DOMAIN . "/confirm/confirm_result.php";
if (!$can_follow) {
	$args = array('type' => 'other', 'from' => ROOT_DOMAIN . '/ticket/show.php', 'msg' => '该订单不可被跟单');
	redirect(jointUrl($url, $args));
}

$totalPrize = $objUserTicketAllFront->getTotalPrize($follow_ticket['u_id']);
$objUserTicketLog = new UserTicketLog($follow_ticket['u_id']);
$ordetTicketInfo = $objUserTicketLog->getsByCondition(array('ticket_id'=>$id));
//跟单人的相关信息
$condition = array();
$condition['partent_id'] = $id;
$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS, UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU);//包括虚拟投注
$follow_infos = $objUserTicketAllFront->getsByCondition($condition);
$follow_uids = $follow_info = array();

foreach ($follow_infos as $value) {
	$follow_uids[] = $value['u_id'];
}

$all_users = $objUserMemberFront->gets($follow_uids);
$follow_info = $objUserTicketAllFront->getFollowInfo($id);//简要的跟单信息

$tpl = new Template();

switch ($follow_ticket['sport']) {
	case 'bk':
		$sport = '篮彩';
		break;
	case 'bd':
		$sport = '北京单场';
		break;
	default:
		$sport = '竞彩足球';
		break;
}

$TEMPLATE['title'] = '聚宝网-聚宝彩票“'.$follow_ticket_user['u_name'].'”用户' . $sport . substr($follow_ticket['datetime'], 5, 5).'投注';

$TEMPLATE['keywords'] = '竞彩晒单,竞彩跟单,晒单跟单,聚宝网跟单,聚宝网竞猜跟单,竞彩投注,聚宝晒单中心,大力水手,王忠仓,寻鸡情求鸭迫,红姐,聚宝红姐。 ';
$TEMPLATE['description'] = '晒单中心展现的是聚宝网专家和明星会员推荐方案的页面，致力于打造竞彩中奖的福地。';
$tpl->assign('is_end', $is_end);
$tpl->assign('follow_info', $follow_info);
$tpl->assign('follow_infos', $follow_infos);
$tpl->assign('all_users', $all_users);
$tpl->assign('totalPrize', $totalPrize);
$tpl->assign('userTicketInfo', $follow_ticket);
$tpl->assign('ordetTicketInfo', $ordetTicketInfo);
$tpl->assign('follow_ticket_user', $follow_ticket_user);
echo_exit($tpl->r('follow'));     
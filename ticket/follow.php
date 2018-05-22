<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

Runtime::requireLogin();
$id = Request::r('userTicketId');
if (!Verify::int($id)) {
	output_404();
// 	echo_exit('id wrong');
}

$objMySQLite = new MySQLite($CACHE['db']['default']);
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

$showAllUserTicket = false;//后台人员查看某人的用户票功能
$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (Runtime::requireRole($roles,false)) {
    $showAllUserTicket = true;
}

if ($u_id != Runtime::getUid() && !$showAllUserTicket) {

	$follow_show=0;
	
	
	if($follow_ticket['prize_state']==0){
		
		
		if($follow_ticket['show_range']==2){//跟单人可见
		
			//查询是否已跟单
			$fu_id = Runtime::getUid();
			$sql ="SELECT * FROM user_ticket_all where 1 and partent_id='".$id."'  and u_id='".$fu_id."' order by id desc limit 0,1 ";		
			$follow_userTicketId = $objMySQLite->fetchOne($sql,'id');
			if(empty($follow_userTicketId)){
				$follow_show=1;	
			}
		}elseif($follow_ticket['show_range']==3){//设置是否截止后可见
			
			if (getCurrentDate()<$follow_ticket['endtime']){//方案在投注截止后可看
					$follow_show=2;//方案在投注截止后可看
				}
			
		}
	
	}
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
$sql ="SELECT u_nick,u_id FROM user_member where u_id in (SELECT u_id FROM user_ticket_all where  id=".$id.")";	
$partent_info = $objMySQLite->fetchOne($sql,'id');	



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

$TEMPLATE['title'] = '智赢网-智赢彩票“'.$follow_ticket_user['u_name'].'”用户' . $sport . substr($follow_ticket['datetime'], 5, 5).'投注';

$TEMPLATE['keywords'] = '竞彩晒单,竞彩跟单,晒单跟单,智赢网跟单,智赢网竞猜跟单,竞彩投注,智赢晒单中心,大力水手,王忠仓,寻鸡情求鸭迫,红姐,智赢红姐。 ';
$TEMPLATE['description'] = '晒单中心展现的是智赢网专家和明星会员推荐方案的页面，致力于打造竞彩中奖的福地。';
$tpl->assign('is_end', $is_end);
$tpl->assign('follow_info', $follow_info);
$tpl->assign('follow_show', $follow_show);
$tpl->assign('follow_infos', $follow_infos);
$tpl->assign('all_users', $all_users);
$tpl->assign('totalPrize', $totalPrize);
$tpl->assign('userTicketInfo', $follow_ticket);
$tpl->assign('ordetTicketInfo', $ordetTicketInfo);
$tpl->assign('follow_ticket_user', $follow_ticket_user);
$tpl->assign('partent_info', $partent_info);
echo_exit($tpl->r('follow'));     
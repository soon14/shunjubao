<?php
/**
 * 方案详情页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userTicketId = Request::r('userTicketId');
$showAllUserTicket = false;//后台人员查看某人的用户票功能

if (!$userTicketId) {
	echo_exit('请输入正确ID');
}

$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfo = $objUserTicketAllFront->get($userTicketId);

if (!$userTicketInfo) {
	echo_exit('请输入正确ID');
}

$u_id = $userTicketInfo['u_id'];
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (Runtime::requireRole($roles,false)) {
    $showAllUserTicket = true;
}

if ($u_id != Runtime::getUid() && !$showAllUserTicket) {
	echo_exit('不允许查看');
}

$totalPrize = $objUserTicketAllFront->getTotalPrize($u_id);
$objUserTicketLog = new UserTicketLog($u_id);
$ordetTicketInfo = $objUserTicketLog->getsByCondition(array('ticket_id'=>$userTicketId));


if(!$showAllUserTicket){
	//先检查当前订单是否跟单订单
	if($userTicketInfo["partent_id"]!=0){
			$objMySQLite = new MySQLite($CACHE['db']['default']);
			$sql ="SELECT * FROM user_ticket_all where 1 and id='".$userTicketInfo["partent_id"]."' order by id desc limit 0,1 ";		
			$partent_userTicketId = $objMySQLite->fetchOne($sql,'id');
			if($partent_userTicketId["show_range"]==3){//如果被跟订单设置了，赛事开始之后方可见
				if (getCurrentDate()<$partent_userTicketId['endtime']){//未结束，不可看
					$endtime_forbin=1;//方案在投注截止后可看
				}	
			}	
	}
}


//跟单人的相关信息
$condition = array();
$condition['partent_id'] = $userTicketId;
$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS,UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU);
$follow_infos = $objUserTicketAllFront->getsByCondition($condition);
$follow_uids = $follow_info = array();

foreach ($follow_infos as $value) {
	$follow_uids[] = $value['u_id'];
}

$all_users = $objUserMemberFront->gets($follow_uids);
$follow_info = $objUserTicketAllFront->getFollowInfo($userTicketId);//简要的跟单信息

switch ($userTicketInfo['sport']) {
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

$TEMPLATE['title'] = '智赢网-智赢彩票“'.$userInfo['u_name'].'”用户' . $sport . substr($userTicketInfo['datetime'], 5, 5).'投注';

$tpl = new Template();
$tpl->assign('endtime_forbin', $endtime_forbin);
$tpl->assign('all_users', $all_users);
$tpl->assign('follow_info', $follow_info);
$tpl->assign('follow_infos', $follow_infos);
$tpl->assign('totalPrize', $totalPrize);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('ordetTicketInfo', $ordetTicketInfo);

echo_exit($tpl->r('ticket02'));
?>
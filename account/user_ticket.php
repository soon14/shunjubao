<?php
/**
 * 投注记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();
$objMySQLite = new MySQLite($CACHE['db']['default']);
$u_id = $userInfo['u_id'];
$tpl = new Template();

$field = 'datetime';
$order = $field. ' desc';

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//是否只显示中奖订单
$is_prize = Request::r('is_prize');
$tpl->assign('is_prize', $is_prize);
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	//默认一个月
	$start_time =  date('Y-m-d', time() - 30 * 24 * 3600);
	$end_time = date('Y-m-d', time());
}
if($start_time<'2018-01-01'){
	$start_time='2018-01-01';
	
}



$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 14;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

$condition = array();
$condition['u_id'] = $u_id;
if ($is_prize==1) {
	$condition['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
}
$dingzhi_order = Request::r('dingzhi_order');

if ($dingzhi_order==1) {
	$follow_id = Request::r('follow_id');	
	
	
	$sql ="SELECT * FROM follow_ticket_log where follow_id='".$follow_id."' and u_id=".$u_id;		
	$dingzhi_array = $objMySQLite->fetchAll($sql,'id');
	
	foreach ($dingzhi_array as $key=>$value) {
		$dingzhi_orderid[] = $value["ticket_id"];
	}
	$condition['id'] = $dingzhi_orderid;
}

$objUserTicketAllFront = new UserTicketAllFront();

$userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start_time. ' 00:00:00', $end_time. ' 23:59:59', $field, $condition, $limit, $order);

foreach($userTicketInfo as $key=>$value) {
	$partent_id = $value["partent_id"];
	if($partent_id>0){
		$sql ="SELECT u_nick,u_id FROM user_member where u_id in (SELECT u_id FROM user_ticket_all where  id=".$partent_id.")";	
		$partent_info = $objMySQLite->fetchOne($sql,'id');	
		$userTicketInfo[$key]["partent_u_nick"]=$partent_info["u_nick"];
		$userTicketInfo[$key]["partent_u_id"]=$partent_info["u_id"];
	}
}





$totalPrize = $objUserTicketAllFront->getTotalPrize($u_id);
//投注总金额
$totalTicketMoney = $objUserTicketAllFront->getTotalTicketMoney($start_time. ' 00:00:00', $end_time. ' 23:59:59', $u_id); 
//时间段内总奖金
$totalPrizeMoney = $objUserTicketAllFront->getTotalPrizeMoney($start_time. ' 00:00:00', $end_time. ' 23:59:59', $u_id);
$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['is_prize'] = $is_prize;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_ticket.php", $args);
}

$nextPage = false;
if (count($userTicketInfo) > $size) {
    $nextPage = $page + 1;
    array_pop($userTicketInfo);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['is_prize'] = $is_prize;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_ticket.php", $args);
}

//晒单用户判定
$objAdminOperate = new AdminOperate();
$can_show_ticket = $objAdminOperate->isShowTickeUser($u_id);

#标题
$TEMPLATE ['title'] = "聚宝网竞彩投注记录";
$TEMPLATE['keywords'] = '聚宝竞彩投注,竞彩投注,竞彩篮球投注,竞彩足球投注。';
$TEMPLATE['description'] = '聚宝网竞彩投注记录。';
$tpl->assign('userInfo', $userInfo);
$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('totalTicketMoney', $totalTicketMoney);
$tpl->assign('totalPrizeMoney', $totalPrizeMoney);
$tpl->assign('totalPrize', $totalPrize);
$tpl->assign('can_show_ticket', $can_show_ticket);
$YOKA ['output'] = $tpl->r ('user_ticket');
echo_exit ( $YOKA ['output'] );
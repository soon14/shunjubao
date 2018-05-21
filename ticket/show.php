<?php
/**
 * 晒单页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

//Runtime::requireLogin();

$sport = Request::r('sport');
if ($sport != 'fb' && $sport != 'bk'&& $sport != 'bd') {
	$sport = 'fb';
}

$field = 'datetime';
$order = 'endtime desc, datetime desc, u_id asc';
$order = 'endtime desc, u_id asc, datetime desc';//按注册时间正序

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 12;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = "{$offset},{$real_size}";

$show_uids = array();
$objAdminOperate = new AdminOperate();
$condition = array();
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$condition['type'] = AdminOperate::TYPE_SHOW_TICKET;
$show_resuls = $objAdminOperate->getsByCondition($condition, null, 'create_time asc');
foreach ($show_resuls as $value) {
	$show_uids[] = $value['show_uid']; 
}

$objUserTicketAllFront = new UserTicketAllFront();
$condition = array();
$condition['print_state'] 	= array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS, UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU);
// $condition['combination_type'] = array(UserTicketAll::COMBINATION_TYPE_NOT_OPEN, UserTicketAll::COMBINATION_TYPE_OPEN);
$condition['combination_type'] = UserTicketAll::COMBINATION_TYPE_OPEN;
$condition['u_id'] 			= $show_uids;
$condition['sport'] 		= $sport;
//添加条件：比赛未开始和未开奖
//$condition['endtime'] = SqlHelper::addCompareOperator('>=', getCurrentDate());
//$condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
//获取前一天11点到现在的单
$today = time();//今天11点第一秒
$yesterday  = strtotime(date('Y-m-d'). ' 00:00:00') - 24 * 60 *60;//昨天11点第一秒
//北单晒单时间为前48小时
if ($sport == UserTicketAll::SPORT_BEIDAN) {
	$yesterday = strtotime(date('Y-m-d'). ' 00:00:00') - 48 * 60 *60;
}
$start_time = date('Y-m-d H:i:s' , $yesterday);
$end_time = date('Y-m-d H:i:s' , $today);

$condition['partent_id']	= 0;//非跟单的单
$show_tickets = $objUserTicketAllFront->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);
$total_show_tickets = $objUserTicketAllFront->getsByCondtionWithField($start_time, $end_time, $field, $condition);
$total_page = ceil(count($total_show_tickets)/$size);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array('sport'=>$sport);
if ($previousPage) {
	$args['page'] = $previousPage;
    $previousUrl = jointUrl(ROOT_DOMAIN."/ticket/show.php", $args);
}

$nextPage = false;
if (count($show_tickets) > $size) {
    $nextPage = $page + 1;
    array_pop($show_tickets);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
    $nextUrl = jointUrl(ROOT_DOMAIN."/ticket/show.php", $args);
}

$partentIds = $uids = array();
$follow_infos = array();//跟单的订单
foreach ($show_tickets as $key=>$value) {
	$show_tickets[$key]['datetime'] = substr($value['datetime'], 5);
	$show_tickets[$key]['endtime'] = substr($value['endtime'], 5);
	$show_tickets[$key]['is_end'] = false;
	//如果结束时间玩于当天的投注最晚时间，则不能跟单
	$lastTouzhuTime = getLastTouzhuTime($value['sport']);
	if ($value['endtime'] <= getCurrentDate() || getCurrentDate() >= $lastTouzhuTime['date'].' '.$lastTouzhuTime['time']) {
		$show_tickets[$key]['is_end'] = true;//是否结束
	}
	$follow_info = $objUserTicketAllFront->getFollowInfo($value['id']);
	if ($follow_info) {
		$follow_infos[$value['id']] = $follow_info;
	}
	$uids[] = $value['u_id'];
}

//pr($follow_infos);
//晒单人
$objUserMemberFront = new UserMemberFront();
$show_users = $objUserMemberFront->gets($uids);
foreach ($show_users as $key=>$value) {
	$show_users[$key]['u_img'] = str_replace('zhiying365', 'zhiying365365', $value['u_img']);
}
$TEMPLATE['title'] = '智赢网|智赢晒单跟单中心。';
$TEMPLATE['keywords'] = '竞彩晒单,竞彩跟单,晒单跟单,智赢网跟单,智赢网竞猜跟单,竞彩投注,智赢网晒单中心,智赢网跟单中心,智赢网大力水手,大力水手,智赢网竞彩熊超,智赢熊超,竞彩熊超,王忠仓,寻鸡情求鸭迫,红姐,智赢红姐。 ';
$TEMPLATE['description'] = '停止盲目投注...跟随智赢高手，让您的利润蒸蒸日上 ! 晒单中心展现的是智赢网专家和明星会员推荐方案的页面，致力于打造竞彩中奖的福地。';
//pr($show_tickets);
$tpl = new Template();
$tpl->assign('sport', $sport);
$tpl->assign('total_page', $total_page);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('show_users', $show_users);
$tpl->assign('show_tickets', $show_tickets);
$tpl->assign('follow_infos', $follow_infos);
echo_exit($tpl->r('show'));

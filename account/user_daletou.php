<?php
/**
 * 投注记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();

$u_id = $userInfo['u_id'];
$tpl = new Template();

$field = 'create_time';
$order = $field. ' desc';

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	//默认一个月
	$start_time =  date('Y-m-d', time() - 30 * 24 * 3600);
	$end_time = date('Y-m-d', time());
}

$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 11;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

$condition = array();
$condition['u_id'] = $u_id;
$Daletoudetail = new Daletoudetail();
$userTicketInfo = $Daletoudetail->get_daletou_list_my($u_id);

foreach($userTicketInfo as $key=>$val){
	
	$userTicketInfo[$key]['qianqu_arr']=explode(',',$val['qianqu']);
	$userTicketInfo[$key]['houqu_arr']=explode(',',$val['houqu']);
	$userTicketInfo[$key]['buytime']=date('Y-m-d H:i:s',$val['buytime']);

}
$previousPage = $page <= $firstPage ? FALSE : $page-1 ;

$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	
    $previousUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

$nextPage = false;
if (count($userTicketInfo) > $size) {
    $nextPage = $page + 1;
    array_pop($userTicketInfo);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
    $nextUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

#标题
$TEMPLATE ['title'] = "聚宝网积分投注记录";
$TEMPLATE['keywords'] = '聚宝竞彩投注,竞彩投注,竞彩篮球投注,竞彩足球投注。';
$TEMPLATE['description'] = '聚宝网积分投注记录。';
$tpl->assign('userInfo', $userInfo);
$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketInfo', $userTicketInfo);
$statusDesc = VirtualTicket::getStatusDesc();
$tpl->assign('statusDesc', $statusDesc);
$YOKA ['output'] = $tpl->r ('user_daletou');
echo_exit ( $YOKA ['output'] );
<?php
/**
 * 用户2x1页
 * 1、统计2x1用户胜率
 * 2、排名
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$sport = Request::r('sport');

if ($sport != 'bk' && $sport != 'fb') {
	$sport = 'fb';
}

$objUserTicketAllFront = new UserTicketAllFront();
$condition = array();
$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS, UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU);
$condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
$condition['user_select'] = array('2x1');
$condition['sport'] = $sport;
$condition['return_time'] = SqlHelper::addCompareOperator('>=', date('Y-m-d H:i:s', time() - 488));

$results = array();

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 10;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$field = 'datetime';
$order = $field . ' desc , return_time desc';
$limit = "{$offset},{$real_size}";

$results = $objUserTicketAllFront->getsByCondition($condition, $limit, $order);

$uids = $mids = array();
foreach ($results as &$val) {
	$uids[] = $val['u_id'];
	$combination = $val['combination'];
	
	$matchs = explode(',',$combination);
	$j = 1;
	
	foreach($matchs as $k => $v) {
		$match = explode("|", $v);
		$mids[] = $match[1];
		$option = explode("&", $match[2]);
		//赔率
		$cond = array();
		$cond['m_id'] = $match[1];
		$goalline = '';
		$objOdds = new Odds($sport, $match[0]);
		$oddInfos = $objOdds->getsByCondition($cond);
		foreach ($oddInfos as $odds) {
			$g = '';
			if ($odds["goalline"]) {//+1.00 -3.50
				$g3 = substr($odds["goalline"], 0, -3);
				$g1 = substr($odds["goalline"], 0, -1);
				if ($g3 != $g1) $g = $g1;
				else $g = $g3;
				$goalline = $g;
			}
		}
		
		$user_option = array();
		foreach($option as $k1 => $v1){
			$key = explode("#",$v1);
			$user_option[] = getChineseByPoolCode($match[0], $key[0]). $goalline;
    	}
		$val['match'.$j++] = array('id'=>$match[1],'option'=>$user_option);
	}
	
}

$objBetting = new Betting($sport);
$matchInfos = $objBetting->gets($mids);

$objUserMemberFront = new UserMemberFront();
$users = $objUserMemberFront->gets($uids);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
//$args = $condition;
$args['sport'] = $sport;
if ($previousPage) {
	$args['page'] = $previousPage;
    $previousUrl = jointUrl(ROOT_DOMAIN."/activity/select_show.php", $args);
}
$nextPage = false;
if (count($results) > $size) {
    $nextPage = $page + 1;
    array_pop($userAccountLogInfos);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
    $nextUrl = jointUrl(ROOT_DOMAIN."/activity/select_show.php", $args);
}

$tpl = new Template();

$tpl->assign('sport',$sport);

//获取总页数
$total_results = $objUserTicketAllFront->getsByCondition($condition);
$total_page = ceil(count($total_results)/$size);
$selectRank = getSelectRank($sport);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('total_page', $total_page);
$tpl->assign('selectRank', $selectRank);
$tpl->assign('results', $results);
$tpl->assign('users', $users);
$tpl->assign('matchInfos', $matchInfos);
echo_exit($tpl->r('select_show'));


<?php
/**
 * 晒单定制页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
Runtime::requireLogin();
$objMySQLite = new MySQLite($CACHE['db']['default']);


$order = 's_recomond desc,s_shenglv desc,s_hondanshu desc';//按注册时间正序

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 13;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = "{$offset},{$real_size}";

$show_uids = array();
$objAdminOperate = new AdminOperate();
$condition = array();
$condition['type'] = 3;
$condition['status'] = 1;
$condition['s_recomond'] =  SqlHelper::addCompareOperator('!=',0);
$results = $objAdminOperate->getsByCondition($condition,$limit,$order);
$total_results = $objAdminOperate->getsByCondition($condition);
$total_page = ceil(count($total_results)/$size);


foreach ($results as $key=>$value) {
	$show_member_info = show_member_info($objMySQLite,$results[$key]["show_uid"]);
	
	

	
	$results[$key]['u_img'] = $show_member_info["u_img"];	
	$results[$key]['u_jointime'] = $show_member_info["u_jointime"];	
	$results[$key]['show_name'] = $show_member_info["u_name"];	
	
	//查询中奖率
	$show_prize_state1 = show_prize_state($objMySQLite,$results[$key]["show_uid"],1);
	
	$show_prize_state2 = show_prize_state($objMySQLite,$results[$key]["show_uid"],2);
	
	$results[$key]['show_prize_state1'] = $show_prize_state1;	
	$results[$key]['show_prize_state2'] = $show_prize_state2;	
	$results[$key]['show_prize_rate'] = round($show_prize_state1/($show_prize_state1+$show_prize_state2))*100;
}





$results_top = $objAdminOperate->getsByCondition($condition,"4");

//var_dump($results_top);exit();

foreach ($results_top as $key=>$value) {
	$show_member_info = show_member_info($objMySQLite,$results_top[$key]["show_uid"]);
	$results_top[$key]['u_img'] = $show_member_info["u_img"];	
	$results_top[$key]['u_jointime'] = $show_member_info["u_jointime"];	

	//查询中奖率
	$show_prize_state1 = show_prize_state($objMySQLite,$results_top[$key]["show_uid"],1);
	$show_prize_state2 = show_prize_state($objMySQLite,$results_top[$key]["show_uid"],2);
	
	$results_top[$key]['show_prize_state1'] = $show_prize_state1;	
	$results_top[$key]['show_prize_state2'] = $show_prize_state2;	
	$results_top[$key]['show_prize_rate'] = round($show_prize_state1/($show_prize_state1+$show_prize_state2))*100;
}






$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array('sport'=>$sport);
if ($previousPage) {
	$args['page'] = $previousPage;
    $previousUrl = jointUrl(ROOT_DOMAIN."/ticket/dingzhi.php", $args);
}

$nextPage = false;
if (count($results) > $size) {
    $nextPage = $page + 1;
    array_pop($results);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
    $nextUrl = jointUrl(ROOT_DOMAIN."/ticket/dingzhi.php", $args);
}



//$show_users = $objUserMemberFront->gets($uids);
$TEMPLATE['title'] = '聚宝网|聚宝晒单跟单中心。';
$TEMPLATE['keywords'] = '竞彩晒单,竞彩跟单,晒单跟单,聚宝网跟单,聚宝网竞猜跟单,竞彩投注,聚宝网晒单中心,聚宝网跟单中心,聚宝网大力水手,大力水手,聚宝网竞彩熊超,聚宝熊超,竞彩熊超,王忠仓,寻鸡情求鸭迫,红姐,聚宝红姐。 ';
$TEMPLATE['description'] = '停止盲目投注...跟随聚宝高手，让您的利润蒸蒸日上 ! 晒单中心展现的是聚宝网专家和明星会员推荐方案的页面，致力于打造竞彩中奖的福地。';
//pr($results);
$tpl = new Template();

$tpl->assign('total_page', $total_page);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('results', $results);
$tpl->assign('results_top', $results_top);
echo_exit($tpl->r('dingzhi'));


function show_prize_state($objMySQLite,$u_id,$prize_state){//查会员红单量，黑单量，胜率

	 $sql ="SELECT count(*) as nums FROM user_ticket_all where  u_id ='".$u_id."' and combination_type=1  and prize_state ='".$prize_state."' group by prize_state ";		
	 $value = $objMySQLite->fetchOne($sql);
	return $value["nums"];
}



function show_member_info($objMySQLite,$u_id){
	
	$sql ="SELECT * FROM user_member where u_id='".$u_id."' limit 0,1";		
	$value = $objMySQLite->fetchOne($sql,'id');
	return $value;
}


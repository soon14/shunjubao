<?php
/**
 * 被打赏列表 
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$dtime_detail = date("Y-m-d H:i:s",time());
$tpl = new Template();

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
$objMySQLite = new MySQLite($CACHE['db']['default']);



//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 90 * 24 * 3600);
	$end_time = date('Y-m-d', time());
}

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 12;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录


$limit = " {$offset},{$real_size} ";


$sql ="SELECT * FROM user_addtips_log where to_u_id='".$u_id."' order by addtime desc  limit ".$limit;		
$data_array = $objMySQLite->fetchAll($sql,'id');

foreach ($data_array as $key=>$value) {
	
	$show_member_info = show_member_info($objMySQLite,$data_array[$key]["u_id"]);
	$data_array[$key]["u_name"]=$show_member_info["u_name"];
	$total_money +=$data_array[$key]["addtips_money"];	
}


$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_tipsed.php", $args);
}
$nextPage = false;
if (count($dingzhi_array) > $size) {
    $nextPage = $page + 1;
    array_pop($dingzhi_array);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_tipsed.php", $args);
}



#标题
$TEMPLATE ['title'] = "聚宝网用户账户被打赏列表 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户账户充值明细。';
$tpl->assign('userInfo', $userInfo);
$tpl->assign('data_array', $data_array);
$tpl->assign('total_money', $total_money);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('user_tipsed'));



function show_member_info($objMySQLite,$u_id){//查会员资料
	$sql ="SELECT * FROM user_member where u_id='".$u_id."' limit 0,1";		
	$value = $objMySQLite->fetchOne($sql,'u_id');

	return $value;
}

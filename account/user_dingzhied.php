<?php
/**
 * 用户定制晒单跟注列表
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$dtime_detail = date("Y-m-d H:i:s",time());
$tpl = new Template();

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
$objMySQLite = new MySQLite($CACHE['db']['default']);


if ($_GET) {//是否操作
	$id = Request::g('id');
	$status = Request::g('status');
	
	$usql = "update `follow_ticket` set status='".$status."' where id='".$id."'";
	$objMySQLite->query($usql);
}



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


$sql ="SELECT * FROM follow_ticket where follow_id='".$u_id."' order by end_time desc  limit ".$limit;		
$dingzhi_array = $objMySQLite->fetchAll($sql,'id');

foreach ($dingzhi_array as $key=>$value) {
	
	$show_member_info = show_member_info($objMySQLite,$dingzhi_array[$key]["u_id"]);
	$dingzhi_array[$key]["u_name"]=$show_member_info["u_name"];
	
	switch($dingzhi_array[$key]["cycle"]){
	case 1:
		$dingzhi_array[$key]["cycle_show"]="一周";
		break;
	case 2:
		$dingzhi_array[$key]["cycle_show"]="两周";
		break;	
	case 3:
		$dingzhi_array[$key]["cycle_show"]="一个月";
		break;		
	default:
		$dingzhi_array[$key]["cycle_show"]="一周";
		break;
	}
	
	
		$dingzhi_array[$key]["enable"]=1;
		if($value["status"]==2){
			$dingzhi_array[$key]["status_show"]="<span style='color:red'>停止</span>";	
		}else{
				
			if($value["end_time"]<$dtime_detail){
				$dingzhi_array[$key]["enable"]=2;
				$dingzhi_array[$key]["status_show"]="<span style='color:red'>已结束</span>";	
			}else{
				$dingzhi_array[$key]["status_show"]="正常";		
			}

		}

		if($value["end_time"]<$dtime_detail){
			$dingzhi_array[$key]["end_time"]=$value["end_time"];	
		}
				

}


$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_dingzhi.php", $args);
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
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_dingzhi.php", $args);
}



#标题
$TEMPLATE ['title'] = "聚宝网用户账户充值明细 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户账户充值明细。';
$tpl->assign('userInfo', $userInfo);
$tpl->assign('dingzhi_array', $dingzhi_array);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('user_dingzhied'));



function show_member_info($objMySQLite,$u_id){//查会员资料
	$sql ="SELECT * FROM user_member where u_id='".$u_id."' limit 0,1";		
	$value = $objMySQLite->fetchOne($sql,'u_id');

	return $value;
}

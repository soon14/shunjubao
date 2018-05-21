<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
ini_set('memory_limit', '-1');
$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}


$tpl = new Template();

$field = 'datetime';
$order = $field. ' desc';
//待查询的日期，允许精确到秒
$start_date = "2016-06-10";
$start_time = "00:00:00";
$end_date = "2016-06-19";
$end_time = "23:59:59";
$start = $start_date . ' ' . $start_time;

$end = $end_date . ' ' . $end_time;

$objUserMemberFront = new UserMemberFront();

$condition = array();
$condition['print_state'] = 1;
$condition['select'] = '2x1';
$condition['prize_state'] = '1';
$condition['num'] = '2';
//$condition['u_id'] = 7420;

$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
//$userTicketIds = array_keys($userTicketInfo);
//var_dump($userTicketInfo);exit();
$u_ids = array();
$point_list = array();
foreach($userTicketInfo as $key=>$value) {	

//echo $value['u_id'];die();

	$u_ids[$value['u_id']] = $value['u_id'];//会员id
		//var_dump($value['datetime']);
	
	$h = date("H",strtotime($value['datetime']));
	if($h>=9  ){
		if($value['money']>=5000){
			$point=$value["money"]*0.05;
		}elseif($value["money"]>=1000 && $value["money"]<5000){
			$point=$value["money"]*0.04;
		}else{
			$point=$value["money"]*0.03;
		}
	
		$point_list[$value['u_id']]["u_id"] = $value['u_id'];//会员id
		$point_list[$value['u_id']]["money"] += $value['money'];
		$point_list[$value['u_id']]["point"] += $point;
		
		$point_list[$value['u_id']]["prize"] += $value["prize"];
		
	}
	

}

$all_users = $objUserMemberFront->gets($u_ids);
//var_dump($point_list);//exit();

foreach($point_list as $key=>$value2){

	$t["u_id"]= $value2['u_id'];
	$t["u_name"]= $all_users[$value2['u_id']]["u_name"];
	$t["money"]= $value2['money'];
	$t["point"]= $value2['point'];
	
	$t["prize"]= $value2['prize'];
	

	$j++;
	$t_point +=$t["point"];
	$t_money +=$t["money"];
	$orderTickets[]=$t;
	
	
	
}
$a = array_sort($orderTickets,"money");

$tpl->assign('rand', rand());
$tpl->assign('t_money', $t_money);
$tpl->assign('t_point', $t_point);
$tpl->assign('j', $j);


$tpl->assign('orderTickets', $a);
$YOKA ['output'] = $tpl->r ('../admin/order/user_orders_euro');
echo_exit ( $YOKA ['output'] );



function array_sort($array, $key){ 
	if(is_array($array)){ 
	$key_array = null; 
	$new_array = null; 
	for( $i = 0; $i < count( $array ); $i++ ){ 
	$key_array[$array[$i][$key]] = $i; 
	} 
	krsort($key_array); 
	$j = 0; 
	foreach($key_array as $k => $v){ 
	$new_array[$j] = $array[$v]; 
	$j++; 
	} 
	unset($key_array); 
	return $new_array; 
	}else{ 
	return $array; 
	} 
} 










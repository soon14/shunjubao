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
$start_date = date('Y-m-01', strtotime('-1 month'));
$start_time = "00:00:00";
$end_date = date('Y-m-t', strtotime('-1 month'));
$end_time = "23:59:59";
$start = $start_date . ' ' . $start_time;
$end = $end_date . ' ' . $end_time;

echo "本次统计日期:".$start."-".$end;


$objUserMemberFront = new UserMemberFront();

$condition = array();
$condition['print_state'] = 1;
//$condition['u_id'] = 237;
$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
//$userTicketIds = array_keys($userTicketInfo);
//var_dump($userTicketInfo);exit();
$u_ids = array();
$point_list = array();
foreach($userTicketInfo as $key=>$value) {	

//echo $value['u_id'];die();

	$u_ids[$value['u_id']] = $value['u_id'];//会员id
	
	$point_list[$value['u_id']]["u_id"] = $value['u_id'];//会员id
    $point_list[$value['u_id']]["money"] += $value['money'];
}

$all_users = $objUserMemberFront->gets($u_ids);
//var_dump($all_users);//exit();

foreach($point_list as $key=>$value2){
	//检查当天是否已经返过积分
	
	
	$t["u_id"]= $value2['u_id'];
	
	//var_dump($value2);exit();
	
	$t["u_name"]= $all_users[$value2['u_id']]["u_name"];
	$t["money"]= $value2['money'];
	
/*1、月投注额500-8888元赠送5%；
2、月投注额8888-58888元赠送6%；
3、月投注额58888-188888元赠送7%；
4、月投注额188888-以上元赠送8%；
*/
	
	
	if($t["money"]>=188888){
		$t["point"]=round($t["money"]*0.08);
	}elseif($t["money"]>=58888 && $t["money"]<188888){
		$t["point"]=round($t["money"]*0.07);
	}elseif($t["money"]>=8888 && $t["money"]<58888){
		$t["point"]=round($t["money"]*0.06);
	}elseif($t["money"]>=500 && $t["money"]<8888){
		$t["point"]=round($t["money"]*0.05);
	}else{
		$t["point"]=0;		
	}
	if($t["point"]>0){
		
		//调用派积分接口 start=======================================================================
		
		
		$start_time_get_log = date('Y-m-d', time());
		$end_time_get_log = date('Y-m-d', time());
		$condition =  array();
		$condition['log_type'] = 44;
		$condition['u_id'] = $value2['u_id'];


		$objUserScoreLogFront = new UserScoreLog();
		$userScoreLogInfos = $objUserScoreLogFront->getsByCondtionWithField($start_time_get_log . ' 00:00:00', $end_time_get_log . ' 23:59:59', 'create_time', $condition, $limit, 'create_time desc');


		$j++;
		$t_point +=$t["point"];
		$t_money +=$t["money"];
		$orderTickets[]=$t;
	}
	
	
	
}
$a = array_sort($orderTickets,"money");

$tpl->assign('t_money', $t_money);
$tpl->assign('t_point', $t_point);
$tpl->assign('j', $j);


$tpl->assign('orderTickets', $a);
$YOKA ['output'] = $tpl->r ('../admin/order/user_orders_to_point');
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


function getToken($params) {
		
		if (!is_array($params)) return '';
		
		ksort($params);
		
		$string = '';
		
		foreach ($params as $key=>$value) {
			if ($key == 'token') {
				continue;
			}
			$string .= $key . $value;
		}
		//应用id必须有
		$appId = $params['appId'];
		//为你分配的appkey
		$appKey = '9cb6bc11c960e0c7';
		//传输的内容
		$string .= $appKey;
		return substr(md5($string), 8, 16);
	}










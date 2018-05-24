<?php
/**
 * 获取用户投注情况进行积分返回
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
ini_set('memory_limit', '-1');
$field = 'datetime';
$order = $field. ' desc';
//待查询的日期，允许精确到秒
$start_date = date('Y-m-01', strtotime('-1 month'));
$start_time = "00:00:00";
$end_date = date('Y-m-t', strtotime('-1 month'));
$end_time = "23:59:59";
$start = $start_date . ' ' . $start_time;
$end = $end_date . ' ' . $end_time;

$objUserMemberFront = new UserMemberFront();

$condition = array();
$condition['print_state'] = 1;
//$condition['u_id'] = 237;
$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
$userTicketIds = array_keys($userTicketInfo);//获取所有订单
//var_dump($userTicketInfo);exit();
$u_ids = array();
$point_list = array();
foreach($userTicketInfo as $key=>$value) {	
	$u_ids[$value['u_id']] = $value['u_id'];//会员id
	$point_list[$value['u_id']]["u_id"] = $value['u_id'];//会员id
    $point_list[$value['u_id']]["money"] += $value['money'];
}
//计算金额
$all_users = $objUserMemberFront->gets($u_ids);
//var_dump($point_list);exit();


$objUserScoreLog = new UserScoreLog();


foreach($point_list as $key=>$value2){

	$t["u_id"]= $value2['u_id'];	
	$t["u_name"]= $all_users[$value2['u_id']]["u_name"];
	$t["money"]= $value2['money'];
	
	/*if($t["money"]>=150000){
		$t["point"]=12000;
	}elseif($t["money"]>=100000 && $t["money"]<150000){
		$t["point"]=5000;
	}elseif($t["money"]>=50000 && $t["money"]<100000){
		$t["point"]=2500;
	}elseif($t["money"]>=30000 && $t["money"]<50000){
		$t["point"]=1500;
	}elseif($t["money"]>=20000 && $t["money"]<30000){
		$t["point"]=1000;
	}elseif($t["money"]>=10000 && $t["money"]<20000){
		$t["point"]=500;
	}elseif($t["money"]>=5000 && $t["money"]<10000){
		$t["point"]=250;
	}elseif($t["money"]>=3000 && $t["money"]<5000){
		$t["point"]=150;
	}elseif($t["money"]>=2000 && $t["money"]<3000){
		$t["point"]=100;
	}elseif($t["money"]>=1000 && $t["money"]<2000){
		$t["point"]=50;
	}else{
		$t["point"]=0;		
	}*/
	
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
		
		
	$start_date = date('Y-m-01', time());
	$start_time = "00:00:00";
	$start = $start_date . ' ' . $start_time;
	$had_bet = $objUserScoreLog->getNum($start, $value2['u_id']);
	if(empty($had_bet)){
		$dtime = time();//当时时间
		$to_uid = $value2['u_id'];
		$total=$t["point"];
		
	
		$php_handle = 'bet_gift.php';
		$params=array("time"=>$dtime,
					  "to_uid"=>$to_uid,
					  "total"=>$total,
					  "appId"=>'3',
						);	
		
		$token = getToken($params);
		$url = 'http://www.shunjubao.xyz/api/'.$php_handle.'?token='.$token.'&time='.$dtime.'&to_uid='.$to_uid.'&total='.$total.'&appId=3';
		
		$json = file_get_contents($url);
		$result = json_decode($json, true);
		//var_dump($result);exit();
	}	
		//调用派积分接口 end=======================================================================
		$j++;
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










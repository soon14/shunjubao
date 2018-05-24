<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];
$tpl = new Template();
include_once ("config.inc.php");
switch (get_param('action')){
		case'add':
			$YOKA ['output'] = $tpl->r ('zhuanjia/user_recommend_add');
			echo_exit ( $YOKA ['output'] );
		case'add_action':

		$booktype = get_param('booktype');//订阅类型
		$bookid = get_param('bookid');//订阅ID
		if($booktype==1){//订阅单场
		
		
				//检查是否有订阅过
				$sql ="SELECT * FROM ".tname("booking")."   where 1  and bookid='".$bookid."' and booktype='".$booktype."' and u_id='".$u_id."'   LIMIT 0,1";			
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
				if(!empty($value)){
					message("你已订阅过,请不要重复订阅!","http://www.shunjubao.xyz/zhuanjia/");
					exit();
				}
		
				$sql ="SELECT * FROM ".tname("recommond")."   where 1  and sysid='".$bookid."' ORDER BY sysid DESC LIMIT 0,1";			
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
				if(empty($value)){
					message("订阅出错!","http://www.shunjubao.xyz/zhuanjia/");
					exit();
				}else{
					$e_id = $value["u_id"];//专家ID
					if($e_id==$u_id){
						message("不能订阅自己推荐的方案!","http://www.shunjubao.xyz/zhuanjia/");
						exit();	
					}
					
					
					$e_name = $value["u_name"];//专家帐号
					$e_nick = $value["u_nick"];//专家帐号
					$booking_money = $value["pmoney"];//金额	
				}
				
			}else{

				$t = get_param('t');
				if($t==1){
						$sql ="SELECT * FROM ".tname("recommond")."   where 1  and sysid='".$bookid."' ORDER BY sysid DESC LIMIT 0,1";			
						
						$query = $conn -> Query($sql);
						$value = $conn -> FetchArray($query);
						if(empty($value)){
							message("订阅出错!","http://www.shunjubao.xyz/zhuanjia/");
							exit();
						}else{
							$e_id = $value["u_id"];//专家ID
							if($e_id==$u_id){
								message("不能订阅自己推荐的方案!","http://www.shunjubao.xyz/zhuanjia/");
								exit();	
							}
							
							
							$e_name = $value["u_name"];//专家帐号
							$e_nick = $value["u_nick"];//专家帐号
							if($booktype==2){
								$end_time=date("Y-m-d H:i:s",time()+7*24*3600);
								
								$sql2 ="SELECT * FROM ".tname("shengqing")."   where 1  and eid='".$e_id."' and ifuse=1 ORDER BY sysid DESC LIMIT 0,1";			
								$query2 = $conn -> Query($sql2);
								$value2 = $conn -> FetchArray($query2);
								
								
								//$booking_money = 50;	
								$booking_money = $value2["week_money"];	
									
							}elseif($booktype==3){
								//$booking_money = 188;	
								
								$sql2 ="SELECT * FROM ".tname("shengqing")."   where 1  and eid='".$e_id."' and ifuse=1 ORDER BY sysid DESC LIMIT 0,1";			
								$query2 = $conn -> Query($sql2);
								$value2 = $conn -> FetchArray($query2);
								
								$booking_money = $value2["month_money"];		
								$end_time=date("Y-m-d H:i:s",time()+30*24*3600);
							}	
					
						}
						
					
				}else{
					
					if(empty($bookid)){
					message("订阅出错!","http://www.shunjubao.xyz/zhuanjia/");
					exit();
				}
				
				
				
				
				if($bookid==$u_id){
						message("不能订阅自己推荐的方案!","http://www.shunjubao.xyz/zhuanjia/");
						exit();	
				}
				
				
				$sql ="SELECT * FROM ".tname("shengqing")."   where 1  and eid='".$bookid."' and ifuse=1 ORDER BY sysid DESC LIMIT 0,1";			
			
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
					//	查询专家信息
				    $e_id = $value["eid"];//专家ID
					$e_name = $value["u_name"];//专家帐号
					$e_nick = $value["u_nick"];//专家帐号
					//$bookid="";//清空订阅ID
					if($booktype==2){
						$end_time=date("Y-m-d H:i:s",time()+7*24*3600);
						//$booking_money = 50;
						$booking_money = $value["week_money"];
								
					}elseif($booktype==3){
						//$booking_money = 188;	
						$booking_money = $value["month_money"];	
						$end_time=date("Y-m-d H:i:s",time()+30*24*3600);
					}	
					
				}
			
			}
		//检查是否有订阅过
		$sql ="SELECT * FROM ".tname("booking")."   where 1   and booktype='".$booktype."' and u_id='".$u_id."' and e_id='".$e_id."'  order by end_time  LIMIT 0,1";			
		$query = $conn -> Query($sql);
		$value = $conn -> FetchArray($query);
		if(!empty($value)){
			
			$this_date = date("Y-m-d H:i:s");	
			if($value["end_time"]>$this_date){
				message("不能重复订阅，之前订阅还未过期哦!","http://www.shunjubao.xyz/zhuanjia/");
				exit();
			}
			
			//message("你已订阅过,请不要重复订阅!","http://www.shunjubao.xyz/zhuanjia/");
			//exit();
		}
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($u_id);
		$balance = $userAccountInfo["cash"];
		if($balance<$booking_money){
			message("你的余额不足，请先充值!","http://www.shunjubao.xyz/account/user_charge.php");
			exit();
		}
			$tmpResult = $objUserAccountFront->consumeCash($u_id, $booking_money);
			if (!$tmpResult->isSuccess()) {
				fail_exit('订阅扣费失败，原因'.$tmpResult->getData());
			}
			$tableInfo = array();
			$tableInfo['u_id'] 			= $u_id;
			$tableInfo['money'] 		= $booking_money;
			$tableInfo['log_type'] 		= BankrollChangeType::DINGYUE;
			$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
			$tableInfo['record_table'] 	= 'user_account';//对应的表
			$tableInfo['record_id'] 	= $u_id;
			$tableInfo['create_time'] 	= getCurrentDate();
			//添加账户日志
			$objUserAccountLogFront = new UserAccountLogFront($u_id);
			$tmpResult = $objUserAccountLogFront->add($tableInfo);
			if (!$tmpResult) {
				fail_exit('订阅扣费失败');
			}
		//	$type = '余额';
		//var_dump($balance);
		//die("yyy");
		//检查会员当前余额
			$arr = array(
					"bookid"=>"'$bookid'",
					"booktype"=>"'$booktype'",
					"u_id"=>"'$u_id'",
					"u_name"=>"'$u_name'",
					"e_id"=>"'$e_id'",
					"e_name"=>"'$e_name'",
					"e_nick"=>"'$e_nick'",
					"booking_money"=>"'$booking_money'",
					"addtime"=>"'$dtime'",
					"end_time"=>"'$end_time'",
					"addip"=>"'$dip'"			
				);
		//	print_r($arr);exit();
				$res = add_record($conn, "booking", $arr);
				if($res['rows'] <= 0)
				{
					message("订阅出错!","http://www.shunjubao.xyz/zhuanjia/");
					exit();
				}else{
					message("订阅成功!","http://www.shunjubao.xyz/zhuanjia/zhuanjia_show.php?id=$e_id");
					exit();
				}
			break;	
		default:
		break;	
}

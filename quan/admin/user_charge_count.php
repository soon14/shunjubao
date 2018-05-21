<?php
	include("config.inc.php");
	include('checklogin.php');
	$tpl -> assign('adminname',$_SESSION["real_name"]);//管理员名称	

	$filename= substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],"/")+1); 
	$tpl -> assign('filename',$filename);	

    switch (get_param('action')){
    	
		default:
			//分页

			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and create_time>='".$s_date."' ";
				$tpl -> assign('s_date',$s_date);
			}else{
				$s_date =  date("Y-m-d",time())." 00:00:00";
				$where .= " and create_time>='".$s_date."' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  create_time<='".$e_date."' ";
				$tpl -> assign('e_date',$e_date);
			}



			//charge_type
		
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney,charge_type,charge_status,charge_source  FROM zhiying.user_charge  where 1=1 and charge_status=2  $where GROUP by charge_type,charge_source order by charge_type desc ,charge_source desc ";			
			
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query)){
				
				$sql2 ="SELECT count(*) as nums ,sum(money) as totalmoney,charge_type,charge_status,charge_source  FROM zhiying.user_charge  where 1=1 and charge_status=1  $where and charge_type='".$value["charge_type"]."' and charge_source='".$value["charge_source"]."'  ";			
				$query2 = $conn -> Query($sql2);
				$value2 = $conn -> FetchArray($query2);
				$value["nums2"] = $value2["nums"];
				$value["totalmoney2"] = $value2["totalmoney"];
				
				$value["rate"] =round($value["nums"]/($value["nums"]+$value["nums2"]),4)*100;
				
				switch($value["charge_type"]){
					case "1":	
						$value["charge_type"]="智赢支付宝";
						break;
					case "2":	
						$value["charge_type"]="手工充值";
						break;
					case "3":	
						$value["charge_type"]="财付通充值";
						break;
					case "4":	
						$value["charge_type"]="微信充值";		
						break;
					case "5":	
						$value["charge_type"]="易宝充值";	
						break;							
					case "6":	
						$value["charge_type"]="支付宝扫码";	
						break;							
					case "7":	
						$value["charge_type"]="在线网银";		
														
						break;
					default:
						$value["charge_type"]="未知";		
						break;
	
				}
				
				
				
				/*if($value["charge_status"]==2){
					$value["charge_status"]="<span style='color:red'>成功</span>";
				}else{
					$value["charge_status"]="充值中";
				}
				*/
				if($value["charge_source"]==10){
					$value["charge_source"]="wap";
				}elseif($value["charge_source"]==11){
					$value["charge_source"]="app";
				}elseif($value["charge_source"]==1){
					$value["charge_source"]="主站";
				}else{
					$value["charge_source"]="未知";
				}
				
				$all["nums"]+=$value["nums"];
				$all["totalmoney"]+=$value["totalmoney"];
				$all["nums2"]+=$value["nums2"];
				$all["totalmoney2"]+=$value["totalmoney2"];
				
				
				
				$result[] = $value;
			}
			
			$tpl -> assign('datalist',$result);
			$all["rate"] =round($all["nums"]/($all["nums"]+$all["nums2"]),4)*100;
			$tpl -> assign('all',$all);
			
			
			
			
			
			$sql ="SELECT charge_name FROM q_charge_alipay_unusual  where 1=1 group by charge_name ";	//总共充值笔数			
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query)){
				$charge_name[] = $value["charge_name"];
			}
			
			$u_id = implode(",",$charge_name);
			
			
			
		   $sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_charge  where 1=1  $where and charge_status=2 and provider='twjALIPAY' ";	//天无局支付			
			$query = $conn -> Query($sql);
			$value01 = $conn -> FetchArray($query);			
			$tpl -> assign('value01',$value01);
			
			
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_charge  where 1=1  $where and charge_status=2 and u_id in (".$u_id.") and provider='alipay' and bank_type in ('alipay','ALIPAY','twjALIPAY') ";	//指定用户充值情况			
			$query = $conn -> Query($sql);
			$value02 = $conn -> FetchArray($query);			
			$tpl -> assign('value02',$value02);
			
			
			
			
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_charge  where 1=1  $where and charge_status=2 and u_id not in (".$u_id.") and provider='alipay' and bank_type in ('alipay','ALIPAY','twjALIPAY') ";	//非指定用户充值情况			
			$query = $conn -> Query($sql);
			$value03 = $conn -> FetchArray($query);			
			$tpl -> assign('value03',$value03);
			
			
			
			
			$sql ="SELECT * FROM zhiying.admin_operate  where 1=1 and type=2 ";
			mysql_query('SET NAMES latin1');
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query)){
				 $extend  = unserialize($value["extend"]);
				  $u_name = trim($extend["u_name"]);
				 
				 $sql2 ="SELECT * FROM zhiying.user_member  where u_name like '%".$u_name."%'  "; 
				 mysql_query('SET NAMES latin1');
				 $query2 = $conn -> Query($sql2);
				 $value2 = $conn -> FetchArray($query2);
				 if(!empty($value2["u_id"])){
					  $t_u_id[] = $value2["u_id"];
				  }
				
			}
		
			$t_u_id =  implode(",",$t_u_id);
	
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log100  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) and u_id not in ($t_u_id) ";	//支付银行充值			
			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log101  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log102  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log103  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log104  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log105  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log106  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log107  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log108  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$sql ="SELECT count(*) as nums ,sum(money) as totalmoney FROM zhiying.user_account_log109  where 1=1  $where and log_type=10 and u_id not in ($t_u_id) ";	//支付银行充值			
			$query = $conn -> Query($sql);
			$value05 = $conn -> FetchArray($query);	
			$log_type_nums += $value05["nums"];
			$log_type_totalmoney += $value05["totalmoney"];
			
			$tpl -> assign('log_type_nums',$log_type_nums);

			$tpl -> assign('log_type_totalmoney',$log_type_totalmoney);
			
			
			$tpl -> display('user_charge_count.html');

			break;	

    }
	
	
	
	
	
	
	
	
	
	
	
	

?>
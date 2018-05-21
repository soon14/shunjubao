<?php
	include("config.inc.php");
	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID		

	
	
	include('checklogin.php');
	$conn2 = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");

    switch (get_param('action')){
		case 'leitai':		
			$type = get_param('type');
			$tid = intval(get_param('tid'));

			$sql = "update user_ticket_all set leitai='".$type."',combination_type='".$type."' WHERE  id='".$tid."'  ";
			
			$conn2->Query($sql);
			$res = $conn2->AffectedRows();

			if( $res > 0 )
			{
				message('操作功成！',"user_ticket_all_leitai.php");
			}else{
				message('设置出错！',"user_ticket_all_leitai.php");
			}
		
				
    	case 'recommend':		
			$type = get_param('type');
			$tid = intval(get_param('tid'));

			$sql = "update user_ticket_all set recommend='".$type."' WHERE  id='".$tid."'";
			
			$conn2->Query($sql);
			$res = $conn2->AffectedRows();

			if( $res > 0 )
			{
				message('设置成功！',"user_ticket_all.php");
			}else{
				message('设置出错！',"user_ticket_all.php");
			}
		case 'god_dan':		
				
			$id = get_param('id');
			if($id!=""){
				$where .= " and a.id='".$id."'";
				$tpl -> assign('id',$id);	
			}
			
			$combination_type = get_param('combination_type');
			if($combination_type!=""){
				$where .= " and a.combination_type='".$combination_type."'";
				$tpl -> assign('combination_type',$combination_type);	
			}
			$prize = get_param('prize');
			if($prize!=""){
				$where .= " and a.prize>0";
				$tpl -> assign('prize',$prize);	
			}
			
			
			$print_state = get_param('print_state');
			if($print_state!=""){
				$where .= " and a.print_state=1";
				$tpl -> assign('print_state',$print_state);	
			}
			
			$money = get_param('money');
			if($money!=""){
				$where .= " and money>500";
				$tpl -> assign('money',$money);	
			}
			
			$pay_rate = get_param('pay_rate');
			if($pay_rate!=""){
				$where .= " and a.pay_rate>0";
				$tpl -> assign('pay_rate',$pay_rate);	
			}
			
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}else{
				$s_date =  date("Y-m-d",time());
				$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  a.datetime<='".$e_date." 23:59:59' ";
				$tpl -> assign('e_date',$e_date);
			}
			$u_name = get_param('u_name');
			if($u_name!=''){
				$where .= " and  b.u_name like '%".$u_name."%'";
				$tpl -> assign('u_name',$u_name);
			}
		
			
			
			
			$spage = get_param('spage');
			if($spage){
				$page=1;
			}else{
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
			}
			

			//$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
		  /*  $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id  where 1 and a.combination_type=1  '.$where),0);
			$sql ='SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id where 1  and a.combination_type=1  '.$where.'  ORDER BY a.id DESC LIMIT '.$start.','.$pageSize.'';*/
				mysql_query('SET NAMES latin1');
			 $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id  where 1    '.$where),0);
			$sql ='SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id where 1    '.$where.'  ORDER BY a.id DESC LIMIT '.$start.','.$pageSize.'';
			
			//echo $sql;exit();
		//	mysqli_set_charset($conn2, "latin1");
		
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
			/*	$sql2 = "SELECT count(*) as gz_nums,sum(money) as gz_money FROM `user_ticket_all` WHERE partent_id ='".$value["id"]."'";
				$query2 = $conn2 -> Query($sql2);
				$value2 = $conn2 -> FetchArray($query2);
				$value["gz_nums"] =$value2["gz_nums"];
				$value["gz_money"] =$value2["gz_money"];*/
				//$value["money"] = "余额:".$value2["cash"].",冻结金额:".$value2["frozen_cash"].",积分:".$value2["score"].",彩金:".$value2["gift"];
				if($value["partent_id"]!=0){
					$value["partent_id"] ='<a target="_blank" href="http://www.zhiying365.com/ticket/follow/'.$value["partent_id"].'.html">'.$value["partent_id"].'</a>';
				}else{
					$value["partent_id"] ='';
				}
				if($value["prize_state"]==1){
						$value["prize_state_show"] ="<span style=color:red>中奖</span>";
				}elseif($value["prize_state"]==2){
					$value["prize_state_show"] ="未中";
				}else{
					$value["prize_state_show"] ="未开奖";
				}
				
				if($value["combination_type"]==1){
						$value["combination_type_show"] ="<span style=color:red>已晒单</span>";
				}else{
					$value["combination_type_show"] ="";
				}
				
				if($value["leitai"]==1){
						$value["leitai_show"] ="<span style=color:red>擂台</span>";
				}else{
					$value["leitai_show"] ="";
				}
				
				if($value["print_state"]==1){
						$value["print_state"] ="已出票";
				}elseif($value["print_state"]==9999){
					   $value["print_state"] ="运营投注";
				}else{
					 $value["print_state"] ="";
				}
				
				
				if($value["pay_rate"]>0){
						if($value["show_range"]==2){
							$value["show_range2"] ="跟单可见";
						}elseif($value["show_range"]==3){
							$value["show_range2"] ="截止可见";
						}else{
							$value["show_range2"] ="所有可见";
						}
						$value["pay_rate2"] =$value["pay_rate"]."%";
				}else{
					$value["pay_rate2"] ="";
				}
				
				//调出投注额20倍以上包含20倍利润的方案（不论投注额度大小）；调出投注额1万以上包含1万的中奖3倍的方案，				
				if($value["prize_state"]==1){

					
					if($value["multiple"]>20){//调出投注额20倍以上包含20倍利润的方案（不论投注额度大小）；调出投注额1万以上包含1万的中奖3倍的方案，
						$result[] = $value;
					}elseif($value["money"]>=10000){
						$result[] = $value;
					}
				}
				$all["money"] += $value["money"];
				$all["prize"] += $value["prize"];
				
			}
			
			
			
			
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'user_ticket_all.php?anction=god_dan&keywords='.$keywords.'&s_date='.$s_date.'&e_date='.$e_date.'&u_name='.$u_name.'&combination_type='.$combination_type.'&prize='.$prize.'&print_state='.$print_state.'&pay_rate='.$pay_rate.'&money='.$money);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('all',$all);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('user_ticket_all.html');
			break;
		default:
			//分页
			
			$id = get_param('id');
			if($id!=""){
				$where .= " and a.id='".$id."'";
				$tpl -> assign('id',$id);	
			}
			
			$combination_type = get_param('combination_type');
			if($combination_type!=""){
				$where .= " and a.combination_type='".$combination_type."'";
				$tpl -> assign('combination_type',$combination_type);	
			}
			$prize = get_param('prize');
			if($prize!=""){
				$where .= " and a.prize>0";
				$tpl -> assign('prize',$prize);	
			}
			
			
			$print_state = get_param('print_state');
			if($print_state!=""){
				$where .= " and a.print_state=1";
				$tpl -> assign('print_state',$print_state);	
			}
			
			$multiple = get_param('multiple');
			if($multiple!=""){
				$where .= " and a.multiple>='".$multiple."'";
				$tpl -> assign('multiple',$multiple);	
			}
			
			
			$money = get_param('money');
			if($money!=""){
				$where .= " and money>='".$money."'";
				$tpl -> assign('money',$money);	
			}
			
			$money2 = get_param('money2');
			if($money!=""){
				$where .= " and money>='".$money2."'";
				$tpl -> assign('money2',$money2);	
			}
			
			
			$prize_money = get_param('prize_money');
			if($prize_money!=""){
				$where .= " and prize>='".$prize_money."'";
				$tpl -> assign('prize_money',$prize_money);	
			}
			
			$combination = get_param('combination');
			if($combination!=""){
				$where .= " and a.combination like '%".$combination."%'";
				$tpl -> assign('combination',$combination);	
			}
			
			
			
			$pay_rate = get_param('pay_rate');
			if($pay_rate!=""){
				$where .= " and a.pay_rate>0";
				$tpl -> assign('pay_rate',$pay_rate);	
			}
			
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}else{
				$s_date =  date("Y-m-d",time());
				$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  a.datetime<='".$e_date." 23:59:59' ";
				$tpl -> assign('e_date',$e_date);
			}
			$u_name = get_param('u_name');
			if($u_name!=''){
				$where .= " and  b.u_name like '%".$u_name."%'";
				$tpl -> assign('u_name',$u_name);
			}
		
			
			
			
			$spage = get_param('spage');
			if($spage){
				$page=1;
			}else{
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
			}
			

			//$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
		  /*  $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id  where 1 and a.combination_type=1  '.$where),0);
			$sql ='SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id where 1  and a.combination_type=1  '.$where.'  ORDER BY a.id DESC LIMIT '.$start.','.$pageSize.'';*/
			 mysql_query('SET NAMES latin1');
			 $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id  where 1    '.$where),0);
			$sql ='SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id where 1    '.$where.'  ORDER BY a.id DESC LIMIT '.$start.','.$pageSize.'';
			
			//echo $sql;exit();
		//	mysqli_set_charset($conn2, "latin1");
		
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
			/*	$sql2 = "SELECT count(*) as gz_nums,sum(money) as gz_money FROM `user_ticket_all` WHERE partent_id ='".$value["id"]."'";
				$query2 = $conn2 -> Query($sql2);
				$value2 = $conn2 -> FetchArray($query2);
				$value["gz_nums"] =$value2["gz_nums"];
				$value["gz_money"] =$value2["gz_money"];*/
				//$value["money"] = "余额:".$value2["cash"].",冻结金额:".$value2["frozen_cash"].",积分:".$value2["score"].",彩金:".$value2["gift"];
				if($value["partent_id"]!=0){
					$value["partent_id"] ='<a target="_blank" href="http://www.zhiying365.com/ticket/follow/'.$value["partent_id"].'.html">'.$value["partent_id"].'</a>';
				}else{
					$value["partent_id"] ='';
				}
				if($value["prize_state"]==1){
						$value["prize_state_show"] ="<span style=color:red>中奖</span>";
				}elseif($value["prize_state"]==2){
					$value["prize_state_show"] ="未中";
				}else{
					$value["prize_state_show"] ="未开奖";
				}
				
				if($value["combination_type"]==1){
						$value["combination_type_show"] ="<span style=color:red>已晒单</span>";
				}else{
					$value["combination_type_show"] ="";
				}
				
				if($value["leitai"]==1){
						$value["leitai_show"] ="<span style=color:red>擂台</span>";
				}else{
					$value["leitai_show"] ="";
				}
				
				if($value["print_state"]==1){
						$value["print_state"] ="已出票";
				}elseif($value["print_state"]==9999){
					   $value["print_state"] ="运营投注";
				}else{
					 $value["print_state"] ="";
				}
				
				
				if($value["pay_rate"]>0){
						if($value["show_range"]==2){
							$value["show_range2"] ="跟单可见";
						}elseif($value["show_range"]==3){
							$value["show_range2"] ="截止可见";
						}else{
							$value["show_range2"] ="所有可见";
						}
						$value["pay_rate2"] =$value["pay_rate"]."%";
				}else{
					$value["pay_rate2"] ="";
				}
				
				$all["money"] += $value["money"];
				$all["prize"] += $value["prize"];
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'user_ticket_all.php?1=1&keywords='.$keywords.'&s_date='.$s_date.'&e_date='.$e_date.'&u_name='.$u_name.'&combination_type='.$combination_type.'&prize='.$prize.'&print_state='.$print_state.'&pay_rate='.$pay_rate.'&money='.$money.'&multiple='.$multiple.'&money2='.$money2.'&prize_money='.$prize_money.'&combination='.$combination);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('all',$all);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('user_ticket_all.html');

			break;	

    }
	


	
?>
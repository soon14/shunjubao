<?php
	include("config.inc.php");
	include('checklogin.php');
	$tpl -> assign('adminname',$_SESSION["real_name"]);//管理员名称	

	$filename= substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],"/")+1); 
	$tpl -> assign('filename',$filename);	

	$tpl -> assign('user_charge',showbasiclist('user_charge',0));

	
	$user_charge = get_param('user_charge');
	
	$charge_mark = get_param('charge_mark');
	$charge_name = get_param('charge_name');
	$tdesc = get_param('tdesc');

	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID	

	
    switch (get_param('action')){
    	case 'add':
		
			$tpl -> display('user_charge_add.html');
			break;			
		case 'add_action':

				$arr = array(
					"user_charge"=>"'$user_charge'",
					"charge_name"=>"'$charge_name'",
					"charge_mark"=>"'$charge_mark'",
					"tdesc"=>"'$tdesc'",
					"addid"=>"'$adminid'",
					"addip"=>"'$ip'",
					"addtime"=>"'$dtime'"		
				);
				
			//	print_r($arr);die();
				$res = add_record($conn, "user_charge_list", $arr);
				
				if($res['rows'] <= 0)
				{
					message('添加失败！',$filename);
					exit();
				}else{
					admin_log($conn,$_SESSION['username'],$_SESSION['username'].'添加支付帐号内容('.$res['id'].')');	
					message('添加成功!',$filename);
					exit();

				}

			break;
			
		case 'up':
				$sysid = get_param('sysid');
				
				$up_user_charge = get_param('up_user_charge');
				
				$arr = array(
					"is_used"=>"'1'",
					"modtime"=>"'$dtime'",
					"modip"=>"'$ip'"		
				);

				$res = update_record($conn, "user_charge_list", $arr, "and sysid = $sysid and user_charge=$up_user_charge ");
				
				$arr = array(
					"is_used"=>"'0'",
					"modtime"=>"'$dtime'",
					"modip"=>"'$ip'"		
				);

				$res = update_record($conn, "user_charge_list", $arr, "and sysid != $sysid and user_charge=$up_user_charge");
				
				if( $res > 0){
					admin_log($conn,$_SESSION['username'],$_SESSION['username'].'设置当前在用支付方式('.$sysid.')');	
					message('成功修改资料',$filename);
					exit();
				}else{
					message('修改信息出错！',$filename);
					exit();	
				}
			
		case 'update':
		
			 	$sysid = get_param('sysid');
				$arr = array(
					"user_charge"=>"'$user_charge'",
					"charge_name"=>"'$charge_name'",
					"charge_mark"=>"'$charge_mark'",
					"tdesc"=>"'$tdesc'",
					"modtime"=>"'$dtime'",
					"modip"=>"'$ip'"		
				);

				$res = update_record($conn, "user_charge_list", $arr, "and sysid = $sysid");
				$query = $conn -> Query($usql);
				
				if( $res > 0){
					admin_log($conn,$_SESSION['username'],$_SESSION['username'].'修改支付帐号数据Id('.$sysid.')');	
					message('成功修改资料',$filename);
					exit();
				}else{
					message('修改信息出错！',$filename);
					exit();	
				}
			
		
			break;

		case 'edit':
			$sysid = get_param('sysid');
			
			$sql = "SELECT *  FROM ".tname("user_charge_list")."  where sysid = ".$sysid." limit 0,1";
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);
			
			$value["user_charge"]=showbasiclist('user_charge', $value["user_charge"]);
			
			$tpl -> assign('value', $value);
			$tpl -> display('user_charge_edit.html');
			break;
    	case 'delete':
			//doid＝1 时为删除资料，待用
			
			$fields = array('sysid');
			if(get_param('doid')==1){//删除多个
				$values = " and sysid in(".get_param('sysid')."0) ";
				$res = delete_more_record($conn, "user_charge_list",$values);	
			}else{
				$values = array(intval(get_param('sysid')));	
				$res = delete_record( $conn, "user_charge_list", $fields, $values);
			}
			if($res>0)
			{
				admin_log($conn,$_SESSION['username'],$_SESSION['username'].'删除支付帐号资料Id('.get_param('sysid').')');	
				message('删除成功！',$filename);
				exit();
			}else{
				message('删除失败!',$filename);
				exit();
			}
    		break;

		default:
			//分页
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			
		
			$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("user_charge_list")."  where 1=1 $where "),0);
			$sql ="SELECT *  FROM ".tname("user_charge_list")."  where 1=1 $where ORDER BY charge_mark desc LIMIT ".$start.",".$pageSize;			
			
		
	
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				
				if($value["is_used"]==1){
					$value["is_used"]="在用";	
				}else{
					$value["is_used"]=" ";	
				}
				$value["up_user_charge"]=$value["user_charge"];	
				$value["user_charge"] = show_basicname("user_charge",$value["user_charge"]);	
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,$filename.'?1=1');

			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('datalist', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('user_charge_list.html');

			break;	

    }

?>
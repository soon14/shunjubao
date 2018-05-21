<?php
	include("config.inc.php");
	include('checklogin.php');
	$tablename = "bascdata";//表名
	

    switch (get_param('action')){
    	case 'add':
			$tpl -> display('bascdata_add.html');
			break;
		case 'add_action':
			$tname = get_param('tname');//名称
			$ttype = get_param('ttype');//类型(单选1，多选2，下拉3)		
			$ttag = get_param('ttag');//中文标记
			$tdesc = get_param('tdesc');//备注说明
			$tstatus = get_param('tstatus');//1,可用，0不可用
			$ip = get_ip();//获取IP
			$dtime = time();//当时时间
			$adminid = $_SESSION["adminid"];//管理员ID
			
			$arr = array(
				"tname"=>"'$tname'",
				"ttype"=>"'$ttype'",
				"ttag"=>"'$ttag'",
				"tdesc"=>"'$tdesc'",
				"tstatus"=>"'$tstatus'",
				"addid"=>"'$adminid'",
				"addtime"=>"'$dtime'",
				"addip"=>"'$ip'",
			);
			//print_r($arr);die();
			$res = add_record( $conn, $tablename, $arr);
			
			if($res['rows'] <= 0)
			{
				message('添加失败！','bascdata_list.php');
				exit();
			}else{
				message('添加成功!','bascdata_list.php');
				exit();
			}
			
			break;
			
		case 'update':
			$sysid = get_param('sysid');//id
			$tname = get_param('tname');//名称
			$ttype = get_param('ttype');//类型(单选1，多选2，下拉3)		
			$ttag = get_param('ttag');//中文标记
			$tdesc = get_param('tdesc');//备注说明
			$tstatus = get_param('tstatus');//1,可用，0不可用
			$ip = get_ip();//获取IP
			$dtime = time();//当时时间
			$adminid = $_SESSION["adminid"];//管理员ID
			
			$arr = array(
				"tname"=>"'$tname'",
				"ttype"=>"'$ttype'",
				"ttag"=>"'$ttag'",
				"tdesc"=>"'$tdesc'",
				"tstatus"=>"'$tstatus'",
				"modid"=>"'$adminid'",
				"modtime"=>"'$dtime'",
				"modip"=>"'$ip'"
			);
			//print_r($arr);die();
			$res = update_record( $conn, $tablename, $arr, "and sysid = $sysid");
			$query = $conn -> Query($usql);
			
			if( $res > 0){
				message('成功修改资料','bascdata_list.php');	
				exit();		
			}else{
				message('修改资料出错','bascdata_list.php');	
				exit();	
			}

			break;

		case 'edit':
			$adid = get_param('sysid');
			$sql = "SELECT * FROM ".tname($tablename)." where sysid = ".$adid;
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);

			$tpl -> assign('sysid', $value["sysid"]);
			$tpl -> assign('tname', $value["tname"]);
			$tpl -> assign('ttype', $value["ttype"]);
			$tpl -> assign('ttag', $value["ttag"]);
			$tpl -> assign('tdesc', $value["tdesc"]);
			
			
			$tpl -> assign('tstatus', $value["tstatus"] == "1" ? "checked" : "");

			$tpl -> display('bascdata_edit.html');
			break;
    	case 'delete':
			//doid＝1 时为删除资料，待用
			
			$fields = array('sysid');
			if(get_param('doid')==1){//删除多个
				$values = " and sysid in(".get_param('sysid')."0) ";
				$res = delete_more_record($conn, $tablename,$values);	
			}else{
				$values = array(intval(get_param('sysid')));	
				$res = delete_record( $conn, $tablename, $fields, $values);		
			}
			if($res>0)
			{
				message('删除成功！',"bascdata_list.php");
				exit();
			}else{
				message('删除失败!',"bascdata_list.php");
				exit();
			}
    		break;

		case 'search':
	
			$where = ' 1=1';
			$keywords = get_param('keywords');
		
			if( $keywords!= '')
			{
				$where .= " and ( tname like '%".$keywords."%' or ttag like '%".$keywords."%' )";
			}
			$tpl -> assign('keywords', $keywords);
		
			$sql ='SELECT * FROM '.tname($tablename).' where 1=1 and '.$where.' ORDER BY sysid DESC';
			//echo $sql;die();
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				
				$result[] = $value;
			}
			
			$tpl -> assign('datalist', $result);
			
			$tpl -> display('bascdata_list.html');
			break;
		default:
			//分页
		
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			//记录总数
	
		 	$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname($tablename)." where 1=1"),0);
			
	
			$sql ="SELECT * FROM ".tname($tablename)." where 1=1  ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;
			//print_r($sql);exit();
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				if($value["modid"]!=""){
					//$value["addid"]=$value["modid"];
					$value["modtime"]=$value["modtime"];					
				}
				$result[] = $value;
			}
			
			
			$multi = multi($totalRecord,$pageSize,$page,'bascdata_list.php?1=1');
			//print_r($totalRecord);die();
	
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('datalist', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('bascdata_list.html');

			break;	

    }

?>
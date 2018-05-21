<?php
	include("config.inc.php");
	include('checklogin.php');
	$tablename = "bascdata_value";//表名
		

	$bd_id = get_param('bd_id');//添加列表值的对应ID	
	if($bd_id=="" && get_param('doid')!=1){
		//message('分类ID不能不空！','bascdata_list.php');
		Redirect("bascdata_list.php");
		exit();
	}else{
		$tpl -> assign('bd_id',$bd_id);//添加列表值的对应ID
	}

	$tvalue = get_param('tvalue');//列表值
	$sysid = get_param('sysid');//系统ID	
	$tname = get_param('tname');//列表值	
	$tvalue2 = get_param('tvalue2');//光斑值
	$orderby = get_param('orderby');//排序	
	$tdesc = get_param('tdesc');//备注说明
	$tstatus = get_param('tstatus');//1,可用，0不可用

	$arr = array(
		"bd_id"=>"'$bd_id'",
		"tvalue"=>"'$tvalue'",
		"tvalue2"=>"'$tvalue2'",
		"orderby"=>"'$orderby'",
		"tname"=>"'$tname'",
		"tdesc"=>"'$tdesc'",
		"tstatus"=>"'$tstatus'"
	);	
		
		
    switch (get_param('action')){
	
		case 'search':
		
			$bd_id = get_param('bdid');
			$where = " 1=1 and bd_id='".$bd_id."' ";
			
			$keywords = get_param('keywords');
		
			if( $keywords!= '')
			{
				$where .= " and ( tname like '%".$keywords."%' )";
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
			
			$tpl -> display('bascdata_value_list.html');
			break;

	
	
    	case 'add':
			$tpl -> display('bascdata_value_add.html');
			break;
		case 'add_action':
			$res = add_record( $conn, $tablename, $arr);
			
			if($res['rows'] <= 0)
			{
				message('添加失败！','bascdata_value.php?bd_id='.$bd_id);
				exit();
			}else{
				message('添加成功!','bascdata_value.php?bd_id='.$bd_id);
				exit();
			}
			
			break;
			
		case 'update':
			$sysid = get_param('sysid');
			
			$res = update_record( $conn, $tablename, $arr, "and sysid = $sysid");
			$query = $conn -> Query($usql);
			
			if( $res > 0){
				message('成功修改资料','bascdata_value.php?bd_id='.$bd_id);	
				exit();		
			}else{
				message('修改资料出错','bascdata_value.php?bd_id='.$bd_id);
				exit();
			}

			break;

		case 'edit':
			
			$sql = "SELECT * FROM ".tname($tablename)." where sysid = ".$sysid;
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);

			$tpl -> assign('bd_id', $value["bd_id"]);//上级ID
			$tpl -> assign('sysid', $value["sysid"]);//本记录ID
			$tpl -> assign('tname', $value["tname"]);
			$tpl -> assign('tvalue', $value["tvalue"]);
			$tpl -> assign('tvalue2', $value["tvalue2"]);	
			$tpl -> assign('orderby', $value["orderby"]);
			$tpl -> assign('tdesc', $value["tdesc"]);
			$tpl -> assign('tstatus', $value["tstatus"] == "1" ? "checked" : "");

			$tpl -> display('bascdata_value_edit.html');
			break;
    	case 'delete':
			//doid＝1 时为删除资料，待用
			//die("dfdfdf");
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
				message('删除成功！',"bascdata_value.php?bd_id=".$bd_id);
				exit();
			}else{
				message('删除失败!',"bascdata_value.php?bd_id=".$bd_id);
				exit();
			}

			break;
		default:
		
			$wheres = " and bd_id='$bd_id'";
						//分页
			
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			//记录总数
	
		 	$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname($tablename)." where 1=1 $wheres"),0);
	
	
			$sql ="SELECT * FROM ".tname($tablename)." where 1=1  $wheres ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;
			//print_r($sql);exit();
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'bascdata_value.php?1=1&bd_id='.$bd_id);
			

			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('datalist', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('bascdata_value_list.html');

			break;	

    }

?>
<?php
	include("config.inc.php");
	include('checklogin.php');
	
	$tablename="post_member";
	
	
	
		
    switch (get_param('action')){
	
		case 'update':
		$isman = get_param('isman');
		$id = get_param('id');
		   $usql = "update ".tname($tablename)." set isman='".$isman."' where id = ".$id;
			$query = $conn -> Query($usql);
			if($query){
				message('操作成功');			
			}else{
			
				message('操作出错');		
			}

			break;
	
    	case 'delete':
			
			$fields = array( 'id');
			$values = array( intval(get_param('id')) );
    		$res = delete_record( $conn, $tablename, $fields, $values);
			
			if( $res > 0 )
			{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'删除了护腕（id）:'.$_REQUEST['id']);
				message('删除成功！');
			}else{
				message('删除失败!');
			}

    		break;
		default:
			//分页
			
			$quan = get_param('quan');
			$tpl -> assign('quan',showbasiclist('quan',$quan));
			
			
			if($quan>0){
				$where .= " and qid='".$quan."' ";
			}
			
			$keywords = get_param('keywords');
			if($keywords!=""){
				$where .= " and (u_name like'%".$keywords."%' or u_nick like'%".$keywords."%' )";
				$tpl -> assign('keywords',$keywords);//促销顾客	
			}
			$isman = get_param('isman');
			if($isman>0){
				$where .= " and isman='1' ";
				$tpl -> assign('mancheck',1);//促销顾客	
			}
			
			
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
			
		 	$totalRecord = $conn -> NumRows($conn -> Query('SELECT COUNT(*) FROM '.tname($tablename).' where 1   '.$where),0);
			$sql ='SELECT * FROM '.tname($tablename).' where 1  '.$where.'  ORDER BY id DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				$value["qid"] = show_basicname("quan",$value["qid"]);	
				if($value["isman"]==1){
					$value["isman_show"]="是";
				}else{
					$value["isman_show"]=" ";
				}
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'quan_member.php?1=1&app='.$app);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('quan_member.html');

			break;	

    }

?>
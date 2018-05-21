<?php
	include("config.inc.php");
	include('checklogin.php');
	
	$tablename="post";
	
	
	
		
    switch (get_param('action')){
	
		case 'update':
		$istop = get_param('istop');
		$id = get_param('id');
		$qid = get_param('qid');
		//置顶并排到第一位
		if($istop==1){
			
			$sql = "SELECT * FROM   ".tname($tablename)."  where  qid='".$qid."' order by orderby desc limit 0,1   ";
			$query = $conn->Query($sql);
			$value = $conn -> FetchArray($query);
			
			$order_nums = $value["orderby"]+1;
			
	 		 $usql = "update ".tname($tablename)." set istop='".$istop."' ,orderby='".$order_nums."'  where id = ".$id;
			
			
		}else{
			 $usql = "update ".tname($tablename)." set istop='".$istop."' where id = ".$id;
		}
			
			
		
		
		  
			$query = $conn -> Query($usql);
			if($query){
				message('操作成功');			
			}else{
			
				message('操作出错');		
			}

			break;
	
    	case 'delete':
			
			$fields = array( 'id');
			$values = array(intval(get_param('id')) );
    		$res = delete_record( $conn, $tablename, $fields, $values);
			
			if( $res > 0 )
			{
	
	
				$usql = " delete from ".tname("post_reply")."  where postid = ".get_param('id');
				$query = $conn -> Query($usql);
	
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
				$where .= " and q_content like'%".$keywords."%' ";
				$tpl -> assign('keywords',$keywords);//促销顾客	
			}
			$istop = get_param('istop');
			if($istop>0){
				$where .= " and istop='1' ";
				$tpl -> assign('topcheck',1);//促销顾客	
			}
			
			
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
			
		 	$totalRecord = $conn -> NumRows($conn -> Query('SELECT COUNT(*) FROM '.tname($tablename).' where 1   '.$where),0);
			$sql ='SELECT * FROM '.tname($tablename).' where 1  '.$where.'  ORDER BY orderby desc,id DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				$value["qid_name"] = show_basicname("quan",$value["qid"]);	
				
				if($value["istop"]==1){
					$value["istop_show"]="是";
				}else{
					$value["istop_show"]=" ";
				}
				$value["postnums"]=show_post_nums($value["id"]);
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'quan_post.php?1=1&app='.$app);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('quan_post.html');

			break;	

    }

?>
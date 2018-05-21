<?php
	include("config.inc.php");
	include('checklogin.php');
	
	$tablename="post_reply";
	
    switch (get_param('action')){
	

	
    	case 'delete':
			
			$fields = array( 'id');
			$values = array(intval(get_param('id')) );
    		$res = delete_record( $conn, $tablename, $fields, $values);
			
			if( $res > 0 )
			{
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
				
					$sql ="SELECT * FROM ".tname("post")." where id='".$value["postid"]."'    LIMIT 0,1";
					$query = $conn -> Query($sql);
					$quan_tizhi = $conn -> FetchArray($query);
					$value["post_dtime"] = $quan_tizhi["dtime"];
					$value["post_content"] = $quan_tizhi["q_content"];
					
					
			
				$value["qid"] = show_basicname("quan",$value["qid"]);	
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'quan_post_reply.php?1=1&app='.$app);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('post_reply.html');

			break;	

    }

?>
<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$userInfo = Runtime::getUser();

#标题
$TEMPLATE ['title'] = "智赢网竞彩专家";
$TEMPLATE['keywords'] = '智赢竞彩投注,竞彩投注,竞彩篮球投注,竞彩足球投注。';
$TEMPLATE['description'] = '智赢网竞彩专家。';
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];


$tpl = new Template();


include_once ("config.inc.php");

switch (get_param('action')){
	
		case "zj":
				//$page = empty($_GET['page'])? 1:intval($_GET['page']);
				//if($page < 1) $page = 1;
				//$start = ($page - 1) * $pageSize;
				
				//$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("booking")." where   u_id='".$u_id ."' and booktype>1 "),0);
				 $sql ="SELECT *  FROM ".tname("booking")."  where  u_id='".$u_id ."' and booktype>1 ";	
				
				$query = $conn -> Query($sql);
				while($value = $conn -> FetchArray($query)){

					 $idlist .= show_recommond_id($value["e_id"],$value["addtime"],$value["end_time"]);

				}
				
				 $idlist =  $idlist."0";
			
				 
						$page = empty($_GET['page'])? 1:intval($_GET['page']);
						if($page < 1) $page = 1;
						$start = ($page - 1) * $pageSize;
						
						$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("recommond")." where    sysid in(".$idlist.") "),0);
					  	$sql ="SELECT *  FROM ".tname("recommond")."  where   sysid in(".$idlist.") ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;			
					
			
						$query = $conn -> Query($sql);
						while($value = $conn -> FetchArray($query)){
							
							$bookinfo = show_recommond_booking($u_id,$value["u_id"]);
							
							
							
							
							$value["e_nick"] = $bookinfo["e_nick"];
							$value["bookid"] = $bookinfo["sysid"];
							$value["booking_money"] = $bookinfo["booking_money"];
							
							if($bookinfo["booktype"]==1){
								$value["booktype_status"]="单场推荐";	
							}elseif($bookinfo["booktype"]==2){
								
								$value["booktype_status"]="订阅一周";		
							}elseif($bookinfo["booktype"]==3){
								
								$value["booktype_status"]="订阅一个月";	
							}
									
							$value["addtime"] = $bookinfo["addtime"];
							$value["end_time"] = $bookinfo["end_time"];
							//	print_r($bookinfo["bookid"]);die();
							
							$result[] = $value;
						}
						
						//print_r($result);die();
						$multi = multi($totalRecord,$pageSize,$page,"user_booking.php?action=zj");
						$tpl -> assign('multi',$multi);
						$tpl -> assign('pageSize',$pageSize);
						$tpl -> assign('totalRecord',$totalRecord);
						$tpl -> assign('datalist', $result);
						$tpl -> assign('page',ceil($totalRecord/$pageSize));
				
				$YOKA ['output'] = $tpl->r ('zhuanjia/user_booking_zj');
				
				break;	
	
	
		default:
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
				if($page < 1) $page = 1;
				$start = ($page - 1) * $pageSize;
				
				$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("booking")." where   u_id='".$u_id ."'  and booktype=1"),0);
				$sql ="SELECT *  FROM ".tname("booking")."  where  u_id='".$u_id ."'  and booktype=1 ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;			
				
				
				$objUserMemberFront = new UserMemberFront();
				
				$query = $conn -> Query($sql);
				while($value = $conn -> FetchArray($query)){
					
					
					$u_name = $info['u_name'];//用户名称，非操作者
					$user = $objUserMemberFront->getByName($u_name);

					
					$recommond = show_recommond($value["bookid"]);
					$value["pubdate"] = $recommond["pubdate"];
					$value["macth"] = $recommond["macth"];
					$value["duiwu"] = $recommond["duiwu"];
					$value["recommond"] = $recommond["recommond"];
		
					
					if($value["booktype"]==1){
						$value["booktype_status"]="单场推荐";	
					}elseif($value["booktype"]==2){
						$value["booktype_status"]="订阅一周";		
					}elseif($value["booktype"]==3){
						$value["booktype_status"]="订阅一个月";	
					}

					$result[] = $value;
				}
				
				if(empty($result)){
					$error_tips = " 未订阅,点击<a href='http://www.shunjubao.xyz/zhuanjia/' target='_blank'>订阅</a>";	
					$tpl -> assign('error_tips',$error_tips);
				}
				
				//print_r($result);die();
				$multi = multi($totalRecord,$pageSize,$page,"user_booking.php?1=1");
				$tpl -> assign('multi',$multi);
				$tpl -> assign('pageSize',$pageSize);
				$tpl -> assign('totalRecord',$totalRecord);
				$tpl -> assign('datalist', $result);
				$tpl -> assign('page',ceil($totalRecord/$pageSize));
				$YOKA ['output'] = $tpl->r ('zhuanjia/user_booking');
				break;	

}
		


echo_exit ( $YOKA ['output'] );

function show_recommond_booking($uid,$eid){
	global $conn;	
	 $sql = "SELECT * FROM  ".tname("booking")."  where   u_id='".$uid."'  and e_id='".$eid."'   ";
	$query = $conn->Query($sql);
	$value = $conn -> FetchArray($query);
	
	return $value;	
}



function show_recommond_id($eid,$s_date,$e_date){
	global $conn;	
	$s_date = date("Y-m-d",strtotime($s_date));
	$e_date = date("Y-m-d",strtotime($e_date));
	
	$sql = "SELECT * FROM  ".tname("recommond")."  where  u_id='".$eid."'  and  DATE_FORMAT(out_time,'%Y-%m-%d')>='$s_date' and DATE_FORMAT(addtime,'%Y-%m-%d')<='$e_date'  ";
	
	

	$query = $conn->Query($sql);
	while($value = $conn -> FetchArray($query)){
		$r .= $value["sysid"].",";
	}

	return $r;	
}


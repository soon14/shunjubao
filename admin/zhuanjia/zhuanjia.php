<?php
/**
 * 查询用户投注情况
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$tpl = new Template();

include_once ("zjconfig.inc.php");

	
	switch (get_param('action')){
		
		
		case'order':
		
				$sysid = get_param('sysid');
				
				$add = get_param('add');
				$desc = get_param('desc');
				$first = get_param('first');
				
				$sql ="SELECT orderby  FROM ".tname("shengqing")."  where  sysid = $sysid";			
				
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
				$myorder = $value["orderby"];
				
				
				if($add==1){//向前1位
					$sql ="SELECT orderby  FROM ".tname("shengqing")."  where  sysid != $sysid and orderby>=$myorder order by orderby  desc limit 0,1";		
					$query = $conn -> Query($sql);
					$value = $conn -> FetchArray($query);
					if($value["orderby"]){
						$myorder  = 	$value["orderby"]+1;		
					}
				
				
				}
				
				
				if($desc==1){
					
					$sql ="SELECT orderby  FROM ".tname("shengqing")."  where  sysid != $sysid and orderby<=$myorder order by orderby  desc limit 0,1";		
					$query = $conn -> Query($sql);
					$value = $conn -> FetchArray($query);
					if($value["orderby"]){
						$myorder  = 	$value["orderby"]-1;		
					}
					
					
				}
				
				if($first==1){
					
					$sql ="SELECT orderby  FROM ".tname("shengqing")."  where  sysid != $sysid order by orderby  desc limit 0,1";		
					$query = $conn -> Query($sql);
					$value = $conn -> FetchArray($query);
					$myorder  = 	$value["orderby"]+1;	
					
					
				}
				
				
				
				$arr = array(
					"orderby"=>"'$myorder'"			
				);
				$res = update_record($conn, "shengqing", $arr, "and sysid = $sysid");
				$query = $conn -> Query($usql);
				if( $res > 0){
	
					Redirect("zhuanjia.php");
				//	message('操作成功','zhuanjia.php');
					exit();
				}else{
					fail_exit("操作出错");
				//	message('操作出错！','zhuanjia.php');
					exit();	
				}
			break;
		
		case'iscommon':
				$iscommon = get_param('iscommon');
			 	$sysid = get_param('sysid');
				$arr = array(
					"iscommon"=>"'$iscommon'"			
				);
				$res = update_record($conn, "shengqing", $arr, "and sysid = $sysid");
				$query = $conn -> Query($usql);
				if( $res > 0){
					Redirect("zhuanjia.php");
					exit();
				}else{
				fail_exit("操作出错");
					exit();	
				}
			break;
		
		
		case'sh':
				$ifuse = get_param('ifuse');
			 	$sysid = get_param('sysid');
				$arr = array(
					"ifuse"=>"'$ifuse'"			
				);
				$res = update_record($conn, "shengqing", $arr, "and sysid = $sysid");
				$query = $conn -> Query($usql);
				if( $res > 0){
						Redirect("zhuanjia.php");
					exit();
				}else{
					fail_exit("操作出错");
					exit();	
				}
			break;
		
		default:
		//分页
		$page = empty($_GET['page'])? 1:intval($_GET['page']);
		if($page < 1) $page = 1;
		$start = ($page - 1) * $pageSize;
		
		$u_name = get_param('u_name');
		if($u_name){
			
			$where = " and  (u_name like '%".$u_name."%' or  mobile like '%".$u_name."%') ";
			$tpl -> assign('u_name',$u_name);
		}
		
		
		
		$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("shengqing")." where 1 $where"),0);
		$sql ="SELECT *  FROM ".tname("shengqing")."  where 1 $where ORDER BY orderby DESC LIMIT ".$start.",".$pageSize;			
		
		
		$query = $conn -> Query($sql);
		while($value = $conn -> FetchArray($query)){
			
			if($value["ifuse"]==1){
				$value["ifuse_status"]="已通过";	
			}elseif($value["ifuse"]==2){
				$value["ifuse_status"]="未通过";		
			}else{
				$value["ifuse_status"]="审核中";	
			}
			
			if($value["iscommon"]==1){
				$value["iscommon_status"]="是";		
			}else{
				$value["iscommon_status"]="否";	
			}
			
			 $value["show_sqsc"] =cut_str($value["sqsc"],3);
			
			 $value["show_desc"] =cut_str($value["ddesc"],3);
			$result[] = $value;
		}
		
		//print_r($result);die();
		$multi = multi($totalRecord,$pageSize,$page,"zhuanjia.php?1=1");
		break;	

    }

	$tpl -> assign('multi',$multi);
	$tpl -> assign('pageSize',$pageSize);
	$tpl -> assign('totalRecord',$totalRecord);
	$tpl -> assign('datalist', $result);
	$tpl -> assign('page',ceil($totalRecord/$pageSize));

$YOKA ['output'] = $tpl->r ('../admin/zhuanjia/zhuanjia');
echo_exit ( $YOKA ['output'] );
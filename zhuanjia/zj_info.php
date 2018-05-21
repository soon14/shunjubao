<?php
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$refer = Request::getReferer();
$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];
$tpl = new Template ();
$TEMPLATE ['title'] = "专家申请资料 - ";
$tpl->assign ('refer',$refer );
include_once ("config.inc.php");



$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

switch (get_param('action')){

		   case 'update':
		   		$sqsc = get_param('sqsc');
				$ddesc = get_param('ddesc');	
				$week_money = intval(get_param('week_money'));
				$month_money = intval(get_param('month_money'));
				
				if($week_money<1 || $month_money<1){
					message('金额不能小于1元！','zj_info.php');
					exit();	
				}
				
				
			$sql ="update ".tname("shengqing")." set sqsc='".$sqsc."',ddesc='".$ddesc."',week_money='".$week_money."',month_money='".$month_money."' where eid='".$u_id ."'   ";			
			
			$res = $conn -> Query($sql);
			if( $res > 0 )
			{
				message('修改成功！','zj_info.php');
				exit();
				
			}else{
				message('修改出错!','zj_info.php');
				exit();
				
			}
		    break;
			default:
				$sql ="SELECT * FROM ".tname("shengqing")."   where 1  and eid='".$u_id."'  LIMIT 1";			
			
				
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
				if(empty($value["sysid"])){
						$tpl -> assign('not_shengqing', 1);
				}else{
				
					if($value["ifuse"]==1){
						$value["ifuse_s"]="已通过";		
					}else{
						$value["ifuse_s"]="未审核";		
					}
				
				
				if($value["iscommon"]==1){
						$value["iscommon_s"]="推荐";		
				}else{
					$value["iscommon_s"]="未推荐";		
				}
				
				
					$tpl -> assign('value', $value);		
				}
		   break;	
		   
}
			

	

$YOKA ['output'] = $tpl->r ('zhuanjia/zj_info');

echo_exit ( $YOKA ['output'] );




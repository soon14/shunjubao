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


		//分页
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
				if($page < 1) $page = 1;
				$start = ($page - 1) * $pageSize;
				
				$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("booking")." where  1 "),0);
				$where = '1=1';
				$u_name = Request::r('u_name');
				if ($u_name) {
					$where .= " and `e_name`='".$u_name."'";
				}
				$sql ="SELECT *  FROM ".tname("booking")."  where  {$where} ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;			
				
				$objUserMemberFront = new UserMemberFront();
				
				$query = $conn -> Query($sql);
				while($value = $conn -> FetchArray($query)){
					
					$user = $objUserMemberFront->getByName($value["e_name"]);
					$value["e_name"]=$user['u_name'];

					//$recommond = show_recommond($value["bookid"]);
					$my_money +=$value["booking_money"];

					if($value["booktype"]==1){
						$value["booktype_status"]="单场推荐";	
					}elseif($value["booktype"]==2){
						$value["booktype_status"]="订阅一周";		
					}else{
						$value["booktype_status"]="订阅一个月";	
					}

					$result[] = $value;
				}
				
				if(empty($result)){
					$error_tips = " 未订阅,点击<a href='http://www.zhiying365.com/zhuanjia/' target='_blank'>订阅</a>";	
					$tpl -> assign('error_tips',$error_tips);
				}
				
				//print_r($result);die();
				$multi = multi($totalRecord,$pageSize,$page,"zhuanjia_dinyue.php?1=1");
		$sql ="SELECT count(*) as nums  FROM ".tname("booking")."  where  1 group by e_id";			
		$query = $conn -> Query($sql);
		$value = $conn -> FetchArray($query);
		
		$tpl -> assign('my_nums',$value["nums"]);
		$tpl -> assign('my_money',$my_money);
	
	$tpl -> assign('multi',$multi);
	
	
	$tpl -> assign('pageSize',$pageSize);
	$tpl -> assign('totalRecord',$totalRecord);
	$tpl -> assign('datalist', $result);
	$tpl -> assign('page',ceil($totalRecord/$pageSize));

$YOKA ['output'] = $tpl->r ('../admin/zhuanjia/zhuanjia_dinyue');
echo_exit ( $YOKA ['output'] );
<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
ini_set('memory_limit', '-1');
$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$tpl = new Template();

$field = 'addtime';
$order = $field. ' desc';


//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

$condition = array();
//$pool = Request::r('pool');


$searchDaletouFront = new Daletouset();
$start_time='';
$end_time='';

$url=ROOT_DOMAIN."/admin/order/daletou_set_num.php";
if(Request::r('action')=='add'){
	$info['qishu'] = Request::r('qishu');
	$a = $searchDaletouFront->get_set_one($info);
	$now =$_POST['now'][0];
	if($a){
		echo "已经录入";
		die;
	}
	$info['qianqu'] = implode(",",$_POST['qianqu']);
	$info['houqu'] = implode(",",$_POST['houqu']);
	$info['j1'] = Request::r('j1');// 1等
	$info['j2'] = Request::r('j2');// 2等
	$info['j3'] = Request::r('j3');// 3等
	$info['j4'] = Request::r('j4');// 4等
	$info['j5'] = Request::r('j5');// 5等
	$info['j6'] = Request::r('j6');// 6等
	$info['now'] = $now;
	if($now==1){
		$where=array();
		$searchDaletouFront->updateset();
	}
	$id = $searchDaletouFront->add($info);
	if($id>0){
		$url=ROOT_DOMAIN."/admin/order/daletou_set_num.php";
		header("Location:$url");
	}else{
		//echo "<script>window.location.href='".ROOT_DOMAIN."/admin/order/daletou_set_num.php'</script>";
		header("Location:$url");
		die;
	}
}
if(Request::r('action')=='del'){
	$info['d_id'] = Request::r('d_id');
	$a = $searchDaletouFront->del_daletou($info);
	if($a==1){
		$url=ROOT_DOMAIN."/admin/order/daletou_set_num.php";
		header("Location:$url");
	}
}

$userTicketInfo = $searchDaletouFront->searchByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);
$userTicketIds = array_keys($userTicketInfo);
$u_ids = array();

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/order/daletou_set_num.php", $args);
}

$nextPage = false;
if (count($userTicketInfo) > $size) {
    $nextPage = $page + 1;
    array_pop($userTicketInfo);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/order/daletou_set_num.php", $args);
}


$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);
$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketInfo', $userTicketInfo);

$YOKA ['output'] = $tpl->r ('../admin/order/daletou_set_num');
echo_exit ( $YOKA ['output'] );
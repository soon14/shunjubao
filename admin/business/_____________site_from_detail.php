<?php
/**
 * 外站来源创建
 * #TODO，后期会产生性能问题：一次性会找出所有u_source用户uid；一次性找出所有uid的所有投注情况；
 */
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::OUTSIDE,
);

if (!Runtime::requireRole($roles,false)) {
	fail_exit("该页面不允许查看");
}

$u_id = Runtime::getUid();

$action = Request::r('action');

$actions = array('create','show');

$tpl = new Template();
$objSiteFrom = new SiteFrom();
$siteFromInfo = $objSiteFrom->getUserSiteFromInfo($u_id);

$tpl->assign('action',$action);
$tpl->assign('siteFromInfo',$siteFromInfo);

switch ($action) {
	case 'create':
		if ($siteFromInfo) fail_exit('您已有推广链接了，不能重复创建');
		$info = array();
		$info['describe'] = '用户自行创建推广链接';
		$info['type'] = SiteFrom::SITE_FROM_TYPE_IN;
		$result = $objSiteFrom->addSFRecord($info);
		if (!$result->isSuccess()) {
			echo_exit($result->getData());
		}
		success_exit('创建成功，返回上一页查看推广链接');
		break;
	case 'show':
		
		 $source_id = $siteFromInfo['id'];
	
		if (!$source_id) {
			fail_exit('您还没有自己的推广链接，赶快去创建吧');
		}
		
		//注册用户总数，c，有效投注量
		$start_time = Request::r('start_time');
		$end_time = Request::r('end_time');
		
		if (!$start_time || !$end_time) {
			$start_time = date('Y-m-d',time() - 7*86400);
			$end_time = date('Y-m-d',time());
		}
		
		$return = array();
		$return['total_registers'] = 0;
		$return['total_idcards'] = 0;
		$return['total_money'] = 0;
		
		do{
		
			$objUserMemberFront = new UserMemberFront();
			$condition = array();
			$condition['u_source'] = $source_id;
			#TODO性能问题，有待改进
			$results = $objUserMemberFront->getsByCondition($condition);
			
			if (!$results) {
				break;
			}
			//var_dump($results);//exit();
			$return['total_registers'] = count($results);//注册用户总数
			
			$uids = array_keys($results);
			
			$objUserRealInfoFront = new UserRealInfoFront();
			$condition = array();
			$condition['u_id'] = $uids;
			$condition['idcard'] = SqlHelper::addCompareOperator('!=', '');
			$results = $objUserRealInfoFront->getsByCondition($condition);
			
			$return['total_idcards'] = count($results);//认证用户总数
			
			$objUserTicketAllFront = new UserTicketAllFront();
			$condition = array();
			$condition['u_id'] = $uids;
			$condition['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
			$results = $objUserTicketAllFront->getsByCondtionWithField($start_time . ' 00:00:00', $end_time .' 23:59:59', 'datetime', $condition);
			$total_money = 0;
			
			foreach ($results as $key=>$value) {
				$total_money += $value['money'];
			}
			
			$return['total_money'] = $total_money;
			
		}while (false);
		
		
		//推广用户列表		
	
		

		//判断是否上一页时用到了$firstPage
		$firstPage = 1;
		$page = Request::varGetInt('page', $firstPage);
		//判断是否下一页时用到了$size
		$size = 20;
		$offset = ($page-1) * $size;
		$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录
		
		$field = 'a.u_id';
		$order = $field . ' desc ';
		$limit = " {$offset},{$real_size} ";
		
		
		$objMySQLite = new MySQLite($CACHE['db']['default']);
		$sql="select a.*,b.idcard from user_member as a left join user_realinfo as b on a.u_id=b.u_id where 1 and a.u_source=".$source_id." and  a.u_jointime>='".$start_time."' and   a.u_jointime<='".$end_time."' order by  $order limit $limit ";
		
    	$site_from_list = $objMySQLite->fetchAll($sql);
		
		$objUserTicketAllFront = new UserTicketAllFront();//投注记录
		$objUserChargeFront = new UserChargeFront();//充值记录
		
		foreach($site_from_list as $key=>$value){
			$totalTicketMoney = $objUserTicketAllFront->getTotalTicketMoney($start_time. ' 00:00:00', $end_time. ' 23:59:59', $value["u_id"]); //投注总金额
			$site_from_list[$key]["total_money"]=$totalTicketMoney;
			
			$user_charge_money=0;
			$condition = array();
			$condition['u_id'] = $value["u_id"];
			$condition['charge_status'] = UserCharge::CHARGE_STATUS_SUCCESS;
			$userCharges = $objUserChargeFront->getsByCondtionWithField($start_time.' 00:00:00', $end_time . ' 23:59:59', 'create_time', $condition);
			foreach ($userCharges as $value) {
				$user_charge_money += $value['money'];
			}

			$site_from_list[$key]["charge_money"]=$user_charge_money;
			
		}
		


		$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
		$args = $condition;
		if ($previousPage) {
			$args['page'] = $previousPage;
			$args['start_time'] = $start_time;
			$args['end_time'] = $end_time;
			$args['action'] = "show";
			$previousUrl = jointUrl(ROOT_DOMAIN."/account/user_site_from.php", $args);
		}
		$nextPage = false;
		if (count($site_from_list) > $size) {
			$nextPage = $page + 1;
			array_pop($site_from_list);// 删除多取的一个
		}
		if ($nextPage) {
			$args['page'] = $nextPage;
			$args['start_time'] = $start_time;
			$args['end_time'] = $end_time;
			$args['action'] = "show";
			$nextUrl = jointUrl(ROOT_DOMAIN."/account/user_site_from.php", $args);
		}
				

		$tpl->assign('site_from_list', $site_from_list);
		$tpl->assign('end_time',$end_time);
		$tpl->assign('start_time',$start_time);
		$tpl->assign('previousUrl', $previousUrl);
		$tpl->assign('nextUrl', $nextUrl);
		$tpl->assign('return',$return);
		break;
	default:
		break;
}

$source_key = Request::r('source_key');

if (strstr($source_key, 'http://') !== false) {
	$parse_url = parse_url($source_key);
	$query_array = explode('&', $parse_url['query']);
	foreach ($query_array as $qa) {
		$qa1 = explode('=', $qa);
		if ($qa1[0] == 'ZYsiteFrom') {
			$source_key = $qa1[1];
			break;
		}
		echo_exit("外站链接参数不正确");
	}
}

$start_time = Request::r('start_time');

if (!strtotime($start_time)) {
	$start_time = date('Y-m-d' ,time() - 30*86400);
}

$end_time = Request::r('end_time');
if (!strtotime($end_time)) {
	$end_time = date('Y-m-d');
}

if (!$source_key) {
	echo_exit($tpl->r('../admin/business/site_from_detail'));
}

$source_id = ConvertData::decryptStr2Id($source_key);
if (!$source_id) {
	fail_exit('参数key不正确');
}

$condition = array();
$condition['source_key'] = $source_key;
//代理人信息
$objSiteFrom = new SiteFrom();
$siteFromInfos = $objSiteFrom->getsByCondition($condition);

if (!$siteFromInfos) {
	fail_exit('未知的代理人');
}

$siteFromInfo = array_pop($siteFromInfos);

$admin_group = $siteFromInfo['admin_group'];//外站代理用户管理组，统计时需要排除
$admin_group = explode(',', $admin_group);

//管理员admin和外站管理员可查看
$showAll = false;
if (Runtime::requireRole(array(Role::ADMIN),false)) {
	$showAll = true;
}
$u_name = Runtime::getUname();
if (!in_array($u_name, $admin_group) && !$showAll) {
	fail_exit('不允许查看');
}

//需要统计信息；usermember里u_source等于$source_id的部分
$uids = $userTicketIds = array();

$condition = array();
$condition['u_source'] = $source_id;

//u_source用户
$objUserMemberFront = new UserMemberFront();
$source_users = $objUserMemberFront->getsByCondtionWithField($start_time.' 00:00:00', $end_time . ' 23:59:59', 'u_jointime', $condition);
foreach ($source_users as $source_user) {
	$uids[$source_user['u_id']] = $source_user['u_id'];
}

$results = array();
//充值成功的金额
$results['user_charge_money'] = 0;
//投注成功的总金额
$results['user_ticket_money'] = 0;
//注册用户
$results['user_member_amount'] = count($uids);

//这些用户的充值情况
$objUserChargeFront = new UserChargeFront();
$condition = array();
$condition['u_id'] = $uids;
$condition['charge_status'] = UserCharge::CHARGE_STATUS_SUCCESS;
$userCharges = $objUserChargeFront->getsByCondtionWithField($start_time.' 00:00:00', $end_time . ' 23:59:59', 'create_time', $condition);
foreach ($userCharges as $value) {
	$results['user_charge_money'] += $value['money'];
}
$objUserTicketAllFront = new UserTicketAllFront();
//u_source投注
$userTickets = $objUserTicketAllFront->getsByCondtionWithField($start_time.' 00:00:00', $end_time . ' 23:59:59', 'datetime', array('u_id'=>$uids));

foreach ($userTickets as $value) {
	if ($value['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS) {
		$results['user_ticket_money'] += $value['money'];
	}
}

$tpl->assign('siteFromInfo', $siteFromInfo);
$tpl->assign('results', $results);
$tpl->assign('source_key', $source_key);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('u_name', $u_name);
echo_exit($tpl->r('../admin/business/site_from_detail'));
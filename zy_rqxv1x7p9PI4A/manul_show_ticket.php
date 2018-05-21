<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

//redirect(ROOT_DOMAIN.'/ticket/manul_show_ticket.php');
Runtime::requireLogin();

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);
//是否智赢出票页面
$is_company_zhiying = Request::r('company_zhiying');
$company_zhiying_limit_money = 100000;
if ($is_company_zhiying) {
	if ($is_company_zhiying !=4 || !Runtime::requireRole($roles,true)) {
 		fail_exit("该页面不允许查看");
	}
}

$objUserTicketAllFront = new UserTicketAllFront();

$tpl = new Template();

$field = 'datetime';
$order = $field. ' asc';

//验证时间格式
$start_time = date('Y-m-d', time() - 30* 24 * 3600);
$end_time = date('Y-m-d', time());

$company_id = TicketCompany::COMPANY_MANUAL;

$select = Request::r('select');
$use_select = array('1x1','2x1');//可供选择的选项

$objMySQLite = new MySQLite($CACHE['db']['default']);

$condition = array();
$condition['company_id'] = $company_id;
$condition['print_state'] = UserTicketAll::TICKET_STATE_NOT_LOTTERY;

$limit = Request::r('limit');//每页显示的数量

if(!Verify::int($limit)) {
	$limit = 200;
} 
$person = Request::r('person');




if(!empty($person)){//如果加了参数就用这个操作了
	switch($select){
		case '唐山':
			$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8162" operate_uname="唐山" checked value="唐山"/>唐山&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			break;
		case '秦皇岛':
			$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8163" operate_uname="秦皇岛" checked value="秦皇岛"/> 秦皇岛&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
			break;			
		case '苏州出票':
			$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8634" operate_uname="苏州出票" checked value="苏州出票"/> 苏州出票&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			break;
			
		case '安徽出票':
			$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8635" operate_uname="安徽出票" checked value="安徽出票"/> 安徽出票&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
			break;			
		case '河北保定':
			$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="13152" operate_uname="河北保定" checked value="河北保定"/> 河北保定&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			break;	
			
		case '山东':
			$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="15160" operate_uname="山东" checked value="山东"/> 山东&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
			break;				
										
		default:
		
		$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8162" operate_uname="唐山" value="唐山"/>
				唐山&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8163" operate_uname="秦皇岛" value="秦皇岛"/>
				秦皇岛&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8634" operate_uname="苏州出票" value="苏州出票"/>
				苏州出票&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8635" operate_uname="安徽出票" value="安徽出票"/>
				安徽出票&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="13152" operate_uname="河北保定" value="河北保定"/>
				河北保定&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="15160" operate_uname="山东" value="山东"/>
				山东';
		
			break;
	}
	
}


//获取当前帐号只出票的地区
$userInfo_area = Runtime::getUser();
	
$objMySQLite_quan = new MySQLite($CACHE['db']['quan']);
$area_str = show_area($objMySQLite_quan,$userInfo_area["u_id"]);



if(!empty($area_str)){
		$str_person = $area_str;
	}else{
		$str_person ='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8162" operate_uname="唐山" value="唐山"/>
			唐山
			<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8163" operate_uname="秦皇岛" value="秦皇岛"/>
			秦皇岛
			<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8634" operate_uname="苏州出票" value="苏州出票"/>
			苏州出票
			<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8635" operate_uname="安徽出票" value="安徽出票"/>
			安徽出票
			<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="13152" operate_uname="河北保定" value="河北保定"/>
			河北保定
			<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="15160" operate_uname="山东" value="山东"/>
			山东';
	}


//var_dump($area_str);exit();
$tpl->assign('str_person', $str_person);



//var_dump($select);
$select_string = '1=1';
switch($select){
	case '2x1':
		$select_string = " `select`='{$select}' && num=2 ";
		break;
	case '1x1':
		$select_string = " `select`='{$select}' ";
		break;	
	case '234'://2x1,3x1,4x1
		$select_other = "   ((`select` = '2x1' && num=2) || (`select` = '3x1' && num=3) || (`select` = '4x1' && num=4)) && print_state=0 ";
		$sql = "select id from user_ticket_all where  {$select_other} && company_id={$company_id}";
		$userTicketInfo_other = $objMySQLite->fetchAll($sql,'id');
		foreach ($userTicketInfo_other as $value) {
			$in_234[]=$value["id"];	
		}
		if(!empty($in_234)){
			$select_string = " id in (".implode(",",$in_234).")";
		}else{
			$select_string = " id in (0)";
		}
		
		break;	
	case 'other'://除开2x1,3x1,4x1之外的票

		$select_other = "   ((`select` = '2x1' && num=2) || (`select` = '3x1' && num=3) || (`select` = '4x1' && num=4)) && print_state=0 ";
		$sql = "select id from user_ticket_all where  {$select_other} && company_id={$company_id} ";
		$userTicketInfo_other = $objMySQLite->fetchAll($sql,'id');
		foreach ($userTicketInfo_other as $value) {
			$in_234[]=$value["id"];	
		}
		if(!empty($in_234)){
			$select_string = " id not in (".implode(",",$in_234).")";
		}else{
			
		}
		break;	
	case 'all'://2x1,3x1,4x1
		$select_string = " 1 ";
		
		//
}



//var_dump($select_string);

$where = " company_id={$company_id} && print_state=0 && {$select_string} ";
if ($is_company_zhiying) $where .= " && max_money<={$company_zhiying_limit_money} ";//理论奖金10W以上
else $where .= " && max_money>{$company_zhiying_limit_money} ";


$sql = "select * from user_ticket_all where {$where} order by {$order} limit {$limit} ";
//$tpl->assign('sql', $sql);
$userTicketInfo = $objMySQLite->fetchAll($sql,'id');


$sort_userTicketInfo = array();
$u_ids = array();

foreach ($userTicketInfo as $value) {
	$u_ids[$value['u_id']] = $value['u_id'];
	$value['pool_desc'] = getPoolDesc($value['sport'], $value['pool']);
        //混合投注时增加一个逻辑：当所有选项是同一个玩法时，不显示混合投注，显示该玩法
        if ($value['pool'] == 'crosspool') {
                //mnl|55706|h#2.48&a#1.34,mnl|55708|h#1.51&a#2.06
                $combination = $value['combination'];
                $C = explode(',', $combination);
                $pools = array();//玩法集合
                foreach ($C as $v) {
                        $M = explode('|', $v);
                        $pools[$M[0]] = $M[0];
                }
                if (count($pools) == 1) $value['pool_desc'] = getPoolDesc($value['sport'], $M[0]) . '(<font style="color:red">混</font>)';
        }
	if ($value['num'] == '3' && $value['select'] == '2x1' && $value['user_select'] != '3串3') {//背景变成黄色
		  $value['yellow']=1;
		}
	$sort_userTicketInfo[$value['id']] = $value;
}

ksort($sort_userTicketInfo);
$userTicketInfo = $sort_userTicketInfo;

$objUserMemberFront = new UserMemberFront();
$all_users = $objUserMemberFront->gets($u_ids);

$getTicketCompany = TicketCompany::getTicketCompany();
$tpl->assign('getTicketCompany', $getTicketCompany);

$tpl->assign('company_id', $company_id);
$tpl->assign('all_users', $all_users);
$tpl->assign('select', $select);
$tpl->assign('limit', $limit);
$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);
$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);

$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('ticket_num', count($userTicketInfo));
$tpl->assign('is_company_zhiying', $is_company_zhiying);
//页面刷新间隔，单位：秒
$reload_second = 5;
$tpl->assign('reload_second', $reload_second);
$YOKA ['output'] = $tpl->r ('manul_show_ticket');
echo_exit ( $YOKA ['output'] );




function show_area($objMySQLite,$u_id){//控制地区

	$sql ="SELECT * FROM  q_member_set_area where u_id='".$u_id."' limit 0,20";	
	$get_array = $objMySQLite->fetchAll($sql,'sysid');
	foreach($get_array as $value){
		
		if($value["u_area"]=="8162"){
			$str_person .='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8162" operate_uname="唐山" value="唐山"/>唐山&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		if($value["u_area"]=="8163"){
			$str_person .='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8163" operate_uname="秦皇岛" value="秦皇岛"/>秦皇岛&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		
		if($value["u_area"]=="8635"){
			$str_person .='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8635" operate_uname="安徽出票" value="安徽出票"/>安徽出票&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		if($value["u_area"]=="8634"){
			$str_person .='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="8634" operate_uname="苏州出票" value="苏州出票"/>苏州出票&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		if($value["u_area"]=="13152"){
			$str_person .='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="13152" operate_uname="河北保定" value="河北保定"/>河北保定&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		if($value["u_area"]=="15160"){
			$str_person .='<input type="radio" name="ticket_person" class="manul_ticket" operate_uid="15160" operate_uname="山东" value="山东"/>山东&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		
		
		
		
	}
	
		

	return $str_person;
}

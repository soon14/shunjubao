<?php
/**
 * 出票公司对帐查询
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$tpl = new Template();

$start_time 	= Request::r('start_time');
$end_time 		= Request::r('end_time');
$company_id 	= Request::r('company_id');
$exclude_virtual = Request::r('exclude_virtual');

$tpl->assign('company_id', $company_id);
$companys = TicketCompany::getTicketCompany();
$tpl->assign('companys', $companys);

if (!strtotime($start_time) || !strtotime($end_time)) {
	echo_exit($tpl->r('../admin/business/company_account'));
}

$print_state_desc = UserTicketAll::getPrintStateDesc();


$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);

$mm_key = $start_time.$end_time.$company_id.'getCompanyAccount';

$objZYMemcache = new ZYMemcache();
$print_array = $objZYMemcache->get($mm_key);

if (!$print_array || Request::g('debug') == YEPF_DEBUG_PASS) {
	$print_array = array();//最终展示的数组，按出票状态分组
	for ($i = 0 ;$i<10 ; $i++) {
		$objUserTicketLog = new UserTicketLog($i);
		$condition = array();
		if ($company_id == TicketCompany::COMPANY_HUAYANG) {
			$company_id = array($company_id, 0);//兼容之前没有区分出票公司的情况
		}
		$condition['company_id'] = $company_id;
		$results = $objUserTicketLog->getsByCondtionWithField($start_time.' 00:00:00', $end_time.' 23:59:59', 'datetime' ,$condition, null, 'datetime asc');
		foreach ($results as $result) {
			if ($exclude_virtual && $result['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU) {
				continue;
			}
			$print_array[$print_state_desc[$result['print_state']]['desc']]['money'] += $result['money'];
			$print_array[$print_state_desc[$result['print_state']]['desc']]['amount']++;
		}
	}
}

$tpl->assign('print_array', $print_array);
echo_exit($tpl->r('../admin/business/company_account'));
?>




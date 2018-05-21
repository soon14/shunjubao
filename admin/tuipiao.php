<?php
/**
 * 退票 
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//$condition['u_id'] = $u_id;
$roles = array(
		Role::ADMIN,
		Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,false)) {
	ajax_fail_exit("该页面不允许查看");
}
$Daletoudetail = new Daletoudetail();
$Daletoubase = new Daletoubase();

if(Request::r('type')=='tuipiao'){
	$userTicketId = Request::r('id');
	if (!Verify::int($userTicketId)) {
		ajax_fail_exit($userTicketId."userTicketId不正确");
	}
	if(!empty($userTicketId)){
		$resu = $Daletoudetail->tuipiao($userTicketId);
		$msg = '操作成功！';
		ajax_success_exit($msg);
		die;
	}
}
if(Request::r('type')=='company_to_zhiying'){
	$ren = TicketCompany::COMPANY_ZHIYING;
	$idstr = Request::r('id');
	if(!empty($idstr) && !empty($ren)){
		$res = $Daletoudetail->chupiao($ren,$idstr);
		$idstr_arr=explode(',',$idstr);
		$result = $Daletoudetail->get($idstr_arr);
		$array_Ren=array('8162'=>'唐山','8163'=>'秦皇岛','8634'=>'苏州出票','8635'=>'安徽出票','8636'=>'河北保定');
		foreach($result as $key=>$val){
			$info = array();
			$info['user_ticket_id'] = $val['l_id'];
			$info['money'] 			= $val['price'];
			$info['datetime'] 			= date('Y-m-d H:i:s',$val['buytime']);
			$info['type']					= UserTicketOperate::TYPE_MANUL_TICKET;
			$info['operate_uid']		= $val['u_id'];
			$info['operate_uname']	= $array_Ren[$ren];
			$info['prize']	= 0;
			
        	///print_r($info);
			//415211
			$objUserTicketOperate = new UserTicketOperate();
			$operId = $objUserTicketOperate->add($info);
		}
		if($res==1){
			ajax_success_exit('操作成功');
		}else{
			ajax_success_exit('操作失败');
		}
	}
}

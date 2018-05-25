<?php
/**
 * 投注记录
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$tpl = new Template();
//$condition['u_id'] = $u_id;
$Daletoudetail = new Daletoudetail();
$Daletoubase = new Daletoubase();

if(Request::r('type')=='tuipiao'){
	$id=Request::r('id');
	if(!empty($id)){
		$resu = $Daletoudetail->tuipiao($id);
		echo $resu;
		die;
	}
	die;
}
if(Request::isPost()){
	$ren = Request::r('ticket_person');
	$idstr = Request::r('listid');
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
			$objUserTicketOperate = new UserTicketOperate();
			$operId = $objUserTicketOperate->add($info);
		}
		if($res==1){
			echo "<script type='text/javascript'>alert('出票成功');window.location.href='/daletou/chupiao.php'</script>";
			die;
		}else{
			echo "<script type='text/javascript'>alert('出票失败');window.location.href='/daletou/chupiao.php'</script>";
			die;
		}
	}
}
$condition1['dstates']='1';
$daletlist = $Daletoubase->success_order_list($condition1);
foreach ($daletlist as $key=>$val){
	$did_list[]=$val['d_id'];
}
$condition['d_id']=$did_list;
$condition['ischupiao']=0;
$condition['company_id']=0;
$userTicketInfo = $Daletoudetail->get_daletou_list($condition);
if(count($userTicketInfo)>0){
	foreach($userTicketInfo as $key=>$val){
		$userTicketInfo[$key]['qianqu_arr']=explode(',',$val['qianqu']);
		$userTicketInfo[$key]['houqu_arr']=explode(',',$val['houqu']);
		$userTicketInfo[$key]['buytime']=date('Y-m-d H:i:s',$val['buytime']);
	}
}
$tpl->assign('count',count($userTicketInfo));
#标题
$TEMPLATE ['title'] = "聚宝出票记录";
$TEMPLATE['keywords'] = '聚宝竞彩投注,竞彩投注,竞彩篮球投注,竞彩足球投注。';
$TEMPLATE['description'] = '聚宝网积分投注记录。';

$tpl->assign('userTicketInfo', $userTicketInfo);
$YOKA ['output'] = $tpl->r ('daletou_chupiao');
echo_exit ( $YOKA ['output'] );
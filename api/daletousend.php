<?php
/**
 * 大乐透是否中奖
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$Daletoudetail = new Daletoudetail();
$Daletoubase = new Daletoubase();
$Daletouset = new Daletouset();
$where=array('now'=>1);
$arr=$Daletouset->get_set_one($where);
if(!$arr){
	$msg['msg']='未设置开奖结果';
	$msg['ok']='-1';
	echo json_encode($msg);
}
$qs=$arr[0]['qishu'];
$kaij_q=explode(",",$arr[0]['qianqu']); // 开奖号码--前
$kaij_h=explode(",",$arr[0]['houqu']);//开奖号码--后
$result = $Daletoubase->get_list_operation($qs);


$sqlval=array();
foreach ($result as $key=>$val){
	$buy_q=explode(",",$val['qianqu']); // 前
	$buy_h=explode(",",$val['houqu']); // 后
	$zhushu = $val['zhushu'];// 注数
	$beishu = $val['beishu'];// 倍数
	$q_num=count(array_intersect($buy_q,$kaij_q));
	$h_num=count(array_intersect($buy_h,$kaij_h));
	if($q_num==5 && $h_num==2){ // 一等奖
		//echo '一等奖'."<br />";
		$price = trim($zhushu)*trim($beishu)*$arr[0]['j1'];
	}elseif($q_num==5 && $h_num==1){// 二等奖
		//echo '二等奖'."<br />";
		$price = trim($zhushu)*trim($beishu)*$arr[0]['j2'];
	}elseif(($q_num==5 && $h_num==0) || ($q_num==4 && $h_num==2)){// 三等奖
		//echo '三等奖'."<br />";
		$price = trim($zhushu)*trim($beishu)*$arr[0]['j3'];
	}elseif(($q_num==4 && $h_num==1) || ($q_num==3 && $h_num==2)){// 四等奖 1:100
		//echo '四等奖'."<br />";
		$price=trim($zhushu)*trim($beishu)*200;
		$price = trim($zhushu)*trim($beishu)*$arr[0]['j4'];
	}elseif(($q_num==4 && $h_num==0) || ($q_num==3 && $h_num==1) || ($q_num==2 && $h_num==2)){// 五等奖 1:5
		//echo '五等奖'."<br />";
		$price=trim($zhushu)*trim($beishu)*10;
		$price = trim($zhushu)*trim($beishu)*$arr[0]['j5'];
	}elseif(($q_num==3 && $h_num==0) || ($q_num==2 && $h_num==1) || ($q_num==1 && $h_num==2) || ($q_num==0 && $h_num==2)){// 六等奖 1:2.5
		//echo '六等奖'."<br />";
		//$price=trim($zhushu)*trim($beishu)*5;
		$price = trim($zhushu)*trim($beishu)*$arr[0]['j6'];
	}else{
		//echo '未中奖'."<br />";
		$sql="update daletou_detail set prize_state=2 where l_id=".$val['l_id'];
		$Daletoubase->query_dlt($sql);
	}
	if($price){
		$re = $Daletoudetail->tuimoney($price,$val['u_id']); // 接口
		if($re['ok']==1){  // 派奖成功
			$sql="update daletou_detail set prize_state=1 where l_id=".$val['l_id'];
			$Daletoubase->query_dlt($sql);
			$sqlval[]="('".$qs."','".$val['u_id']."','".$val['l_id']."','".$q_num."','".$h_num."','".$price."',1,'".date('Y-m-d H:i:s',time())."')"; 
		}else{ // 派奖失败
			$sqlval[]="('".$qs."','".$val['u_id']."','".$val['l_id']."','".$q_num."','".$h_num."','".$price."',0,'".date('Y-m-d H:i:s',time())."')";
		}
	}
}
if(count($sqlval)>0){
	$values_str=implode(",", $sqlval);
	$sql_jl="insert into daletou_zj (qishu,u_id,l_id,qnum,hnum,jiangjin,cz,addtime) values".$values_str;
	$resu= $Daletoubase->query_dlt($sql_jl);
	$msg['msg']='派奖成功';
	$msg['ok']='成功';
}else{
	$msg['msg']='无派奖记录';
	$msg['ok']='-1';
}
echo json_encode($msg);
<?php
header("Content-type: text/html; charset=utf-8");
ini_set('display_errors',0);
define('PAY_ROOT',dirname(__FILE__));
include (PAY_ROOT."/class/yeepayCommon.php");
include (PAY_ROOT."/class/yeepay.class.php");
include (PAY_ROOT."/class/yeepayOne.class.php");

//if($type=='onePay'){
	$yeepayObj=new yeepayOne();
    $orderid='o'.date('YmdHis',time());
    $money=0.01;
	$usrArr=array();
	$usrArr['cardno']='';
	$usrArr['idcardtype']='';
	$usrArr['idcard']='';
	$usrArr['owner']='';
	$usrArr['userid']='20187585455';
	$usrArr['userip']='127.0.0.1';
	$usrArr['terminalid']='';
	
	
    $url=$yeepayObj->sendPay($orderid,$money,$usrArr);
	header('Location:'.$url);
//}else{
	//$yeepayObj=new yeepay();
   // $orderid='o'.date('YmdHis',time());
   // $money=0.01;
    //echo $yeepayObj->sendPay($orderid,$money);
//}

?>

<?php
/**
 * 检测帐号，并发送验证码
 */
exit;
include_once ("config.inc.php");

//检查手机是否存在 不存在则返回1		
$uname = trim(intval(get_param('uname')));
if(preg_match("/1[3458]{1}\d{9}$/",$uname)){  
		$sql ="SELECT * FROM user_realinfo   where 1  and mobile='".$uname."' LIMIT 0,1";			
		$query = $conn -> Query($sql);
		$value = $conn -> FetchArray($query);
		$u_id = $value["u_id"];  
}else{     
 	$status=3;
   
}


if(empty($u_id)){//找不到手机号
		$status=3;
}else{	
	//生成验证码，时间，手机号发送到手机上
	$token_key="ZhiYin888";
	$time=time().rand(10000,100000);

	$key=substr(md5($uname.$time.$token_key),5,15);
	$code=substr($time,8,6);//验证码
	
	
		$arr = array(
				"u_id"=>"'$u_id'",
				"u_phone"=>"'$uname'",
				"code"=>"'$code'",
				"dtime"=>"'$dtime'",
				"dip"=>"'$dip'"
			);
	
	//	print_r($arr);exit();
		$res = add_record2($conn, "user_code", $arr);

	$arr = array("u_code"=>"'$code'","u_code_time"=>"'$dtime'");
	$res = update_record2($conn,"user_member",$arr, "and u_id = $u_id");


	$_SESSION["zf_uid"]=$u_id;


	
	$result=0;
	$url="http://www.shunjubao.xyz/sms/send.php?time=".$time."&u_name=".$uname."&key=".$key;
	$result = file_get_contents($url);	
	$status=1;//成功发送

}



$r = array('status'=>$status);	
echo json_encode($r); exit();	

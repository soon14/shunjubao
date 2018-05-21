<?php
/**
 * 发送信息
 */
session_start();//开启缓存
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';
$objZYShortMessage = new ZYShortMessage();
$Validate_Code = trim($_REQUEST['Validate_Code']);
$mobile = trim($_REQUEST['mobile']);

log_wap("pc_mobile.txt",$mobile);


$type=trim($_REQUEST['type']);
if($type=='checkcode'){ // 检查验证码
	$code =trim($_REQUEST['code']);
	session_start();
	if(strtotime($_SESSION['time'])+300<time()){
		session_destroy();
		unset($_SESSION['time']);
		unset($_SESSION['code']);
		echo '-1'; // 验证码过期
	}else{
		if($_SESSION['mcode']==$code){
			echo '1'; // 验证码正确
		}else{
			echo '-2'; // 验证码错误
		}
	}
}elseif($type=='sendcode'){ //发送验证码
	exit();
	//先验证验证码是否正确
	if($_SESSION['Validate_Code']!=$Validate_Code){
			echo '5'; // 验证码不对
	}else{
		$result = $objZYShortMessage->sendOneRegister($mobile);
		$code = $objZYShortMessage->getCode();
		
		if($code && $result){
			if(isset($_SESSION['time']))//判断缓存时间
			{
				session_id();
				$_SESSION['time'];
			}
			else
			{
				$_SESSION['time'] = date("Y-m-d H:i:s");
			}
			$_SESSION['mcode']=$code;//将content的值保存在session中
			echo '1';  // 发送成功
			$_SESSION['Validate_Code']="";
			log_wap("pc_mobile_suc.txt",$mobile);
			
		}else{
			echo '-3'; // 发送失败
		}

	}


}


function  log_wap($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}




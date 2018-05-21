<?php
/**
 * 本接口使用在
 * 开心新注册用户赠券活动，增加自动给用户加为名品机构主页粉丝功能
 * 接口逻辑
 * 1.判断密钥 -返回错误信息
 * error:1['开心用户ID错误'] 
 * error:2['时间戳错误']
 * error:3['密钥为空']
 * error:4['密钥加密错误']
 * error:6['高街内部错误']
 * error:7['时间戳过期']一个小时
 * 2.判断是否领取过券 -返回错误信息
 * error:5['此人以发过券'] 
 
 * 3.发券(jsong格式数组)
 * ['coupon_str':券号]
 * ['coupon_pwd':密码]
 * ['start_time':使用开始时间]
 * ['end_time':结束时间]
 *   
 * 4.记录发券日志
 * 调用方式：http://www.gaojie.com/api/KxRegUserGiftCoupon_api.php?kid=555&time=1318930620&key=bfdabdbc1ebb9a8fb077dc9576ad0aef
 * 密钥 kx_coupon
 * 参数1.key[加密后密钥] 加密方式 md5(555.'kx_coupon'.1318930620)  
 * 参数2.kid[开心ID]
 * 参数3.time[unixtime时间戳]
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


//1.判断密钥 |返回错误信息
$kid = isset($_GET['kid'])?$_GET['kid']:'';
$time = isset($_GET['time'])?$_GET['time']:'';
$key = isset($_GET['key'])?$_GET['key']:'';

if(!isInt($kid) || $kid == ''){
	echo 'error:1';
	exit;
}

if(!isInt($time) && $time == ''){
	echo 'error:2';
	exit;
}


if($key == ''){
	echo 'error：3';
	exit;
}

//时间戳过期时间是一个小时
if((time() - $time)  > 60*60*1){
	echo 'error:7';
	exit;
}

$skey = md5($kid.'kx_coupon'.$time);
if($key != $skey){
	echo 'error:4';
	exit;
}

$objCouponGiftKxRegUserApiLogFront = new CouponGiftKxRegUserApiLogFront();

//2.判断是否领取过券 -返回错误信息
$retData =  $objCouponGiftKxRegUserApiLogFront->getOneLog($kid);
if(is_array($retData)){
	echo 'error:5';
	exit;
};

//3.发券
$uid = Runtime::getUid();
$objCouponFront = new CouponFront();
$returnData = $objCouponFront->genOnce('after_first_login');

if(!is_array($returnData)){
	echo 'error:6';
	exit;	
}
$CouponData = array( 
	'coupon_str' => $returnData['coupon_str'] ,
	'coupon_pwd' => $returnData['coupon_pwd'],
	'start_time' => $returnData['start_time'],
	'end_time'	 => $returnData['end_time'],
);
echo json_encode($CouponData);

//4.记录发券日志
$info = array('kid' => $kid ,'coupon_id' => $returnData['id'],'create_time' => time());
$objCouponGiftKxRegUserApiLogFront->addOneLog($info);

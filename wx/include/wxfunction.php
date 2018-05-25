<?php

/*-------------------------------------------微信API/kc-------------------------------------------*/

//ERROR日志

function errorLog($log){
	$filename = 'error.txt';
	$temp = file_get_contents($filename);
	file_put_contents($filename,$temp.date("Y-m-d H:i:s")."\nlog=".$log."\n\n");	
}

//发送文本------内容
function sendText($contentStr){
	//内容不能为空
	if($contentStr==''){
		return false;
	}
	
	$textTpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>0</FuncFlag>
				</xml>";
		
	$userName 		= $GLOBALS["userName"];
	$developerName	= $GLOBALS["developerName"];
	$time 			= $GLOBALS["dtime"];
	$msgType 		= "text";
			
	$resultStr = sprintf($textTpl, $userName, $developerName, $time, $msgType, $contentStr);


	echo $resultStr;//发送

	return true;
}


//处理接收文本信息
function receiveText($content)
{
	$conn = $GLOBALS["conn"];
  $keyword = $content;

  if(isset($keyword)){
		$keyword = strtolower($keyword);

		if($keyword=='0'){
			sendText_kf('1');
		}else{//关键字自动回复
			autoKey($keyword);
			exit;
		}
	}else{
		// errorLog($GLOBALS["userName"].' Input something...');
	}

	return true;
}

//关键字自动回复
function autoKey($keyword){

	switch($value['MsgType']){
		case 'text'://回复文本
			break;
		case 'news'://回复图文
			break;
		default:
			sendText('聚宝网汇集国内一流竞彩分析师团队，每日（足球、篮球）推送赛事分析及推荐！如果需要在线客服请回复0,我们将为您提供人工服务。');
	}
	return true;
}





//发送客服返回数据
function sendText_kf($contentStr){
	//内容不能为空
	if($contentStr==''){
		return false;
	}
	
	$textTpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				</xml>";
		
	$userName 		= $GLOBALS["userName"];
	$developerName	= $GLOBALS["developerName"];
	$time 			= $GLOBALS["dtime"];
	$msgType 		= "transfer_customer_service";
			
	$resultStr = sprintf($textTpl, $userName, $developerName, $time, $msgType, $contentStr);

	echo $resultStr;//发送

	return true;
}




?>
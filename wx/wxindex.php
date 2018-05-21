<?php
include_once("include/wxfunction.php");//微信公共函数文件
//define your token
define("TOKEN", "zhiying365wxmp");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();



class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
    	// errorLog('2');

			//get post data, May be due to the different environments
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			
	      	//extract post data
			if (!empty($postStr)){     
	          	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$GLOBALS["userName"] 			= $postObj->FromUserName;		//用户ID（OpenID）
				$GLOBALS["developerName"] = $postObj->ToUserName;			//开发者账号
				$type 										= trim($postObj->MsgType);		//类型（text event）
				$CreateTime 							= trim($postObj->CreateTime);	//文本消息时间
				$Event 										= trim($postObj->Event);		//事件推送（subscribe）
				$keyword 									= trim($postObj->Content);		//文本消息内容
				$eventkey 								= trim($postObj->EventKey);		//click值
	            
			
				$Event = strtolower($Event);

			//	errorLog($postStr);

				switch($type){
					//推送
					case "event":
						if($Event=="subscribe"){
							$content = "欢迎您加入我们智赢的大家庭（智赢网--以智慧赢取人生）--智赢网汇集国内一流竞彩分析师团队，每日（足球、篮球）推送赛事分析及推荐！
	您还未有智赢网账户？<a href='http://mp.zhiying365.com/passport/reg.php'>点击注册</a>";
							sendText($content);
							
						}elseif($Event=="unsubscribe"){//取消关注
							$content = "欢迎您加入我们智赢的大家庭（智赢网--以智慧赢取人生）--智赢网汇集国内一流竞彩分析师团队，每日（足球、篮球）推送赛事分析及推荐！
	您还未有智赢网账户？<a href='http://mp.zhiying365.com/passport/reg.php'>点击注册</a>";
							sendText($content);
						}elseif($Event=="click"){
						}elseif($Event=="scan"){
						}
						break;
					
					//文本
					case "text":
						receiveText($keyword);//处理文本信息
						break;
				}

	    }else {
	    	errorLog('提取POST失败');
	    	exit;
	    }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>
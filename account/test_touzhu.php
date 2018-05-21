<?php
header("Content-type:text/html;charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


/*$s				= $_REQUEST["sport"];
$p				= $_REQUEST["pool"];
$select			= $_REQUEST["select"];
$user_select	= $_REQUEST["user_select"];
$multiple		= $_REQUEST["multiple"];

$money			= $_REQUEST["money"];//投注金额
$c				= $_REQUEST["combination"];//had|55969|d#3.9,hhad|55980|a#2.3&d#2.2
$uid			= Runtime::getUid();
$from 			= $_REQUEST['from'];//页面来源
$partent_id 	= Request::r('partent_id');//是否跟单
$company_id 	= TicketCompany::COMPANY_HUAYANG;//出票公司
$source			= UserMember::getUserSource();//站点来源*/
$u_id = "14777";//u_id
$u_name = "红单为王";//会员名
$s = "fb";
$select = "2x1";
$user_select = "2x1";
$multiple = "1";
$money = "2";
$c = "had|97248|h#1.51,had|97249|d#3.6";
$pool = "had";
$from = "";//网址
$partent_id = "0";//跟单ID
$company_id = 1;//出票公司
$source	= 12;//IOS app


exit("请先打开测试");


	$dtime = time();
	$params=array("time"=>$dtime,
				  "u_id"=>$u_id,
				  "u_name"=>$u_name,
				  "s"=>$s,
				  "pool"=>$pool,
				  "select"=>$select,
				  "appId"=>'4',
				  "user_select"=>$user_select,
				  "multiple"=>$multiple,
				  "money"=>$money, 
				  "c"=>$c,  
				  "from"=>$from,   
				  "partent_id"=>$partent_id,
				  "company_id"=>$company_id,
				  "source"=>$source,
				);	
				
		$token = getToken($params);
		$params["token"]=$token;
		$url = http_build_query($params);
		echo $url = 'http://www.zhiying365365.com/api/touzhu_ticket.php?'.$url;
		
		$json = file_get_contents($url);
		$result = json_decode($json, true);
		
		var_dump($result);exit();
		
		
		
		
	function getToken($params) {		
		if (!is_array($params)) return '';	
		ksort($params);
		$string = '';
		foreach ($params as $key=>$value) {
			if ($key == 'token') {
				continue;
			}
			$string .= $key . $value;
		}
		//应用id必须有
		$appId = $params['appId'];
		//为你分配的appkey
		$appKey = 'b9705bc6df1e6b9';
		//传输的内容
		$string .= $appKey;
		return substr(md5($string), 8, 16);
	}

	
		
?>
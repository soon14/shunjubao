<?php
 	header("Content-type: text/html; charset=utf-8"); 
    $dtime=time();
	$money = '';
	$u_id='';//小虎的帐号id
	$php_handle = 'daletousend.php';
	$total = $money*100;
	
	$params=array("time"=>$dtime,
				  "u_id"=>$u_id,
				  "total"=>$total,
				  "appId"=>'3',);	

	$token = getToken($params);
	$url = 'http://www.shunjubao.com/api/'.$php_handle.'?token='.$token.'&time='.$dtime.'&u_id='.$u_id.'&total='.$total.'&appId=3';
	$json = file_get_contents($url);
	$result = json_decode($json, true);
	var_dump($result);

/**
*参数加密算法
*	@param array $params 所有待传递参数(包含appID，除token外)
*	@return 字符串：md5后16位即$token
*	*/
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
		$appKey = '9cb6bc11c960e0c7';
		//传输的内容
		$string .= $appKey;
		return substr(md5($string), 8, 16);
}
?>
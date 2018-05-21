<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


$fp = fopen("auto_saishi_lock2.txt", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) {

	$objMySQLite = new MySQLite($CACHE['db']['default']);

	
	$content_start = '<div class="sales_L FloatL">'; 
	$content_end = '<div class="sales_R FloatR">'; 

		
	$url ="http://info.sporttery.cn/iframe/lottery_notice.php";
	//$contents = file_get_contents($url); 
	$contents = getHtmlContent_cookie($url);
	
	
	$intH1start= strpos($contents, $content_start);
	$intH1end = strpos($contents, $content_end);
	$strH1 = substr($contents,$intH1start,$intH1end);
	
	$contents_list_array = explode('<div class="sales_dot"></div>',$strH1);
	

	
	for($i=0;$i<count($contents_list_array)-1;$i++){
		preg_match_all('(<div class="sales_tit">(.*)</div>)', $contents_list_array[$i], $matches);
		$title = strip_tags($matches[1][0]);	
		preg_match_all('(<div class="sales_con">(.*)</div>)', $contents_list_array[$i], $matches);
		$list_note = strip_tags($matches[1][0]);
		
		
	   $sql_check ="SELECT * FROM zy_saishi where title='".$title."' and list_note='".$list_note."' ";	
	   $value_check = $objMySQLite->fetchAll($sql_check,'id');
		if(!empty($value_check)){
			continue;	
		}
		$create_time = getCurrentDate();
		
		
		/*$title = strip_tags($title);//去除html标签
		$pattern = '/\s/';//去除空白
		$title = preg_replace($pattern, '', $title);      
		
		$list_note = strip_tags($list_note);//去除html标签
		$pattern = '/\s/';//去除空白
		$list_note = preg_replace($pattern, '', $list_note);  */
		
		$ifnote =0;
		$tableInfo = array();
		$tableInfo['title'] 		= $title;
		$tableInfo['list_note'] 		    = $list_note;
		$tableInfo['create_time'] 		= $create_time;
		$tableInfo['ifnote'] 				= $ifnote;
		
		$insert_value = implode("','",$tableInfo);
		
		
		
		$insql = "insert into zy_saishi(title,list_note,create_time,ifnote) value ('".$insert_value."')";
		$objMySQLite->query($insql);
		
	}

	 // 释放锁定
	  flock($fp, LOCK_UN); 
} else {
   exit();//直接退出
}
fclose($fp);


function getHtmlContent_cookie($url){
		$cookie_file = dirname(__FILE__).'/cookie.txt';
		
		$ch = curl_init($url); //初始化
		curl_setopt($ch, CURLOPT_HEADER, 0); //不返回header部分
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，而非直接输出
		curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file); //存储cookies
		curl_exec($ch);
		curl_close($ch);
		//使用上面保存的cookies再次访问
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用上面获取的cookies
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

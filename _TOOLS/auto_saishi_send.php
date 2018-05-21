<?php
/**
 * 获取赛停售的通知,并发送通知信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
header("Content-type: text/html; charset=utf-8"); 
$objMySQLite = new MySQLite($CACHE['db']['default']);
$objZYShortMessage = new ZYShortMessage();

$moblie = array("15295466220");
$sql ="SELECT * FROM zy_saishi where ifnote=0  order by id asc limit 0,1 ";	
$zy_saishi_list = $objMySQLite->fetchAll($sql,'id');
if($zy_saishi_list){
	foreach ($zy_saishi_list as $data) {	
		$id = $data["id"];
		$title = cut_str(iconv('gb2312','utf-8',$data["title"]),10);
		$create_time = substr($data["create_time"],0,10);

		$insql = "update zy_saishi  set ifnote=1 where id = '".$id."'";
		$objMySQLite->query($insql);
		
		for($i=0;$i<count($moblie);$i++){
			$res = $objZYShortMessage->send_saishi_send($moblie[$i],$title,$create_time); 
		}

		 log_result_error("saishi_".$id,'auto_saishi_send');
		 exit("succ");
		//var_dump($result);exit();
	}
}else{
	echo "no_data";
	exit();
}



//截取utf8字符?
function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
{
if($code == 'UTF-8')
{
$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
preg_match_all($pa, $string, $t_string);

if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."";
return join('', array_slice($t_string[0], $start, $sublen));
}
else
{
$start = $start*2;
$sublen = $sublen*2;
$strlen = strlen($string);
$tmpstr = '';
for($i=0; $i<$strlen; $i++)
{
if($i>=$start && $i<($start+$sublen))
{
if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);
else $tmpstr.= substr($string, $i, 1);
}
if(ord(substr($string, $i, 1))>129) $i++;
}
if(strlen($tmpstr)<$strlen ) $tmpstr.= "";
return $tmpstr;
}
}



?>
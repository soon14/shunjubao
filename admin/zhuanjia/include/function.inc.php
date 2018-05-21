<?php






function show_selectname($tablename,$typeid,$typename='typename',$fieldsname='sysid'){//返回二级下拉菜单名称

	global $conn;	
	$sql = "SELECT ".$typename." FROM ".tname($tablename)." where  ".$fieldsname."='".$typeid."' limit 0,1";
	$query = $conn->Query($sql);
	$row=$conn->FetchArray($query);
	if($row[$typename]){
		$tname =  $row[$typename];
	}else{
		$tname =  " ";//未知
	}
	return $tname;	
}

function show_basicname($typename,$value){//返回一级下拉，单选，多选名称
	global $conn;	
	$sql = " SELECT tname FROM ".tname("bascdata_value")." where bd_id=(SELECT sysid FROM ".tname("bascdata")."  where tname='".$typename."') and tvalue='".$value."' limit 0,1";
	$query = $conn->Query($sql);
	$row=$conn->FetchArray($query);
	if($row["tname"]){
		$tname =  $row["tname"];
	}else{
		$tname =  "未知";
	}
	return $tname;	
}


/*返回二级下拉菜单JS数组*/
function showbasicselected($tablename,$pid=1,$arrname){

	global $conn;	
	$sql = "SELECT * FROM ".tname($tablename)." where parentid=".$pid." and ifuser=1 order by orderby desc";
	$query = $conn->Query($sql);
	
	
	$tempsortarray .="var ".$arrname." = new Array();\n";
	$i=0;
	$j=0;
	while($row=$conn->FetchArray($query)){
		
		$tempsortarray .= $arrname."[".$i."] = new Array('".$row["parentid"]."','".$row["sysid"]."','".$row["typename"]."');\n";
		$sql2 = "SELECT * FROM ".tname($tablename)." where parentid=".$row["sysid"]."  and ifuser=1  order by orderby desc";
		$query2 = $conn->Query($sql2);
		
		
		if($j==0){
			$j=$i+1;
		}else{
			$j=$i;
		}
		$j=$i+1;
		while($row2=$conn->FetchArray($query2)){
			$tempsortarray .= $arrname."[".$j."] = new Array('".$row2["parentid"]."','".$row2["sysid"]."','".$row2["typename"]."');\n";
			$j++;
		}
			
		$i=$j;
		//$i++;	
	}

	return  $tempsortarray;
}


function showbasiclist($listname,$selectid=1,$event=""){
//$listname 对应表tvalue,$selectid 当前选中ID

	global $conn;	
	$sql = "SELECT b.*,a.ttype FROM ".tname('bascdata_value')." as b left join ".tname('bascdata')." as a on b.bd_id=a.sysid where a.tname='".$listname."' and b.tstatus=1 order by b.orderby desc";
	$query = $conn->Query($sql);
			
	$numrows = $conn->NumRows($query);
	$isselect=0;
	while($value = $conn->FetchArray($query)){	
		$checked="";
		$selected="";

		if(strrpos($selectid,",")){//多个选中时
				if(in_array($value["tvalue"],explode(",",$selectid))){
					$checked='checked="checked"';
				}
		}elseif($value["tvalue"]==$selectid){
			$checked='checked="checked"';
			$selected='selected="selected"';
		}
		$thisevent="";
		if($value["ttype"]==1){//单选
			if($event){
				$thisevent = $event." = \"".$listname."_".$event."('".$listname."','".$value["tvalue"]."')\"";
			}
			$result .= '<input type="radio"  name="'.$listname.'"  id="'.$listname.'"  '.$thisevent.' value="'.$value["tvalue"].'" '.$checked.'/>'.$value["tname"];
		}elseif($value["ttype"]==2){//多选
			
			
			$result .= '<input type="checkbox" name="'.$listname.'[]"  id="'.$listname.'" value="'.$value["tvalue"].'" '.$checked.' />'.$value["tname"];
			
		}elseif($value["ttype"]==3){//下拉
			$isselect = 1;//标记输入<select></select>
			$result .='<option value="'.$value["tvalue"].'" '.$selected.'>'.$value["tname"].'</option>';
		}else{
			$result .= '<input type="radio" name="'.$listname.'" value="'.$value["tvalue"].'" />'.$value["tname"];
		}
		
	}
	
	
	if($isselect==1){//下拉时
		$result = '<select name="'.$listname.'" style="width:100px; height:18px;"><option value="0">请选择</option>'.$result.'</select>';
	}
	
	return $result;
}




function show_tstatus($id){
	if($id=="1"){
		return "启用";	
	}else{
		return "停用";		
	}
}


function show_datalist_type($id){
	switch($id){
		case"1":
			$typename="单选";
			break;	
		case"2":
			$typename="多选";
			break;	
		case"3":
			$typename="下拉";
			break;						
		default:
			$typename="单选";
			break;	
	}
	return $typename;
}


//显示基础数据列表名称
function show_datalist_type_name($id) {
	global $conn;

	$sql = "SELECT ttag FROM ".tname('bascdata')." WHERE sysid=$id limit 0,1 ";
	$query = $conn->Query($sql);
	$value = $conn->FetchArray($query);
	$result = $value["ttag"];

	return $result;
}




function format_string($string, $length, $format = "0"){
	if(strlen($string) >= $length)return $string;
	$prestr = "";
	for($i = 0; $i < $length - strlen($string); $i ++)$prestr .= $format;
	return $prestr.$string;
}

function get_param($param_name){

  $param_value = "";
  if(isset($_POST[$param_name])){
  	if(is_array($_POST[$param_name])){
		$param_value = implode(",",$_POST[$param_name]);
	}else{
		$param_value = $_POST[$param_name];	
	}
  }else if(isset($_GET[$param_name])){
    $param_value = $_GET[$param_name];
  }
  return trim($param_value);
}


function shownewsgroup($bid) {
	global $conn;

	 $sql = "SELECT `group`  FROM ".tname('t_news_group')." WHERE id=$bid ";

	$query = $conn->Query($sql);
	while($value = $conn->FetchArray($query)) {
		$result = $value["group"];
	}
	return $result;
}

function showgroup($bid,$tablename) {
	global $conn;

	$sql = "SELECT `typename`  FROM ".tname($tablename)." WHERE sysid=$bid ";
	$query = $conn->Query($sql);
	$value = $conn->FetchArray($query);
	$result = $value["typename"];

	return $result;
}




//显示会员名称
function showusername($memberid) {
	global $conn;

	$sql = "SELECT real_name FROM ".tname('admin')." WHERE uid=$memberid limit 0,1 ";
	$query = $conn->Query($sql);
	$value = $conn->FetchArray($query);
	$result = $value["real_name"];

	return $result;
}


//显示会员组名称
function showmembergroup($gid) {
	global $conn;

	 $sql = "SELECT `group`  FROM ".tname('t_member_group')." WHERE id=$gid ";
	$query = $conn->Query($sql);
	while($value = $conn->FetchArray($query)) {
		$result = $value["group"];
	}
	return $result;
}

function adminListSort($conn,$pid,$pidname,$i,$showname,$tablename="Sort",$sortid="id",$filename){
//无限级分类 2007-06-20
//参数：$conn数据库连接；$i分类显示样式；
//$pid父ID,$pidname父ID字段名,$showname要显示字段名
//$tablename表名，分类操作页名的前缀；
//$Sortid分类ID号
	$showclassname="";
	$strsql="select * from ".$tablename." where ".$pidname."='".$pid."' and ifuser=1 order by orderby desc";
	
	$rs1=$conn->Query($strsql);
	while($rs=$conn->FetchArray($rs1)){	
			 $strsq2="select * from ".$tablename." where  ".$pidname."=".$rs[$sortid]." and ifuser=1 order by orderby desc";

			$rs2=$conn->Query($strsq2);
			if($conn->NumRows($rs2)>0){
				$showclassname = "";
				$update_del="<li style='padding-left:430px;border-bottom:#666 dotted 1px;'><a href='".$filename."?action=mod&updateid=".$rs[$sortid]."'>修改</a>&nbsp;</li>";
			}else{
				$showclassname = "class='Child'";
				$update_del="<li  style='float:right;'><a href='".$filename."?action=mod&updateid=".$rs[$sortid]."'>修改</a>&nbsp;｜&nbsp;<a onclick=\"return checkdel('".$rs[$sortid]."');\" href='#'>删除</a>&nbsp;</li>";
			}
			
			if($rs["enabled"]=="N"){
				$enabled="<span style='color:red'>[未启用]</span>";
				$enabled="";
			}else{
				$enabled="";
			}
			
		echo"<ul style='float:left; width:500px; border-bottom:#666 dotted 1px;'><li style='float:left;".$showclassname." ".$showstyle."><a href='".$filename."?action=mod&updateid=".$rs[$sortid]."'>$rs[$showname]</a>$enabled".$update_del."</li>";
		$showclassname="";
		adminListSort($conn,$rs[$sortid],$pidname,$i+1,$showname,$tablename,$sortid,$filename);			
	echo "</ul>";					
//document.scripts[document.scripts.length-1]	
	}

}


function HTMLEncode($mystring){
//转换为HTML
	$mystring = preg_replace("/&/i", "&amp;",$mystring);
	$mystring = preg_replace("/\"/i", "&quot;",$mystring);
	$mystring = preg_replace("/</i", "&lt;",$mystring);
	$mystring = preg_replace("/>/i", "&gt;",$mystring);
	$mystring = preg_replace("/\ /i","&nbsp;",$mystring);
	$mystring = preg_replace("/\n/i","<br>",$mystring);
	$mystring = preg_replace("/\t/i","&nbsp;&nbsp;&nbsp;&nbsp;",$mystring);
	return $mystring;
} 



/*
功能:返回IP对应的区域
$ip：IP
*/
function convertip($ip) {

//    echo './ipdata/QQWry.Dat';exit;
	$return = '';
	if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
		$iparray = explode('.', $ip);
		if($iparray[0] == 10 || $iparray[0] == 127 || ($iparray[0] == 192 && $iparray[1] == 168) || ($iparray[0] == 172 && ($iparray[1] >= 16 && $iparray[1] <= 31))) {
			$return = '局域网';
		} elseif($iparray[0] > 255 || $iparray[1] > 255 || $iparray[2] > 255 || $iparray[3] > 255) {
			$return = '内部地址';
		} else {
//			$tinyipfile = WEBPATH_DIR.'./ipdata/QQWry.Dat';
            $tinyipfile = 'QQWry.Dat';
			$return = convertip_full($ip, $tinyipfile);
		}
	}
	return $return;
}
//获取当前IP
function get_ip()
{

	$ip = '';
	if (getenv('HTTP_CLIENT_IP')) 
	{
		$ip = getenv('HTTP_CLIENT_IP');

	} else if ( getenv('HTTP_X_FORWARDED_FOR') ) 
	{
  		$ip = getenv('HTTP_X_FORWARDED_FOR');

	} else if (getenv('REMOTE_ADDR')) 
	{

  		$ip = getenv('REMOTE_ADDR');

	} else {

 		 $ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
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


function setsafesql($str){
//过滤有害的字符串，防SQL注入
	global $message; //引用定义在lang文件夹下的变量
	if (eregi("\'|\"|and|or|select|insert|update|delete|union",$str)){
		echo($message["oper"]["opererror"]."<a href='javascript:history.go(-2);'>".$message["oper"]["operback"]."</a>");
		exit();
	}else{
		return $str;
	}
}


function multi($num, $perpage, $curr_page, $mpurl,$pramname="page") {
	$multipage = '';
	if($num > $perpage) {
		
		$page = 10;
		$offset = 2;
		$pages = ceil($num / $perpage);
		$from = $curr_page - $offset;
		$to = $curr_page + $page - $offset - 1;
			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				if($from < 1) {
					$to = $curr_page + 1 - $from;
					$from = 1;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $curr_page - $pages + $to;
					$to = $pages;
						if(($to - $from) < $page && ($to - $from) < $pages) {
							$from = $pages - $page + 1;
						}
				}
			}
			//上一页，下一页
			if($curr_page>1){
				$prepage = $curr_page-1;
			}else{
				$prepage = 1;
			}
			
		
			if($curr_page<$pages){
			
				$nextpage = $curr_page+1;
			}else{
				$nextpage = $curr_page; 
			}
			//
			
			if($curr_page > 1) {
				$multipage .= "<a href='{$mpurl}&".$pramname."=1'>&lt;&lt;</a><a href='{$mpurl}&".$pramname."={$prepage}'>&lt;</a>";
			} else {
				$multipage .= "<span class='disabled'>&lt;&lt;</span><span class='disabled'>&lt;</span>";
			}
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) {
					$multipage .= "<a href='{$mpurl}&".$pramname."=$i'>[$i]</a>";
				} else {
					$multipage .= "<span class='current'>[$i]</span>";
				}
			}
			$maxpage = ceil($num/$perpage);
			if($curr_page < $maxpage) {
				$multipage .= "<a href='{$mpurl}&".$pramname."={$nextpage}'>&gt;</a><a href='{$mpurl}&".$pramname."={$maxpage}'>&gt;&gt;</a>";
			} else {
				$multipage .= "<span class='disabled'>&gt;</span><span class='disabled'>&gt;&gt;</span>";
			}
			
	}
	return $multipage;
}//end

function showjsinfo($mssage,$url="OLD"){
//show $message and goto $url
//if $url length less than 4 go back
	if(strlen($url) < 4){
		echo("<script>alert('".$mssage."');".chr(10));
		die("window.history.go(-1);</script>");
	}else{
		echo("<script>alert('".$mssage."');".chr(10));
		die("window.location.href='".$url."';</script>");
	}
}



// 编码转换函数
function Xconv($int, $out, $str)
{
	$int = strtoupper($int);
	$out = strtoupper($out);

	if ($int == "GB2312") $int = "GBK";
	if ($out == "GB2312") $out = "GBK";

	if (!function_exists("iconv"))
	{
		global $_CONF;
		@include_once $_CONF["PATH"]."/include/encoding/encoding.inc.php";

		$CharEncoding = new Encoding();
		$CharEncoding->FilePath = $_CONF["PATH"]."/include/encoding/";
		$CharEncoding->SetGetEncoding($int);
		$CharEncoding->SetToEncoding($out);

		$var = $CharEncoding->EncodeString($str);
	}
	else
	{
		$var = iconv($int, $out, $str);
	}

	if (empty($var))
	{
		return $str;
	}
	else
	{
		return $var;
	}
}



// 剪切字符串为指定长度，并且剔除半个汉字
function TrimStr($string, $length)
{
	$len = strlen($string);

	if ($len <= $length) return $string;

	$checkchar = "";

	for ($i = 0; $i < $length; $i++)
	{
		$ac = ord($string[$i]);

		if ($ac >= 161)
		{
			$checkchar .= chr($ac);
			$checkchar .= chr(ord($string[$i+1]));
			$i++;
		}
		else
		{
			$checkchar .= chr($ac);
		}
	}

	return trim($checkchar)." ......";
}


// 检查字符串是否含有非法的字符，可用于检查"用户名"等字段
function checkAlpha($alpha)
{
	if(!ereg("^[a-zA-Z0-9 \-]+$", $alpha))
	{
		return 0;
	}
	else
	{
		return 1;
	}
}


// 检查Email地址
function checkMail($email)
{
	if (!eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-wyz][a-z](g|l|m|pa|t|u|v)?$", $email))
	{
		return 0;
	}
	else
	{
		return 1;
	}
}


// 检查ASCII字符串
function checkAscii($ascii)
{
	if(!ereg("^[a-zA-Z0-9 \.\,\+\!\@\#\$\%\^\&\*\(\)\~\/\'\_\-]+$", $ascii))
	{
		return 0;
	}
	else
	{
		return 1;
	}
}


// 检查是否为数字
function checkDigit($digit)
{
	if(!ereg("^[0-9]+$", $digit))
	{
		return 0;
	}
	else
	{
		return 1;
	}
}



// 检查主机名称是否合法
function checkHostName($alpha)
{
	if(!ereg("^[a-zA-Z0-9\.\@\*\-]+$", $alpha))
	{
		return 0;
	}
	else
	{
		return 1;
	}
}



// 格式化字符串，清除"\"
function handleData($var)
{
	if (is_array($var))
	{
		foreach ($var as $k => $v)
		{
			if (is_array($v))
			{
				foreach($v as $k1 => $v1)
				{
					$var[$k][$k1] = trim(htmlspecialchars(stripslashes($v1)));
				}
			}
			else
			{
				$var[$k] = trim(htmlspecialchars(stripslashes($v)));
			}
		}
	}
	else
	{
		$var = trim(htmlspecialchars(stripslashes($var)));
	}

	return $var;
}



// 生成密码
function CreatePassword($str)
{
	mt_srand(microtime() * 10000);
	$rand = mt_rand();
	$passwd = md5($rand."RedDNS, Inc.".$str.time());
	$passwd = substr($passwd, 1, 8);
	return $passwd;
}


//设置cookie
function isetcookie($var, $value, $life=0) {
	setcookie($var, $value, $life, COOKIE_PATH, COOKIE_DOMAIN, $_SERVER['SERVER_PORT']==443?1:0);
}

//对话框
function showmessage($msgkey, $url_forward='', $second=1, $values='') {
	global $smarty, $showmessage;
	if($url_forward && empty($second)) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");
	} else {
		//include_once(I_ROOT.'./language/lang_showmessage.php');
		if(isset($showmessage[$msgkey])) {
			$message = $showmessage[$msgkey];
		} else {
			$message = $msgkey;
		}
		if($values != '') {
			$message .= $values;
		}
		if($url_forward) {
			$message = "<a href=\"$url_forward\">$message</a><script>setTimeout(\"window.location.href ='$url_forward';\", ".($second*1000).");</script>";
		} else {
			$message = "<a href=\"javascript:history.back(-1);\">$message</a>";
			//$message = "<a href=\"javascript:history.back(-1);\">$message</a><script>setTimeout(\"history.back(-1);\", ".($second*1000).");<//script>";
		}
		$smarty -> assign('url_forward', $url_forward);		
		$smarty -> assign('message', $message);
		$smarty -> display('showmessage.html');
	}
	exit;
}

//本地密码生成方式
function buildpassword($password) {
	return substr(sha1($password),10,20); 
}

//获取到表名
function tname($name) {
	return MYSQL_TABLEPRE.$name;
}

//添加数据
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false) {
	global $conn;

	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$conn->Query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')');
	if($returnid && !$replace) {
		return $conn->InsertID();
	}
}

//获取在线IP
function getonlineip($format=0) {
	//初始化变量
	$returnIp = '';
	
	//获取IP
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
	$returnIp = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';

	//格式化IP %03d表示 空格用0代替最小三位整数转成十进位
	if($format) {
		$ips = explode('.', $_SGLOBAL['onlineip']);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $returnIp;
	}
}




function get_userbrowser(){
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$browser = '';
	if(strpos($agent, 'MSIE')) {
		  if (preg_match("/MSIE ([0-9].[0-9]+);/",$agent,$matches)){
		   $browser = 'Internet Explorer '.$matches[1];
		  } else {
		   $browser = 'Internet Explorer (hack)';
		  }
	}elseif(strpos($agent, "NetCaptor")) {
		  $browser = "NetCaptor";
	} elseif(strpos($agent, "Netscape")) {
		  $browser = "Netscape";
	} elseif(strpos($agent, "Lynx")) {
		  $browser = "Lynx";
	} elseif(strpos($agent, "Opera")) {
		  $browser = "Opera";
	} elseif(strpos($agent, "Konqueror")) {
		  $browser = "Konqueror";
	} elseif(strpos($agent, "Mozilla")) {
		  if (preg_match("/ Firefox/([0-9](.[0-9])+)/",$agent,$matches)){
		   $browser = 'Firefox '.$matches[1];
		  } else {
		   $browser = 'Moziila';
		  }
	} else {
		  $browser = 'other';
	}
	
	return $browser;
}
/**
* 获取访问者的操作系统类型
* @return unknown
*/
function get_os() {
	$os = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($os,"Windows NT 5.0")) $os="Windows 2000";
	elseif(strpos($os,"Windows NT 5.1")) $os="Windows XP";
	elseif(strpos($os,"Windows NT 5.2")) $os="Windows 2003";
	elseif(strpos($os,"Windows NT 6.0")) $os="Windows Vista";
	elseif(strpos($os,"Windows NT")) $os="Windows NT";
	elseif(strpos($os,"Windows 9")) $os="Windows 98";
	elseif(strpos($os,"unix")) $os="Unix";
	elseif(strpos($os,"linux")) $os="Linux";
	elseif(strpos($os,"SunOS")) $os="SunOS";
	elseif(strpos($os,"BSD")) $os="FreeBSD";
	elseif(strpos($os,"Mac")) $os="Mac";
	else $os="Other";
	return $os;
}



function str_guoyu($str){
	$str=trim($str);
	$str=strip_tags($str);
	$str=htmlspecialchars_decode($str);
	$str=addslashes($str);
	$str=mysql_escape_string($str);
	return $str;
}


//UTF-8截取字符串
function getstr($string, $length, $decode=0, $in_slashes=0, $out_slashes=0) {
//$decode  进行url解码 ,$in_slashes  传入字符串去\转义  $out_slashes传出字符串加\转移
	$string = trim($string);
	
	if ($decode) {
		$string = urldecode($string);
	}
	
	if($in_slashes) {
		//传入的字符有slashes
		$string = stripslashes($string);
	}
			
	if($length && strlen($string) > $length) {
		//截断字符
		$wordscut = '';
		//utf8编码
		$n = 0;
		$tn = 0;
		$noc = 0;
		while ($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1;
				$n++;
				$noc++;

			} elseif(194 <= $t && $t <= 223) {
				$tn = 2;
				$n += 2;
				$noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3;
				$n += 3;
				$noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4;
				$n += 4;
				$noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5;
				$n += 5;
				$noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6;
				$n += 6;
				$noc += 2;
			} else {
				$n++;
			}
			if ($noc >= $length) {
				break;
			}
		}
		if ($noc > $length) {
			$n -= $tn;
		}
		$wordscut = substr($string, 0, $n);
		$string = $wordscut;
	}
	
	if($out_slashes) {
		$string = addslashes($string);
	}
	
	return trim($string);
}

//处理搜索关键字
function stripsearchkey($string) {
	$string = trim($string);
	$string = str_replace('*', '%', addcslashes($string, '%_'));
	$string = str_replace('_', '\_', $string);
	return $string;
}

//产生随机字符
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}


//判断提交是否正确
function submitcheck($var) {	
	if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) && $_POST['formhash'] == formhash()) {
			return true;
		} else {
			showmessage('submit_invalid');
		}
	} else {
		return false;
	}
}


//获取限制条件
function getwheres($intkeys, $strkeys, $randkeys, $likekeys, $regkeys, $pre='') {	
	$wherearr = array();
	$urls = array();

	if(is_array($intkeys) && !empty($intkeys)) {
		foreach ($intkeys as $key=>$var) {
			$value = get_param($var);
			$value = !empty($value)?stripsearchkey($value):'';
			if(strlen($value)) {
				$wherearr[] = "{$pre}{$key}='".intval($value)."'";				
				$urls[] = "$var=$value";
			}
		}
	}
	
	
	if(is_array($strkeys) && !empty($strkeys)) {
		foreach ($strkeys as $key=>$var) {
			$value = get_param($var);
			$value = strlen($value)?stripsearchkey($value):'';
			if(strlen($value)) {
				$wherearr[] = "{$pre}{$key}='$value'";
				$urls[] = "$var=".rawurlencode($value);
			}
		}
	}
	
	if(is_array($randkeys) && !empty($randkeys)) {
		foreach ($randkeys as $key=>$vars) {
			$value1 = get_param($var[1].'1');
			$value1 = strlen($value1)?stripsearchkey($value1):'';
			$value1 = get_param($var[2].'2');
			$value1 = strlen($value1)?stripsearchkey($value1):'';
			if($value1) {
				$wherearr[] = "{$pre}{$key[1]}>='$value1'";
				$urls[] = "{$vars[1]}1=".rawurlencode($_GET[$vars[1].'1']);
			}
			if($value2) {
				$wherearr[] = "{$pre}{$key[1]}<='$value2'";
				$urls[] = "{$vars[1]}2=".rawurlencode($_GET[$vars[1].'2']);
			}
		}
	}

	if(is_array($likekeys) && !empty($likekeys)) {
		foreach ($likekeys as $key=>$var) {
			$value = get_param($var);
			$value = strlen($value)?stripsearchkey($value):'';
			if(strlen($value)) {
				$wherearr[] = "{$pre}{$key} LIKE BINARY '%$value%'";
				$urls[] = "$var=".rawurlencode($value);
			}
		}
	}
	
	if(is_array($regkeys) && !empty($regkeys)) {
		foreach ($regkeys as $key=>$var) {
			$value = get_param($var);
			$value = strlen($value)?stripsearchkey($value):'';
			if(!empty($value)) {
				$wherearr[] = "(FIND_IN_SET({$value}, {$pre}{$key}))";
				$urls[] = "$var=".rawurlencode($value);
			}
		}
	}

	return array('wherearr'=>$wherearr, 'urls'=>$urls);
}



//脚本执行时间差
function microtime_float(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}


function ck_numen($str){
 return preg_match("/^([a-zA-Z0-9_-])+$/",$str);
}

//产生随机特定范围的字符
function randomkeys($length) { 
    $pattern = '1234567890abcdef';    //字符池 
    for($i=0; $i<$length; $i++) { 
        $key .= $pattern{mt_rand(0,15)};    //生成php随机数 
    } 
    return $key; 
}







?>
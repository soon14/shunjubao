<?php	
session_start();
$admin_user = $_SESSION['dm_name'];	
include("config.inc.php");	
include("checklogin.php");	
$action = get_param("action");
$mydate = date("Y-m-d",time());


//查未申请修改未处理的问题
	$bug_nums=0;
	$strsql = " select count(*) as nums from ".tname("bug")."  where status in (1,2) ";
	$query = $conn->Query($strsql);
	$value = $conn -> FetchArray($query);
	$bug_nums =  $value["nums"];
	$tpl -> assign('bugnums', $bug_nums);


	
	//查询微信打单列表
	$sql ="SELECT * FROM ".tname("wx_print")." where 1=1 and status=1 and  DATE_FORMAT(dtime,'%Y-%m-%d')='".$mydate."'  ORDER BY sysid DESC ";
	
	$query = $conn -> Query($sql);
	while($value = $conn -> FetchArray($query)){
	
	
		if($value["toid"]){//老客
			$value["url"] = "tohospital_list.php?action=newedit&sysid=".$value["toid"]."&wxprint=1&wxid=".$value["sysid"]."&wxphone=".$value["phone"];
		}else{
			$value["url"] = "tohospital_list.php?action=add&qkeyword=".$value["phone"]."&wxprint=1&wxid=".$value["sysid"];
			//新客	
		}
		$result[] = $value;
	}
	$tpl -> assign('weixin',$result);

	
//月计算end	
	//查询是否已经有录过天气
	
	$strsql = " select * from ".$TABLE_NAME_INC."weather where wdate='".$mydate."'";
	$query = $conn->Query($strsql);
	$wcontent = $conn -> FetchArray($query);
	$wcontent["wtype"] = show_basicname("weather",$wcontent["wtype"]);
	$tpl -> assign('wcontent', $wcontent);
	//=========================
	
	
	$tpl -> assign('weather',showbasiclist('weather'));
	$tpl -> assign('default_date',date("Y-m-d",time()));//默认时间	
	
	if($_SESSION['adminid']=='') {
		header("Location: login.php");
	}else{
		
		$tpl -> display("main_index.html");			
   }
   
  
function aweek($gdate = "", $first = 0){
 if(!$gdate) $gdate = date("Y-m-d");
 $w = date("w", strtotime($gdate));//取得一周的第几天,星期天开始0-6
 $dn = $w ? $w - $first : 6;//要减去的天数

 //本周开始日期
 $st = date("Y-m-d", strtotime("$gdate -".$dn." days"));
 //本周结束日期
 $en = date("Y-m-d", strtotime("$st +6 days"));
 //上周开始日期
 $last_st = date('Y-m-d',strtotime("$st - 7 days"));
 //上周结束日期
 $last_en = date('Y-m-d',strtotime("$st - 1 days"));
 return array($st, $en,$last_st,$last_en);//返回开始和结束日期
}

 //DATE_FORMAT(FROM_UNIXTIME(modtime),'%Y-%m-%d')
   
   
?>
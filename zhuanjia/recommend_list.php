<?php
/**
 * passport之：注册界面
 */
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$userInfo = Runtime::getUser();
$refer = Request::getReferer();
$tpl = new Template ();
#标题
$TEMPLATE ['title'] = "智赢专家单场推荐列表页";
$TEMPLATE['keywords'] = '专家推荐、单场推荐、付费推荐、专家订阅、竞彩足球、北单、单场竞猜、单场投注、大小球预测、亚盘、亚盘推荐、盘口玩法、赔率解析、亚洲盘口、NBA推荐、篮球推荐、盈利计划';
$TEMPLATE['description'] = '智赢网专家订阅为彩民提供订阅推荐服务，聘请实战专家指导竞彩、北单及篮彩的投注。';
#埋藏跳转页面
$tpl->assign ('refer',$refer );
include_once ("config.inc.php");

/*
//通过审核的专家  推荐专家
 $sql ="SELECT u.u_nick,u.u_img,u.u_name,s.* FROM ".tname("shengqing")." as s left join user_member as u on s.u_name=u.u_name  where 1  and s.ifuse=1 and s.iscommon=1 ORDER BY s.sysid DESC LIMIT 0,4";			

$query = $conn -> Query($sql);
while($value = $conn -> FetchArray($query)){
	if(empty($value["u_img"])){
		$value["u_img"]="http://www.shunjubao.xyz/www/statics/i/touxiang.jpg";
	}
	
	
	$recommond =show_win_lv($value["eid"]);
	$value["lv"] = round(($recommond["zj"]/($recommond["zj"]+$recommond["wzj"]))*100)."%";	
	$value["zj"] =$recommond["zj"];
	$value["wzj"] =$recommond["wzj"];
	
	$result[] = $value;
}
$tpl -> assign('datalist', $result);*/


$pageSize = 15;
$page = empty($_GET['page'])? 1:intval($_GET['page']);
if($page < 1) $page = 1;
$start = ($page - 1) * $pageSize;
//通过审核的方案，推荐的方案

$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("recommond")."   where 1  and ifuse=1 ORDER BY sysid DESC "),0);


$sql ="SELECT * FROM ".tname("recommond")."   where 1  and ifuse=1  ORDER BY sysid DESC  LIMIT ".$start.",".$pageSize;		
$query = $conn -> Query($sql);
while($value = $conn -> FetchArray($query)){
	$myuser = show_user($value["u_id"]);
	$value["u_img"] = $myuser["u_img"];
	if(empty($myuser["u_img"])){
		$value["u_img"]="http://www.shunjubao.xyz/www/statics/i/touxiang.jpg";
	}
	$value["u_nick"] = $myuser["u_nick"];
	

	$recommond =show_win_lv($value["u_id"]);
	$value["lv"] = round(($recommond["zj"]/($recommond["zj"]+$recommond["wzj"]))*100)."%";	
	
	$this_date = date("Y-m-d H:i:s");
	
	if($this_date>$value["out_time"]){
		$value["isout"]=1;
	}
	$result2[] = $value;
	
	
	$multi = multi($totalRecord,$pageSize,$page,"recommend_list.php?1=1");
	$tpl -> assign('multi',$multi);
	$tpl -> assign('pageSize',$pageSize);
	$tpl -> assign('totalRecord',$totalRecord);
	$tpl -> assign('datalist2', $result2);
	$tpl -> assign('page',ceil($totalRecord/$pageSize));

}

$YOKA ['output'] = $tpl->r ('zhuanjia/recommend_list');
echo_exit ( $YOKA ['output'] );















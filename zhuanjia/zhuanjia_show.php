<?php
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$userInfo = Runtime::getUser();
$refer = Request::getReferer();
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];
$tpl = new Template ();
#标题
$TEMPLATE ['title'] = "智赢专家-专家详细";
$TEMPLATE['keywords'] = '专家推荐、单场推荐、付费推荐、专家订阅、竞彩足球、北单、单场竞猜、单场投注、大小球预测、亚盘、亚盘推荐、盘口玩法、赔率解析、亚洲盘口、NBA推荐、篮球推荐、盈利计划';
$TEMPLATE['description'] = '智赢专家-专家详细。';
#埋藏跳转页面
$tpl->assign ('refer',$refer );
include_once ("config.inc.php");
$id = intval(get_param('id'));//专家ID
//先检查是否过期,是否有订阅
//检查是否有订阅过
/*$sql ="SELECT * FROM ".tname("booking")."   where 1  and e_id='".$id."' and booktype>1 and u_id='".$u_id."' order by sysid desc  LIMIT 0,10";			
$query = $conn -> Query($sql);
$value = $conn -> FetchArray($query);
if(empty($value)){
		$dinyue_not = 1;
		$tpl -> assign('dinyue_not', $dinyue_not);
	//message("请先订阅","http://www.zhiying365.com/zhuanjia/");
	//exit();
}*/
//检查是否已经过期
	if($value["booktype"]==2){
		$value["end_time"]=date("Y-m-d H:i:s",strtotime($value["addtime"])+7*24*3600);	
	}elseif($value["booktype"]==3){
		$value["end_time"]=date("Y-m-d H:i:s",strtotime($value["addtime"])+30*24*3600);
	}
		if($dinyue_not !=1){
			if($value["end_time"]<date("Y-m-d H:i:s",time())){
				$dinyue_out = 1;
				$tpl -> assign('dinyue_out', $dinyue_out);
				//message("对不起，你的订阅已过期，请重新订阅!","index.php");
			//	exit();	
			}
	  }
$sql ="SELECT u.u_nick,u.u_img,u.u_name,s.* FROM ".tname("shengqing")." as s left join user_member as u on s.u_name=u.u_name  where 1  and s.ifuse=1 and s.iscommon=1 and s.eid='".$id."' ORDER BY s.sysid DESC LIMIT 0,4";			
$query = $conn -> Query($sql);
$value = $conn -> FetchArray($query);
if(!$value["u_name"]){
	//message("专家资料不存在","index.php");
	Redirect("index.php");
				//exit();
	exit();
}else{
	 $e_id = $value["eid"];
	 
	 $myuser = show_user($value["eid"]);
	$value["u_img"] = $myuser["u_img"];
	if(empty($value["u_img"])){
		$value["u_img"]="http://www.zhiying365.com/www/statics/i/touxiang.jpg";
	}
	$tpl -> assign('value', $value);	
}
//通过审核的方案，推荐的方案
$sql ="SELECT * FROM ".tname("recommond")."   where 1  and ifuse=1  and u_id='".$e_id."' ORDER BY sysid DESC LIMIT 0,10";			
$query = $conn -> Query($sql);
while($value = $conn -> FetchArray($query)){
	$show_if_dinyue = show_if_dinyue($u_id,$id,$value["sysid"]);
	if(!$show_if_dinyue){
		$show_if_dinyue2 = show_if_dinyue2($u_id,$id);//是否订阅月，周 是否过期
		//echo $show_if_dinyue2["end_time"];exit();
		if($value["addtime"]<=$show_if_dinyue2["end_time"]){//检查是否到了过期时间
			if($value["islottey"]==1){
				$value["islottey_status"]='<div class="zhuangTai"><strong><span>&nbsp;</span></strong></div>';	
			}elseif($value["islottey"]==2){
				$value["islottey_status"]='<div class="zhuangTai"><strong><em>&nbsp;</em></strong></div>';		
			}else{
				$value["islottey_status"]='<div class="zhuangTai"><b class="">暂无赛果</b></div>';	
			}		
		}else{
			//addtime
			$value["ishow"]=2;
			$value["islottey_status"]="请先订阅";
			$value["recommond"]="请先订阅";
		}
	}else{
		if($value["islottey"]==1){
			$value["islottey_status"]='<div class="zhuangTai"><strong><span>&nbsp;</span></strong></div>';	
		}elseif($value["islottey"]==2){
			$value["islottey_status"]='<div class="zhuangTai"><strong><em>&nbsp;</em></strong></div>';		
		}else{
			$value["islottey_status"]='<div class="zhuangTai"><b class="">暂无赛果</b></div>';	
		}		
	}
	$result2[] = $value;
}
$tpl -> assign('datalist2', $result2);
//新闻
$sql ="SELECT * FROM ".tname("news")."   where 1   and e_id='".$e_id."' ORDER BY sysid DESC LIMIT 0,100";			
$query = $conn -> Query($sql);
while($value = $conn -> FetchArray($query)){
	$result3[] = $value;
}
$tpl -> assign('datalist3', $result3);
$YOKA ['output'] = $tpl->r ('zhuanjia/zhuanjia_show');
echo_exit ( $YOKA ['output'] );
function show_if_dinyue($uid,$eid,$sysid){//订阅单场
	global $conn;		
	$sql ="SELECT * FROM ".tname("booking")."   where 1  and e_id='".$eid."' and  u_id='".$uid."' and bookid='".$sysid."'  LIMIT 0,1";			
	$query = $conn -> Query($sql);
	$value = $conn -> FetchArray($query);
	if($value){
		return true;	
	}else{
		return false;	
	}
}
//查询是否有订阅周或者月的推荐
function show_if_dinyue2($uid,$eid){
	global $conn;		
	$sql ="SELECT * FROM ".tname("booking")."   where 1  and e_id='".$eid."' and  u_id='".$uid."' and  booktype in (2,3) order by end_time desc limit 0,1";			
	$query = $conn -> Query($sql);
	$value = $conn -> FetchArray($query);
	if($value){
		return $value;	
	}else{
		return false;	
	}
}

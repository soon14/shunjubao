<?php

include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$refer = Request::getReferer();

$tpl = new Template ();
$TEMPLATE ['title'] = "智赢专家-专家列表页";
$TEMPLATE['keywords'] = '专家推荐、单场推荐、付费推荐、专家订阅、竞彩足球、北单、单场竞猜、单场投注、大小球预测、亚盘、亚盘推荐、盘口玩法、赔率解析、亚洲盘口、NBA推荐、篮球推荐、盈利计划';
$TEMPLATE['description'] = '智赢网专家订阅为彩民提供订阅推荐服务，聘请实战专家指导竞彩、北单及篮彩的投注。';

#埋藏跳转页面

$tpl->assign ('refer',$refer );



include_once ("config.inc.php");
$pageSize = 9;
        $page = empty($_GET['page'])? 1:intval($_GET['page']);

		if($page < 1) $page = 1;

		$start = ($page - 1) * $pageSize;
		
		$show_zj_id = show_zj_id();
		$show_zj_id .="0";
		

		$totalRecord = $conn -> NumRows($conn -> Query("SELECT u.u_nick,u.u_img,u.u_name,s.* FROM ".tname("shengqing")." as s left join user_member as u on s.u_name=u.u_name  where 1  and s.ifuse=1  and s.eid in (".$show_zj_id.")   "),0);

		

		$sql ="SELECT u.u_nick,u.u_img,u.u_name,s.* FROM ".tname("shengqing")." as s left join user_member as u on s.u_name=u.u_name  where 1  and s.ifuse=1  and s.eid in (".$show_zj_id.") ORDER BY s.sysid DESC  LIMIT ".$start.",".$pageSize;		

		$query = $conn -> Query($sql);

		while($value = $conn -> FetchArray($query)){
			
			$myuser = show_user($value["eid"]);
			$value["u_img"] = $myuser["u_img"];
			
			if(empty($value["u_img"])){
			$value["u_img"]="http://www.shunjubao.xyz/www/statics/i/touxiang.jpg";
			}

			$recommond =show_win_lv($value["eid"]);
			$value["lv"] = round(($recommond["zj"]/($recommond["zj"]+$recommond["wzj"]))*100)."%";	
			$value["zj"] =$recommond["zj"];
			$value["wzj"] =$recommond["wzj"];
	
			$result[] = $value;

		}

		

		//print_r($result);die();

		$multi = multi($totalRecord,$pageSize,$page,"zhuanjia_list.php?1=1");







	$tpl -> assign('multi',$multi);

	$tpl -> assign('pageSize',$pageSize);

	$tpl -> assign('totalRecord',$totalRecord);

	$tpl -> assign('datalist', $result);

	$tpl -> assign('page',ceil($totalRecord/$pageSize));

	

$YOKA ['output'] = $tpl->r ('zhuanjia/zhuanjia_list');

echo_exit ( $YOKA ['output'] );




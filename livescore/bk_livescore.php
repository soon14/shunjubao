<?php
/**
 * 竞彩足球列表页之比分直播
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$objMySQLite = new MySQLite($CACHE['db']['default']);
$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crs');
$TEMPLATE['title'] = '智赢网竞彩篮球比分直播';
$TEMPLATE['keywords'] = '比分,竞猜比分,比分玩法,波胆,竞猜足球,足球竞猜,智赢网,智赢2串1,竞彩2串1,竞猜专家,专家推荐,足彩专家,王忠仓,大力水手';
$TEMPLATE['description'] = '智赢网提供竞彩足球比分玩法直播，最专业的彩民赢取最高额回报，波胆命中变身人生赢家。。';


//$condition['id'] =  81763;
$condition['date'] =  date("Y-m-d");
$order = 'b_date asc';
$dates = $str = array();
$objBetting = new Betting("bk");
//$BettingInfos = $objBetting->getsByCondition($condition, null, $order);
$lcmatch = bk_result();
foreach($lcmatch as $val){
	$value['a_cn']=$val['a_cn'];
	$value['h_cn']=$val['h_cn'];
	$value['l_cn']=$val['l_cn'];
	$value['num_show']=$val['m_num'];
	$value['start_time']=date("y-m-d H:i",strtotime($val['starttime']));
	$value['status']=$val['status'];
	$value["m1"]=explode(":",$val["one"]);
	$value["m2"]=explode(":",$val["two"]);
	$value["m3"]=explode(":",$val["three"]);
	$value["m4"]=explode(":",$val["four"]);
	$value["m5"]=explode(":",$val["add"]);
	$value["score"]=explode(":",$val["full"]);
	$show_betting[]=$value;	
}
/*
foreach ($BettingInfos as $value) {	
$value["num_show"]= show_num($value["num"]);//周三049

	$bk_result_array = bk_result($value["id"]);
    print_r($bk_result_array);
		//var_dump($bk_result_array);exit();
		if(!empty($bk_result_array)){
			
			$value["m1"]=explode(":",$bk_result_array["one"]);
			$value["m2"]=explode(":",$bk_result_array["two"]);
			$value["m3"]=explode(":",$bk_result_array["three"]);
			$value["m4"]=explode(":",$bk_result_array["four"]);
			$value["score"]=explode(":",$bk_result_array["full"]);
			
		}

			
	
	$show_betting[]=$value;
}
*/

//var_dump($show_betting);//exit();
//增加临时实时比分数据
function bk_result(){
	$conn = @mysql_connect("localhost", "root","1q2w3e4R!") or die("Could not connect to database");
	@mysql_select_db("org_spdata", $conn) or die ("Could not select database");

	$sql ="SELECT * FROM bk_result_org where starttime > '".date('Y-m-d 00:00:00',time())."' order by starttime desc ";		

	$query = mysql_query($sql,$conn);
	$weekcn=array('0'=>"周日",'1'=>"周一",'2'=>"周二",'3'=>"周三",'4'=>"周四",'5'=>"周五",'6'=>"周六");
	while($row=mysql_fetch_assoc($query)){
		$week=preg_replace('@(\d{1})(\d{3})@','\\1',$row['m_num']);
		
		$row['m_num']= $weekcn[$week].preg_replace('@(\d{1})(\d{3})@','\\2',$row['m_num']);
		$value[]=$row;
	}
	//$value = mysql_fetch_array($query);
	
	return $value;
}

$tpl->assign('show_betting', $show_betting);
echo_exit($tpl->r('livescore/bk_livescore'));

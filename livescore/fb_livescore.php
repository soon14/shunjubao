<?php
/**
 * 竞彩足球列表页之比分直播
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$objMySQLite = new MySQLite($CACHE['db']['org_spdata']);
$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crs');
$TEMPLATE['title'] = '智赢网竞彩足球比分直播';
$TEMPLATE['keywords'] = '比分,竞猜比分,比分玩法,波胆,竞猜足球,足球竞猜,智赢网,智赢2串1,竞彩2串1,竞猜专家,专家推荐,足彩专家,王忠仓,大力水手';
$TEMPLATE['description'] = '智赢网提供竞彩足球比分玩法直播，最专业的彩民赢取最高额回报，波胆命中变身人生赢家。。';

$mdate = date("Y-m-d");
$sql ="SELECT * FROM fb_result_org where  DATE_FORMAT(starttime,'%Y-%m-%d')='".$mdate."'  ORDER BY FIELD(`status`, '上', '下','Fixture','Played'),m_num asc";		
$show_betting = $objMySQLite->fetchAll($sql,'id');

foreach($show_betting as $key=>$value){
	if($value["status"]=='Played'){
		$show_betting[$key]["status"]="完";
	}elseif($value["status"]=='Fixture'){
		$show_betting[$key]["status"]="未";	
	}

	switch($show_betting[$key]["weather"]){
		case "天晴":
			$weather= "<img src='http://www.zhiying365.com/www/statics/i/sunny.png' title='".$show_betting[$key]["weather"]."' border=0>";
			break;
		case "大致多云":
			$weather= "<img src='http://www.zhiying365.com/www/statics/i/cloudy.png' title='".$show_betting[$key]["weather"]."' border=0>";
			break;
		case "阵雨":
			$weather= "<img src='http://www.zhiying365.com/www/statics/i/rain.png' title='".$show_betting[$key]["weather"]."' border=0>";
			break;				
		case "微雨":
			$weather= "<img src='http://www.zhiying365.com/www/statics/i/sprinkle.png' title='".$show_betting[$key]["weather"]."' border=0>";
			break;		
		default:
			$weather="";
			break;	
	}
	$show_betting[$key]["weather"]=$weather;
	
	
	//红牌数，黄牌数 
	//H为主队，A为客队
	if($show_betting[$key]["h_rc"]>=1){
		$show_betting[$key]["h_rc"] = '<span id="h_rc_'.$show_betting[$key]["m_id"].'" style="background-color:#F00;">'.$show_betting[$key]["h_rc"].'</span>';
	}else{
		$show_betting[$key]["h_rc"] = '';
	}
	if($show_betting[$key]["h_yc"]>=1){
		$show_betting[$key]["h_yc"] = '<span  id="h_yc_'.$show_betting[$key]["m_id"].'" style="background-color:#FF0;" >'.$show_betting[$key]["h_yc"].'</span>';
	}else{
		$show_betting[$key]["h_yc"] = '';
	}
	
	
	if($show_betting[$key]["a_rc"]>=1){
		$show_betting[$key]["a_rc"] = '<span id="a_rc_'.$show_betting[$key]["m_id"].'"  style="background-color:#F00;">'.$show_betting[$key]["a_rc"].'</span>';
	}else{
		$show_betting[$key]["a_rc"] = '';
	}
	
	if($show_betting[$key]["a_yc"]>=1){
		$show_betting[$key]["a_yc"] = '<span id="a_yc_'.$show_betting[$key]["m_id"].'" style="background-color:#FF0;">'.$show_betting[$key]["a_yc"].'</span>';
	}else{
		$show_betting[$key]["a_yc"] = '';
	}
	
	
	
	
}





//var_dump($show_betting);//exit();
//增加临时实时比分数据
function result_org($m_id){
	$conn = @mysql_connect("localhost", "root","1q2w3e4R!") or die("Could not connect to database");
	@mysql_select_db("org_spdata", $conn) or die ("Could not select database");

	$sql ="SELECT * FROM fb_result_org where m_id='".$m_id."' limit 0,1";		
	$query = mysql_query($sql,$conn);
	$value = mysql_fetch_array($query);
	return $value;
}



$tpl->assign('show_betting', $show_betting);
echo_exit($tpl->r('livescore/fb_livescore'));

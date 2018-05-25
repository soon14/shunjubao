<?php
/**
 * 竞彩足球列表页之比分直播
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$objMySQLite = new MySQLite($CACHE['db']['default']);
$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crs');
$TEMPLATE['title'] = '竞彩足球赛果开奖-聚宝网';
$TEMPLATE['keywords'] = '足球比分直播,足彩直播,足球即时比分,足彩即时比分,足球彩票比分,比分直播网,足球数据中心。';
$TEMPLATE['description'] = '聚宝网足球数据中聚宝网竞彩足球赛果开奖结果。';

$mdate = date("Y-m-d",(time()-60*60*24*3));

 $sql ="SELECT a.*,b.* FROM bk_betting a left join bk_result  b on a.id=b.id where  DATE_FORMAT(a.date,'%Y-%m-%d')>='".$mdate."' and a.status='Final' and b.id>0  order by date desc, time desc";		

$show_betting = $objMySQLite->fetchAll($sql,'id');

foreach($show_betting as $key=>$value){

		$s1=explode(":",$value["s1"]);
		$s2=explode(":",$value["s2"]);
		$s3=explode(":",$value["s3"]);
		$s4=explode(":",$value["s4"]);
		$s5=explode(":",$value["s5"]);
		$final=explode(":",$value["final"]);
		

		$show_betting[$key]["s1"]=$s1;	
		$show_betting[$key]["s2"]=$s2;
		$show_betting[$key]["s3"]=$s3;
		$show_betting[$key]["s4"]=$s4;
		$show_betting[$key]["s5"]=$s5;
		$show_betting[$key]["final"]=$final;
		
		$show_betting[$key]["num"]=show_num($value["num"]);
		
	
}


$tpl->assign('show_betting', $show_betting);
echo_exit($tpl->r('livescore/bk_match_result'));

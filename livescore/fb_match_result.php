<?php
/**
 * 竞彩足球列表页之比分直播
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$objMySQLite = new MySQLite($CACHE['db']['default']);
$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crs');
$TEMPLATE['title'] = '竞彩足球赛果开奖-智赢网';
$TEMPLATE['keywords'] = '足球比分直播,足彩直播,足球即时比分,足彩即时比分,足球彩票比分,比分直播网,足球数据中心。';
$TEMPLATE['description'] = '智赢网足球数据中智赢网竞彩足球赛果开奖结果。';

$mdate = date("Y-m-d",(time()-60*60*24*3));
$sql ="SELECT a.*,b.half,b.full,b.final FROM fb_betting a left join fb_result  b on a.id=b.id where  DATE_FORMAT(a.date,'%Y-%m-%d')>='".$mdate."' and a.status='Final' and b.full is not null order by date desc, time desc";		
$show_betting = $objMySQLite->fetchAll($sql,'id');

foreach($show_betting as $key=>$value){	
	$show_betting[$key]["num"]=show_num($value["num"]);
}







$tpl->assign('show_betting', $show_betting);
echo_exit($tpl->r('livescore/fb_match_result'));

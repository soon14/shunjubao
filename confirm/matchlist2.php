<?php
/**
 * 获取赛事信息
 * 转移到后台察看
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
redirect(ROOT_DOMAIN . '/admin/game/score_match.php');
exit;
$sport	= Request::r('s');

if (!$sport) {
	$sport = 'fb';
}
if (!in_array($sport, array('fb','bk'))) {
	echo_exit('sport not exist');
}
//取近3个赛事日期
$b_dates = array(
		date('Ymd', time() - 86400 *2) 	=> date('Y-m-d', time() - 86400 *2),//前天
		date('Ymd', time() - 86400) 	=> date('Y-m-d', time() - 86400),//昨天
		date('Ymd', time()) 			=> date('Y-m-d', time()),//当天
);
$condition = array(
		'status'	=> array(Betting::STATUS_FINAL),
		'b_date'	=> $b_dates,
);

$i = 0;
$objBetting = new Betting($sport);
$results = $objBetting->getsByCondition($condition, null, 'b_date asc');
foreach ($results as $value) {
	$lotttime 	= $value['b_date'];
	$ballid 	= $value['num'];
	$value['l_cn'] = gb2312toU8($value['l_cn']);
	$value['h_cn'] = gb2312toU8($value['h_cn']);
	$value['a_cn'] = gb2312toU8($value['a_cn']);
	//获取即时比分
	$url = "http://prize.shunjubao.xyz/KJCenter/getResult.php?sport={$sport}&lotttime=".$lotttime."&ballid=".$ballid;
	$objCurl = new Curl($url);
	$res = $objCurl->get();
	
	if (!$res) {
		echo "{$lotttime}-{$ballid} 获取失败</br>";
		continue;
	}
	echo "赛事日期：{$lotttime}</br>";
	$kj_get_result = json_decode($res, true);
	
	if (!$kj_get_result) {
		$score = "{$lotttime}-{$ballid} 比分暂无";
	} else {
		$score = ",半场比分:".$kj_get_result[0]["half_score"].",全场比分:".$kj_get_result[0]["full_score"];
		$i++;
	}
	$str = $value["l_cn"].": ".$value["h_cn"]."VS".$value["a_cn"].",时间:".$value["date"]." ".$value["time"] . $score . "<hr>";
	echo $str;
	
}
	echo "共计{$i}场有赛果的比赛";
	exit;
	

?>
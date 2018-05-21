<?php
/**
 * 获取赛事信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$sport	= Request::r('sport');

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

$return = $matchIds = $score_results = array();


$objBetting = new Betting($sport);
$objSportResult = new SportResult($sport);
$objScoreApi = new ScoreApi();

foreach ($b_dates as $b_date) {
	$res = $objScoreApi->getScoreAllByLotttime($sport, $b_date);
	if (!$res->isSuccess()) {
// 		echo "{$res->getData()}</br>";
		continue;
	}
	$data = $res->getData();
	foreach ($data as $d) {
		$matchInfo = $objBetting->getMatchInfoByDateAndNum($b_date, $d['ballid']);
		$matchInfo['apiInfo'] = $d;//接口信息加入进来
		$results[] = $matchInfo;
	}
}

foreach ($results as $value) {
	$matchIds[] = $value['id'];
}

$sportResults = $objSportResult->gets($matchIds);

$sportPoolFb = UserTicketAll::$allFBPoolDesc;
$sportPoolBk = UserTicketAll::$allBKPoolDesc;

foreach ($results as $value) {
	$lotttime 	= $value['b_date'];
	$ballid 	= $value['num'];
	//$value['l_cn'] = gb2312toU8($value['l_cn']);
	//$value['h_cn'] = gb2312toU8($value['h_cn']);
	//$value['a_cn'] = gb2312toU8($value['a_cn']);
	
	$poolResult = array();
	
	switch (strtolower($value['s_code'])) {
		case UserTicketAll::SPORT_FOOTBALL:
			foreach ($sportPoolFb as $pool) {
				$desc = '';//彩果的中文描述
				//对应让球数,让球胜平负 让分胜负和大小分都可能有多个让球数
				$allGollinesInfo = getAllGoallines($pool, $value['id']);
				//发现有让球
				if (is_array($allGollinesInfo)) {
					foreach ($allGollinesInfo as $goalline) {
						$combination = scoreToPoolResultFB($pool, $value['apiInfo']['full_score'], $goalline, $value['apiInfo']['half_score']);
						$desc .= getResults($pool, $combination).'('.$goalline.')'.'<br>';
						$poolResult[$pool]['combination'][] = $combination;
					}
				} else {
					//没有让球数
					$combination = scoreToPoolResultFB($pool, $value['apiInfo']['full_score'], '', $value['apiInfo']['half_score']);
					$desc = getResults($pool, $combination);
					$poolResult[$pool]['combination'][] = $combination;
				}
				$poolResult[$pool]['desc'] = $desc;
			}
			break;
		case UserTicketAll::SPORT_BASKETBALL:
			foreach ($sportPoolBk as $pool) {
				$desc = '';//彩果的中文描述
				//对应让球数,让球胜平负 让分胜负和大小分都可能有多个让球数
				$allGollinesInfo = getAllGoallines($pool, $value['id']);
				//发现有让球
				if (is_array($allGollinesInfo)) {
					foreach ($allGollinesInfo as $goalline) {
						$combination = scoreToPoolResultBK($pool, scoreChange($value['s_code'], $value['apiInfo']['full_score']), $goalline);
						$desc .= getResults($pool, $combination).'('.$goalline.')'.'<br>';
						$poolResult[$pool]['combination'][] = $combination;
					}
				} else {
					//没有让球数
					$combination = scoreToPoolResultBK($pool, scoreChange($value['s_code'], $value['apiInfo']['full_score']));
					$desc = getResults($pool, $combination);
					$poolResult[$pool]['combination'][] = $combination;
				}
				$poolResult[$pool]['desc'] = $desc;
			}
			break;
	}
	
	$return[] = array(
		'matchId'	=> $value['id'],
		'num'		=> $value['num'],
		'b_date'	=> $lotttime,
		'l_cn'		=> $value['l_cn'],
		'h_cn'		=> $value['h_cn'],
		'a_cn'		=> $value['a_cn'],
		'date'		=> $value['date'],
		'time'		=> $value['time'],
		//雷达接口的比分都是主vs客，即时比分的篮球是客vs主
		'half_jishi'=> $value['apiInfo']['half_score'],
		'full_jishi'=> $value['apiInfo']['full_score'],
		'half_leida'=> scoreChange($value['s_code'], $sportResults[$value['id']]['half']),
		'full_leida'=> scoreChange($value['s_code'], $sportResults[$value['id']]['final']),
		//彩果
		'poolResult'=> $poolResult,
	);
}

$tpl = new Template();
$tpl->assign('return',$return);
$tpl->assign('sport',$sport);


$tpl->assign('sportPoolFb',$sportPoolFb);
$tpl->assign('sportPoolBk',$sportPoolBk);
$tpl->d('../admin/game/score_match');
?>
<?php
/**
 * 获取赛事信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$sport = 'fb';//更新足球的比分和赛果

$b_dates = array(
		date('Ymd', time() - 86400 *2) 	=> date('Y-m-d', time() - 86400 *2),//前天
		date('Ymd', time() - 86400) 	=> date('Y-m-d', time() - 86400),//昨天
		date('Ymd', time()) 			=> date('Y-m-d', time()),//当天
);
$condition = array(
		'status'	=> array(Betting::STATUS_FINAL),
		'b_date'	=> $b_dates,
);

$return = $score_results = array();
$ii = $kk = $jj = 0;

$objBetting 	= new Betting($sport);//赛事
$objSportResult = new SportResult($sport);//比赛结果
$objScoreApi 	= new ScoreApi();//获取即时比分
$objPoolResult 	= new PoolResult($sport);//赛果

foreach ($b_dates as $b_date) {
	$res = $objScoreApi->getScoreAllByLotttime($sport, $b_date);
	if (!$res->isSuccess()) {
		echo_cli($res->getData());
		continue;
	}
	$data = $res->getData();
	foreach ($data as $d) {

		$matchInfo = $objBetting->getMatchInfoByDateAndNum($b_date, $d['ballid']);
		$matchInfo['apiInfo'] = $d;//接口信息加入进来

		$results[] = $matchInfo;
		$kk++;
		
		//比分入库start ======================================================
		$condition = array();
		$condition['id'] = $matchInfo["id"];
		$if_had_result = $objSportResult->getsByCondition($condition, 1);
		
		if ($if_had_result) {
			continue;
		}
		
		//比分入库
		$info = array();
		$info['id'] 	= $matchInfo["id"];
		$info['s_code'] = strtoupper($sport);
		$info['m_num'] 	= $matchInfo["num"];
		$info['status']	= SportResult::RESULT_STATUS_FINAL;
		$info['half']	= $matchInfo["apiInfo"]["half_score"];
		$info['full']	= $matchInfo["apiInfo"]["full_score"];
		$info['final']	= $matchInfo["apiInfo"]["full_score"];
		$ResultID = $objSportResult->add($info);
		$jj++;
		//比分入库end ======================================================	
		
	}
}

if (!$results) {
	echo_cli("暂无赛事");
	exit;
}

$sportPoolFb = UserTicketAll::$allFBPoolDesc;

foreach ($results as $value) {
	
	foreach ($sportPoolFb as $pool) {//更新彩果
		//对应让球数,让球胜平负 让分胜负和大小分都可能有多个让球数
		$allGollinesInfo = getAllGoallines($pool, $value['id']);
		
		//发现有让球
		if (is_array($allGollinesInfo)) {
			
			foreach ($allGollinesInfo as $goalline) {
				$combination = scoreToPoolResultFB($pool, $value['apiInfo']['full_score'], $goalline, $value['apiInfo']['half_score']);
				
				//赛果入库 start ======================================================
				$condition = array();
				$condition['m_id'] 			= $value["id"];
				$condition['p_code'] 		= strtoupper($pool);
				$condition['combination'] 	= $combination;
				$if_had_poolresult = $objPoolResult->getsByCondition($condition, 1);
				
				if ($if_had_poolresult) {
					continue;
				}
				
				//赛果入库
				$info = array();
				$info['s_code'] = strtoupper($sport);
				$info['m_id'] 	= $value["id"];
				$info['m_num'] 	= $value["num"];
				$info['p_code'] = strtoupper($pool);
				$info['o_type'] = "F";//未使用
				$info['p_id'] 	= "0";//未使用
				$info['refund'] = "0";//未使用
				$info['totals'] = "0";//未使用
				$info['combination']= $combination;
				$info['value']	= "";
				$info['winunit']= "";
				$PoolResultID = $objPoolResult->add($info);
				$ii++;
	//赛果入库end ======================================================	
			}
			
		} else {
			//没有让球数
			$combination = scoreToPoolResultFB($pool, $value['apiInfo']['full_score'], '', $value['apiInfo']['half_score']);
			//赛果入库 start ======================================================
			$condition = array();
			$condition['m_id'] 			= $value["id"];
			$condition['p_code'] 		= strtoupper($pool);
			$condition['combination'] 	= $combination;
			$if_had_poolresult = $objPoolResult->getsByCondition($condition, 1);

			if ($if_had_poolresult) {
				continue;
			}
			//赛果入库
			$info = array();
			$info['s_code'] = strtoupper($sport);
			$info['m_id'] 	= $value["id"];
			$info['m_num'] 	= $value["num"];
			$info['p_code'] = strtoupper($pool);
			$info['o_type'] = "F";//未使用
			$info['p_id'] 	= "0";//未使用
			$info['refund'] = "0";//未使用
			$info['totals'] = "0";//未使用
			$info['combination']= $combination;
			$info['value']	= "";
			$info['winunit']= "";
			$PoolResultID = $objPoolResult->add($info);
			$ii++;
			//赛果入库end ======================================================		
		}
			
	}
}

echo_cli("共场{$kk}赛事，添加了个{$jj}比分，添加了个{$ii}彩果");

?>

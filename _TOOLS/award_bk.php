<?php
/**
 * 获取赛事信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$sport	= "bk";

//取近3个赛事日期
$b_dates = array(
		date('Ymd', time() - 86400 *3) 	=> date('Y-m-d', time() - 86400 *3),//前天
		date('Ymd', time() - 86400 *2) 	=> date('Y-m-d', time() - 86400 *2),//前天
		date('Ymd', time() - 86400) 	=> date('Y-m-d', time() - 86400),//昨天
		date('Ymd', time()) 			=> date('Y-m-d', time()),//当天
);
$condition = array(
		'status'	=> array(Betting::STATUS_FINAL),
		'b_date'	=> $b_dates,
);

$return = $matchIds = $score_results = array();

$objBetting = new Betting($sport);//赛事
$objSportResult = new SportResult($sport);//比赛结果
$objScoreApi = new ScoreApi();//获取小何的比分
$objPoolResult = new PoolResult($sport);//赛果


foreach ($b_dates as $b_date) {
	$res = $objScoreApi->getScoreAllByLotttime($sport, $b_date);
	if (!$res->isSuccess()) {
 		echo "{$res->getData()}</br>";
		continue;
	}
	$data = $res->getData();
	foreach ($data as $d) {
		$matchInfo = $objBetting->getMatchInfoByDateAndNum($b_date, $d['ballid']);
		$matchInfo['apiInfo'] = $d;//接口信息加入进来
		
		//var_dump($matchInfo);exit();
		
		//比分入库start ======================================================
		$condition = array();
		$condition['id'] = $matchInfo["id"];
		$if_had_result = $objSportResult->getsByCondition($condition);
		
		
		
		//调整主客场比分顺序
		$s1_array = explode(":",$matchInfo["apiInfo"]["first_score"]);
		$s1 = $s1_array[1].":".$s1_array[0];
		
		$s2_array = explode(":",$matchInfo["apiInfo"]["two_score"]);
		$s2 = $s2_array[1].":".$s2_array[0];
		
		$s3_array = explode(":",$matchInfo["apiInfo"]["three_score"]);
		$s3 = $s3_array[1].":".$s3_array[0];
		
		$s4_array = explode(":",$matchInfo["apiInfo"]["four_score"]);
		$s4 = $s4_array[1].":".$s4_array[0];
		

		$s5_array = explode(":",$matchInfo["apiInfo"]["add_score"]);//小何接口只有一个加时比分
		$s5 = $s5_array[1].":".$s5_array[0];
		if($s5_array[1]==0 && $s5_array[0]==0){//加时为0:0时，入库为空
			$s5="";	
		}
		
		
		$full_score = ($s1_array[1]+$s2_array[1]+$s3_array[1]+$s4_array[1]+$s5_array[1]).":".($s1_array[0]+$s2_array[0]+$s3_array[0]+$s4_array[0]+$s5_array[0]);
		//小何建议重新计算总分，重新计算比分
		
		if(empty($if_had_result)){//比分入库

				$info = array();
				$info['id'] = $matchInfo["id"];
				$info['s_code'] = "BK";
				$info['m_num'] = $matchInfo["num"];
				$info['status']	= "Conclude";
				$info['s1']= $s1?$s1:'';
				$info['s2']= $s2?$s2:'';
				$info['s3']= $s3?$s3:'';
				$info['s4']= $s4?$s4:'';	
				$info['s5']= $s5?$s5:'';	
				$info['s6']= '';	
				$info['s7']= '';
				$info['final']= $full_score;	

				$ResultID = $objSportResult->add($info);
			
		}	
		
	//	var_dump($matchInfo["id"]);exit();
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
	$value['l_cn'] = '';
	$value['h_cn'] = '';
	$value['a_cn'] = '';
	
	$poolResult = array();
	switch (strtolower($value['s_code'])) {
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

					//赛果入库 start ======================================================
							$condition = array();
							$condition['m_id'] = $value["id"];
							$condition['p_code'] = strtoupper($pool);
							$condition['combination'] = $combination;
							$if_had_poolresult = $objPoolResult->getsByCondition($condition);
						//	var_dump($matchInfo["id"]);exit();
							if(empty($if_had_poolresult)){//赛果入库
	
									$info = array();
									$info['s_code'] = "BK";
									$info['m_id'] = $value["id"];
									$info['m_num'] = $ballid;
									$info['p_code'] = strtoupper($pool);
									$info['o_type'] = "F";//未使用
									$info['p_id'] = "0";//未使用
									$info['refund'] = "0";//未使用
									$info['totals'] = "0";//未使用
									$info['combination']= $combination;
									$info['value']= "";
									$info['winunit']= "";
									$PoolResultID = $objPoolResult->add($info);
									echo $PoolResultID.PHP_EOL;
							}
						//赛果入库end ======================================================	
					}
				} else {
					//没有让球数
					$combination = scoreToPoolResultBK($pool, scoreChange($value['s_code'], $value['apiInfo']['full_score']));
					$desc = getResults($pool, $combination);
					$poolResult[$pool]['combination'][] = $combination;
					
					
					//赛果入库 start ======================================================
							$condition = array();
							$condition['m_id'] = $value["id"];
							$condition['p_code'] = strtoupper($pool);
							$condition['combination'] = $combination;
							$if_had_poolresult = $objPoolResult->getsByCondition($condition);
			
							if(empty($if_had_poolresult)){//赛果入库
									$info = array();
									$info['s_code'] = "BK";
									$info['m_id'] = $value["id"];
									$info['m_num'] = $value["num"];
									$info['p_code'] = strtoupper($pool);
									$info['o_type'] = "F";//未使用
									$info['p_id'] = "0";//未使用
									$info['refund'] = "0";//未使用
									$info['totals'] = "0";//未使用
									$info['combination']= $combination;
									$info['value']= "";
									$info['winunit']= "";									
									$PoolResultID = $objPoolResult->add($info);
								
								
							}
						//赛果入库end ======================================================	
					
				}
				$poolResult[$pool]['desc'] = $desc;
			}
			break;
	}
	
/*	$return[] = array(
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
	);*/
}


?>

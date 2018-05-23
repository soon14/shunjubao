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
		date('Ymd', time()) 			=> date('Y-m-d', time()),//当天
		date('Ymd', time() + 86400) 	=> date('Y-m-d', time() + 86400),//明天
);
$condition = array(
		'status'	=> array(Betting::STATUS_FINAL),
		'b_date'	=> $b_dates,
);

$return = $matchIds = $score_results = array();


$objBetting = new Betting($sport);
$objSportResult = new SportResult($sport);
$objScoreApi = new ScoreApi();

$objOdds_had = new Odds($sport,"had");//胜平负
$objOdds_hhad = new Odds($sport,"hhad");//让胜平负
$objOdds_ttg = new Odds($sport,"ttg");//总进球
$objOdds_hafu = new Odds($sport,"hafu");//半全场
$objOdds_crs = new Odds($sport,"crs");//比分


foreach ($b_dates as $b_date) {	

	$condition = array();
	$condition['date'] = $b_date;
	$order = 'b_date asc';

	$data = $objBetting->getsByCondition($condition, null, $order);
	
	//var_dump($b_date);//exit();
	
	foreach ($data as $matchInfo) {
		//何雷达接口
		$new_leida_had_array = new_leida_sp($sport,"odds_had",$matchInfo["id"]);
		$new_leida_hhad_array = new_leida_sp($sport,"odds_hhad",$matchInfo["id"]);
		$new_leida_ttg_array = new_leida_sp($sport,"odds_ttg",$matchInfo["id"]);
		$new_leida_hafu_array = new_leida_sp($sport,"odds_hafu",$matchInfo["id"]);	
		$new_leida_crs_array = new_leida_sp($sport,"odds_crs",$matchInfo["id"]);	
		//==========================end
		
		
		$condition = array();
		$condition['m_id'] = $matchInfo["id"];
		
		$had_arr = $objOdds_had->getsByCondition($condition);
		$hhad_arr = $objOdds_hhad->getsByCondition($condition);
		$ttg_arr = $objOdds_ttg->getsByCondition($condition);	
		$hafu_arr = $objOdds_hafu->getsByCondition($condition);
		$crs_arr = $objOdds_crs->getsByCondition($condition);

	
		//雷达接口sp
		foreach($had_arr as $key=>$value){

			if($new_leida_had_array["a"]!=$had_arr[$key]["a"] || $new_leida_had_array["d"]!=$had_arr[$key]["d"] || $new_leida_had_array["h"]!=$had_arr[$key]["h"]){
				$had_unusual = "<span style='color:red'>(有变动)</span>雷达:".$had_arr[$key]["date"]." ".$had_arr[$key]["time"]."<br/>何:".$new_leida_had_array["date"]." ".$new_leida_had_array["time"]."<br/>";
			}else{
				$had_unusual = "雷达:".$had_arr[$key]["date"]." ".$had_arr[$key]["time"]."<br/>何:".$new_leida_had_array["date"]." ".$new_leida_had_array["time"]."<br/>";
			}
			
			$had=$had_unusual."胜(".$had_arr[$key]["a"].")(".$new_leida_had_array["a"].")<br/>平(".$had_arr[$key]["d"].")(".$new_leida_had_array["d"].")<br/>负(".$had_arr[$key]["h"].")(".$new_leida_had_array["h"].")";
		}
		$matchInfo['had'] = $had;





		foreach($hhad_arr as $key=>$value){
			
			if($new_leida_hhad_array["a"]!=$hhad_arr[$key]["a"] || $new_leida_hhad_array["d"]!=$hhad_arr[$key]["d"] || $new_leida_hhad_array["h"]!=$hhad_arr[$key]["h"]){
				$hhad_unusual = "<span style='color:red'>(有变动)</span>雷达：".$hhad_arr[$key]["date"]." ".$hhad_arr[$key]["time"]."<br/>何:".$new_leida_hhad_array["date"]." ".$new_leida_hhad_array["time"]."<br/>";
			}else{
				$hhad_unusual = "雷达:".$hhad_arr[$key]["date"]." ".$hhad_arr[$key]["time"]."<br/>何：".$new_leida_hhad_array["date"]." ".$new_leida_hhad_array["time"]."<br/>";
			}
			
			
			$hhad=$hhad_unusual."让胜(".$hhad_arr[$key]["a"].")(".$new_leida_hhad_array["a"].")<br/>让平(".$hhad_arr[$key]["d"].")(".$new_leida_hhad_array["d"].")<br/>让负(".$hhad_arr[$key]["h"].")(".$new_leida_hhad_array["h"].")";
		}
		$matchInfo['hhad'] = $hhad;
		
		foreach($ttg_arr as $key=>$value){
			$ttg="0球(".$ttg_arr[$key]["s0"].")(".$new_leida_ttg_array["s0"].")<br/>1球(".$ttg_arr[$key]["s1"].")(".$new_leida_ttg_array["s1"].")<br/>2球(".$ttg_arr[$key]["s2"].")(".$new_leida_ttg_array["s2"].")<br/>3球(".$ttg_arr[$key]["s3"].")(".$new_leida_ttg_array["s3"].")<br/>4球(".$ttg_arr[$key]["s4"].")(".$new_leida_ttg_array["s4"].")<br/>5球(".$ttg_arr[$key]["s5"].")(".$new_leida_ttg_array["s5"].")<br/>6球(".$ttg_arr[$key]["s6"].")(".$new_leida_ttg_array["s6"].")<br/>7+球(".$ttg_arr[$key]["s7"].")(".$new_leida_ttg_array["s7"].")";
		}
		$matchInfo['ttg'] = $ttg;	

		foreach($hafu_arr as $key=>$value){
			$hafu="主-主(".$hafu_arr[$key]["aa"].")(".$new_leida_hafu_array["aa"].")<br/>主-平(".$hafu_arr[$key]["ad"].")(".$new_leida_hafu_array["ad"].")<br/>主-客(".$hafu_arr[$key]["ah"].")(".$new_leida_hafu_array["ah"].")<br/>平-主(".$hafu_arr[$key]["da"].")(".$new_leida_hafu_array["da"].")<br/>平-平(".$hafu_arr[$key]["dd"].")(".$new_leida_hafu_array["dd"].")<br/>平-客(".$hafu_arr[$key]["dh"].")(".$new_leida_hafu_array["dh"].")<br/>客-主(".$hafu_arr[$key]["ha"]."(".$new_leida_hafu_array["ha"]."))<br/>客-平(".$hafu_arr[$key]["hd"].")(".$new_leida_hafu_array["hd"].")<br/>客-客(".$hafu_arr[$key]["hh"].")(".$new_leida_hafu_array["hh"].")";
		}
		$matchInfo['hafu'] = $hafu;
		
		

		
		foreach($crs_arr as $key=>$value){
			$crs="1:0(".$crs_arr[$key]["0100"].")(".$new_leida_crs_array["0100"].")<br/>2:0(".$crs_arr[$key]["0200"].")(".$new_leida_crs_array["0200"].")<br/>2:1(".$crs_arr[$key]["0201"].")(".$new_leida_crs_array["0201"].")<br/>3:0(".$crs_arr[$key]["0300"].")(".$new_leida_crs_array["0300"].")<br/>3:1(".$crs_arr[$key]["0301"].")(".$new_leida_crs_array["0301"].")<br/>3:2(".$crs_arr[$key]["0302"].")(".$new_leida_crs_array["0302"].")<br/>4:0(".$crs_arr[$key]["0400"].")(".$new_leida_crs_array["0400"].")<br/>4:1(".$crs_arr[$key]["0401"].")(".$new_leida_crs_array["0401"].")<br/>4:2(".$crs_arr[$key]["0402"].")(".$new_leida_crs_array["0402"].")<br/>5:0(".$crs_arr[$key]["0500"].")(".$new_leida_crs_array["0500"].")<br/>5:1(".$crs_arr[$key]["0501"].")(".$new_leida_crs_array["0501"].")<br/>5:2(".$crs_arr[$key]["0502"].")(".$new_leida_crs_array["0502"].")<br/>胜其他(".$crs_arr[$key]["-1-h"].")(".$new_leida_crs_array["-1-h"].")<br/>";
			
			$crs.="0:0(".$crs_arr[$key]["0000"].")(".$new_leida_crs_array["0000"].")<br/>1:1(".$crs_arr[$key]["0101"].")(".$new_leida_crs_array["0101"].")<br/>2:2(".$crs_arr[$key]["0202"].")(".$new_leida_crs_array["0202"].")<br/>3:3(".$crs_arr[$key]["0303"].")(".$new_leida_crs_array["0303"].")<br/>平其他".$crs_arr[$key]["-1-d"]."(".$new_leida_crs_array["-1-d"].")<br/>";
			
			$crs.="0:1(".$crs_arr[$key]["0001"].")(".$new_leida_crs_array["0001"].")<br/>0:2(".$crs_arr[$key]["0002"].")(".$new_leida_crs_array["0002"].")<br/>1:2(".$crs_arr[$key]["0102"].")(".$new_leida_crs_array["0102"].")<br/>0:3(".$crs_arr[$key]["0003"].")(".$new_leida_crs_array["0003"].")<br/>1:3(".$crs_arr[$key]["0103"].")(".$new_leida_crs_array["0103"].")<br/>2:3(".$crs_arr[$key]["0203"].")(".$new_leida_crs_array["0203"].")<br/>0:4(".$crs_arr[$key]["0004"].")(".$new_leida_crs_array["0004"].")<br/>1:4(".$crs_arr[$key]["0104"].")(".$new_leida_crs_array["0104"].")<br/>2:4(".$crs_arr[$key]["0204"].")(".$new_leida_crs_array["0204"].")<br/>0:5(".$crs_arr[$key]["0005"].")(".$new_leida_crs_array["0005"].")<br/>1:5(".$crs_arr[$key]["0105"].")(".$new_leida_crs_array["0105"].")<br/>2:5(".$crs_arr[$key]["0205"].")(".$new_leida_crs_array["0205"].")<br/>负其他(".$crs_arr[$key]["-1-h"].")(".$new_leida_crs_array["-1-h"]."";
			
			
		}
		$matchInfo['crs'] = $crs;

		
		$results[] = $matchInfo;
	}
}


foreach ($results as $value) {
	$lotttime 	= $value['b_date'];
	$ballid 	= $value['num'];
	//$value['l_cn'] = gb2312toU8($value['l_cn']);
	//$value['h_cn'] = gb2312toU8($value['h_cn']);
	//$value['a_cn'] = gb2312toU8($value['a_cn']);


	$return[] = array(
		'matchId'	=> $value['id'],
		'num'		=> $value['num'],
		'b_date'	=> $lotttime,
		'l_cn'		=> $value['l_cn'],
		'h_cn'		=> $value['h_cn'],
		'a_cn'		=> $value['a_cn'],
		'date'		=> $value['date'],
		'time'		=> $value['time'],
		'had'		=> $value['had'],
		'hhad'		=> $value['hhad'],
		'ttg'		=> $value['ttg'],
		'hafu'		=> $value['hafu'],
		'crs'		=> $value['crs'],
	);
}




$tpl = new Template();
$tpl->assign('return',$return);
$tpl->assign('sport',$sport);

$tpl->assign('cur_time',date("Y-m-d H:i:s"));
$tpl->assign('sportPoolFb',$sportPoolFb);
$tpl->assign('sportPoolBk',$sportPoolBk);
$tpl->d('../admin/game/score_match_sp2');


function new_leida_sp($sport,$pool,$m_id){
	$conn = @mysql_connect("localhost", "root","1q2w3e4R!") or die("Could not connect to database");
	@mysql_select_db("org_spdata", $conn) or die ("Could not select database");

	$sql ="SELECT * FROM ".$sport."_".$pool." where m_id='".$m_id."' limit 0,1";		
	$query = mysql_query($sql,$conn);
	$value = mysql_fetch_array($query);
	return $value;
}







?>
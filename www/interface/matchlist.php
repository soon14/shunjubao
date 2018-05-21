<?php
include_once "../include/init.php";
$s=$_REQUEST["s"];
$p=$_REQUEST["p"];
$f=$_REQUEST["f"];
$date=$_REQUEST["d"]?$_REQUEST["d"]:date("Y-m-d");
switch($s){
	case "fb":$str=fb_list($p,$date);
		echo $f."(".$str.");";
		break;
	case "bk":$str=bk_list($p,$date);
		echo $f."(".$str.");";
		break;
}
function fb_list($p,$date){
	global $db_r;
	$today=date("Y-m-d");
	$total=0; 
	if($date==$today){
		$sql = "select `b_date` from fb_betting where status='Selling' order by `b_date` asc";
	}else{
		$sql = "select `date` as b_date from fb_betting where date='".$date."' order by `b_date` asc";
	}
 	$query = mysql_query($sql,$db_r);
	while($d = mysql_fetch_assoc($query)){
		$total++;
		$dates[$d["b_date"]]++;
	}
 	$str["total"]=$total;
	$str["group"]=count($dates);
 	foreach($dates as $k => $v){
		$datas=array();
		$D=array();
		$datas["day"]=$k;
		$datas["size"]=$v; 
		if($date==$today){
			$sql = "select * from fb_betting where status='Selling' and b_date='".$k."' order by num asc , date asc , time asc";
		}else{
			$sql = "select * from fb_betting where date='".$k."' order by date asc , time asc, num asc";
		}
 		$query = mysql_query($sql,$db_r);
		while($d = mysql_fetch_assoc($query)){
			$end_up_time = getMatchEndTime('fb', $d["b_date"], $d["date"], $d["time"]);
			$d["date"] = $end_up_time['date'];
			$d['time'] = $end_up_time['time'];
			$datas["num"]=iconv('gb2312','utf-8',substr(show_num($d["num"]),0,-3));
			$D[$d["id"]]['id']=$d["id"];
			$D[$d["id"]]['num']=substr($d["num"],1);
			$D[$d["id"]]['date']=$d["date"];
			$D[$d["id"]]['time']=$d["time"];
			$D[$d["id"]]['l_cn']=iconv('gb2312','utf-8',$d["l_cn"]);
			$D[$d["id"]]['l_color']=color($d["l_id"]);
			$D[$d["id"]]['h_cn']=iconv('gb2312','utf-8',$d["h_cn"]);
			$D[$d["id"]]['a_cn']=iconv('gb2312','utf-8',$d["a_cn"]);
			
			if(substr_count($p,",hhad")){
				// hhad
				$sql="select * from fb_odds_hhad where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['hhad']['h']=$odds["h"];
					$D[$d["id"]]['hhad']['d']=$odds["d"];
					$D[$d["id"]]['hhad']['a']=$odds["a"];
					$D[$d["id"]]['hhad']['goalline']=substr($odds["goalline"],0,2);
				}
			}
			if(substr_count($p,",had")){
				// had
				$sql="select * from fb_odds_had where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['had']['h']=$odds["h"];
					$D[$d["id"]]['had']['d']=$odds["d"];
					$D[$d["id"]]['had']['a']=$odds["a"];
				}
			}
			if(substr_count($p,",crs")){
				// crs
				$sql="select * from fb_odds_crs where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['crs']['-1-a']=$odds["-1-a"];
					$D[$d["id"]]['crs']['-1-d']=$odds["-1-d"];
					$D[$d["id"]]['crs']['-1-h']=$odds["-1-h"];
					$D[$d["id"]]['crs']['0000']=$odds["0000"];
					$D[$d["id"]]['crs']['0001']=$odds["0001"];
					$D[$d["id"]]['crs']['0002']=$odds["0002"];
					$D[$d["id"]]['crs']['0003']=$odds["0003"];
					$D[$d["id"]]['crs']['0004']=$odds["0004"];
					$D[$d["id"]]['crs']['0005']=$odds["0005"];
					$D[$d["id"]]['crs']['0100']=$odds["0100"];
					$D[$d["id"]]['crs']['0101']=$odds["0101"];
					$D[$d["id"]]['crs']['0102']=$odds["0102"];
					$D[$d["id"]]['crs']['0103']=$odds["0103"];
					$D[$d["id"]]['crs']['0104']=$odds["0104"];
					$D[$d["id"]]['crs']['0105']=$odds["0105"];
					$D[$d["id"]]['crs']['0200']=$odds["0200"];
					$D[$d["id"]]['crs']['0201']=$odds["0201"];
					$D[$d["id"]]['crs']['0202']=$odds["0202"];
					$D[$d["id"]]['crs']['0203']=$odds["0203"];
					$D[$d["id"]]['crs']['0204']=$odds["0204"];
					$D[$d["id"]]['crs']['0205']=$odds["0205"];
					$D[$d["id"]]['crs']['0300']=$odds["0300"];
					$D[$d["id"]]['crs']['0301']=$odds["0301"];
					$D[$d["id"]]['crs']['0302']=$odds["0302"];
					$D[$d["id"]]['crs']['0303']=$odds["0303"];
					$D[$d["id"]]['crs']['0400']=$odds["0400"];
					$D[$d["id"]]['crs']['0401']=$odds["0401"];
					$D[$d["id"]]['crs']['0402']=$odds["0402"];
					$D[$d["id"]]['crs']['0500']=$odds["0500"];
					$D[$d["id"]]['crs']['0501']=$odds["0501"];
					$D[$d["id"]]['crs']['0502']=$odds["0502"]; 
				}
			}
			if(substr_count($p,",ttg")){
				// ttg
				$sql="select * from fb_odds_ttg where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['ttg']['s0']=$odds["s0"];
					$D[$d["id"]]['ttg']['s1']=$odds["s1"];
					$D[$d["id"]]['ttg']['s2']=$odds["s2"];
					$D[$d["id"]]['ttg']['s3']=$odds["s3"];
					$D[$d["id"]]['ttg']['s4']=$odds["s4"];
					$D[$d["id"]]['ttg']['s5']=$odds["s5"];
					$D[$d["id"]]['ttg']['s6']=$odds["s6"]; 
					$D[$d["id"]]['ttg']['s7']=$odds["s7"];
				}
			}
			if(substr_count($p,",hafu")){
				// hafu
				$sql="select * from fb_odds_hafu where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['hafu']['hh']=$odds["hh"];
					$D[$d["id"]]['hafu']['hd']=$odds["hd"];
					$D[$d["id"]]['hafu']['ha']=$odds["ha"];
					$D[$d["id"]]['hafu']['dh']=$odds["dh"];
					$D[$d["id"]]['hafu']['dd']=$odds["dd"];
					$D[$d["id"]]['hafu']['da']=$odds["da"];
					$D[$d["id"]]['hafu']['ah']=$odds["ah"]; 
					$D[$d["id"]]['hafu']['ad']=$odds["ad"];
					$D[$d["id"]]['hafu']['aa']=$odds["aa"];
				}
			}
			// 比分
			$D[$d["id"]]['score']='';
			$D[$d["id"]]['had_key']='';
			$D[$d["id"]]['hhad_key']='';
			$D[$d["id"]]['ttg_key']='';
			$sql="select * from fb_result where id=".$d["id"];            
			$query1=mysql_query($sql,$db_r);
			if($result=mysql_fetch_array($query1)){ 
				$D[$d["id"]]['score']=$result["final"]; 
			}
			$sql="select * from fb_poolresult where m_id=".$d["id"]." and p_code in ('HHAD','HAD','TTG') and value=''";       
 			$query1=mysql_query($sql,$db_r);
			while($result=mysql_fetch_array($query1)){
				$p_code = $result["p_code"];
				switch ($p_code) {
					case "HAD":
						$D[$d["id"]]['had_key']=substr($result["combination"],0,1);
						break;
					case "HHAD":
						$D[$d["id"]]['hhad_key']=substr($result["combination"],0,1);
						break;
					case "TTG":
						$D[$d["id"]]['ttg_key']=substr($result["combination"],0,1);
					break;
					default:
						;
					break;
				}
							
			}
					
		}
		$datas["matchs"][]=$D;
		$str["datas"][]=$datas;
 	}
	$str=json_encode($str);
	return $str;	
}
function bk_list($p,$date){
	global $db_r;
	$today=date("Y-m-d");
	$total=0; 
	if($date==$today){
		$sql = "select `b_date` from bk_betting where status='Selling' order by `b_date` asc";
	}else{
		$sql = "select `date` as b_date from bk_betting where date='".$date."' order by `b_date` asc";
	}
  	$query = mysql_query($sql,$db_r);
	while($d = mysql_fetch_assoc($query)){
		$total++;
		$dates[$d["b_date"]]++;
	}
	
 	$str["total"]=$total;
	$str["group"]=count($dates);
 	foreach($dates as $k => $v){
		$datas=array();
		$datas["day"]=$k;
		$datas["size"]=$v; 
		if($date==$today){
			$sql = "select * from bk_betting where status='Selling' and b_date='".$k."' order by date asc , time asc,num asc";
		}else{
			$sql = "select * from bk_betting where date='".$k."' order by date asc , time asc,num asc";
		} 
  		$query = mysql_query($sql,$db_r);
		while($d = mysql_fetch_assoc($query)){
			$end_up_time = getMatchEndTime('bk', $d["b_date"],$d["date"], $d["time"]);
			$d["date"] = $end_up_time['date'];
			$d['time'] = $end_up_time['time'];
			$datas["num"]=iconv('gb2312','utf-8',substr(show_num($d["num"]),0,-3));
			$D[$d["id"]]['id']=$d["id"];
			$D[$d["id"]]['num']=substr($d["num"],1);
			$D[$d["id"]]['date']=$d["date"];
			$D[$d["id"]]['time']=$d["time"];
			$D[$d["id"]]['l_cn']=iconv('gb2312','utf-8',$d["l_cn"]);
			$D[$d["id"]]['l_color']=color($d["l_id"]);
			$D[$d["id"]]['h_cn']=iconv('gb2312','utf-8',$d["h_cn"]);
			$D[$d["id"]]['a_cn']=iconv('gb2312','utf-8',$d["a_cn"]);
			
			if(substr_count($p,",mnl")){
				// hhad
				$sql="select * from bk_odds_mnl where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['mnl']['h']=$odds["h"];
 					$D[$d["id"]]['mnl']['a']=$odds["a"];
 				}
			}
			if(substr_count($p,",hdc")){
				// had
				$sql="select * from bk_odds_hdc where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['hdc']['h']=$odds["h"];
 					$D[$d["id"]]['hdc']['a']=$odds["a"];
					$D[$d["id"]]['hdc']['goalline']=$odds["goalline"];
				}
			}
			if(substr_count($p,",hilo")){
				// crs
				$sql="select * from bk_odds_hilo where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
					$D[$d["id"]]['hilo']['h']=$odds["h"];
					$D[$d["id"]]['hilo']['l']=$odds["l"];
					$D[$d["id"]]['hilo']['goalline']=$odds["goalline"];
				}
			}
			if(substr_count($p,",wnm")){
				// ttg
				$sql="select * from bk_odds_wnm where m_id=".$d["id"];            
				$query1=mysql_query($sql,$db_r);
				if($odds=mysql_fetch_array($query1)){ 
 					$D[$d["id"]]['wnm']['w1']=$odds["w1"];
					$D[$d["id"]]['wnm']['w2']=$odds["w2"];
					$D[$d["id"]]['wnm']['w3']=$odds["w3"];
					$D[$d["id"]]['wnm']['w4']=$odds["w4"];
					$D[$d["id"]]['wnm']['w5']=$odds["w5"];
					$D[$d["id"]]['wnm']['w6']=$odds["w6"]; 
					$D[$d["id"]]['wnm']['l1']=$odds["l1"];
					$D[$d["id"]]['wnm']['l2']=$odds["l2"];
					$D[$d["id"]]['wnm']['l3']=$odds["l3"];
					$D[$d["id"]]['wnm']['l4']=$odds["l4"];
					$D[$d["id"]]['wnm']['l5']=$odds["l5"];
					$D[$d["id"]]['wnm']['l6']=$odds["l6"]; 
 				}
			}
		
		}
		$datas["matchs"][]=$D;
	}
	$str["datas"][]=$datas;	
	$str=json_encode($str);
	return $str;	
}

/**
 * 获取比赛的截止投注时间
 * 比较开赛前8分钟与每天投注截止时间，哪个在前用哪个
 * @param $sport
 * @param $b_date
 * @param unknown_type $date
 * @param unknown_type $time
 * @return array('date','time');
 */
function getMatchEndTime($sport, $b_date, $date, $time) {
	
	$new_date = $date;
	$new_time = $time;
	
	$m_timestamp = strtotime($date.' '.$time);//赛事的开赛时间
	$m_timestamp -= 8 * 60;//提前8分钟
	
	$end_up = getSportStartEndTime($sport, $b_date);
	$end_time = $end_up['end_time'];
	
	$d_timestamp = strtotime($end_time);//每天比赛的截止时间
	$timestamp = $d_timestamp;
	
	if ($m_timestamp < $d_timestamp) {
		$timestamp = $m_timestamp;
	}
	$new_date = date('Y-m-d', $timestamp);
	$new_time = date('H:i:s', $timestamp);
	return array('date'=>$new_date, 'time'=>$new_time);
}
?>
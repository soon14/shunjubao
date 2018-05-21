<?php
//转换赛程编号
function show_num($value){
	$day=substr($value,0,1);
	$value=substr($value,1);
	switch($day){
		case 1;$day="周一";break;
		case 2;$day="周二";break;
		case 3;$day="周三";break;
		case 4;$day="周四";break;
		case 5;$day="周五";break;
		case 6;$day="周六";break;
		case 7;$day="周日";break;		
	}
	return $day.$value;	
}
// 联赛颜色
function color($id){
	$C[47]="009900";$C[78]="009900";$C[77]="0CB9E4";$C[3]="567576";$C[60]="41BE76";$C[30]="297CA5";$C[14]="CC9900";
	$C[54]="009966";$C[56]="CB194C";$C[5]="37BE5A";$C[45]="003306";$C[21]="FF850B";$C[75]="3A5500";$C[15]="FF6699";
	$C[63]="054594";$C[31]="663333";$C[32]="6B2B2B";$C[17]="FF6699";$C[64]="57A87B";$C[71]="8EAD12";$C[66]="33BBCC";
	$C[24]="808080";$C[41]="3C3CFF";$C[57]="009966";$C[26]="DCB352";$C[2]="FF7000";$C[29]="128FCD";$C[18]="FF2F73";
	$C[12]="00A8A8";$C[46]="08855C";$C[50]="660033";$C[76]="CC3399";$C[48]="15DBAE";$C[11]="770088";$C[70]="CC9933";
	$C[67]="004488";$C[19]="3A794E";$C[10]="3A7500";$C[52]="666666";$C[73]="660000";$C[6]="DDDD00";$C[23]="A00800";
	$C[23]="003366";$C[1]="336600";$C[39]="005E5E";$C[61]="98CCFF";$C[38]="3C3CFF";$C[62]="006633";$C[40]="0066FF";
	$C[25]="FF3333";$C[37]="990099";$C[70]="CC9933";$C[7]="006633";$C[43]="22C126";$C[42]="009900";$C[49]="00A653";
	$C[69]="F75000";$C[58]="004488";$C[55]="008888";$C[34]="DB31EE";$C[51]="666666";$C[20]="CC3300";$C[36]="A05CA0";
	$C[72]="296CA0";$C[81]="5BC992";$C[82]="000000";$C[28]="2069C4";$C[80]="BE2B8F";$C[27]="2069C4";$C[93]="f157b9";
	$C[94]="f157b9";
	
	if($C[$id]==""){
		return '#000000';
	}else{
		return "#".$C[$id]; 
	}
}
/*　篮球让分胜负　*/
	$SPORT["fb"]="足球";
	$SPORT["bk"]="篮球";
	
/*　篮球让分胜负　*/ 
	$HDC["H"]="让分主胜";$HDC["A"]="让分主负";
/*　篮球胜负　*/ 
	$MNL["H"]="主胜";$MNL["A"]="主负";
/*　篮球大小分　*/ 
	$HILO["H"]="大分";$HILO["L"]="小分";
/*　篮球胜分差　*/ 
	$WNM["L1"]="客胜1-5";$WNM["L2"]="客胜6-10";$WNM["L3"]="客胜11-15";$WNM["L4"]="客胜16-20";
	$WNM["L5"]="客胜21-25";$WNM["L6"]="客胜26+";
	$WNM["W1"]="主胜1-5";$WNM["W2"]="主胜6-10";$WNM["W3"]="主胜11-15";$WNM["W4"]="主胜16-20";
	$WNM["W5"]="主胜21-25";$WNM["W6"]="主胜26+";
	
/*　足球让球胜平负　*/ 
	$HHAD["H"]="胜";$HHAD["D"]="平";$HHAD["A"]="负";
/*　足球胜平负　*/	
	$HAD["H"]="胜";$HAD["D"]="平";$HAD["A"]="负";
/*　足球半全场　*/ 
	$HAFU["HH"]="胜胜";$HAFU["HD"]="胜平";$HAFU["HA"]="胜负";
	$HAFU["DH"]="平胜";$HAFU["DD"]="平平";$HAFU["DA"]="平负";
	$HAFU["AH"]="负胜";$HAFU["AD"]="负平";$HAFU["AA"]="负负";
/*　足球总进球　*/ 
	$TTG["S0"]="0球";$TTG["S1"]="1球";$TTG["S2"]="2球";$TTG["S3"]="3球";
	$TTG["S4"]="4球";$TTG["S5"]="5球";$TTG["S6"]="6球";$TTG["S7"]="7+";
/*　足球比分　*/	
	$CRS["0100"]="1:0";$CRS["0200"]="2:0";$CRS["0201"]="2:1";$CRS["0300"]="3:0";$CRS["0301"]="3:1";$CRS["0302"]="3:2";
	$CRS["0400"]="4:0";$CRS["0401"]="4:1";$CRS["0402"]="4:2";$CRS["0500"]="5:0";$CRS["0501"]="5:1";$CRS["0502"]="5:2";
	$CRS["-1-H"]="胜其他";$CRS["0000"]="0:0";$CRS["0101"]="1:1";$CRS["0202"]="02:02";$CRS["0303"]="3:3";$CRS["-1-D"]="平其他";
	$CRS["0001"]="0:1";$CRS["0002"]="0:2";$CRS["0102"]="1:2";$CRS["0003"]="0:3";$CRS["0103"]="1:3";$CRS["0203"]="2:3";
	$CRS["0004"]="0:4";$CRS["0104"]="1:4";$CRS["0204"]="2:4";$CRS["0005"]="0:5";$CRS["0105"]="1:5";$CRS["0205"]="2:5";
	$CRS["-1-A"]="负其他";
/*　竞彩玩法　*/
	$POOL["hdc"]="让分胜负";$POOL["mnl"]="胜负";
	$POOL["hilo"]="大小分";$POOL["wnm"]="胜分差";
	
	$POOL["had"]="胜平负";$POOL["hhad"]="让球胜平负";
	$POOL["hafu"]="半全场";$POOL["ttg"]="总进球";$POOL["crs"]="比分";
	$POOL["crosspool"]="混合过关";
function chinese($value,$pool){
 	$values=explode(",",$value);
	$value=strtoupper($values[0]);
 	switch($pool){
		case "mnl":global $MNL;$chinese=$MNL[$value];break;
		case "wnm":global $WNM;$chinese=$WNM[$value];break;
		case "crs":global $CRS;$chinese=$CRS[$value];break;
		case "ttg":global $TTG;$chinese=$TTG[$value];break;
		case "hafu":global $HAFU;$chinese=$HAFU[$value];break;
		case "had":global $HAD;$chinese=$HAD[$value];break;
		case "hhad":global $HHAD;$chinese=$HHAD[$value];break;
		case "hilo":global $HILO;$chinese=$HILO[$value];break;
		case "hdc":global $HDC;$chinese=$HDC[$value];break;		  
	}
	$chinese.=$values[1];
	return $chinese?$chinese:$value;
}
/* 分页函数 */
function page_all($page,$sql,$records='30'){	
	global $db_r; 	
	$sql="select count(*) from $sql"; 
	$query=@mysql_query($sql,$db_r);
	$array=@mysql_fetch_row($query);
	$all_records=$array[0];	
	if ($all_records<=0){                     
		return "0" ;
	}
	$all_page=ceil($all_records/$records);	 
	if($page>$all_page){                      
		$page=$all_page; 
	}elseif($page<1){ 	 
		$page=1;
	}  
	$start_topic=($page-1)*$records;		
	$all[0]=$all_records;	//记录总数
	$all[1]=$all_page;		//总页数
	$all[2]=$start_topic;	//本页开始记录
	$all[3]=$records;	//本页开始记录
	return $all;
} 
function page_list($all_page,$search_page,$page,$pages,$search){	 
	if($all_page<=1){
		return "";
	}
	$show_str='';
	$show_str.="<a href=\"$search_page?page=1&$search\" target='_self'>首页</a>" ;
	if (($page/$pages)>0){
		$start_page=(ceil($page/$pages)-1)*$pages+1 ;
	}else{
		$start_page=1;
	}
	$end_page=$start_page+$pages-1;
	if ($all_page>$end_page){ 
		$end_page=$start_page+$pages-1 ;
	}else{ 
		$end_page=$all_page ;
	}
	if (($start_page/$pages)>1){   
		$i=($start_page-$pages );
		$show_str.="<a href=\"$search_page?page=$i&$search\" target='_self'><<</a>";
	} 
	for ($i=$start_page;$i<=$end_page;$i++){ 
		if ($i==$page){
			$show_str.="<a class='hover'>[".$i."]</a>";
		}else{
			$show_str.="<a href=\"$search_page?page=$i&$search\" target='_self'>".$i."</a>";
		}
	} 
	if ($i<=$all_page){  
		$show_str.="<a href=\"$search_page?page=$i&$search\" target='_self'>>></a>";
	} 
	$show_str.="<a href=\"$search_page?page=$all_page&$search\" target='_self'>尾页</a>"; 
	return $show_str;  
} 

/**
 * 临时的跳转方法
 * @param unknown_type $type
 */
function redirectUrl($type, $from = '', $para = array()) {
	$url = $_SERVER['HTTP_HOST']."/zy/confirm/confirm_result.php?";
	if (!$from) $from = $_SERVER['HTTP_REFERER'] . '/www/football/hafu_list.html';
	$para['type'] = $type;
	$para['from'] = $from;
	$url = $url . http_build_query($para);
	header("Location: http://{$url}");
	exit;
}

/**
 * 获取竞彩开售时间和截止时间
 *  竞足 周一至周五 开售：09:00 停售：23：52
		周六、日 开售：09:00 停售：00：52
	竞篮 周一/二/五 09:00～23:52 
		周三/四 07:30～23:52 
		周六/日 09:00～00:52
 * @param string $sport fb|bk
 * @param string $b_date 奖期
 * @return array('start_time'=>2014-12-21 09:00:00 ,'end_time'=>2014-12-21 23:52:00);
 */
function getSportStartEndTime($sport, $b_date = '') {
	$time = time();
	if ($b_date) $time = strtotime($b_date);
	$sport = strtolower($sport);
	$week = date('w', $time);
	$s_date = date('Y-m-d', $time);//开始日期
	$e_date = date('Y-m-d', $time);//截止日期 
	switch ($sport) {
		case 'fb':
			if ($week == 6 || $week == 0) {
				$start_time = '09:00:00';
				$end_time = '00:52:00';
				$e_date = date('Y-m-d', $time + 24 * 3600);//截止日期
			} else {
				$start_time = '09:00:00';
				$end_time = '23:52:00';
			}
			break;
		case 'bk':
			switch ($week) {
				case 1:case 2:case 5:
					$start_time = '09:00:00';
					$end_time = '23:52:00';
					break;
				case 3:case 4:
					$start_time = '07:30:00';
					$end_time = '23:52:00';
					break;
				case 6: case 0:
					$start_time = '09:00:00';
					$end_time = '00:52:00';
					$e_date = date('Y-m-d', $time + 24 * 3600);//截止日期
					break;
			}
			break;
		default:
			$start_time = '09:00:00';
			$end_time = '23:52:00';
			break;
	}
	
	return array('start_time'=>$s_date .' ' . $start_time, 'end_time'=>$e_date .' ' . $end_time);
}
?>
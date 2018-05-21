<?php
/*主库环境*/
define("DB_SERVER","localhost");
define("DB_PORT",3306);
define("DB_USER","root");
define("DB_PASS","meijun820526");
define("DB_DATABASE","zhiying"); 

/* 从库环境变量 */
define("DB_SERVER_R","localhost");
define("DB_PORT_R",3306);
define("DB_USER_R","root");
define("DB_PASS_R","meijun820526");
define("DB_DATABASE_R","zhiying");
/* 连接主库 */
function db_w(){	
	$db_w=mysql_connect(DB_SERVER.':'.DB_PORT,DB_USER,DB_PASS, true);
	mysql_select_db(DB_DATABASE,$db_w); 
	return $db_w;
}
/* 连接从库 */
function db_r(){
	$db_r=mysql_connect(DB_SERVER_R.':'.DB_PORT_R,DB_USER_R,DB_PASS_R, true);
	mysql_select_db(DB_DATABASE_R,$db_r); 
	return $db_r;
}
function check_connection($conn){
	if(@mysql_ping($conn) === false){
		return false;
	}
	return true;
}
function reconnect($conn, $m){
	if(!check_connection($conn)){
		if($m == "master"){
			return db_w();
		}else{
			return db_r();
		}
	}
	return $conn;
}
$db_r=db_r();
$db_w=db_w();

/* 验证文件时间 */
function check_file($name,$date,$time,$xsn){
	global $db_w,$db_r,$url;
	$id=0;
	$sql="select * from `match_xml` where `name`='$name' order by date desc, time desc limit 1";
	$db_r = reconnect($db_r, "slave");
	$query=mysql_query($sql,$db_r);
	if($d=mysql_fetch_array($query)){
		$id=$d["id"]; 
	}
	$contentmd5 = md5_file($url.$name);
	if($id==0){
		$sql="insert into `match_xml` set `name`='$name',`date`='$date',`time`='$time',`contentmd5`='$contentmd5',xsn='$xsn'";
	}elseif($date==$d["date"]){
		if(($time>$d["time"]) or ($time==$d["time"] and $xsn>$d['xsn']) ){
			$sql="update `match_xml` set `date`='$date',`time`='$time',`contentmd5`='$contentmd5',xsn='$xsn' where id=$id";
		}else{
			return false;
		}
	}elseif($date>$d["date"]){
		$sql="update `match_xml` set `date`='$date',`time`='$time',`contentmd5`='$contentmd5',xsn='$xsn' where id=$id";
	}else{
		return true;		
	}
	$db_w = reconnect($db_w, "master");
	mysql_query($sql,$db_w);
	return true;
}
/* 数组　*/
function LEAGUEINFO(){	
	global $db_r;
	$sql="select `id`,`cn` from `fb_league`";
	$db_r = reconnect($db_r, "slave");
	$query=mysql_query($sql,$db_r);
	while($d=mysql_fetch_array($query)){
		$L["fb"][$d["id"]]=$d["cn"]; 
	}
	$sql="select `id`,`cn` from `bk_league`";
	$db_r = reconnect($db_r, "slave");
	$query=mysql_query($sql,$db_r);
	while($d=mysql_fetch_array($query)){
		$L["bk"][$d["id"]]=$d["cn"]; 
	}
	return $L;
} 
function TEAMINFO(){	
	global $db_r;
	$sql="select `id`,`cn` from `fb_team`";
	$db_r = reconnect($db_r, "slave");
        $query=mysql_query($sql,$db_r);
	while($d=mysql_fetch_array($query)){
		$T["fb"][$d["id"]]=$d["cn"]; 
	}
	$sql="select `id`,`cn` from `bk_team`";
	$db_r = reconnect($db_r, "slave");
        $query=mysql_query($sql,$db_r);
	while($d=mysql_fetch_array($query)){
		$T["bk"][$d["id"]]=$d["cn"]; 
	}
	return $T;
}
function application($index,$vals){
	global $db_w,$db_r;
	$date=$vals[$index['APPPARAM'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['APPPARAM'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
 	if(!check_file('1_0_0.xml',$date,$time,$xsn)){
		return ;
	} 
	foreach ($index as $k=>$v){  
		if($k=="SPORTS"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code=$vals[$v[$i]]["attributes"]["CODE"];
					$no=$vals[$v[$i]]["attributes"]["NO"];
					$en=$vals[$v[$i]+1]["value"];
					$cn=$vals[$v[$i]+2]["value"];
 					$str="`type`='sports',`code`='$code',`no`='$no',`en`='$en',`cn`='$cn'";
					$sql="replace `match_application` set $str";
					$sql=iconv("utf-8","gb2312",$sql);
					$db_w = reconnect($db_w, "master");
 					mysql_query($sql,$db_w);
 				}
			}
		}
		if($k=="POOL"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code=$vals[$v[$i]]["attributes"]["CODE"];
					$o_type=$vals[$v[$i]]["attributes"]["ODDSTYPE"];
					$no=$vals[$v[$i]]["attributes"]["NO"];
					$p_type=$vals[$v[$i]+1]["value"];
					$en=$vals[$v[$i]+2]["value"];
					$cn=$vals[$v[$i]+3]["value"];
					$str="`type`='pool',`code`='$code',`o_type`='$o_type',`no`='$no',`p_type`='$p_type',`en`='$en',`cn`='$cn'";
					$sql="replace `match_application` set $str";
					$sql=iconv("utf-8","gb2312",$sql);
					$db_w = reconnect($db_w, "master");
  					mysql_query($sql,$db_w);
   				}
			}
		}
	} 
}
function league($index,$vals,$sports){
	global $db_w,$db_r;
	$date=$vals[$index['LEAGUELIST'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['LEAGUELIST'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('2_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_league";break;
		case 2:$db="bk_league";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="LEAGUE"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code=$vals[$v[$i]]["attributes"]["CODE"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$en=$vals[$v[$i]+1]["value"];
					$cn=$vals[$v[$i]+2]["value"];
					$display=$vals[$v[$i]+3]["value"];
					$str="`id`='$id',`s_code`='$s_code',`code`='$code',`en`='$en',`cn`='$cn',`display`='$display'";
					$sql="replace `$db` set $str";
					$sql=iconv("utf-8","gbk",$sql);
					$db_w = reconnect($db_w, "master");
   					mysql_query($sql,$db_w); 
  				}
			}
		}
	} 
}
function team($index,$vals,$sports){
	global $db_w,$db_r;
	$date=$vals[$index['TEAMLIST'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['TEAMLIST'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('3_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_team";break;
		case 2:$db="bk_team";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="TEAM"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code=$vals[$v[$i]]["attributes"]["CODE"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$en=$vals[$v[$i]+1]["value"];
					$en=str_replace("'","",$en);
					$cn=$vals[$v[$i]+2]["value"];
					$cn=str_replace("'","",$cn);
					$c_code=$vals[$v[$i]+3]["attributes"]["CODE"];
					$c_id=$vals[$v[$i]+3]["attributes"]["ID"];
 					$str="`id`='$id',`s_code`='$s_code',`code`='$code',`en`='$en',`cn`='$cn',`c_code`='$c_code',`c_id`='$c_id'";
					$sql="replace `$db` set $str";
					$sql=iconv("utf-8","gbk",$sql);
  					mysql_query($sql,$db_w); 
 				}
			}
		}
	} 
}
function betting($index,$vals,$sports){
	return;
	global $db_w,$db_r;
	$date=$vals[$index['BETMATCHLIST'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['BETMATCHLIST'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('4_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_betting";break;
		case 2:$db="bk_betting";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$date=$vals[$v[$i]+1]["value"];
					$time=$vals[$v[$i]+2]["value"];
					$b_date=$vals[$v[$i]+3]["value"];
					$status=$vals[$v[$i]+4]["value"];					
					/* league */
					$l_code=$vals[$v[$i]+5]["attributes"]["CODE"];
					$l_id=$vals[$v[$i]+5]["attributes"]["ID"];
					$l_en=$vals[$v[$i]+6]["value"];
					$l_cn=$vals[$v[$i]+7]["value"]; 
 					/* home */
					$h_code=$vals[$v[$i]+9]["attributes"]["CODE"];
					$h_id=$vals[$v[$i]+9]["attributes"]["ID"];
					$h_en=$vals[$v[$i]+10]["value"];
					$h_cn=$vals[$v[$i]+11]["value"];					
					/* away */
					$a_code=$vals[$v[$i]+13]["attributes"]["CODE"];
					$a_id=$vals[$v[$i]+13]["attributes"]["ID"];
					$a_en=$vals[$v[$i]+14]["value"];
					$a_cn=$vals[$v[$i]+15]["value"];
					$str="`id`='$id',`s_code`='$s_code',`num`='$num',`date`='$date',`time`='$time',`b_date`='$b_date',";
					$str.="`status`='$status',`l_code`='$l_code',`l_id`='$l_id',`l_en`='$l_en',`l_cn`='$l_cn',";
					$str.="`h_code`='$h_code',`h_id`='$h_id',`h_en`='$h_en',`h_cn`='$h_cn',";
					$str.="`a_code`='$a_code',`a_id`='$a_id',`a_en`='$a_en',`a_cn`='$a_cn'";
					$sql="replace `$db` set $str";
					$sql=iconv("utf-8","gbk",$sql);
					//mysql_query($sql,$db_w); 
				}
			}
		}
	} 
}
function matchs($index,$vals,$sports){
	global $db_w,$db_r;
	$date=$vals[$index['MATCHLIST'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['MATCHLIST'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];	
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('5_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	$L=LEAGUEINFO();
    $T=TEAMINFO();
	switch($sports){
		case 1:$db="fb_betting";break;
		case 2:$db="bk_betting";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					if($sports==1){
						if($id>=401 and $id<=499){
						//	continue;
						}
					}elseif($sports==2){
						if($id>=151 and $id<=300){
						//	continue;
						}
					}
					$date=$vals[$v[$i]+1]["value"];
					$time=$vals[$v[$i]+2]["value"];
					$b_date=$vals[$v[$i]+3]["value"];
					$status=$vals[$v[$i]+4]["value"];					
					/* league */
					$l_code=$vals[$v[$i]+5]["attributes"]["CODE"];
					$l_id=$vals[$v[$i]+5]["attributes"]["ID"];					 
					/* home */
					$h_code=$vals[$v[$i]+6]["attributes"]["CODE"];
					$h_id=$vals[$v[$i]+6]["attributes"]["ID"];				 
					/* away */
					$a_code=$vals[$v[$i]+7]["attributes"]["CODE"];
					$a_id=$vals[$v[$i]+7]["attributes"]["ID"];	
			 		$l_cn=$L[substr($db,0,2)][$l_id];
					$h_cn=$T[substr($db,0,2)][$h_id];
					$a_cn=$T[substr($db,0,2)][$a_id];					
					$count=0;
					$sql="select `id` from `$db` where `id`='$id'";
					$db_r = reconnect($db_r, "slave");
					$query=mysql_query($sql,$db_r);
					if($d=mysql_fetch_array($query)){
						$count=$d["id"];
					}
					$str="`id`='$id',`s_code`='$s_code',`num`='$num',`date`='$date',`time`='$time',`b_date`='$b_date',";
					$str.="`status`='$status',`l_code`='$l_code',`l_id`='$l_id',`l_cn`='$l_cn',";
					$str.="`h_code`='$h_code',`h_id`='$h_id',`h_cn`='$h_cn',";
					$str.="`a_code`='$a_code',`a_id`='$a_id',`a_cn`='$a_cn'";
					if($count>0){
						$sql="update `$db` set $str where id=$id";
					}else{
						$sql="insert into `$db` set $str";
					}				 
					$db_w = reconnect($db_w, "master");
					mysql_query($sql,$db_w); 
				}
			}
		}
	} 
}
function allpool($index,$vals,$sports){
	global $db_w,$db_r;
	$date=$vals[$index['ALLPOOLDEFINED'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['ALLPOOLDEFINED'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('6_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_allpool";$nc=4;break;
		case 2:$db="bk_allpool";$nc=4;break;
	}
	foreach ($index as $k=>$v){  
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$j=$v[$i]+1;
					for($n=1;$n<=$nc;$n++){		
						$p_code=$vals[$j]["attributes"]["CODE"];
						if(!isset($p_code)){
							break;
						}
						$o_type=$vals[$j]["attributes"]["ODDSTYPE"];
						$p_id=$vals[$j]["attributes"]["ID"];
						$j=$j+2;
						$single=$vals[$j]["value"];
						$allup=$vals[++$j]["value"];
						$goalline=$fixedodds="";
						if($p_code=="HAD"){
							$j=$j+3;
						}elseif(strpos("0,HHAD,OUOE,HDC,HILO",$p_code)){
							$j=$j+2;
							// 判断goalline 具体类型
							if($vals[$j]["tag"]=="FIXEDODDSGOALLINE"){
								$fixedodds=$vals[$j]["value"];
								if($fixedodds=="0.00"){
									$fixedodds='';
								}
								$j=$j+1;
							}elseif($vals[$j]["tag"]=="GOALLINE"){
								$goalline=$vals[$j]["value"];
								if($goalline=="0.00"){
									$goalline='';
								}
								$j=$j+1;
							}
							// 判断浮动和过关goal是否同时存在
							if(isset($vals[$j]["value"])){
								$fixedodds=$vals[$j]["value"];
								if($fixedodds=="0.00"){
									$fixedodds='';
								}
								$j=$j+2;
							}else{
								$j++;
							}							
						}else{
							$j=$j+3;
						}
						
						$c_date=$vals[$j]["value"];
						$c_time=$vals[++$j]["value"];
						$j=$j+2;
						$totalleg=$vals[$j]["attributes"]["TOTALLEG"];
						$s_date=$vals[++$j]["attributes"]["INITIALDATE"];
						$s_time=$vals[$j]["attributes"]["INITIALTIME"];					
						$cbt=$vals[++$j]["value"];
						$int=$vals[++$j]["value"];
						$vbt=$vals[++$j]["value"];
						$j=$j+3;					 
						$str="`s_code`='$s_code',`m_id`='$id',`m_num`='$num',`p_code`='$p_code',`o_type`='$o_type',";
						$str.="`p_id`='$p_id',`single`='$single',`allup`='$allup',`goalline`='$goalline',`fixedodds`='$fixedodds',";
						$str.="`c_date`='$c_date',`c_time`='$c_time',`totalleg`='$totalleg',`s_date`='$s_date',";
						$str.="`s_time`='$s_time',`cbt`='$cbt',`int`='$int',`vbt`='$vbt'";
						$sql="select id from `$db` where `m_id`='$id' and `p_code`='$p_code'";
						$db_r = reconnect($db_r, "slave");
						$query=mysql_query($sql,$db_r);
						if($d=mysql_fetch_array($query)){ }						
						if($d["id"]>0){
							$sql="update `$db` set $str where `m_id`='$id' and `p_code`='$p_code'";
						}else{
							$sql="insert into `$db` set $str";
 						}
						$db_w = reconnect($db_w, "master");
						mysql_query($sql,$db_w);  	 			
					}
 				}
			}
		}
	} 
}
function pool($index,$vals,$sports,$p_no){
	global $db_w,$db_r;
	$date=$vals[$index['POOLDEFINED'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['POOLDEFINED'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('7_'.$sports.'_'.$p_no.'.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_allpool";break;
		case 2:$db="bk_allpool";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$j=$v[$i]+1;					 
					/* pool */						
					$p_code=$vals[$j]["attributes"]["CODE"];
					$o_type=$vals[$j]["attributes"]["ODDSTYPE"];
					$p_id=$vals[$j]["attributes"]["ID"];
					$status=$vals[++$j]["value"];
					$j=$j+2;
					$single=$vals[$j]["value"];
					$allup=$vals[++$j]["value"];
					$goalline=$fixedodds="";
					if($p_code=="HAD"){
						$j=$j+3;
					}elseif(strpos("0,HHAD,OUOE,HDC,HILO",$p_code)){
						$j=$j+2;
						// 判断goalline 具体类型
						if($vals[$j]["tag"]=="FIXEDODDSGOALLINE"){
							$fixedodds=$vals[$j]["value"];
							if($fixedodds=="0.00"){
								$fixedodds='';
							}
							$j=$j+1;
						}elseif($vals[$j]["tag"]=="GOALLINE"){
							$goalline=$vals[$j]["value"];
							if($goalline=="0.00"){
								$goalline='';
							}
							$j=$j+1;
						}
						// 判断浮动和过关goal是否同时存在
						if(isset($vals[$j]["value"])){
							$fixedodds=$vals[$j]["value"];
							if($fixedodds=="0.00"){
								$fixedodds='';
							}
							$j=$j+2;
						}else{
							$j++;
						}							
					}else{
						$j=$j+3;
					}
					$c_date=$vals[$j]["value"];
					$c_time=$vals[++$j]["value"];
					$j=$j+2;
					$totalleg=$vals[$j]["attributes"]["TOTALLEG"];
					$s_date=$vals[++$j]["attributes"]["INITIALDATE"];
					$s_time=$vals[$j]["attributes"]["INITIALTIME"];					
					$cbt=$vals[++$j]["value"];
					$int=$vals[++$j]["value"];
					$vbt=$vals[++$j]["value"];
					$j=$j+3;	
					$str="`s_code`='$s_code',`m_id`='$id',`m_num`='$num',`p_code`='$p_code',`o_type`='$o_type',`p_id`='$p_id',";
					$str.="`status`='$status',`single`='$single',`allup`='$allup',`goalline`='$goalline',`fixedodds`='$fixedodds',";
					$str.="`c_date`='$c_date',`c_time`='$c_time',`totalleg`='$totalleg',`s_date`='$s_date',";
					$str.="`s_time`='$s_time',`cbt`='$cbt',`int`='$int',`vbt`='$vbt'";
					$sql="select id from `$db` where `m_id`='$id' and `p_code`='$p_code'";
					$db_r = reconnect($db_r, "slave");
					$query=mysql_query($sql,$db_r);
					if($d=mysql_fetch_array($query)){ }						
					if($d["id"]>0){
						$sql="update `$db` set $str where `m_id`='$id' and `p_code`='$p_code'";
					}else{
						$sql="insert into `$db` set $str";
 					}	
					$db_w = reconnect($db_w, "master");
 					mysql_query($sql,$db_w);  
 				}
			}
		}
	} 
}
function spvalue($index,$vals,$sports,$p_no){
	global $db_w,$db_r;
	$date=$vals[$index['MATCHSPVALUE'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['MATCHSPVALUE'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	$p_code=strtolower($vals[$index['POOLCODE'][0]]["value"]);
	if(!check_file('8_'.$sports.'_'.$p_no.'.xml',$date,$time,$xsn)){
			return ;
	}
	switch($sports){
		case 1:$db="fb_spvalue_".$p_code;break;
		case 2:$db="bk_spvalue_".$p_code;break;
	}
	foreach ($index as $k=>$v){ 
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$p_id=$vals[$v[$i]+1]["attributes"]["ID"];
					$status=$vals[$v[$i]+1]["attributes"]["STATUS"];
 					$j=$v[$i]+2;
				    $key="";	
					$str="`s_code`='$s_code',`m_id`='$id',`m_num`='$num',";
 					$str.="`p_id`='$p_id',`status`='$status',";
					$d=$t="";	
					$del=1;	
					for($n=1;$n<=31;$n++){
						if(!isset($vals[$j]["attributes"]["C"])){
							break;
						}
						$c=str_replace(":","",$vals[$j]["attributes"]["C"]);
						if($p_code=="wnm"){
							$c=str_replace("+","w",$vals[$j]["attributes"]["C"]);
							$c=str_replace("-","l",$c);
						}						
						if(strlen($c)==1 and is_numeric($c)){
							$c="s".$c;
						}
						$value=$vals[$j]["attributes"]["V"];
						if($value!="99999.00"){
							$del=0;	
 						}
						$date=$vals[$j]["attributes"]["D"];
						$t=$vals[$j]["attributes"]["T"];
						$j++;
 						$key.="`$c`='$value' and ";
						$str.="`$c`='$value',";
					}
					$str.="`date`='$date',`time`='$t'";
 					if($del==1){
						$sql="select count(*) cnt from `$db` where `m_id`='$id' and `p_id`='$p_id'";
 						$db_r = reconnect($db_r, "slave");
   						$query=mysql_query($sql,$db_r);						
						if($d=mysql_fetch_array($query)){ }				
						if($d[0]>1){
							$sql="delete from `$db` where `m_id`='$id' and `p_id`='$p_id'";
 							$db_w = reconnect($db_w, "master");
  						//	mysql_query($sql,$db_w);
						}else{
							$sql="insert into `$db` set $str";
 							$db_w = reconnect($db_w, "master");
   							mysql_query($sql,$db_w); 
						} 
 					}else{
						$last_id=$same_id='';
						$sql="select id from `$db` where `m_id`='$id' and `p_id`='$p_id' order by id desc limit 1";
						$db_w = reconnect($db_w, "master");
						$query=mysql_query($sql,$db_w);
						if($d=mysql_fetch_array($query)){
							$last_id=$d["id"];
						}	
						$sql="select id from `$db` where `m_id`='$id' and $key `p_id`='$p_id' order by id desc limit 1";
						$db_w = reconnect($db_w, "master");
						$query=mysql_query($sql,$db_w);
						if($d=mysql_fetch_array($query)){ 
							$same_id=$d["id"];
						}						
						if(($last_id!=$same_id and $last_id!='') or ($last_id=='' and $same_id=="")){
							$sql="insert into `$db` set $str";
							$db_w = reconnect($db_w, "master");
 							mysql_query($sql,$db_w); 
						}
					}
				} 
			}
		}
	}
}
function result($index,$vals,$sports){
	global $db_w,$db_r;
	$date=$vals[$index['MATCHRESULT'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['MATCHRESULT'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('9_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_result";$nc=3;break;
		case 2:$db="bk_result";$nc=99;break;
	}
	foreach ($index as $k=>$v){   	
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				$_setdata = array();
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$status=$vals[$v[$i]+1]["value"];
					$j=$v[$i]+3;
					$half=$full=$final='';
					for($n=1;$n<=$nc;$n++){
						if(!isset($vals[$j]["attributes"]["NO"])){
							break;
						}
						$no=$vals[$j]["attributes"]["NO"];
						if($sports==1){
							switch($no){
								case 1:$half=$vals[$j]["value"];
								case 2:$full=$vals[$j]["value"];
								case 999:$final=$vals[$j]["value"];	
							} 
							$j++;
						}else{
							switch($no){
								case 1:$s1=$vals[$j]["value"];$_setdata[] = "`s1`='$s1'";break;
								case 2:$s2=$vals[$j]["value"];$_setdata[] = "`s2`='$s2'";break;
								case 3:$s3=$vals[$j]["value"];$_setdata[] = "`s3`='$s3'";break;
								case 4:$s4=$vals[$j]["value"];$_setdata[] = "`s4`='$s4'";break;
								case 5:$s5=$vals[$j]["value"];$_setdata[] = "`s5`='$s5'";break;
								case 6:$s6=$vals[$j]["value"];$_setdata[] = "`s6`='$s6'";break;
								case 7:$s7=$vals[$j]["value"];$_setdata[] = "`s7`='$s7'";break;
								case 999:$final=$vals[$j]["value"];	$_setdata[] = "`final`='$final'";break;
								} 
							$j++;
						}						
 					}	
					$str="`id`='$id',`s_code`='$s_code',`m_num`='$num',`status`='$status',";
					if($sports==1){
						$str.="`half`='$half',`full`='$full',`final`='$final'";
					}else{
						$str .= implode(",", $_setdata);
					}				
					$sql="replace `$db` set $str";
					$db_w = reconnect($db_w, "master");
					mysql_query($sql,$db_w); 		
  				}
			}
		}
	} 
}
function poolresult($index,$vals,$sports){
	global $db_w,$db_r;
	$date=$vals[$index['MATCHPOOLDIV'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['MATCHPOOLDIV'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('10_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_poolresult";$nc=5;break;
		case 2:$db="bk_poolresult";$nc=4;break;
	}
 	foreach ($index as $k=>$v){  
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
 					$j=$v[$i]+1;
					for($n=1;$n<=$nc;$n++){
						if(!isset($vals[$j]["attributes"]["CODE"])){
							break;
						}
						$code=$vals[$j]["attributes"]["CODE"];
						$o_type=$vals[$j]["attributes"]["ODDSTYPE"];
						$p_id=$vals[$j]["attributes"]["ID"];
						$refund=$vals[++$j]["value"];
						if($refund!=1){ 
							$totals=$vals[++$j]["value"];
							for($c=1;$c<=20;$c++){
								if(!isset($vals[++$j]["attributes"]["COMBINATION"])){
 									$j++;
									break;
								}
								$combination=$vals[$j]["attributes"]["COMBINATION"].",";
								$combination.=@$vals[$j]["attributes"]["GOALLINE"];
								$value=@$vals[$j]["attributes"]["VALUE"];
								$winunit=@$vals[$j]["attributes"]["WINUNIT"];
 								$str="`m_id`='$id',`s_code`='".$s_code."',`m_num`='$num',`p_code`='$code',";
								$str.="`o_type`='$o_type',`p_id`='$p_id',`refund`='$refund',";
								$str.="`totals`='$totals',`combination`='$combination',`value`='$value',winunit='$winunit'";
								$sql="select id from `$db` where `m_id`='$id' and `p_code`='$code' and `combination`='$combination' and `value`='$value'";
								$db_r = reconnect($db_r, "slave");
 								$query=mysql_query($sql,$db_r);
								if($d=@mysql_fetch_array($query)){ }
								if($d["id"]>0){
									$sql="update `$db` set $str where `m_id`='$id' and `p_code`='$code' and  `combination`='$combination' and `value`='$value'";
								}else{
									$sql="insert into `$db` set $str";
								} 
								$db_w = reconnect($db_w, "master");
  								mysql_query($sql,$db_w); 	 
							}							
						}else{
							$totals=$combination=$value="";
						}												
					}			
  				}
			}
		}
	}
}
function country($index,$vals){
	global $db_r,$db_w;
	$date=$vals[$index['COUNTRYLIST'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['COUNTRYLIST'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	if(!check_file('11_0_0.xml',$date,$time,$xsn)){
		return ;
	}
	foreach ($index as $k=>$v){  
		if($k=="COUNTRY"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code=$vals[$v[$i]]["attributes"]["CODE"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$en=$vals[$v[$i]+1]["value"];
					$cn=$vals[$v[$i]+2]["value"]; 
					$str="`id`='$id',`code`='$code',`en`='$en',`cn`='$cn'";
					$sql="replace `match_country` set $str";
  					$sql=iconv("utf-8","gbk",$sql);
					$db_w = reconnect($db_w, "master");
					mysql_query($sql,$db_w);
 				}
			}
		}
	} 
}
function allup($index,$vals,$sports){
	global $db_r,$db_w;
	$date=$vals[$index['ALLUPFORMULA'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['ALLUPFORMULA'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	if(!check_file('12_'.$sports.'_0.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:$db="fb_allup";break;
		case 2:$db="bk_allup";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="POOL"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code=$vals[$v[$i]]["attributes"]["CODE"];
					$no=$vals[$v[$i]]["attributes"]["NO"];
					$j=$v[$i];
					for($n=1;$n<=57;$n++){
 						$formula=$vals[++$j]["attributes"]["FORMULA"];
						if($formula==""){
 							break;
						}
						$value=$vals[$j]["value"]; 
  						$str="`s_code`='$s_code',`p_code`='$code',`p_no`='$no',`formula`='$formula',`value`='$value'";
						$sql="select id from `$db` where `p_code`='$code' and `formula`='$formula'";
						$db_r = reconnect($db_r, "slave");
						$query=mysql_query($sql,$db_r);
						if($d=mysql_fetch_array($query)){ }
						if($d["id"]>0){
							$sql="update `$db` set $str where `p_code`='$code' and `formula`='$formula'";
 						}else{
							$sql="insert into `$db` set $str";
 						} 
						$db_w = reconnect($db_w, "master");
 						mysql_query($sql,$db_w); 				
 					}			 
 				} 
			}
		}
	if($k=="CROSSPOOL"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$code="CROSSPOOL";$vals[$v[$i]]["attributes"]["CODE"];
					$no="";$vals[$v[$i]]["attributes"]["NO"];
					$j=$v[$i];
					for($n=1;$n<=57;$n++){
 						$formula=$vals[++$j]["attributes"]["FORMULA"];
						if($formula==""){
 							break;
						}
						$value=$vals[$j]["value"]; 
  						$str="`s_code`='$s_code',`p_code`='$code',`p_no`='$no',`formula`='$formula',`value`='$value'";
						$sql="select id from `$db` where `p_code`='$code' and `formula`='$formula'";
						$db_r = reconnect($db_r, "slave");
						$query=mysql_query($sql,$db_r);
						if($d=mysql_fetch_array($query)){ }
						if($d["id"]>0){
							$sql="update `$db` set $str where `p_code`='$code' and `formula`='$formula'";
 						}else{
							$sql="insert into `$db` set $str";
 						} 
						$db_w = reconnect($db_w, "master");
 						mysql_query($sql,$db_w); 				
 					}			 
 				} 
			}
		}

	} 
}
function odds($index,$vals,$sports,$p_no){
	global $db_w,$db_r;
	$date=$vals[$index['MATCHODDS'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['MATCHODDS'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	$p_code=strtolower($vals[$index['POOLCODE'][0]]["value"]);
	if(!check_file('13_'.$sports.'_'.$p_no.'.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:
			$db="fb_odds_".$p_code;
			$db_his = $db."_HIS";
			break;		
		case 2:$db="bk_odds_".$p_code;
			$db_his = $db."_HIS";
			break;
	}
	foreach ($index as $k=>$v){ 	
		if($k=="MATCH"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$p_id=$vals[$v[$i]+1]["attributes"]["ID"];
  					if($p_code=="had"){
						$goalline="";
                       	$j=$v[$i]+2;
					}elseif(strpos("0,hhad,ouoe,hdc,hilo",$p_code)){
						$goalline=$vals[$v[$i]+2]["value"];
						if($goalline=="+0.00"){
							$goalline="";
						}
						$goalline="`goalline`='$goalline',";
						$j=$v[$i]+3;
					}else{
						$goalline="";
						$j=$v[$i]+2;
					}					
					$str="`s_code`='$s_code',`m_id`='$id',`m_num`='$num',";
					$str.="`p_id`='$p_id',";	
					$d=$t="";		
					for($n=1;$n<=31;$n++){ 
						if(!isset($vals[$j]["attributes"]["C"])){
 							break;
						}
						$c=str_replace(":","",$vals[$j]["attributes"]["C"]);
						if($p_code=="wnm"){
							$c=str_replace("+","w",$vals[$j]["attributes"]["C"]);
							$c=str_replace("-","l",$c);
						}
 						if(strlen($c)==1 and is_numeric($c)){
							$c="s".$c;
						}
						$s=str_replace(":","",$vals[$j]["attributes"]["S"]);
						if($s==1){
							$value=$vals[$j]["attributes"]["V"];
						}else{
							$value="";
						}						
						$date=$vals[$j]["attributes"]["D"];
						$t=$vals[$j]["attributes"]["T"];
						$j++;
 						$str.="`$c`='$value',";
					}
					$str.="$goalline `date`='$date',`time`='$t'";
 					$sql="select id from `$db` where `m_id`='$id' and `p_id`='$p_id'";
					$db_r = reconnect($db_r, "slave");
 					$query=mysql_query($sql,$db_r);
					if($d=mysql_fetch_array($query)){}
 					if($d["id"]>0){
						$sql="update `$db` set $str where `m_id`='$id' and `p_id`='$p_id' ";
 					}else{
						$sql="insert into `$db` set $str";
 					}
					//echo $sql."<br>";
					$db_w = reconnect($db_w, "master");
 					mysql_query($sql,$db_w); 
					// his
					$sql = "select m_id from `$db_his` where `m_id`='$id' and `date`='$date' and `time`='$t'";
					$query=mysql_query($sql,$db_r);
					if($d=mysql_fetch_array($query)){}
					if($d["m_id"]<=0){
						$sql="insert into `$db_his` set $str";
						$db_w = reconnect($db_w, "master");
						mysql_query($sql,$db_w);														
					}
  				}
			}
		}
	}
}
function tournament_pool($index,$vals,$sports){
  	global $db_w,$db_r;
	$date=$vals[$index['TOURNPOOL'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['TOURNPOOL'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];	
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
 	if(!check_file('23_'.$sports.'_0.xml',$date,$time,$xsn)){
	return ;
	}
	switch($sports){
		case 1:$db="fb_tournament";break;
		case 2:$db="bk_tournament";break;
	}
	foreach ($index as $k=>$v){  
		if($k=="TOURNAMENT"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$code=$vals[$v[$i]]["attributes"]["SHORTCODE"];
					$en=$vals[++$v[$i]]["value"];
					$cn=$vals[++$v[$i]]["value"];
					$sql_str1="t_num=$num,t_id=$id,t_code='$code',t_en='$en',t_cn='$cn',";
 					for($n=1;$n<=10;$n++){
						if(!isset($vals[++$v[$i]]["attributes"]["CODE"])){
							if(!isset($vals[++$v[$i]]["attributes"]["CODE"])){
								break;	
							}  													 
						}	
						$p_code=$vals[$v[$i]]["attributes"]["CODE"];
						$p_type=$vals[$v[$i]]["attributes"]["ODDSTYPE"];
						$p_id=$vals[$v[$i]]["attributes"]["ID"];
						$p_status=$vals[$v[$i]]["attributes"]["STATUS"];
						$l_code=$vals[++$v[$i]]["attributes"]["CODE"];
						$l_id=$vals[$v[$i]]["attributes"]["ID"];
						$v[$i]=$v[$i]+1;
  						$c_date=$vals[++$v[$i]]["value"];
						$c_time=$vals[++$v[$i]]["value"];
 						$v[$i]=$v[$i]+2;
  						$single=$vals[++$v[$i]]["value"];
						$allup=$vals[++$v[$i]]["value"];
						
						$v[$i]=$v[$i]+2;
  						$cbt=$vals[++$v[$i]]["value"];
						$int=$vals[++$v[$i]]["value"];
						$vbt=$vals[++$v[$i]]["value"];
						
						$sql_str2="p_code='$p_code',p_type='$p_type',p_id=$p_id,p_status='$p_status',";
						$sql_str2.="l_code='$l_code',l_id=$l_id,c_date='$c_date',c_time='$c_time',single='$single',";
						$sql_str2.="allup='$allup',cbt=$cbt,`int`='$int',vbt='$vbt',";
						for($ss=1;$ss<=80;$ss++){
							$v[$i]=$v[$i]+2;
							$g_num='';
							$g_result=$v[$i];
							// group
							if(isset($vals[$v[$i]]["attributes"]["DISPLAYNAME"])){
								$g_num=$vals[$v[$i]]["attributes"]["NUM"];
								$g_name=$vals[$v[$i]]["attributes"]["DISPLAYNAME"];
								$g_en=$vals[++$v[$i]]["value"];
								$g_cn=$vals[++$v[$i]]["value"];
								$sql="g_num='$g_num',g_display='$g_name',g_en='$g_en',g_cn='$g_cn'";
								$sql="update $db set $sql where t_id=$id and p_id=$p_id and g_num=''";
  								$db_w = reconnect($db_w, "master");
								$sql=iconv("utf-8","gbk",$sql);
								mysql_query($sql,$db_w);
								$v[$i]=$v[$i]+2;
								$g_result=$v[$i]+2;
								if($vals[$g_result]["tag"]=="RESULTDIV"){
								//	$v[$i]=$g_result;
								}
 							}							
							// result
							if($vals[$v[$i]]["tag"]=="RESULTDIV"){
								$status=$vals[++$v[$i]]["value"];
								if($vals[++$v[$i]]["tag"]=="FIXEDODDSWINNING"){
									$selection=$vals[$v[$i]]["attributes"]["SELECTION"];
								}
								if($vals[++$v[$i]]["tag"]=="PARIMUTUELWINNING"){
									$p_selection=$vals[$v[$i]]["attributes"]["SELECTION"];
									$p_value=$vals[$v[$i]]["attributes"]["VALUE"];
								}
								$sql="status='$status',selection='$selection'";
								$sql="update $db set $sql where t_id=$id and p_id=$p_id and g_num='$g_num'";
 								$sql=iconv("utf-8","gbk",$sql);
								$db_w = reconnect($db_w, "master");
								mysql_query($sql,$db_w);
							}
							if(!isset($vals[$v[$i]]["attributes"]["NUM"])){
								break;
							}							
							$s_num=$vals[$v[$i]]["attributes"]["NUM"];
							$s_status=$vals[$v[$i]]["attributes"]["STATUS"];
							$s_code=$vals[++$v[$i]]["attributes"]["CODE"];
							$s_id=$vals[$v[$i]]["attributes"]["ID"];
							if($p_code=="FNL"){
								$s_code2=$vals[++$v[$i]]["attributes"]["CODE"];
								$s_id2=$vals[$v[$i]]["attributes"]["ID"];
							}else{
								$s_code2=$s_id2=0;
							}
							$sql="replace into $db set ".$sql_str1.$sql_str2."s_num='$s_num',s_status='$s_status',s_code='$s_code',s_id='$s_id',s_code2='$s_code2',s_id2='$s_id2'";
							$db_w = reconnect($db_w, "master");
							$sql=iconv("utf-8","gbk",$sql);
							mysql_query($sql,$db_w);
   						}
					}
				}		
			}
		}
	}
}
function tournament_odds($index,$vals,$sports,$p_no){
	global $db_w,$db_r;
	$date=$vals[$index['TOURNODDS'][0]]["attributes"]["UPDATEDATE"];
	$time=$vals[$index['TOURNODDS'][0]]["attributes"]["UPDATETIME"];
	$xsn=$vals[$index['XSN'][0]]["value"];
	$s_code=$vals[$index['SPORTSCODE'][0]]["value"];
	$p_code=strtolower($vals[$index['POOLCODE'][0]]["value"]);
	if(!check_file('25_'.$sports.'_'.$p_no.'.xml',$date,$time,$xsn)){
		return ;
	}
	switch($sports){
		case 1:
			$db="fb_tournament_odds";
 			break;		
		case 2:$db="bk_tournament_odds";
 			break;
	}
 	foreach ($index as $k=>$v){  
		if($k=="TOURNAMENT"){
			for($i=0;$i<count($v);$i++){  
				if($vals[$v[$i]]["type"]=="open"){
					$num=$vals[$v[$i]]["attributes"]["NUM"];
					$id=$vals[$v[$i]]["attributes"]["ID"];
					$sql_str1="p_code='$p_code',t_num=$num,t_id=$id,";
  					for($n=1;$n<=10;$n++){
						if(!isset($vals[++$v[$i]]["attributes"]["ID"])){
							break;
						}
						$p_id=$vals[$v[$i]]["attributes"]["ID"]; 
 						$sql_str2="p_id=$p_id,";
 						for($n=1;$n<=80;$n++){
 							if(!isset($vals[++$v[$i]]["attributes"]["C"])){
								break;
							}
  							$c=$vals[$v[$i]]["attributes"]["C"];
							$s=$vals[$v[$i]]["attributes"]["S"];
							$value=$vals[$v[$i]]["attributes"]["V"];
							$date=$vals[$v[$i]]["attributes"]["D"];
							$t=$vals[$v[$i]]["attributes"]["T"];
 							$sql="replace into $db set ".$sql_str1.$sql_str2."c='$c',s='$s',v='$value',d='$date',t='$t'";
 							$db_w = reconnect($db_w, "master");
 							mysql_query($sql,$db_w);
   						}
					}
				}		
			}
		}
	}
}
?>

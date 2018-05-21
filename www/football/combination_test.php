<?php
/* 短信发送测试 start */
$mobile="13910822083"; // 梅君 
$mobile="18511490500"; // 王洋

$content=urlencode("验证码:OPP，您正在进行手机绑定操作，验证码5分钟内有效【章鱼网】");
$url="http://admin.esoftsms.com/sdk/BatchSend.aspx?CorpID=BJZX01031&Pwd=123456&Mobile=".$mobile."&Content=".$content;
echo $url;
$f=file($url);
print_r($f);
exit;
/* 短信发送测试 end */
 
// 定义串关方式
$FORMULA['1']="1";
$FORMULA['2*1']="2"; 
$FORMULA['3*1']="3";$FORMULA['3*3']="2";$FORMULA['3*4']="2,3"; 
$FORMULA['4*1']="4";$FORMULA['4*4']="3";$FORMULA['4*5']="3,4";$FORMULA['4*6']="2"; $FORMULA['4*11']="2,3,4"; 
$FORMULA['5*1']="5";$FORMULA['5*5']="4";$FORMULA['5*6']="4,5";$FORMULA['5*10']="2"; $FORMULA['5*16']="3,4,5";$FORMULA['5*20']="2,3";$FORMULA['5*26']="2,3,4,5"; 
$FORMULA['6*1']="6";$FORMULA['6*6']="5";$FORMULA['6*7']="5,6";$FORMULA['6*15']="2";$FORMULA['6*20']="3";$FORMULA['6*22']="4,5,6";$FORMULA['6*35']="2,3"; $FORMULA['6*42']="3,4,5,6";$FORMULA['6*50']="2,3,4";$FORMULA['6*57']="2,3,4,5,6";
$FORMULA['7*1']="7";$FORMULA['7*7']="6";$FORMULA['7*8']="6,7";$FORMULA['7*21']="5";$FORMULA['7*35']="4";$FORMULA['7*120']="2,3,4,5,6,7";
$FORMULA['8*1']="8";$FORMULA['8*8']="7";$FORMULA['8*9']="7,8";$FORMULA['8*28']="6";$FORMULA['8*56']="5";$FORMULA['8*70']="4";$FORMULA['8*247']="2,3,4,5,6,7,8";
// 定义可能组合 
$MAX_F[-1]=array("HH","HD","DA","AA");
$MAX_F[+1]=array("HH","DH","AD","AA");
/*
	参数定义
	$multiple=2
	$formula=
	$combination=玩法|比赛id|选项&赔率,选项&赔率;玩法|比赛id|选项&赔率,选项&赔率;
*/
$multiple=2;
$formula=$_REQUEST["f"]?$_REQUEST["f"]:'2*1';
$combination='HAD|51050|H&1.85,D&2.95,A&3.8;HHAD|51050|H&3.75,D&3.55,A&1.68|-1;HAD|51051|H&1.70,D&3.75,A&3.45;HHAD|51051|H&2.95,D&3.9,A&1.82|-1';
// 全部方案比赛数组
$C=explode(";",$combination);
$strs=array();
$match_index=0;;
foreach($C as $k => $v){
 	$match=explode("|",$v);
	$M[$match_index]["id"]=$match[1];
	$M[$match_index]["pool"]=$match[0]; 
	if(stripos($match[2],",")){
		$keys=explode(",",$match[2]);
		$M[$match_index]["key"]["count"]=count($keys);
		foreach($keys as $k1 => $v1){
			$key=explode("&",$v1);
 			$M[$match_index]["key"][$k1+1]["value"]=$key[0];
			$M[$match_index]["key"][$k1+1]["odds"]=$key[1];
			$M2[$match[1]][$match[0]][$key[0]]=$key[1];
			if($match[0]=="HHAD"){
				$M2[$match[1]][$match[0]]["goalline"]=$match[3];
			}
		}
	}else{
		$key=explode("&",$match[2]);
		$M[$match_index]["key"]["count"]=1;
		$M[$match_index]["key"][1]["value"]=$key[0];
		$M[$match_index]["key"][1]["odds"]=$key[1];
		$M2[$match[1]][$match[0]][$key[0]]=$key[1];
		if($match[0]=="HHAD"){
			$M2[$match[1]][$match[0]]["goalline"]=$match[3];
		}
	}
	$match_index++;
}
/*
组合方案
$M=make_c();
print_r($M);
*/
/*
	最大奖金比赛数组
*/
$M=max_money($M2);
$M=make_c();
print_r($M);

function max_money($M){
 	global $MAX_F;
	foreach($M as $k => $v){
		$max=0;
 		if(isset($v["HAD"]) && isset($v["HHAD"])){
			if($v["HHAD"]["goalline"]=="-1"){
				foreach($MAX_F[-1] as $k1 => $v1){
 					if(isset($v["HAD"][$v1[0]]) or isset($v["HHAD"][$v1[1]])){
						$new=$v["HAD"][$v1[0]]+$v["HHAD"][$v1[1]];
 						if($new>$max){
							$max=$new;
							$had_key=$v1[0];
							$hhad_key=$v1[1];
						}	
					}					
				}
			}elseif($v["HHAD"]=="+1"){
				foreach($MAX_F[+1] as $k1 => $v1){
 					if(isset($v["HAD"][$v1[0]]) or isset($v["HHAD"][$v1[1]])){
						$new=$v["HAD"][$v1[0]]+$v["HHAD"][$v1[1]];
 						if($new>$max){
							$max=$new;
							$had_key=$v1[0];
							$hhad_key=$v1[1];
						}	
					}					
				}
			}
			switch($had_key){
				case "H":unset($M[$k]["HAD"]["D"]);unset($M[$k]["HAD"]["A"]);break;
				case "D":unset($M[$k]["HAD"]["H"]);unset($M[$k]["HAD"]["A"]);break;
				case "A":unset($M[$k]["HAD"]["H"]);unset($M[$k]["HAD"]["D"]);break;	
			}
			switch($hhad_key){
				case "H":unset($M[$k]["HHAD"]["D"]);unset($M[$k]["HHAD"]["A"]);break;
				case "D":unset($M[$k]["HHAD"]["H"]);unset($M[$k]["HHAD"]["A"]);break;
				case "A":unset($M[$k]["HHAD"]["H"]);unset($M[$k]["HHAD"]["D"]);break;	
			}
		}
		
	}
	// 拼接方案字符串
	$i=0;
	foreach($M as $k =>$v){
		if(isset($v["HAD"])){			
			$M2[$i]["id"]=$k;
			$M2[$i]["pool"]="HAD";
 			$M2[$i]["key"]["count"]=1;
			if(isset($v["HAD"]["H"])){
				$key="H";$odds=$v["HAD"]["H"];
			}
			if(isset($v["HAD"]["D"])){
				$key="D";$odds=$v["HAD"]["D"];
			}
			if(isset($v["HAD"]["A"])){
				$key="A";$odds=$v["HAD"]["A"];
			}
			$M2[$i]["key"][1]["value"]=$key;
			$M2[$i]["key"][1]["odds"]=$odds;
			$i++;
		}
		if(isset($v["HHAD"])){
			$M2[$i]["id"]=$k;
			$M2[$i]["pool"]="HHAD";
			$M2[$i]["key"]["count"]=1;
			if(isset($v["HHAD"]["H"])){
				$key="H";$odds=$v["HHAD"]["H"];
			}
			if(isset($v["HHAD"]["D"])){
				$key="D";$odds=$v["HHAD"]["D"];
			}
			if(isset($v["HHAD"]["A"])){
				$key="A";$odds=$v["HHAD"]["A"];
			}
			$M2[$i]["key"][1]["value"]=$key;
			$M2[$i]["key"][1]["odds"]=$odds;
			$i++;
		} 
	}
	return $M2;	
}
function make_c(){
 	global $FORMULA,$C,$formula;
	// 全部组合
	$max="";
	for($i=1;$i<=count($C);$i++){
		$max.="1";
	}
 	// 过关过滤
	$c=array();
	for($i=bindec($max);$i>=1;$i--){
		$value=decbin($i);
		$count=substr_count($value,"1");
		if(!substr_count($FORMULA[$formula],$count)){
			continue;
		}
		$zero='';
		if(strlen($value)!=count($C)){
			for($j=count($C);$j>strlen($value);$j--){
				$zero.="0";
			}
			$value=$zero.$value;
		}		
 		$new=show_combination($value);
		if(is_array($new)){
			$c=@array_merge($c,$new);
		}
	}	
	return $c;
}
// 筛选比赛
function show_combination($value){
	$c=array();
	for($i=0;$i<strlen($value);$i++){
 		if(substr($value,$i,1)==1){
 			$c=make_array($i,$c);
 			if($c==""){
				return;	
			}
 		}	
	}	 
	return $c;
}
// 复选处理
function make_array($i,$c){
 	global $M;
  	$new=array();
  	if(count($c)>0){
 		foreach($c as $k =>$v){
 			$str=$v;
			for($j=1;$j<=$M[$i]["key"]["count"];$j++){
				if(substr_count($str,$M[$i]["id"])){
					return '';
				}else{
 					$new[]=$str.";".$M[$i]["id"]."|".$M[$i]["pool"]."|".$M[$i]["key"][$j]["value"]."&".$M[$i]["key"][$j]["odds"];
				}
 			}
		}
	}else{
 		for($j=1;$j<=$M[$i]["key"]["count"];$j++){
			$new[$j]=$M[$i]["id"]."|".$M[$i]["pool"]."|".$M[$i]["key"][$j]["value"]."&".$M[$i]["key"][$j]["odds"];
		}
	}
	return $new;
}
?>
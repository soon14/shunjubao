<?php
include_once "../include/init.php";

$s=$_REQUEST["sport"];
$p=$_REQUEST["pool"];
$select=$_REQUEST["select"];
$user_select=$_REQUEST["user_select"];
$multiple=$_REQUEST["multiple"];

$money=$_REQUEST["money"];
$c=$_REQUEST["combination"];
$uid=$_SESSION["u_id"];
$from = $_REQUEST['from'];//ҳ����Դ

if(!$uid) {
	redirectUrl('login', $from);
	exit;	
}

$datetime=date("Y-m-d H:i:s");
$print_state = 0;

if($s!="fb" and $s!="bk"){
	redirectUrl('sport', $from);
	echo "�������ʹ���";
	exit;
}
if($money<=0){
	redirectUrl('money', $from);
	echo "Ͷע������";
	exit;
}
if($multiple>100000){
	redirectUrl('multiple', $from);
	echo "Ͷע��������";
	exit;
}
if($POOL[$p]==""){
	redirectUrl('pool', $from);
	echo "Ͷע�淨����";
	exit;
}

//�������Ͷע��ʱ��
$s_e_time = getSportStartEndTime($s);

if ($datetime < $s_e_time['start_time']) {
	//���ڿ�ʼʱ��
	redirectUrl('start_time', $from);	
}

if ($datetime > $s_e_time['end_time']) {
	//���ڽ���ʱ��
	redirectUrl('end_time', $from);
}

// ��֤�û����
$user_cash=0;
$sql="select cash,rebate_per,rebate from user_account where u_id=$uid";
$query1=mysql_query($sql,$db_r);
if($d=mysql_fetch_array($query1)){ 
	$user_cash=$d["cash"];
	$user_rebate=$d["rebate"];
	$rebate_per=$d["rebate_per"];
}
if($user_cash<$money){
	redirectUrl('cash', $from);
	echo "���㣬���ֵ";
	exit;
}
// ��֤����״̬
$table=$s."_betting";
$matchs=explode(',',$c);
$old_time="";
foreach($matchs as $k => $v){
	$mid=explode("|",$v);	
 	$sql="select * from $table where id=".$mid[1];
	$query=mysql_query($sql,$db_r);
	if($d=mysql_fetch_array($query)){
		if($d["status"]!="Selling"){
			redirectUrl('start', $from);
			echo show_num($d["num"])." �����ѿ���";
			exit;
		}
		//ÿ����������ǰ8����Ͷע
		$can_touzhu = false;
		if (strtotime($d["date"]." ".$d["time"]) -time() > 8 * 60) $can_touzhu = true;
		if(!$can_touzhu){
			redirectUrl('end', $from);
			echo show_num($d["num"])." ����Ͷע�ѽ�ֹ";
			exit;
		}
		// ���һ��������ʼʱ��
		$return_time=$d["date"]." ".$d["time"];
 		if($return_time<$old_time){
			$return_time=$old_time;
		}
	}
	// ��֤����
	$option=explode("&",$mid[2]); 
	$table1=$s."_odds_".$mid[0];
	foreach($option as $k1 => $v1){
		$key=explode("#",$v1);
		$sql="select `".$key[0]."` from $table1 where m_id=".$mid[1];
 		$query=mysql_query($sql,$db_r);
		if($d=mysql_fetch_array($query)){
			$odds_str.=$d[0]."&";
		}	
	}
	$odds_str=substr($odds_str,0,-1).",";
} 
// ���崮�ط�ʽ
// ���������� 
$MAX_F[-1]=array("HH","HD","DA","AA");
$MAX_F[+1]=array("HH","DH","AD","AA");

$C=explode(",",$c);
$strs=array();
$match_index=0;;
foreach($C as $k => $v){
	$match=explode("|",$v);
	$M[$match_index]["id"]=$match[1];
	$M[$match_index]["pool"]=$match[0]; 
	if(stripos($match[2],"&")){
		$keys=explode("&",$match[2]);
		$M[$match_index]["key"]["count"]=count($keys);
		foreach($keys as $k1 => $v1){
			$key=explode("#",$v1);
			$M[$match_index]["key"][$k1+1]["value"]=$key[0];
			$M[$match_index]["key"][$k1+1]["odds"]=$key[1];
			$M2[$match[1]][$match[0]][$key[0]]=$key[1];
			if($match[0]=="HHAD"){
				$M2[$match[1]][$match[0]]["goalline"]=$match[3];
			}
		}
	}else{
		$key=explode("#",$match[2]);
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
 
$M=make_c($select,$C);
if((count($M)*$multiple*2)!=$money){
	redirectUrl('money', $from);
	echo " Ͷע������";
	exit;
}
// ��¼Ͷע
$sql_str="`u_id`='".$uid."',`sport`='".$s."',`pool`='".$p."',`select`='".$select."',`multiple`='".$multiple."',";
$sql_str.="`money`='".$money."',`datetime`='".$datetime."',`combination`='".$c."',`odds`='".substr($odds_str,0,-1)."',";
$sql_str.="`return_time`='".$return_time."',";
$sql_str.="`user_select`='".$user_select."',";//����û����ط�ʽ
$sql_str.="`print_state`='".$print_state."',";
$sql_str.="`prize`='0.00'";
$sql="insert into user_ticket_all set $sql_str";

if(mysql_query($sql,$db_w)){
//	echo $sql."<br>";
	$ticket_id=mysql_insert_id();
	// �޸����
	$sql="update user_account set cash=cash-$money where u_id=$uid";
	mysql_query($sql,$db_w);
	// ��¼Ͷע��ˮ
	$table="user_account_log10".substr($uid,-1);
	$sql_str="u_id=$uid,create_time='".$datetime."',money='".$money."',old_money='".$user_cash."',";
	$sql_str.="log_type=3,record_table='user_ticket_all',record_id='".$ticket_id."'";
	$sql="insert into $table set $sql_str";
 	mysql_query($sql,$db_w);
	// ��¼����
	if($rebate_per>0){
		$score=$money*$rebate_per;//������������λ��Ԫ
		$sql_str="u_id=$uid,create_time='".$datetime."',rebate_score='".$score."',percent='".$rebate_per."',";
		$sql_str.="ticket_id='".$ticket_id."',ticket_money='".$money."'";
		$sql="insert into user_rebate set $sql_str";
		mysql_query($sql,$db_w);
		$record_id=mysql_insert_id();
 		// �޸ķ�������
		$sql="update user_account set rebate=rebate+$score where u_id=$uid";
		mysql_query($sql,$db_w);
		// ��¼������ˮ
		$sql_str="u_id=$uid,create_time='".$datetime."',money='".$score."',old_money='".$user_rebate."',";
		$sql_str.="log_type=8,record_table='user_rebate',record_id='".$record_id."'";
		$sql="insert into $table set $sql_str";
 		mysql_query($sql,$db_w);
 		//14-05-19��ӣ������Զ������˻�
 		// ������������˻�
		$table="user_account";
		$sql = "update {$table} set cash=cash+{$score} where u_id={$uid}";
		mysql_query($sql,$db_w);
		// �˻���־������һ�
		$table="user_account_log10".substr($uid,-1);
		$sql_str="u_id=$uid,create_time='".$datetime."',money='".$score."',old_money='".$user_rebate."',";
		$sql_str.="log_type=9,record_table='user_rebate',record_id='".$record_id."'";
		$sql="insert into $table set $sql_str";
		mysql_query($sql,$db_w);
	}
	
	$table="user_ticket_log10".substr($uid,-1);
	//��֤����ÿע���Ϊ99����Ʊ�ӿ����ƣ�
	while ($multiple>0) {
		foreach($M as $k => $v){
			if ($multiple >= 99) {
				$this_multiple = 99;
			} else {
				$this_multiple = $multiple;
			}
			$select=explode(",",$v);
			$sql_str="`u_id`='".$uid."',`sport`='".$s."',`pool`='".$p."',`select`='".count($select)."x1',`multiple`='".$this_multiple."',";
			$sql_str.="`money`='".($this_multiple*2)."',`datetime`='".$datetime."',`combination`='".$v."',";
			$sql_str.="`return_time`='".$return_time."',ticket_id='".$ticket_id."',";
			$sql_str.="`print_state`='".$print_state."',";
			$sql_str.="`prize`='0.00'";
			$sql="insert into $table set $sql_str";
			//echo $sql."<br>";
			mysql_query($sql,$db_w);
		}
		$multiple -= 99;
	}
	
	redirectUrl('success', $from);
	echo 'Ͷע�ɹ� <a href="http://'.$_SERVER['HTTP_HOST'].'/zy/account/user_center.php">��˷��ص��û�����</a>';
} else {
	redirectUrl('fail', $from);
	echo 'Ͷעʧ�� ����ϵ�ͷ�';
}
exit;
function make_c($select,$C){
  	// ȫ�����
	$max="";
	for($i=1;$i<=count($C);$i++){
		$max.="1";
	}
 	// ���ع���
	$c=array();
	$selects=explode("|",$select);
 	$select='';
	foreach($selects as $k => $v){
		$select.=substr($v,0,1).",";
	}
	$select=substr($select,0,-1);
 	for($i=bindec($max);$i>=1;$i--){
		$value=decbin($i);
		$count=substr_count($value,"1");
		
		
 		if(!substr_count($select,$count)){
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
// ɸѡ����
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
// ��ѡ����
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
 					$new[]=$str.",".$M[$i]["pool"]."|".$M[$i]["id"]."|".$M[$i]["key"][$j]["value"]."#".$M[$i]["key"][$j]["odds"];
				}
 			}
		}
	}else{
 		for($j=1;$j<=$M[$i]["key"]["count"];$j++){
			$new[$j]=$M[$i]["pool"]."|".$M[$i]["id"]."|".$M[$i]["key"][$j]["value"]."#".$M[$i]["key"][$j]["odds"];
		}
	}
	return $new;
} 

?>
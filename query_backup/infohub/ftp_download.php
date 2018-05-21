<?php
function php_ftp_download() {
	$phpftp_host = "221.208.198.138";
	$phpftp_port = 21;
	$phpftp_user = "data";
	$phpftp_passwd = "hljjcw.cn";
	
	$files[0]="1_0_0.xml"; 
	$files[1]="2_1_0.xml";$files[2]="2_2_0.xml";
	$files[3]="3_1_0.xml";$files[4]="3_2_0.xml";
	$files[5]="4_1_0.xml";$files[6]="4_2_0.xml";
	$files[7]="5_1_0.xml";$files[8]="5_2_0.xml";
	$files[9]="6_1_0.xml";$files[10]="6_2_0.xml";
	$files[11]="7_1_1.xml";$files[12]="7_1_2.xml";$files[13]="7_1_3.xml";$files[14]="7_1_4.xml";$files[15]="7_1_5.xml";$files[54]="7_1_10.xml";
	$files[16]="7_2_6.xml";$files[17]="7_2_7.xml";$files[18]="7_2_8.xml";$files[19]="7_2_9.xml";
	$files[20]="8_1_1.xml";$files[21]="8_1_2.xml";$files[22]="8_1_3.xml";$files[23]="8_1_4.xml";$files[24]="8_1_5.xml";$files[55]="8_1_10.xml";
	$files[25]="8_2_6.xml";$files[26]="8_2_7.xml";$files[27]="8_2_8.xml";$files[28]="8_2_9.xml";
	$files[29]="9_1_0.xml";$files[30]="9_2_0.xml";
	$files[31]="10_1_0.xml";$files[32]="10_2_0.xml";
	$files[33]="11_0_0.xml";
	$files[34]="12_1_0.xml";$files[35]="12_2_0.xml";
	$files[36]="13_1_1.xml";$files[37]="13_1_2.xml";$files[38]="13_1_3.xml";$files[39]="13_1_4.xml";$files[40]="13_1_5.xml";$files[53]="13_1_10.xml";
	$files[41]="13_2_6.xml";$files[42]="13_2_7.xml";$files[43]="13_2_8.xml";$files[44]="13_2_9.xml";
	$files[45]="23_1_0.xml";$files[46]="23_2_0.xml";
	$files[47]="25_1_41.xml";$files[48]="25_1_42.xml";$files[49]="25_1_43.xml";
	$files[50]="25_2_41.xml";$files[51]="25_2_42.xml";$files[52]="25_2_43.xml";

 	$ftp = ftp_connect($phpftp_host,$phpftp_port);
	if($ftp) {
		if(ftp_login($ftp, $phpftp_user, $phpftp_passwd)) {
			if(@ftp_chdir($ftp,$ftp_path)) {
 				ftp_pasv($ftp, true);
				foreach($files as $k => $v){
					ftp_get($ftp, "/usr/share/nginx/html/www/query/infohub/xml/".$v, $v, FTP_BINARY);
 				}
				/*
				if(ftp_get($ftp, $filename, $filename, FTP_BINARY)) {
					ftp_quit( $ftp );
  				}
				*/
			}
		}
	}
}
php_ftp_download();
/* fb_allpool: +fixedodds  */
include_once "/usr/share/nginx/html/www/query/infohub/config.php";
/* xml list */
$url="/usr/share/nginx/html/www/query/infohub/xml/";
$files[0]="1_0_0.xml"; 
$files[1]="2_1_0.xml";$files[2]="2_2_0.xml";
$files[3]="3_1_0.xml";$files[4]="3_2_0.xml";
$files[5]="4_1_0.xml";$files[6]="4_2_0.xml";
$files[7]="5_1_0.xml";$files[8]="5_2_0.xml";
$files[9]="6_1_0.xml";$files[10]="6_2_0.xml";
$files[11]="7_1_1.xml";$files[12]="7_1_2.xml";$files[13]="7_1_3.xml";$files[14]="7_1_4.xml";$files[15]="7_1_5.xml";$files[54]="7_1_10.xml";
$files[16]="7_2_6.xml";$files[17]="7_2_7.xml";$files[18]="7_2_8.xml";$files[19]="7_2_9.xml";
$files[20]="8_1_1.xml";$files[21]="8_1_2.xml";$files[22]="8_1_3.xml";$files[23]="8_1_4.xml";$files[24]="8_1_5.xml";$files[55]="8_1_10.xml";
$files[25]="8_2_6.xml";$files[26]="8_2_7.xml";$files[27]="8_2_8.xml";$files[28]="8_2_9.xml";
$files[29]="9_1_0.xml";$files[30]="9_2_0.xml";
$files[31]="10_1_0.xml";$files[32]="10_2_0.xml";
$files[33]="11_0_0.xml";
$files[34]="12_1_0.xml";$files[35]="12_2_0.xml";
$files[36]="13_1_1.xml";$files[37]="13_1_2.xml";$files[38]="13_1_3.xml";$files[39]="13_1_4.xml";$files[40]="13_1_5.xml";$files[53]="13_1_10.xml";
$files[41]="13_2_6.xml";$files[42]="13_2_7.xml";$files[43]="13_2_8.xml";$files[44]="13_2_9.xml";
$files[45]="23_1_0.xml";$files[46]="23_2_0.xml";
$files[47]="25_1_41.xml";$files[48]="25_1_42.xml";$files[49]="25_1_43.xml";
$files[50]="25_2_41.xml";$files[51]="25_2_42.xml";$files[52]="25_2_43.xml";
/* 解析 xml */
for($i=0;$i<count($files);$i++){
//for($i=47;$i<=49;$i++){
	$data=str_replace("\n","",@file($url.$files[$i])); 
	if($data==""){
		continue;
	}
	$data=str_replace("\r","",$data); 
	$data=@implode("",$data); 
 	$xml=xml_parser_create();
	xml_parse_into_struct($xml,$data,$vals,$index);
 	xml_parser_free($xml); 
 	switch($i){  
		case 0:
			application($index,$vals);break;
		case 1:case 2:
			league($index,$vals,$i);break;
		case 3:case 4:
			team($index,$vals,$i-2);break;	
		case 5:case 6:
			betting($index,$vals,$i-4);break;
		case 7:case 8:
			matchs($index,$vals,$i-6);break;
		case 9:case 10:
			allpool($index,$vals,$i-8);break;	
		case 11:case 12:case 13:case 14:case 15:case 54:
			if($i==54){
				$j=10;
			}else{
				$j=$i-10;
			}
			pool($index,$vals,1,$j);break;	
		case 16:case 17:case 18:case 19:
			pool($index,$vals,2,$i-10);break;
		case 20:case 21:case 22:case 23:case 24:case 55:
			if($i==55){
				$j=10;
			}else{
				$j=$i-19;
			}
			spvalue($index,$vals,1,$j);break;	
		case 25:case 26:case 27:case 28:
			spvalue($index,$vals,2,$i-19);break;	
		case 29:case 30:
			result($index,$vals,$i-28);break;
		case 31:case 32:
			poolresult($index,$vals,$i-30);break;
		case 33:
			country($index,$vals);break;
		case 34:case 35:
			allup($index,$vals,$i-33);break;
		case 36:case 37:case 38:case 39:case 40:case 53:
			if($i==53){
				$j=10;
			}else{
				$j=$i-35;
			}
			odds($index,$vals,1,$j);break;	
		case 41:case 42:case 43:case 44:
			odds($index,$vals,2,$i-35);break;
 		case 45:case 46:
			tournament_pool($index,$vals,$i-44);break;
		case 47:case 48:case 49:
			tournament_odds($index,$vals,1,$i-6);break;
		case 50:case 51:case 52:
			tournament_odds($index,$vals,2,$i-9);break;		
	} 
}
?>

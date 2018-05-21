<?php
/**
 * 大乐透首页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$tpl = new Template();
$TEMPLATE['title'] = '大乐透- ';


$data=array();
$url = 'http://www.okooo.com/daletou/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec( $ch );
curl_close( $ch );

$regex4="/<div class=\"kaijiang_qh\".*?>.*?<\/div>/ism";
if(preg_match_all($regex4, $return, $matches1)){
	$tpl->assign('qishu',iconv("GB2312//IGNORE", "UTF-8", $matches1[0][0]));
}else{
	echo '0';
}
$arr=array();
$str=iconv("GB2312//IGNORE", "UTF-8", $matches1[0][0]);
if(preg_match('/\d+/',$str,$arr)){
	$tpl->assign('qishunum',$arr[0]);
	$tpl->assign('qishunumnext',$arr[0]+1);
}
$regex5="/<div class=\"kaijiang_ball\".*?>.*?<\/div>/ism";
if(preg_match_all($regex5, $return, $matches2)){
	$tpl->assign('kaihao',iconv("GB2312//IGNORE", "UTF-8", $matches2[0][0]));
}else{
	echo '0';
}

$regex6="/<table width=\"260\" cellspacing=\"0\" cellpadding=\"0\" class=\"kaijiang_tab\">.*?<\/table>/ism";
if(preg_match_all($regex6, $return, $matches3)){
	$tpl->assign('tablelist',iconv("GB2312//IGNORE", "UTF-8", $matches3[0][0]));
}else{
	echo '0';
}
$YOKA ['output'] = $tpl->r ( 'daletou_index' );
echo_exit ( $YOKA ['output']);
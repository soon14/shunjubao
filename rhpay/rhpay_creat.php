<?php
include_once ("config.inc.php");

$qrCode = "https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=2017062107534668&scope=auth_base&redirect_uri=http://trx.ronghuijinfubj.com/middlepaytrx/alipay/redirect/B100198839_rhali1500813273741201";

include 'include/phpqrcode.php';
$errorCorrectionLevel = 'L';//容错级别
$matrixPointSize = 7;//生成图片大小
//生成二维码图片
//QRcode::png($qrCode, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 10);
//直接返回 二维码图片
var_dump(QRcode::png($qrCode, false, $errorCorrectionLevel, $matrixPointSize));
 
?>
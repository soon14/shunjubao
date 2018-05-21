<?php
/**
 * 后台脚本之：自动生成跟单页面
 */

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


$url = "http://www.shunjubao.com/ticket/show.php";
$content=file_get_contents($url);
if($content){
	$fs=fopen("/home/wwwroot/www.zhiying365.com/www/ticket/show.html",'w');
	fwrite($fs,$content);
}

$url = "http://www.shunjubao.com/ticket/show.php?sport=bk";
$content=file_get_contents($url);
if($content){
	$fs=fopen("/home/wwwroot/www.zhiying365.com/www/ticket/bkshow.html",'w');
	fwrite($fs,$content);
}

$url = "http://www.shunjubao.com/ticket/show.php?sport=bk";
$content=file_get_contents($url);
if($content){
	$fs=fopen("/home/wwwroot/www.zhiying365.com/www/ticket/bkmshow.html",'w');
	fwrite($fs,$content);
}

$url = "http://www.shunjubao.com/ticket/show.php";
$content=file_get_contents($url);
if($content){
	$fs=fopen("/home/wwwroot/www.zhiying365.com/www/ticket/mshow.html",'w');
	fwrite($fs,$content);
}


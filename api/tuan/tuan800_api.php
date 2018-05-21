<?php
/**
 * 团800接口
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objTuanFront = new TuanFront();
$objSSProdSphinx = new SSProdSphinx();
$objSSConsignerFront = new SSConsignerFront();
$objSSProdFront = new SSProdFront();

$condition = array(
	'site'	=> array(SpecialSale::SITE_OWNER_ALL, SpecialSale::SITE_OWNER_MAIN, SpecialSale::SITE_TUAN),
);
$ssProds = $objSSProdFront->getsByConditionOrderByRand($condition, 5);

$tuans = $objSSProdFront->convertToTuanInfoFromSSProds($ssProds);

$result .= '<?xml version="1.0" encoding="UTF-8"?><urlset>';

foreach ($tuans as $tuan) {
	$url = "http://www.gaojie.com/product/p{$tuan['friendlyUrl']}m?channelid=2400003";
	
	$startTime = date('Y-m-d 00:00:00', $tuan['realStartTime']);
	$endTime = date('Y-m-d 00:00:00', $tuan['realEndTime']);
	$rebate = round(($tuan['rebate']), 1);
	$bougth = 20 + $tuan['bought'];

	$soldOut = 'no'; //是否已卖光

	$result .= '<url>';
	$result .= "<loc>{$url}</loc>";
	$result .= "<wapLoc></wapLoc>"; //
	$result .= "<data>";
	$result .= "<display>";
	$result .= "<website>高街</website>";
	$result .= "<identifier></identifier>"; //
	$result .= "<siteurl>http://www.gaojie.com/?channelid=2400003</siteurl>";
	$result .= "<city>全国</city>";
	$result .= "<title><![CDATA[【全国】{$tuan['title']}]]></title>";
	$result .= "<image>{$tuan['image']}</image>";
	$result .= "<tag>生活,日常服务,其它</tag>";
	$result .= "<startTime>$startTime</startTime>";
	$result .= "<endTime>$endTime</endTime>";
	$result .= "<value>{$tuan['old_price']}</value>";
	$result .= "<price>{$tuan['unit_price']}</price>";
	$result .= "<rebate>{$rebate}</rebate>";
	$result .= "<bought>{$bougth}</bought>";
	$result .= "<maxQuota></maxQuota>"; # 最多购买人数 , 最高配额［选填］
	$result .= "<minQuota></minQuota>"; # 最少购买人数 , 有多少人参加团购才会成功的人数［选填］
	$result .= "<post>yes</post>";
	$result .= "<soldOut>{$soldOut}</soldOut>"; # 是否已卖光
	$result .= "<priority>0</priority>"; # 如果同时发布多个团购 用0-99数字表示团购的优先级 数字越小优先级越高 团购排序，会根据优先级由高到低进行[选填]
	$result .= "<tip>预计发货时间：下单后1-2个工作日内开始发货</tip>"; # 重要的提示信息[选填]
	$result .= "</display>";
	$result .= "<merchantEndTime>{$endTime}</merchantEndTime>"; # 团购有效期结束时间 ［选填］
	$result .= "<shops>";
	$result .= "<shop>";
	$result .= "<name></name>";
	$result .= "<tel></tel>";
	$result .= "<addr></addr>";
	$result .= "<area></area>";
	$result .= "<openTime></openTime>";
	$result .= "<longitude></longitude>";
	$result .= "<latitude></latitude>";
	$result .= "<trafficInfo></trafficInfo>";
	$result .= "</shop>";
	$result .= "</shops>";
	$result .= "</data>";
	$result .= "</url>";
}

$result .= "</urlset>";

if ($tuans) {
	echo $result;
}
<?php
/**
 * “百团大购”团购导航api
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objTuanFront = new TuanFront();

$tuans = $objTuanFront->getsUnderWayTuan();

$result .= '<?xml version="1.0" encoding="UTF-8"?><urlset>';
foreach ($tuans as $tuan) {
	$result .= '<url>';
	$url = 'http://tuan.gaojie.com/tuan/detail/'."{$tuan['ssProd']['friendlyUrl']}"; # 商品详细地址
	$result .= "<loc>{$url}</loc>";
	$result .= '<data>';
	$result .= '<display>';
	$result .= "<website>高街</website>";
	$result .= "<siteurl>{$url}</siteurl>";
	$result .= "<city>全国</city>";
	$result .= "<title>{$tuan['specialSale']['name']}</title>";
	$result .= "<image>{$tuan['specialSale']['img_b_415x249']}</image>";
	$result .= "<value>{$tuan['ssProd']['old_price']}</value>";
	$result .= "<price>{$tuan['ssProd']['unit_price']}</price>";
	$rebate = ConvertData::toMoney(($tuan['ssProd']['unit_price']/$tuan['ssProd']['old_price']*10)); # 折扣
	$result .= "<rebate>{$rebate}</rebate>";
	$startTime = date('Y-m-d H:i:s', $tuan['specialSale']['start_time']); # 开始时间
	$result .= "<startTime>{$startTime}</startTime>";
	$endTime = date('Y-m-d H:i:s', $tuan['specialSale']['end_time']); # 结束时间
	$result .= "<endTime>{$endTime}</endTime>";
	$bougth = getUserNumBySSProdId($tuan['ssProdId']) + $tuan['specialSale']['tuan_pseudo_num']; # 售出数
	$result .= "<bought>{$bougth}</bought>";
	$result .= "<BusiContact>400-0816-999</BusiContact>";# 商家联系方式
	$result .= '</display>';
	$result .= '</data>';
	$result .= '</url>';
}
$result .= '</urlset>';

if ($tuans) {
	echo $result;
} else {

}
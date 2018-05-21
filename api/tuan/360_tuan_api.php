<?php
/**
 * 360团购导航api
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objTuanFront = new TuanFront();
$objProductFront = new ProductFront();

$tuans = $objTuanFront->getsUnderWayTuan();
//echo '<pre>';print_r($tuans);exit;

$result .= '<?xml version="1.0" encoding="utf-8" ?> ';
$result .= '<data>';
$result .= '<apiversion>2.0</apiversion>';
$result .= '<site_name>高街</site_name>';
$result .= '<goodsdata>';

$i = 1;
foreach ($tuans as $tuan) {
//	echo '<pre>';print_r($tuan);exit;
	$url = 'http://tuan.gaojie.com/tuan/detail/'."{$tuan['ssProd']['friendlyUrl']}?channelid=2400002"; # 商品详细地址
	$rebate = ConvertData::toMoney(($tuan['ssProd']['unit_price']/$tuan['ssProd']['old_price']*10)); # 折扣
	$bougth = getUserNumBySSProdId($tuan['ssProdId']) + $tuan['specialSale']['tuan_pseudo_num']; # 购买人数
	$startTime = date('YmdHis', $tuan['specialSale']['start_time']);
	$endTime = date('YmdHis', $tuan['specialSale']['end_time']);
	
	$product = $objProductFront->get($tuan['ssProd']['productId']);
	$title = mb_strcut( $product['name'], 0, 40, 'utf-8');
	
	$result .= '<goods id="'.$i.'">';
	$result .= "<pid>{$tuan['ssProdId']}</pid>";
	$result .= "<feature></feature>"; //商品的特征，多特征之间用空格分隔，[选填]
	$result .= "<city_name>全国</city_name>";
	$result .= "<site_url>http://www.gaojie.com/</site_url>";
	$result .= "<title>{$title}</title>";
	$result .= "<goods_url>{$url}</goods_url>";
	$result .= "<desc>{$tuan['specialSale']['name']}</desc>";
	$result .= "<class>精品购物</class>";
	$result .= "<img_url>{$tuan['specialSale']['img_b_415x249']}</img_url>";
	$result .= "<original_price>{$tuan['ssProd']['old_price']}</original_price>";
	$result .= "<sale_price>{$tuan['ssProd']['unit_price']}</sale_price>";
	$result .= "<sale_rate>{$rebate}</sale_rate>";
	$result .= "<sales_num>{$bougth}</sales_num>";
	$result .= "<start_time>{$startTime}</start_time>";
	$result .= "<close_time>{$endTime}</close_time>";
	$result .= "<merchant_name>高街网</merchant_name>";
	$result .= "<merchant_tel>400-0816-999</merchant_tel>";
	$result .= "<spend_start_time></spend_start_time>";
	$result .= "<spend_close_time></spend_close_time>";
	$result .= "<merchant_addr></merchant_addr>";
	$result .= "<hot_area></hot_area>";
	$result .= "<longitude></longitude>";
	$result .= "<latitude></latitude>";
	$result .= "</goods>";
	$i++;
}

$result .= '</goodsdata>';
$result .= '</data>';

if ($tuans) echo $result;
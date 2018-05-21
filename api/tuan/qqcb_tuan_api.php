<?php
/**
 * qq彩贝团接口
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objTuanFront = new TuanFront();
$objSSConsignerFront = new SSConsignerFront();

$tuans = $objTuanFront->getsUnderWayTuan();

function subcategory($title) {
	if (strpos($title, '包') || strpos($title, '包') === 0) {
		return array(
			'tag' => 5,
			'sub_tag' => 2,
		);
	}
	if (strpos($title, '服') || strpos($title, '服') === 0 || 
		strpos($title, '装') || strpos($title, '装') === 0)
	{
		return array(
			'tag' => 5,
			'sub_tag' => 1,
		);
	}
	if (strpos($title, '茶') || strpos($title, '茶') === 0 || 
		strpos($title, '饮') || strpos($title, '饮') === 0)
	{
		return array(
			'tag' => 5,
			'sub_tag' => 4,
		);
	}
	if (strpos($title, '家具') || strpos($title, '家具') === 0) {
		return array(
			'tag' => 5,
			'sub_tag' => 5,
		);
	}
	if (strpos($title, '洁面') || strpos($title, '洁面') === 0) {
		return array(
			'tag' => 4,
			'sub_tag' => 1,
		);
	}
	if (strpos($title, '指甲油') || strpos($title, '洁面') === 0) {
		return array(
			'tag' => 4,
			'sub_tag' => 2,
		);
	}
	return array(
		'tag' => 5,
		'sub_tag' => 6,
	);
}

$result .= '<?xml version="1.0" encoding="UTF-8"?><urlset>';

foreach ($tuans as $tuan) {
	$url = 'http://tuan.gaojie.com/tuan/detail/'."{$tuan['ssProd']['friendlyUrl']}?channelid=2400004";
	$startTime = $tuan['specialSale']['start_time'];
	$endTime   = $tuan['specialSale']['end_time'];
	$rebate = ConvertData::toMoney(($tuan['ssProd']['unit_price']/$tuan['ssProd']['old_price']*10));
	$bougth = getUserNumBySSProdId($tuan['ssProdId']) + $tuan['specialSale']['tuan_pseudo_num'];

	if ($tuan['ss_status'] == SpecialSale::STATUS_ENDED) {
		$soldOut = '1';
	} else {
		$soldOut = '0';
	}

	#我们团购分类和彩贝分类的对应关系
	//$qqcb_tag = 5; // 网购精品
	//$qqcb_sub_tags = array(1=>1, 2=>2, 3=>6); // 彩贝分类 1:服饰 2:鞋包 6.其他.高街团购分类：1:服饰 2:鞋包 3:生活
	$qqcb_tag = subcategory($tuan['specialSale']['name']);
	
	$consigner = $objSSConsignerFront->get($tuan['ssProd']['specialSaleConsignerId']);

	$result .= '<url>';
	$result .= "<loc>{$url}</loc>";
	$result .= "<data>";
	$result .= "<display>";
	$result .= "<website>高街</website>";
	$result .= "<identifier></identifier>"; //
	$result .= "<siteurl>http://www.gaojie.com/</siteurl>";
	$result .= "<city>全国</city>";
	$result .= "<district></district>";
	$result .= "<title><![CDATA[【全国】{$tuan['specialSale']['name']}]]></title>";
	$result .= "<image>{$tuan['specialSale']['img_b_415x249']}</image>";
	$result .= "<tag>{$qqcb_tag['tag']}</tag>";
	$result .= "<sub_tag>{$qqcb_tag['sub_tag']}</sub_tag>";
	$result .= "<priority>0</priority>";# 是否推荐到首页 0 是，非0为否
	$result .= "<startTime>$startTime</startTime>";
	$result .= "<endTime>$endTime</endTime>";
	$result .= "<value>{$tuan['ssProd']['old_price']}</value>";
	$result .= "<price>{$tuan['ssProd']['unit_price']}</price>";
	$result .= "<rebate>$rebate</rebate>";
	$result .= "<bought>$bougth</bought>";
	$result .= "<maxQuota></maxQuota>"; # 最多购买人数 , 最高配额［选填］
	$result .= "<minQuota></minQuota>"; # 最少购买人数 , 有多少人参加团购才会成功的人数［选填］
	$result .= "<soldOut>{$soldOut}</soldOut>"; # 是否已卖光
	$result .= "</display>";
	$result .= "</data>";
	$result .= "</url>";
}

$result .= "</urlset>";

if ($tuans) {
	echo $result;
}

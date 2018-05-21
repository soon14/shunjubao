<?php
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$gouwuke = Request::g('gouwuke');
$qqcb = Request::g('qqcb');

$objSSProdFront = new SSProdFront();
$objSpecialSaleFront = new SpecialSaleFront();

$codition = array(
	'site' => array(SpecialSale::SITE_OWNER_ALL, SpecialSale::SITE_OWNER_MAIN),
	'status' => SpecialSale::STATUS_UNDERWAY,
);
$specialSales = $objSpecialSaleFront->getsByCondition($codition);

$result = '<?xml version="1.0" encoding="utf-8" ?>';
if ($gouwuke) {
	$result .= "<urlsets>";
} else if ($qqcb){
	$result .= "<urlset>";
} else {
	exit;
}
foreach ($specialSales as $specialSale) {
	if ($specialSale['status'] != SpecialSale::STATUS_UNDERWAY) {
		continue;
	}
	
	$categoryName = getCategoryNameByCategoryId($specialSale['categoryIds'][0]);
	$specialSale_url = ROOT_DOMAIN . "/{$categoryName}/{$specialSale['friendlyUrl']}";
	
	$tag = subcategory($specialSale['name']);
	
	$ssProd = $objSSProdFront->getsBySpecialSaleId($specialSale['id'], null, 1);
	$ssProd = array_values($ssProd);
	$objBrandFront = new BrandFront();
	$brand = $objBrandFront->get($ssProd[0]['productInfo']['brandId']);
	if (!$brand || !$brand['logo']) {
		continue;
	}
	
	if ($gouwuke) {
		$result .= "<urlset>";
		$result .= "<loc>{$specialSale_url}</loc>";
		$url = "http://www.gaojie.com";
	} else {
		$result .= "<url>";
		$result .= "<loc>{$specialSale_url}?channelid=2400005</loc>";
		$result .= "<data>";
		$result .= "<display>";
		$url = "http://www.gaojie.com?channelid=2400005";
	}
	$result .= "<website>高街网</website>";
	$result .= "<identifier>{$specialSale['id']}</identifier>";
	$result .= "<siteurl>{$url}</siteurl>";
	$result .= "<title><![CDATA[{$specialSale['name']}]]></title>";
	$result .= "<banner_image>{$specialSale['img_l_662x288']}</banner_image>";
	$result .= "<brand><![CDATA[{$brand['zh_name']}]]></brand>";
	$result .= "<logo_image>{$brand['logo']}</logo_image>";
	$result .= "<tag>{$tag}</tag>";
	$result .= "<priority>0</priority>";
	$result .= "<startTime>{$specialSale['start_time']}</startTime>";
	$result .= "<endTime>{$specialSale['end_time']}</endTime>";
	$result .= "<highdiscount>6.0</highdiscount>";
	$result .= "<lowdiscount>1.0</lowdiscount>";
	if ($gouwuke) {
		$result .= "</urlset>";
	} else {
		$result .= "</display>";
		$result .= "</data>";
		$result .= "</url>";
	}
}
if ($gouwuke) {
	$result .= "</urlsets>";
} else if ($qqcb){
	$result .= "</urlset>";
}

if ($specialSales) echo $result;
exit;

//按特卖名称中的关键字细化分类
function subcategory ($title) {
	$subcategory = array(
		array(
			'keywords' => array('衫','围巾','丝巾','女装','男装','内衣','皮带','袜','美式休闲 名品购物季'),
			'category' => 'clothing',
		),
		array(
			'keywords' => array('配饰','配件','琥珀','饰品','手串','Twice lovely orange系列','潮品','春日潮品系列专场','Twice 挪威春天系列配饰'),
			'category' => 'jewelry',
		),
		array(
			'keywords' => array('运动'),
			'category' => 'sports',
		),
		array(
			'keywords' => array('镜','茶','蜜蜂','手工'),
			'category' => 'stores',
		),
		array(
			'keywords' => array('包', '袋'),
			'category' => 'bags',
		),
		array(
			'keywords' => array('洗护','化妆','肤', '面膜'),
			'category' => 'beauty',
		),
		array(
			'keywords' => array('家居','居家'),
			'category' => 'home',
		),
		array(
			'keywords' => array('鞋'),
			'category' => 'shoes',
		),
	);
	
	foreach ($subcategory as $tmpcat) {
		foreach ($tmpcat['keywords'] as $tmpV) {
			if (strpos($title, $tmpV) !== false) {
				return $tmpcat['category'];
			}
		}
	}
	
	return 'others';
}

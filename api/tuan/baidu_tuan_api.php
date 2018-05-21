<?php
/**
 * 百度团购导航api
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

$objTuanFront = new TuanFront();
$objBrandFront = new BrandFront();
$objProductFront = new ProductFront();
$objSSProdFront = new SSProdFront();
$objSpecialSaleFront = new SpecialSaleFront();
$objOrderAttrIdxFront = new OrderAttrIdxFront();

///////////////////////////////有针对性投放///////////////////////////////
$keywords = array(
	array(
		'keyword' => '手表',//搜索的关键词
		'subcategory' => '手表' //对应百度的分类
	),
	array(
		'keyword' => '鞋',
		'subcategory' => '鞋靴'
	),
	array(
		'keyword' => '包',
		'subcategory' => '箱包'
	),
	array(
		'tag' => '46',//指定tag分类的商品
		'subcategory' => '春装热卖'
	),
	array(
		'tag' => '146',//指定tag分类的商品
		'subcategory' => '化妆品'
	),
	array(
		'tag' => '4',//指定tag分类的商品
		'subcategory' => '饰品'
	),
	array(
		'specialSaleId' => '446',//指定tag分类的商品
		'subcategory' => '春装热卖',
	)
);

$ssProdsOfShelves = array();//存放按关键词搜索出来的商品
$i = 0;
foreach ($keywords as $tmpKw) {
	$objSSProdSphinx = new SSProdSphinx();
	$keyWord = $tmpKw['keyword'];
	$tag = $tmpKw['tag'];
	$specialSaleId = $tmpKw['specialSaleId'];
	$subcategory = $tmpKw['subcategory'];
	
	$objSSProdSphinx->filterBySite(array(SpecialSale::SITE_OWNER_ALL, SpecialSale::SITE_OWNER_MAIN));// 指定站点
	$objSSProdSphinx->filterByStatus(array(SSProd::STATUS_SHELVES));// 指定特卖商品状态
	$objSSProdSphinx->filterBySSStatus(array(SpecialSale::STATUS_UNDERWAY));
	$objSSProdSphinx->rejectPresell();// 踢除预售的
	$objSSProdSphinx->setLimit(50);
	$objSSProdSphinx->distinctByProdId(SSProdSphinx::PARAM_ORDER_TYPE_SORT_DESC);
	
	if ($keyWord) {
		$buildKeywords = "@name {$keyWord} | @path_cat_name {$keyWord} | @brand_name {$keyWord}";
		$objSSProdSphinx->addQuery($buildKeywords);
	}
	if ($tag) {
		$objSSProdSphinx->filterByProdCategoryIds(array($tag));
		$objSSProdSphinx->addQuery();
	}
	if ($specialSaleId) {
		$objSSProdSphinx->filterBySSId(array($specialSaleId));
		$objSSProdSphinx->addQuery();
	}
	
	$tmpSearchResult = $objSSProdSphinx->runQueries();
	if (isset($tmpSearchResult[0]['matches']) && is_array($tmpSearchResult[0]['matches'])) {
		$ssProdsOfShelves[$i]['ssProds'] = $objSSProdFront->gets(array_keys($tmpSearchResult[0]['matches']));
	}
	$ssProdsOfShelves[$i]['subcategory'] = $subcategory;
	$i++;
}

$tmpSSProds = $SSProdIds = array();
foreach ($ssProdsOfShelves as $tmpInfo) {
	foreach ($tmpInfo['ssProds'] as $tmpK => $tmpV) {
		$SSProdIds[$tmpK] = $tmpK;
		$tmpSSProds[$tmpK]['ssProd'] = array(
			'friendlyUrl' => $tmpV['friendlyUrl'],
			'unit_price' => $tmpV['default_ssProdAttr']['unit_price'],
			'old_price' => $tmpV['default_ssProdAttr']['old_price'],
			'ssProdId' => $tmpV['id'],
			'productId' => $tmpV['productId'],
			'subcategory' => $tmpInfo['subcategory'],
			'image' => $tmpV['default_ssProdAttr']['prodAttr']['imgs'][0]['b_308x330'],
		);
		$tmpSSProds[$tmpK]['ssProd']['productInfo']['brandId'] = $tmpV['productInfo']['brandId'];
		
		$specialSale = $objSpecialSaleFront->get($tmpV['specialSaleId']);
		$tmpSSProds[$tmpK]['specialSale'] = $specialSale;
		$tmpSSProds[$tmpK]['specialSale']['img_b_415x249'] = $specialSale['img_s_226x118'];
		$tmpSSProds[$tmpK]['specialSale']['categoryId'] = $specialSale['categoryIds'][0];
		$tmpSSProds[$tmpK]['specialSale']['name'] = $tmpV['productInfo']['name'];
	}
}

$countsBySSProdIds = $objOrderAttrIdxFront->getCountBySSProdIds($SSProdIds);

foreach ($tmpSSProds as $tmpk => $tmpv) {
	$tmpSSProds[$tmpk]['bougth'] = $countsBySSProdIds[$tmpk] ? $countsBySSProdIds[$tmpk] : 0;
}

$tuans = $objTuanFront->getsUnderWayTuan();
$tuans = array_merge($tuans, $tmpSSProds);

function subcategory($id, $title) //对团购商品进行分类
{
	switch ($id) 
	{
		case 1: 
			if (strpos($title, '表') || strpos($title, '表') === 0) {
				return '手表';
			}
			if (strpos($title, '包') || strpos($title, '包') === 0) {
				return '箱包';
			}
			if (strpos($title, '配饰') || strpos($title, '配饰') === 0 ||
				strpos($title, '链') || strpos($title, '链') === 0 ||
				strpos($title, '银') || strpos($title, '银') === 0 ||
				strpos($title, '坠') || strpos($title, '坠') === 0 )
			{
				return '饰品';
			}
			return '服装';
		case 2: 
			if (strpos($title, '鞋') || strpos($title, '鞋') === 0) {
				return '鞋靴';
			}
			return '箱包';
		case 4: 
			if (strpos($title, '美容') || strpos($title, '美容') === 0 ||
				strpos($title, '化妆') || strpos($title, '化妆') === 0 ||
				strpos($title, '指甲油') || strpos($title, '指甲油') === 0 ||
				strpos($title, '面膜') || strpos($title, '面膜') === 0)
			{
				return '化妆品';
			}
			if (strpos($title, '减肥') || strpos($title, '减肥') === 0 ||
				strpos($title, '茶') || strpos($title, '茶') === 0)
			{
				return '食品饮料';
			}
			return '生活家居';
		case 6: 
			if (strpos($title, '表') || strpos($title, '表') === 0) {
				return '手表';
			}
			if (strpos($title, '包') || strpos($title, '包') === 0) {
				return '箱包';
			}
			if (strpos($title, '配饰') || strpos($title, '配饰') === 0) {
				return '饰品';
			}
			return '其他';
		default : return '其他';
	}
}

$result .= '<?xml version="1.0" encoding="UTF-8"?><urlset>';
foreach ($tuans as $tuan) {
	if (!$tuan['ssProdId']) {
		$url = "http://www.gaojie.com/product/p{$tuan['ssProd']['friendlyUrl']}m?channelid=2400001";
	} else {
		$url = 'http://tuan.gaojie.com/tuan/detail/'."{$tuan['ssProd']['friendlyUrl']}?channelid=2400001";
	}
	$rebate = ConvertData::toMoney(($tuan['ssProd']['unit_price']/$tuan['ssProd']['old_price']*10)); # 折扣
	
	if (isset($tuan['bougth'])) {
		$bougth = $tuan['bougth'] + 7 + $tuan['ssProd']['ssProdId'] % 13;
	} else {
		$bougth = getUserNumBySSProdId($tuan['ssProdId']) + $tuan['specialSale']['tuan_pseudo_num']; # 购买人数
	}
	
	$brand = $objBrandFront->get($tuan['ssProd']['productInfo']['brandId']);
	if ($tuan['ssProd']['subcategory']){
		$subcategory = $tuan['ssProd']['subcategory'];
		$image = $tuan['ssProd']['image'];
	} else {
		$subcategory = subcategory($tuan['specialSale']['categoryId'], $tuan['specialSale']['name']);
		$image = $tuan['specialSale']['img_b_415x249'];
	}
	
	$product = $objProductFront->get($tuan['ssProd']['productId']);
//	echo '<pre>';print_r($product['name']);exit;
	
	$result .= '<url>';
	$result .= "<loc>{$url}</loc>"; //商品url
	$result .= '<data>';
	$result .= '<display>';
	$result .= "<website>高街网</website>";
	$result .= "<siteurl>http://www.gaojie.com/</siteurl>";
	$result .= "<city>全国</city>";
	$result .= "<category>4</category>"; //团购分类号     4 为“网上购物”
	$result .= "<subcategory>$subcategory</subcategory>"; //细分类
	$result .= "<dpshopid></dpshopid>"; //商家的大众点评网ID
	$result .= "<range></range>"; //商圈名称
	$result .= "<address></address>"; //商家的店面地址
	$result .= "<major>1</major>"; //是否主打
	$result .= "<title><![CDATA[{$tuan['specialSale']['name']}]]></title>";
	$result .= "<image>{$image}</image>";
	$result .= "<startTime>{$tuan['specialSale']['start_time']}</startTime>";
	$result .= "<endTime>{$tuan['specialSale']['end_time']}</endTime>";
	$result .= "<value>{$tuan['ssProd']['old_price']}</value>";
	$result .= "<price>{$tuan['ssProd']['unit_price']}</price>";
	$result .= "<rebate>{$rebate}</rebate>";
	$result .= "<bought>{$bougth}</bought>";
	$result .= "<name><![CDATA[{$product['name']}]]></name>"; //商品名称准确描述
	$result .= "<seller>{$brand['en_name']}</seller>"; //团购的商家名称
	$result .= "<phone>400-0816-999</phone>"; //商家的电话
	$result .= '</display>';
	$result .= '</data>';
	$result .= '</url>';

}
$result .= '</urlset>';
if ($tuans) echo $result;
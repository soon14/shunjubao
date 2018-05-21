<?php
/**
 * 易购数据接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objSSProdFront = new SSProdFront();

echo '<?xml version="1.0" encoding="utf-8" ?><boot>';

$offset = 0;
$size = 50;
while (TRUE) {
	$ssProds = $objSSProdFront->getsByConditionFromSphinx(array(), "{$offset},{$size}");
	if (!$ssProds) {
		break;
	}
	
	foreach ($ssProds as $ssProd) {
		$objBrandFront = new BrandFront();
		$objSpecialSaleFront = new SpecialSaleFront();
		
		$brand = $objBrandFront->get($ssProd['productInfo']['brandId']);
		
		$url = ROOT_DOMAIN . "/product/p{$ssProd['friendlyUrl']}m/?channelid=9000008";
		
		$specialSale = $objSpecialSaleFront->get($ssProd['specialSaleId']);
		
		$nav = "<![CDATA[首页 &gt; {$specialSale['name']} &gt; {$ssProd['productInfo']['name']}]]>"; //浏览路径
		
		$result = "<urlset>";
		$result .= "<ident>gaojie_{$ssProd['id']}</ident>";
		$result .= "<productname><![CDATA[{$ssProd['productInfo']['name']}]]></productname>";
		$result .= "<pinpai><![CDATA[{$brand['zh_name']} {$brand['en_name']}]]></pinpai>";
		$result .= "<orifenlei>{$nav}</orifenlei>";//浏览路径
		$result .= "<refprice>{$ssProd['old_price']}</refprice>";
		$result .= "<price_1>{$ssProd['unit_price']}</price_1>";
		$result .= "<quehuo>false</quehuo>"; //商品状态 ，是否缺货
		$result .= "<picurls><picurllist>";
		$result .= "<smallpicurl>{$ssProd['default_ssProdAttr']['prodAttr']['imgs'][0]['s_47x51']}</smallpicurl>";
		$result .= "<picurl>{$ssProd['default_ssProdAttr']['prodAttr']['imgs'][0]['b_308x330']}</picurl>";
		$result .= "<bigpicurl>{$ssProd['default_ssProdAttr']['prodAttr']['imgs'][0]['l_2000x2000']}</bigpicurl>";
		$result .= "</picurllist></picurls>";
		$result .= "<url>{$url}</url>";
		$result .= "<shortintrohtml><![CDATA[{$ssProd['productInfo']['desc']}]]></shortintrohtml>";//商品简介
		$result .= "<shortintro></shortintro>";
		$result .= "<color><![CDATA[{$ssProd['default_ssProdAttr']['prodAttr']['attr_1']['value']}]]></color>";//颜色
		$result .= "<upc></upc>";//条形码
		$result .= "</urlset>";
		
		echo $result;
	}
	
	$offset += $size;
}

echo '</boot>';
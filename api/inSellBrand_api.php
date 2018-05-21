<?php
/**
 * CMS 在售品牌数据接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objSpecialSaleFront = new SpecialSaleFront();

$sites = array(0);
$inSellBrandsTmp = array();
$inSellBrandsTmp = $objSpecialSaleFront->getsSpecialSale($sites, null, SpecialSale::STATUS_UNDERWAY, null);

$objSSCategoryFront = new SSCategoryFront();
$categorys = $objSSCategoryFront->getsAll();

$i = 1;
foreach ($inSellBrandsTmp as $tmpK => $tmpV) {
	$url = ROOT_DOMAIN.'/'.$categorys[$tmpV['categoryIds'][0]]['en_name'].'/'.$tmpV['friendlyUrl'];

	$class = '';
	if (($i % 9) == 0) {
		$class = " class='ct'";
	}
	echo "<li{$class}>";
	echo "<a href=\"{$url}\" target=\"_blank\" title=\"{$tmpV['name']}\"><img src=\"{$tmpV['img_logo_85x85']}\" alt=\"{$tmpV['name']}\"></a>";
	echo "<p>{$tmpV['discount']}</p>";
	echo "</li>";

	$i++;
}

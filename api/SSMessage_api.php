<?php
/**
 * 为资讯频道提供最新特卖信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objSpecialSaleFront = new SpecialSaleFront();

$site = array(SpecialSale::SITE_OWNER_MAIN,SpecialSale::SITE_OWNER_ALL);
$specialSales = $objSpecialSaleFront->getsSpecialSale($site, null, SpecialSale::STATUS_UNDERWAY, null);

foreach($specialSales as $key=>$specialSale)
{
	$myspecialSale[$key]['name'] = $specialSale['name'];
	$myspecialSale[$key]['img_s_226x118'] = $specialSale['img_s_226x118'];
	$myspecialSale[$key]['start_time'] = $specialSale['start_time'];
	$myspecialSale[$key]['end_time'] = $specialSale['end_time'];
	$myspecialSale[$key]['format_start_time'] = date("m月d日", $specialSale['start_time']);
	$myspecialSale[$key]['format_end_time'] = date("m月d日", $specialSale['end_time']);
	$myspecialSale[$key]['discount'] = $specialSale['discount'];
	$categoryName = getCategoryNameByCategoryId($specialSale['categoryIds']['0']);
	$myspecialSale[$key]['url'] = ROOT_DOMAIN."/".$categoryName ."/".$specialSale['friendlyUrl'];
	unset($categoryName);
}

$outputType = Request::g('outputType', Filter::TRIM);
$getType = Request::g('getType', Filter::TRIM);
$getNum  = Request::g('getNum', Filter::TRIM);
if ('random' == $getType) {
	srand((float)microtime()*1000000);
	shuffle($myspecialSale);
}
if (Verify::unsignedInt($getNum)) {
	$myspecialSale = array_slice($myspecialSale, 0, $getNum);
}

if ('json' == $outputType) {
	$message = json_encode($myspecialSale);
	echo($message);
} elseif ('js' == $outputType) {
	foreach($myspecialSale as $item) {
		echo "document.write(\"<li>\");";
		echo "document.write(\"<div class='newhot_pic'>\");";
		echo "document.write(\"<a href='{$item['url']}'><img src='{$item['img_s_226x118']}' /></a>\");";
		echo "document.write(\"</div>\");";
		echo "document.write(\"<div class='newhot_txt'>\");";
		echo "document.write(\"<a href='{$item['url']}'>{$item['name']}</a><br />\");";
		echo "document.write(\"{$item['format_start_time']}-{$item['format_end_time']}\");";
		echo "document.write(\"</div>\");";
		echo "document.write(\"</li>\");";
	}
}
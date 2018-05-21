<?php
/**
 * 百度数据开放平台
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objSSProdFront = new SSProdFront();
$objBrandFront = new BrandFront();
$objCategoryFront = new CategoryFront();
$objSpecialSaleFront = new SpecialSaleFront();
$objProductFront = new ProductFront();
$objTuanCategoryFront = new TuanCategoryFront();
$objSSCategoryFront = new SSCategoryFront();

header("Content-type: text/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8" ?><urlset>';

$ss_status = Request::g('ss_status');
if ($ss_status == 'ended') {
	$cond = array(
		'ss_status'	=> array(
			SpecialSale::STATUS_ENDED,
		),
		'status'	=> array(
			SSProd::STATUS_SHELVES,
			SSProd::STATUS_SELL_OUT,
		),
	);
} else {
	$cond = array(
		'ss_status'	=> array(
			SpecialSale::STATUS_UNDERWAY,
		),
		'status'	=> array(
			SSProd::STATUS_SHELVES,
			SSProd::STATUS_SELL_OUT,
		),
	);
}

$page = Request::g('page');
if (!$page || !Verify::naturalNumber($page)) {
	$page = 1;
}

$offset = ($page - 1) * 3000;// 每页3000个url
$size = 100;
$max_offset = $offset + 3000;

while (TRUE) {
	if ($offset > $max_offset) {
		break;
	}
	$ssProds = $objSSProdFront->getsByConditionFromSphinx($cond, "{$offset},{$size}");
	if (!$ssProds) {
		break;
	}

	$brandIds = array();
	$specialSaleIds = array();
	$pids = array();
	foreach ($ssProds as $ssProd) {
		$brandIds[$ssProd['productInfo']['brandId']] = $ssProd['productInfo']['brandId'];
		$specialSaleIds[$ssProd['specialSaleId']] = $ssProd['specialSaleId'];
		$pids[$ssProd['productInfo']['id']] = $ssProd['productId'];
	}

	$brands = $objBrandFront->gets($brandIds);
	$specialSales = $objSpecialSaleFront->gets($specialSaleIds);
	$productCats = $objProductFront->getsCatsByPids($pids);

	foreach ($ssProds as $ssProd) {
		$title = $ssProd['productInfo']['name'];
		$title = str_replace("拉杆箱", "拉杆箱/旅行箱", $title);
		$title = str_replace("手拎", "手提/手拎", $title);
		$title = str_replace("手拿", "手拿/手提", $title);
		$title = str_replace('腰带', '腰带/皮带', $title);
		$title = str_replace("拉杆包", "拉杆包/拉杆箱/旅行箱", $title);
		$title = str_replace("旅行包", "旅行包/拉杆箱/旅行箱", $title);
		$title = str_replace("美臀垫", "美臀垫/坐垫", $title);


		$brand = $brands[$ssProd['productInfo']['brandId']];
		$specialSale = $specialSales[$ssProd['specialSaleId']];

		$cat_path = '';
		if (isset($productCats[$ssProd['productId']])) {
			foreach ($productCats[$ssProd['productId']] as $prodCat) {
				$cat_path .= $prodCat['path'];
			}
		}
		$cat_path = trim($cat_path, ',');
		$tmpcatIds = array_unique(explode(',', $cat_path));
		$objCategory = new Category();
		$tmpCats = $objCategory->gets($tmpcatIds);
		$prodCatNames = array();
		foreach ($tmpCats as $tmpCat) {
			if ($tmpCat['name'] == '手拎包') {
				$prodCatNames[] = '手拎包';
				$prodCatNames[] = '手提包';
			} else if ($tmpCat['name'] == '手拿包') {
				$prodCatNames[] = '手拿包';
				$prodCatNames[] = '手包';
			} else if ($tmpCat['name'] == '旅行包') {
				$prodCatNames[] = '旅行包';
				$prodCatNames[] = '拉杆箱';
				$prodCatNames[] = '拉杆包';
				$prodCatNames[] = '旅行箱';
			} else if ($tmpCat['name'] == '泳装') {
				$prodCatNames[] = '泳装';
				$prodCatNames[] = '泳衣';
			} else {
				$prodCatNames[] = $tmpCat['name'];
			}
		}

		if (in_array("鞋子", $prodCatNames)) {
			if (in_array("男士", $prodCatNames)) {
				$prodCatNames[] = "男鞋";
			} else {
				$prodCatNames[] = "女鞋";
			}
		}

		$tags = join("\\", $prodCatNames);

		# 如果没有分类，手动给个默认的
		if (!$tags) {
			if (isset($specialSale['categoryId']) && Verify::int($specialSale['categoryId'])) {
				$tuanCate = $objTuanCategoryFront->get($specialSale['categoryId']);
				if ($tuanCate) {
					$tags = $tuanCate['name'];
				}
			} else if (is_array($specialSale['categoryIds'])) {
				$ssCates = $objSSCategoryFront->gets($specialSale['categoryIds']);
				$ssCateNames = array();
				foreach ($ssCates as $ssCate) {
					$ssCateNames[] = $ssCate['name'];
				}
				$tags = join("\\", $ssCateNames);
			}

			if (!$tags) {
				$tags = "服装";
			}
		}

		$description = strip_tags($ssProd['productInfo']['desc'], "<style>");
		$description = preg_replace('#<style>.*</style>#is', '', $description);
		$description = mb_substr($description, 0, 2000, 'utf-8');

		$last_update_time = date('Y-m-d', $ssProd['update_time']);
		$end_time = date('Y-m-d', $specialSale['end_time']);

		# 每个sku都对应一条记录
		foreach ($ssProd['ssProdAttrs'] as $tmpSSProdAttr) {
			$tmp_title = "{$title} {$tmpSSProdAttr['prodAttr']['attr_1']['value']} {$tmpSSProdAttr['prodAttr']['attr_2']['value']}"
						. " {$brand['zh_name']} {$brand['en_name']}"
						. '('.join('/', $prodCatNames).')';

			$realtitle = "{$brand['zh_name']} {$brand['en_name']} {$tmpSSProdAttr['prodAttr']['attr_1']['value']} {$tmpSSProdAttr['prodAttr']['attr_2']['value']}";
			$url = jointUrl(WWW_ROOT_DOMAIN . "/product/p{$ssProd['friendlyUrl']}m/" . base64url_encode($tmpSSProdAttr['prodAttr']['attr_1']['value'])
				, array(
					'attr2'	=> base64url_encode($tmpSSProdAttr['prodAttr']['attr_2']['value']),
					'channelid'	=> '2800001',
				)
			);
			$price = ConvertData::toMoney($tmpSSProdAttr['unit_price'], false);

			$result = "<url>";
			$result .= "<loc><![CDATA[{$url}]]></loc>";
			$result .= "<lastmod>{$last_update_time}</lastmod>";

			if ($specialSale['status'] == SpecialSale::STATUS_ENDED
				|| $ssProd['status'] == SSProd::STATUS_SELL_OUT
				|| $tmpSSProdAttr['amount'] == 0
			) {// 已结束的链接权重低一些
				$result .= "<priority>1.0</priority>";
				$stock = 1;// 1表示缺货
			} else {
				$result .= "<priority>0.1</priority>";
				$stock = 0;
			}

			$stock = 0;// 强制表示不缺货

			$result .= "<data>";
			$result .= "<display>";
			$result .= "<title><![CDATA[{$tmp_title}]]></title>";
			$result .= "<realtitle><![CDATA[{$realtitle}]]></realtitle>";
			$result .= "<price>{$price}</price>";
			$result .= "<brand><![CDATA[{$brand['zh_name']}]]></brand>";
			$result .= "<tags>{$tags}</tags>";
			$result .= "<services>100%正品\\满288全场免运费\\7天退换货</services>";
			$result .= "<image>{$tmpSSProdAttr['prodAttr']['imgs'][0]['b_308x330']}</image>";
			$result .= "<store>高街网</store>";
			$result .= "<stock>{$stock}</stock>";
			$result .= "<description><![CDATA[{$description}]]></description>";
			$result .= "<city>北京</city>";
			$result .= "<expirationdate>{$end_time}</expirationdate>";
			$result .= "<score>5</score>";
			$result .= "</display>";
			$result .= "</data>";
			$result .= "</url>";
			echo $result;
		}
	}
	$offset += $size;
}
echo '</urlset>';
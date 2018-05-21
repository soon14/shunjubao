<?php
/**
 * 按照FF协议提供在线商品列表
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

//header('Content-Type: text/xml');

$ssProds = $display = $productIds = $brandIds = $categoryIds = $ssProdAttrIds = $color = $size = array();
$specialSaleId = $en_name = $zh_name = '';
$offset = 0;
$index = 1;
$ssProds_status = SSProd::STATUS_SHELVES;
$ss_status = SpecialSale::STATUS_UNDERWAY;
$order_status = array(
						OrderAttrIdx::STATUS_DELIVER_SUCCESS,
						OrderAttrIdx::STATUS_HAS_REPLENISH,
						OrderAttrIdx::STATUS_HAS_SHIPMENT,
						OrderAttrIdx::STATUS_HAS_SHIPMENT_FROM_REPLENISH,
						);

$objOrderAttrIdxFront = new OrderAttrIdxFront();
$objSpecialSaleFront = new SpecialSaleFront();
$objProductFront = new ProductFront();
$objSSCategoryFront = new SSCategoryFront();
$categorys = $objSSCategoryFront->getsAll();

$objSSProdFront = new SSProdFront();
$objBrandFront = new BrandFront();

do{

	$specialSales = $objSpecialSaleFront->getsByStatusOrderByStartTime($ss_status,"{$offset},1");

	if (!$specialSales) {
		break;
	}
	foreach ($specialSales as $key=>$specialSale) {
		$specialSaleId = $specialSale['id'];
		$categorys_name[$key] = $categorys[$specialSale['categoryIds'][0]]['name'];
	}
	$specialSaleProds = $objSSProdFront->getsBySpecialSaleId($specialSaleId,$ssProds_status);
	foreach ($specialSaleProds as $key=>$value) {
		$productIds[] = $value['productId'];
		$brandIds[] = $value['productInfo']['brandId'];

		foreach ($value['ssProdAttrs'] as $k=>$v) {
			$ssProdAttrIds[] = $v['id'];
		}
	}
	if (!$ssProdAttrIds) {
		break;
	}

	$products = $objProductFront->gets($productIds);
	$brands = $objBrandFront->gets($brandIds);

	$orderAttrs = $objOrderAttrIdxFront->getsBySpecialSaleId($specialSaleId, $order_status);
	$quantity_sold = array();
	foreach ($orderAttrs as $k=>$v) {
		if ($v['orderStatus'] == Order::STATUS_HAS_SHIPMENT || $v['orderStatus'] == Order::STATUS_WAIT_SHIPMENT) {
			if (array_key_exists($v['ssProdAttrId'],$quantity_sold)) {
				$quantity_sold[$v['ssProdAttrId']] += $v['amount'];
			} else {
				$quantity_sold[$v['ssProdAttrId']] = $v['amount'];
			}
		}
	}

	$display['store'] = '高街网';
	$display['city'] = '北京';
	$display['shipping'] = '全国：10';
	foreach ($specialSaleProds as $key=>$value) {
		$display['moreimage'] = $display['color'] = $display['size'] = '';
		$display['quantity_sold'] = 0;
		$color = $size = array();
		$ssProds[$index]['loc'] = ROOT_DOMAIN.'/'.'product/'.'p'.$value['friendlyUrl'].'m';
		$ssProds[$index]['lastmod'] = date('Y-m-d',$value['update_time']);
		$display['title'] = $products[$value['productId']]['name'];
		$display['price'] = $value['unit_price'];
		$display['market_price'] = $value['old_price'];
		$en_name = $brands[$value['productInfo']['brandId']]['en_name'];
		$zh_name = $brands[$value['productInfo']['brandId']]['zh_name'];
		$display['brand'] = $en_name.($en_name?'\\':'').$zh_name;
		$display['tags'] = $categorys_name[$value['specialSaleId']];
		$display['services'] = '100%正品\\满288全场免运费\\7天退货';
		foreach ($value['ssProdAttrs'] as $k=>$v) {
			$display['stock'] = $v['amount']?0:1;
			$display['image'] = $v['imgs'][0]['w_2000x2000'];
				foreach ($v['imgs'] as $kk=>$vv) {
					$display['moreimage'] .= $display['moreimage']?',':'';
					$display['moreimage'] .= $vv['w_2000x2000'];
				}
			$color[] = $v['attr_1']['value'];
			$size[] = $v['attr_2']['value'];
			if (count($color)>1) {
				$color = array_unique($color);
			}
			if (count($color)>1) {
				$size = array_unique($size);
			}
			$display['color'] = implode('\\', $color);
			$display['size'] = implode('\\', $size);
			$display['quantity_sold'] += $quantity_sold[$k]?$quantity_sold[$k]:0;
		}
		$display['start_date'] = date('Y-m-d-H:i:s',$specialSales[$value['specialSaleId']]['start_time']);
		$display['end_date'] = date('Y-m-d-H:i:s',$specialSales[$value['specialSaleId']]['end_time']);
		$ssProds[$index]['data'] = array('display'=>$display);
		$index++;
	}
	$offset++;
}
while (1);
$tpl = new Template();
$tpl->assign('ssProds',$ssProds);
$YOKA['output'] = $tpl->r('ffprods_api');
echo_exit($YOKA['output']);
//$ssProds = arrayToXml($ssProds,'urlset',null,'url');

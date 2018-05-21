<?php
/**
 * 提供给蘑菇街的分享接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$url = Request::g('url');
if (!preg_match('#^http\://www\.gaojie\.com/product/p([a-z]+)m(?:/(.+))?(\?channelid=(\d{7,13}))?$#i', $url, $match)) {
//if (!preg_match('#^http\://gen\.gaojie100\.com/product/p([a-z]+)m(?:/(.+))?(\?channelid=(\d{7,13}))?$#i', $url, $match)) {
	$return_res = array('status'=>'fail', 'msg'=>'URL参数传递错误!');
	echo json_encode($return_res);
	exit();
}

$friendlyUrl = $match[1];
$ssProdId =  ConvertData::decryptStr2Id($friendlyUrl);
if (!Verify::unsignedInt($ssProdId)) {
	$return_res = array('status'=>'fail', 'msg'=>'找不到相应的商品!');
	echo json_encode($return_res);
	exit();
}

$objSSProdFront = new SSProdFront();
$objSpecialSaleFront = new SpecialSaleFront();
$objBrandFront = new BrandFront();
$objSSCategoryFront = new SSCategoryFront();
$objProductFront = new ProductFront();

$ssProd = $objSSProdFront->get($ssProdId);
if (!$ssProd) {
	$return_res = array('status'=>'fail', 'msg'=>'找不到相应的商品!');
	echo json_encode($return_res);
	exit();
}

$specialSale = $objSpecialSaleFront->get($ssProd['specialSaleId']);
if($ssProd['status'] != SSProd::STATUS_SHELVES || $specialSale['status'] != SpecialSale::STATUS_UNDERWAY){
	$return_res = array('status'=>'fail', 'msg'=>'商品或特卖还没有上架!');
	echo json_encode($return_res);
	exit();
}

$productId = $ssProd['productId'];
$cateInfo = $objProductFront->getsCatsByPids(array($productId));
if ($cateInfo[$productId]) {
	$cur_cate = current($cateInfo[$productId]);
	$cid = $cur_cate['id'];
	$category = $cur_cate['name'];
} else {
	$cid = $specialSale['categoryIds'][0];
	$category_info = $objSSCategoryFront->get($cid);
	$category = $category_info['name'];
}
$brand = $objBrandFront->get($ssProd['productInfo']['brandId']);

$item = array(
'num_id'=>$ssProdId,//数字ID
'iid'=>$friendlyUrl,//字符串ID
'detail_url'=>ROOT_DOMAIN."/product/p{$friendlyUrl}m",//url
'title'=>$ssProd['productInfo']['name'],//标题
'price'=>$ssProd['unit_price'],//价格
'pic_url'=>$ssProd['default_ssProdAttr']['prodAttr']['imgs'][0]['b_308x330'],//图片地址
'cid'=>$cid,//分类ID
'category'=>$category, //分类名称
'brand'=>$brand["zh_name"],//品牌名称
'created'=>$specialSale['start_time'],//上价时间unix时间
);

$return_res = array('status'=>'ok', 'item'=>$item);
echo json_encode($return_res);
exit();

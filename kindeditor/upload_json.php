<?php
/**
 * KindEditor PHP
 *
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 *
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

# 为了在图片上传的同时，能做一些其它的处理，比如：生成多张尺寸不一的缩略图等
# 特添加这个参数于用支持
# 目前支持的app_type有：
# 1、prod_attr ，商品属性传图
$app_type = $_GET['app_type'];
$id = $_REQUEST['id'];
$water = $_REQUEST['water'];
//文件保存目录路径
$save_path = IMG_UPLOAD_PATH . '/';
//文件保存目录URL
$save_url = IMG_UPLOAD_URL . '/';
//定义允许上传的文件扩展名
$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
//最大文件大小
$max_size = 8000000;

$save_path = realpath($save_path) . '/';

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("临时文件可能不是上传文件。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr) === false) {
		alert("上传文件扩展名是不允许的扩展名。");
	}
	//创建文件夹
	$ymd = date("Ymd");
	$ymd = date("Y") . '/' . date('md');
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		if (!mkdir($save_path, 0775, true)) {
			alert("创建目录失败：{$save_path}");
		}
	}
	//新文件名
	$new_file_name = date("His") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0777);//0644
	$file_url = $save_url . $new_file_name;
	$waterPath = ROOT_PATH.'/www/statics/i/water.png';
	if($water == 'yes')
	{
		addWaterImg($file_path,10,10,$waterPath);
	}
	switch ($app_type) {
		case 'prod_attr':// 商品属性传图，生成 66x71、47x51 的缩略图
			resizeImg($file_path, 110, 130);  //团购右侧推荐图片
			resizeImg($file_path, 47, 51);
			resizeImg($file_path, 66, 71);
			resizeImg($file_path, 40, 42);
			resizeImg($file_path, 21, 21);	//团购商品颜色属性图片
			break;
	/*	case 'prod_attr_detail':  //详细图需要添加水印
			addWaterImg($file_path,10,10,$waterPath);
			break; */
		case 'productDesc':  //添加商品的详细信息时判断
			  ## 如果水印添加不成功的话，图就不显示鸟，哈哈
			  if($water == 'yes')
			  {
				$file_url = getWaterUrl($file_url);
			  }
			break;
		case 'tuan_images':
			resizeImg($file_path, 300, 180);
			break;
		default:
			break;
	}

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>
<?php
/**
 *
 * 缩放图片
 * @param string $src 源图全路径
 * @param float $dst_w 目标图片宽度
 * @param float $dst_h 目标图片高度
 * @return InternalResultTransfer
 */
function resizeImg($src, $dst_w, $dst_h) {
	$srcDir = pathinfo($src, PATHINFO_DIRNAME);
	$dstDir = $srcDir . '_thumbs' . "/{$dst_w}x{$dst_h}";
	if (!file_exists($dstDir)) {
		if (!mkdir($dstDir, 0775, true)) {
			return InternalResultTransfer::fail("创建目标目录{$dstDir}失败");
		}
	}
	$dst = "{$dstDir}/" . pathinfo($src, PATHINFO_BASENAME);

	$result = TMImage::resize($src, $dst_w, $dst_h, $dst);
	if ($result->isSuccess()) {
		return InternalResultTransfer::success($dst);
	} else {
		return $result;
	}
}

/*
 * 图片加水印
 * 将水印图片放到一个文件夹中
 */
function addWaterImg($src,$posX,$posY,$waterImg='')
{

	if(!$waterImg || !file_exists($waterImg))
	{
		return InternalResultTransfer::fail("水印图片没有获取到");
	}
	$srcDir = pathinfo($src,PATHINFO_DIRNAME);
	$dstDir = $srcDir . '_water';
	if(!file_exists($dstDir)){
		if(!mkdir($dstDir,0775,true)){
			return InternalResultTransfer::fail("创建目标目录{$dstDir}失败");
		}
	}
	$dst = "{$dstDir}/" . pathinfo($src, PATHINFO_BASENAME);
	$result = TMImage::imageWaterMark($src, $waterImg, $posX, $posY,$dst);
	if ($result->isSuccess()) {
		return InternalResultTransfer::success($dst);
	} else {
		return $result;
	}
}

/**
 * 根据源图的url获取添加水印的图片
 * @param string $srcUrl
 * @return string | false
 */
function getWaterUrl($srcUrl) {
	$src = $srcUrl;
	if (empty($src)) {
		return false;
	}

	$srcDir = pathinfo($src, PATHINFO_DIRNAME);
	$dstDir = $srcDir . '_water';
	$dst = "{$dstDir}/" . pathinfo($src, PATHINFO_BASENAME);
	return $dst;
}

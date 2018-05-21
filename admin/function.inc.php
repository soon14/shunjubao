<?php
/**
 *
 * 根据源图的url获取压缩后的特定宽 $dst_w、高$dst_h 的目标图url
 * @param string $srcUrl
 * @param int $dst_w
 * @param int $dst_h
 * @return string | false
 */
function getThumbUrl($srcUrl, $dst_w, $dst_h) {
	$src = $srcUrl;
	if (empty($src)) {
		return false;
	}

	$srcDir = pathinfo($src, PATHINFO_DIRNAME);
	$dstDir = $srcDir . '_thumbs' . "/{$dst_w}x{$dst_h}";
	$dst = "{$dstDir}/" . pathinfo($src, PATHINFO_BASENAME);
	return $dst;
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

/**
 * 获取当前的批次
 * @param boolean $next 是否取下一期
 * @return int
 */
function getBatch($next = false){
	$begin_date = SUBSCRIBE_EAMIL_START_DATE;
	$begin_time = strtotime($begin_date);
	$week_time = 60*60*24*7;//一周的秒数
	$now_time = time();
	$num = $next?2:1;
	return floor(($now_time - $begin_time)/$week_time) + $num;
}

/**
 * 获取本周某一天的日期
 * @param int $w 0-6代表周日-周六
 * @return DateTime 2014-03-23
 */
function getSpecialDate($w) {
	return date('Y-m-d',strtotime(date('Y-m-d' ,time()). '00:00:00') - (date('w') - $w)*24*3600 );
}

/**
 * 导出csv格式的需要，内容里不能有回车、换行、逗号
 */
function enterReplaceToBlank ($str){
	if (!$str) return '';
	$str = str_replace(array("\r\n", "\r", "\n"), ' ', $str);
	$str = str_replace(array(","), '，', $str);
	return $str;
}
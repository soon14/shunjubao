<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$fashionNavCahce = 'fashionNavCahce';
$objTMMemcached = new TMMemcached();

if ('del' == $_GET['act']) { // 手动的删除CACHE
	$objTMMemcached->delete($fashionNavCahce);
	echo "Cache deleted successfully!!!<br />";
}

$viewNav = $objTMMemcached->get($fashionNavCahce);
if (!empty($viewNav)) {
	echo $viewNav;
	exit();
}

// 目前采用比较暴力的方法
$objCurl = new Curl(ROOT_DOMAIN);
$content = $objCurl->get();

//preg_match_all('|<div class=\"site\-nav\">(.*)</div>|U', $content, $out);
$start = strpos($content, '<div class="site-nav">');

$content = substr($content, $start);
$navContent = preg_split("|</div>\s*</div>\s*</div>|U", $content);

if (empty($navContent[0])) {
	die;
}

$navLine = explode("\r\n", $navContent[0]);
$viewNav = "";
foreach((array)$navLine as $item) {
	$tmpLine = str_replace("'", '"', $item);
	//$tmpLine = str_replace('"', '\"', $tmpLine);
	$viewNav .= "document.write('{$tmpLine}');";
}

if ("" != trim($viewNav)) {
	$viewNav .= "document.write('</div></div></div>');";
	$objTMMemcached->set($fashionNavCahce, $viewNav, 3600); // 导航缓存1小时
	echo $viewNav;
}
<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//手机版的主页
if (preg_match(WAP_DOMAIN_MATCH, ROOT_DOMAIN)) {
	$filename = ROOT_PATH.'/news/wap/wap.html';
} elseif (preg_match(APP_DOMAIN_MATCH, ROOT_DOMAIN)) {
	//app的首页
	$filename = ROOT_PATH.'/news/app/index.html';
} elseif(preg_match(IOS_DOMAIN_MATCH, ROOT_DOMAIN)) {
	//ios的首页
	$filename = ROOT_PATH.'/news/ios/index.html';
} elseif(preg_match(MP_DOMAIN_MATCH, ROOT_DOMAIN)) {
	//微信的首页
	$filename = ROOT_PATH.'/news/mp/index.html';
} else {
    //主站的首页
    $filename = ROOT_PATH.'/news/index.html';
}
//var_dump(ROOT_PATH);
//var_dump($filename);
if (file_exists($filename)) {
	
	$contents = file_get_contents($filename);
	echo_exit($contents);
} else {
	echo_exit(ROOT_PATH.'/index_temp.html');
}
?>

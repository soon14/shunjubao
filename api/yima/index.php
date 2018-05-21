<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
/**
 * 响应形如如下请求
 * /etao/FullIndex.xml -> /etao/index.php?type=FullIndex
 * /etao/IncrementIndex.xml -> /etao/index.php?type=IncrementIndex
 * /etao/SellerCats.xml -> /etao/index.php?type=SellerCats
 * /etao/item/1234.xml -> /etao/index.php?type=item&id=1234
 */

$info = $_GET;
die(DataAgentFront::genXml(DataAgentFront::CORP_YIMA, $info));
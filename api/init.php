<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

$objZYAPI = new ZYAPI();

$params = Request::getRequestParams();

//验证是否通过
$appId = $params['appId'];

if (!in_array($appId, ZYAPI::getAllAppIds())) {
	
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_PARAMS);
}
$res = $objZYAPI->verifyToken($params);
if (!$res) {
	$objZYAPI->outPutF(ApiItems::ERROR_CODE_TOKEN);
}

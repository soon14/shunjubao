<?php
/**
 * partner目录下的php入口文件都应包含本文件
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function.inc.php';

# 验证请求是否合法
# 所有从合作方(app)过来的请求，都需要做这个校验。所以，把sign的校验从 PayParams.class.php 中驳离出来会好些。
# by gxg
$params = getRequestParams();
$requet_method = $_SERVER['REQUEST_METHOD'];

if (!isset($params['sign'])) {
	failExit('请指定sign值');
}

if (!isset($params['partner'])) {
	failExit('请指定合作方id');
}

$partner = $params['partner'];
try {
	$objPartnerConfig = new PartnerConfig($partner);
} catch (Exception $e) {
	failExit($e->getMessage());
}

$objYokaServiceUtility = new YokaServiceUtility();
$objYokaServiceUtility->secret = $objPartnerConfig->getSecuritCode();
if (!$objYokaServiceUtility->checkSign($params['sign'], $params)) {
    # 签名验证失败
//     failExit('签名验证失败');
}
# 校验完就可以删除了
$var_name = "_{$requet_method}";
unset(${$var_name}['sign']);

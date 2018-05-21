<?php
/**
 * 外站统一入口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$allSiteFrom = array(
	'enjoyz'=>'dbqeb',
);

$key = UserMember::OTHER_SITES_FROM_COOKIE_KEY;
$from = Request::g($key);

$sourceId = ConvertData::decryptStr2Id($from);

if (UserMember::verifySiteFrom($from)) {
	//记录下来源
	TMCookie::set($key, $from);
}
redirect(ROOT_DOMAIN);
exit;

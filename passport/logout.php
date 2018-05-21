<?php
/**
 * passport之：退出登录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$from = Request::getReferer();
$from = $from ? $from : ROOT_DOMAIN;

$objTMPassport = new TMPassport();
$objTMPassport->logout();

redirect($from);
exit;
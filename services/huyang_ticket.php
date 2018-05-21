<?php
/**
 * 华阳出票接口之彩票落地通知
 * 1、找出对应系统票并更改状态
 * 2、当所有系统票均出票成功时，更改用户票状态
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

$params = Request::getRequestParams();

$objHY = new HuaYangTicketClient();
$objHY->setResponseParams($params);



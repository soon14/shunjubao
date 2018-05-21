<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

//getTheoreticalBonus($sport, $combination, $multiple, $money, $select, $userTicket = array())
$max_money = getTheoreticalBonus("fb", "had|98837|h#2.23,had|98838|h#2.18,had|98839|h#1.66,hhad|98840|h#2.50|-1.00", 5, "10.00","4x1","1360177");
var_dump($max_money["detail"][4]["max_money"]);
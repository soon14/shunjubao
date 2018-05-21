<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

/**
 * $_GET中各查询定义:
 * partner_name: 合作渠道名称,
 * partner_key: 合作渠道指派的key,不需要传递,双方约定
 * v: 0.1,
 * 
 * timestamp: unix时间戳,
 * type: fetch_all,(可能会有fetch_one),
 */
$config = partnerConfigInfo();
$info = $_GET;

$sign = $info['sign'];
unset($info['sign']);

ksort($info);
foreach($info as $key => $value) {
    $plain[] = $key . $value;
}

$adsense_from = $info['partner_name'];
$timestamp = $info['timestamp'];
if(abs(time() - $timestamp) >= 120) {//如果时间戳误差大于2分钟,则不能通过
//    die('timeout');
}

$partner_info = $config[$adsense_from];

$plain = implode('', $plain) . $partner_info['partner_key'];
if($sign != md5($plain)) {
//    die('sign error');
}

$objUserOrderForStatisFront = new UserOrderForStatisFront();

$orderIds = $objUserOrderForStatisFront->getsOrdersByAdsenseFrom($adsense_from);

var_dump($orderIds);

//getsOrdersByAdsenseFrom

function partnerConfigInfo() {
    return array(
        'duomai' => array(
            'partner_key' => 'D#AvY22G'
        )
    );
}
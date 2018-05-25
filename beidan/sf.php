<?php
/**
 * 北单胜负
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = '聚宝网北京单场胜负过关投注';
$TEMPLATE['keywords'] = '胜负过关,北单胜负过关,北京单场胜负过关,北单最新玩法,足球串篮球,网球竞猜,冰球竞猜,乒乓球竞猜,竞猜足球,足球竞猜,聚宝网,竞猜专家,专家推荐,足彩专家,北单推荐,北单玩法,北单投注,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '聚宝网北京单场胜负过关玩法投注，北单最新玩法，最接近国际博彩公司的投注方法，返奖率创北单新高。';
echo_exit($tpl->r('beidan/sf'));
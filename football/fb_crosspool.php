<?php
/**
 * 竞彩足球列表页之混合过关
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crosspool');
$TEMPLATE['title'] = '聚宝网竞彩足球混合过关投注';
$TEMPLATE['keywords'] = '竞彩,竞彩混合过关,混合过关,竞彩混串,混合串关,足球竞猜,聚宝网,聚宝2串1,竞彩2串1,竞猜专家,专家推荐,足彩专家,王忠仓,大力水手';
$TEMPLATE['description'] = '聚宝网提供竞彩足球胜平负/让球胜平负,总进球,半全场的混合投注,比分玩法相融合的混合投注，人气最高，中奖率最高。。';
echo_exit($tpl->r('confirm/fb_crosspool'));

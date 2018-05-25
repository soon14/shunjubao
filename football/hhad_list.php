<?php
/**
 * 竞彩足球列表页之胜平负和让球胜平负
 */

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'hhad');
$TEMPLATE['title'] = '聚宝网竞彩足球胜平负/让球胜平负投注';
$TEMPLATE['keywords'] = '竞彩,竞彩足球,胜平负,竞彩足球胜平负,竞猜足球,足球竞猜,聚宝网,聚宝2串1,竞彩2串1,竞猜专家,专家推荐,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '聚宝网提供竞彩足球胜平负/让球胜平负玩法投注,竞彩最受欢迎玩法,智慧彩民的首选。';
echo_exit($tpl->r('confirm/hhad_list'));
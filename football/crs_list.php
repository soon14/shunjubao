<?php
/**
 * 竞彩足球列表页之胜平负和比分
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crs');
$TEMPLATE['title'] = '聚宝网竞彩足球比分投注';
$TEMPLATE['keywords'] = '比分,竞猜比分,比分玩法,波胆,竞猜足球,足球竞猜,聚宝网,聚宝2串1,竞彩2串1,竞猜专家,专家推荐,足彩专家,王忠仓,大力水手';
$TEMPLATE['description'] = '聚宝网提供竞彩足球比分玩法投注，最专业的彩民赢取最高额回报，波胆命中变身人生赢家。。';
echo_exit($tpl->r('confirm/crs_list'));
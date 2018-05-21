<?php
/**
 * 竞彩篮球列表页之胜分差
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'wnm');
$TEMPLATE['title'] = '智赢网竞彩篮球胜分差投注';
$TEMPLATE['keywords'] = '胜分差,竞彩蓝球胜分差,竞彩篮球,NBA竞猜,竞猜NBA,国际篮球,国际篮球联赛,欧洲篮球联赛,美职篮,篮球彩票,篮彩专家,篮彩投注,投注篮球';
$TEMPLATE['description'] = '智赢网竞彩蓝球胜分差玩法投注,玩转胜分差,玩赚篮彩,竞猜NBA的首选。';
echo_exit($tpl->r('confirm/wnm_list'));
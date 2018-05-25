<?php
/**
 * 竞彩篮球列表页之胜负和让分胜负
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'hdc');
$TEMPLATE['title'] = '聚宝网竞彩篮球胜负/让分胜负投注';
$TEMPLATE['keywords'] = '竞彩,篮彩胜负,让分胜负,竞彩篮球,NBA竞猜,竞猜NBA,国际篮球,国际篮球联赛,欧洲篮球联赛,美职篮,篮球彩票,篮彩专家,篮彩投注,投注篮球';
$TEMPLATE['description'] = '聚宝网竞彩蓝球胜负/让分胜负玩法投注,篮彩中最稳妥的玩法。';
echo_exit($tpl->r('confirm/hdc_list'));
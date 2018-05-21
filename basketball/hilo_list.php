<?php
/**
 * 竞彩篮球列表页之大小分
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'hilo');
$TEMPLATE['title'] = '智赢网竞彩篮球大小分投注';
$TEMPLATE['keywords'] = '大小分,竞彩蓝球大小分,竞彩篮球,NBA竞猜,竞猜NBA,国际篮球,国际篮球联赛,欧洲篮球联赛,美职篮,篮球彩票,篮彩专家,篮彩投注,投注篮球';
$TEMPLATE['description'] = '智赢网提供竞彩蓝球大小分玩法投注,竞猜大小,玩赚篮球,玩转NBA。';
echo_exit($tpl->r('confirm/hilo_list'));
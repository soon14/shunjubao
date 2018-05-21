<?php
/**
 * 竞彩篮球列表页之混合过关
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'crosspool');
$TEMPLATE['title'] = '智赢网竞彩篮球混合过关投注';
$TEMPLATE['keywords'] = '篮彩混合过关,篮彩混合串关,竞彩混合过关,竞彩篮球,NBA竞猜,竞猜NBA,国际篮球,国际篮球联赛,欧洲篮球联赛,美职篮,篮球彩票,篮彩专家,篮彩投注,投注篮球';
$TEMPLATE['description'] = '智赢网竞彩蓝球胜负/让分胜负、胜分差、大小分玩法相融合的混合过关投注,打造最受欢迎的篮彩竞猜。';
echo_exit($tpl->r('confirm/bk_crosspool'));
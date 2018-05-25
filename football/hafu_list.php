<?php
/**
 * 竞彩足球列表页之半全场
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'hafu');
$TEMPLATE['title'] = '聚宝网竞彩足球半全场投注';
$TEMPLATE['keywords'] = '半全场,竞彩半全场,半全场玩法,竞猜足球,足球竞猜,聚宝网,聚宝2串1,竞彩2串1,竞猜专家,专家推荐,赢球团';
$TEMPLATE['description'] = '聚宝网提供竞彩足球半全场玩法投注，猜半场，猜全场，赢取高额奖金。';
echo_exit($tpl->r('confirm/hafu_list'));

<?php
/**
 * 竞彩足球列表页之总进球
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = getChineseByPoolCode('pool', 'ttg');
$TEMPLATE['title'] = '智赢网竞彩足球总进球投注';
$TEMPLATE['keywords'] = '竞彩,总进球,进球数玩法,大小球,竞彩进球数,足球竞猜,智赢网,智赢2串1,竞彩2串1,竞猜专家,专家推荐,足彩专家,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '智赢网提供竞彩足球总进球数玩法投注，玩转进球数，大小球。';
echo_exit($tpl->r('confirm/ttg_list'));

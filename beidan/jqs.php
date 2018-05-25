<?php
/**
 * 北单进球数
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = '聚宝网北京单场进球数投注';
$TEMPLATE['keywords'] = '总进球,北单总进球,北京单场总进球,竞猜足球,足球竞猜,聚宝网,竞猜专家,专家推荐,足彩专家,北单推荐,北单玩法,北单投注,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '聚宝网北京单场总进球玩法投注,大小球变种,玩转比赛进球数。';
echo_exit($tpl->r('beidan/jqs'));
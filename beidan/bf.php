<?php
/**
 * 北单比分
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = '智赢网北京单场比分投注';
$TEMPLATE['keywords'] = '比分,波胆,北单比分,北京单场比分,竞猜足球,足球竞猜,智赢网,竞猜专家,专家推荐,足彩专家,北单推荐,北单玩法,北单投注,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '智赢网北京单场比分玩法投注,高回报玩法,技术彩民的最爱。';
echo_exit($tpl->r('beidan/bf'));
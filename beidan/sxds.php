<?php
/**
 * 北单上下单双
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = '智赢网北京单场上下单双投注';
$TEMPLATE['keywords'] = '上下单双,北单上下单双,竞猜足球,足球竞猜,智赢网,竞猜专家,专家推荐,足彩专家,北单推荐,北单玩法,北单投注,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '智赢网北京单场上下单双玩法投注,接近外围博彩的竞猜。';
echo_exit($tpl->r('beidan/sxds'));

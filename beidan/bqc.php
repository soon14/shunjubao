<?php
/**
 * 北单半全场
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$TEMPLATE['title'] = '智赢网北京单场半全场投注';
$TEMPLATE['keywords'] = '半全场,北单半全场,北京单场半全场,竞猜足球,足球竞猜,智赢网,竞猜专家,专家推荐,足彩专家,北单推荐,北单玩法,北单投注,王忠仓,大力水手,赢球团';
$TEMPLATE['description'] = '智赢网北京单场半全场玩法投注,猜半全,到智赢。';
echo_exit($tpl->r('beidan/bqc'));

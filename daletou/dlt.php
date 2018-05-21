<?php
/**
 * 大乐透投注页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$tpl = new Template();
$TEMPLATE['title'] = '大乐透- ';
//种下cookie方便联合登录时的跳转
$tpl->assign('connect_urls', $connect_urls);
$YOKA ['output'] = $tpl->r ( 'daletou_index' );
echo_exit ( $YOKA ['output'] );
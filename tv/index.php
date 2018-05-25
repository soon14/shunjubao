<?php
/**
 * 聚宝网TV直播间
 */
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
#标题
$TEMPLATE ['title'] = "在线足球赛事直播-聚宝网聚宝彩票";
$TEMPLATE['keywords'] = '足球视频,聚宝直播间,足球直播,在线足球直播,足球赛事视频,。';
$TEMPLATE['description'] = '在线足球赛事直播聚宝网聚宝彩票。';

echo_exit($tpl->r('tv'));
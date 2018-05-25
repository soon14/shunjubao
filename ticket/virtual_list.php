<?php
/**
 * 虚拟比赛列表页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$TEMPLATE['title'] = '积分投注-竞猜中超';
$TEMPLATE['content'] = '中超联赛,中国足球,2015中超,2015中国足球联赛，聚宝网';
$TEMPLATE['description'] = '中超联赛中国足球，聚宝积分投注竞猜换大奖！';

$currentDate = getCurrentDate();
$condition = array();
$condition['start_time'] = SqlHelper::addCompareOperator('>=', $currentDate);
$objBettingVirtual = new BettingVirtual();
$vb_ids = $objBettingVirtual->findIdsBy($condition);

$vb_lists = $objBettingVirtual->gets($vb_ids);

$tpl = new Template();

$sportDesc = BettingVirtual::getSportDesc();
$tpl->assign('sportDesc', $sportDesc);
$tpl->assign('vb_lists', $vb_lists);
echo_exit($tpl->r('virtual_list'));
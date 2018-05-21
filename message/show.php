<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objUserMessageFront = new UserMessageFront();
$messages = array();

$order = 'create_time desc';
$condition = array();
$condition['status'] = UserMessage::STATUS_SHENHE;
$messages = $objUserMessageFront->getsByCondition($condition, 100, $order);
$show_messages = array();//按uid分组的
foreach ($messages as $key=>$value) {
	$uid = $value['u_id'];
	//获取上一个留言和下一个留言
	$previd = $nextid = 0;
	$condition['u_id'] = $uid;
	$m = $objUserMessageFront->getsByCondition($condition, null, $order);
	
	foreach ($m as $k=>$v) {
		if ($v['id']>$value['id'] && !$previd) {
			$previd = $v['id'];
			break;
		}
	}
	foreach ($m as $k=>$v) {
		if ($v['id']<$value['id'] && !$nextid) {
			$nextid = $v['id'];
			break;
		}
	}
	if (!array_key_exists($uid, $show_messages)) {
		$show_messages[$uid] = $value;
	}
	
	$value['previd'] = $previd;
	$value['nextid'] = $nextid;
	$show_messages[$uid]['user_messages'][$value['id']] = $value;
}
// pr($show_messages);
$img_num = 0;

$u_id = Runtime::getUid();

if ($u_id) {
	$start_time = date('Y-m-d').' 00:00:00';
	$end_time = date('Y-m-d H:i:s');
	$user_messages = $objUserMessageFront->getsByCondtionWithField($start_time, $end_time, 'create_time', array('u_id'=>$u_id));
	$img_num = count($user_messages);
}

$tpl = new Template();
$TEMPLATE['title'] = "智赢网-智赢彩票留言墙-智赢网|智赢网竞彩|智赢网北单,彩票赢家首选人气最旺的网站！";
$TEMPLATE['keywords'] = '智赢网,智赢彩票,智赢留言墙。';
$TEMPLATE['description'] = '智赢网,智赢彩票,智赢留言墙您的意见与建议对我们很重要。';
$tpl->assign('messages', $show_messages);
$tpl->assign('img_num', $img_num);
$tpl->d('user_message');
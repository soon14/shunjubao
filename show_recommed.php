<?php
/**
 * 付费系统查看推荐页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if ($_REQUEST['email']) {
	
	#验证邮箱
	$email = Request::r('email');
	if (!Verify::email($email)) {
		fail_exit('邮箱不合法');
	}
	
	#验证密码
	$pwd = Request::r('pwd');
	$objSubscribeSecret = new SubscribeSecret();
	$result = $objSubscribeSecret->verifyEmailAndPwd($email, $pwd);
	if (!$result->isSuccess()) {
		fail_exit($result->getData());
	}
	
	$objSubscribeEmailFront = new SubscribeEmailFront();
	$ids = $objSubscribeEmailFront->findIdsByEmail($email);
	if (!$ids) {
		fail_exit('您没有订阅推荐');
	}
	$results = $objSubscribeEmailFront->gets($ids);
	
	#判断是否在订阅期
	$time = time();
	$flag = false;//可否查看的标记
	$batch = false;
	foreach ($results as $value) {
		$start_time = strtotime($value['start_time']);
		$end_time = strtotime($value['end_time']) + 20 * 3600;
		if ($time >= $start_time && $time <= $end_time) {
			$flag = true;
			$batch = $value['batch'];
			break;
		}
	}
	
	#可以查看这个批次
	if ($flag) {
		$objCms = new Cms();
		$condition = array();
		$condition['batch'] = $batch;
		$cms = $objCms->getsByCondition($condition, null, 'create_time desc');
		
		#当前订阅的批次还没有上传
		if (!$cms) {
			fail_exit('您的订阅还没有上传');
		}
	} else {
		fail_exit('您的订阅已过期');
	}
	
	$tpl = new Template();
	$tpl->assign('infos', $cms);
	$YOKA ['output'] = $tpl->r ( 'fufeituijian' );
	echo_exit ( $YOKA ['output'] );
}
 echo '<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录 - 【聚宝网】彩票赢家首选_中国竞彩网_足彩_篮彩_单场_福彩_体彩_人气最旺的彩票网站</title>
<meta name="keywords" content="竞彩,中国竞彩网,足彩,中国足彩网,篮彩,单场,福彩,体彩,足球彩票,篮球彩票" />
<meta name="description" content="聚宝网是彩票赢家的聚集地，口碑最好的彩票做单网站，竞彩、单场彩票、篮球彩票、足球彩票人气超旺，可以通过网站和手机客户端使用。提供福利彩票和体育彩票的开奖、走势图表、缩水过滤、奖金评测、比分直播等资讯服务。" />
</head>';
 echo '<form method="post">';
 echo '请输入订阅邮箱:';
 echo '<input type="text" value="" name="email"/>';
 echo '</br>';
 echo '请&nbsp;输&nbsp;入&nbsp;&nbsp;密&nbsp;&nbsp;码:';
 echo '<input type="password" value="" name="pwd"/>';
 echo '</br>';
 echo '<a href="'.ROOT_DOMAIN.'/subscribe_secret.php" target="_blank" title="点此设定密码">我还没有密码</a>';
 echo '</br>';
 echo '<input type="submit" value="提交"/>';
 echo '</form>';
 exit;
?>
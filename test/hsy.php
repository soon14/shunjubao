<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

//删除fb_poolresult表多余的数据
$obj = new PoolResult('fb');

for ($m_id=81435;$m_id>=80400;$m_id--) {
	
	$cond = array(
			'm_id'		=> $m_id,
			'p_code'	=> 'HHAD',
	);
	
	$res = $obj->getsByCondition($cond, 1 ,'id asc');
	
	if (!$res) {
		continue;
	}
	
	$poolResult = array_pop($res);
	
	$con_d = array(
			'id'			=> SqlHelper::addCompareOperator('!=', $poolResult['id']),
			'm_id'			=> $poolResult['m_id'],
			'p_code'		=> 'HHAD',
			'combination'	=> $poolResult['combination'],
	);
	
	$obj->delete($con_d);
}

pr('完成');
exit;
$CACHE['db'] = array(
		'default'   => "mysqli://root:1q2w3e4R!@{$host}:3306/zhiying",
		'leida'   	=> "mysqli://root:1q2w3e4R!@{$host}:3306/leida",
		'log_data'	=>	"mysqli://root:1q2w3e4R!@{$host}:3306/log_data",
);
$dsn = $CACHE['db']['default'];
$offset = 0;
$step = 100;
$i = 0;
$objBetting = new Betting('bk');
$objMySQLite = new MySQLite($dsn);
do {
	$limit = "{$offset},{$step}";

	$sql = "select * from bk_betting where `b_date`<'2016-05-03' order by id desc limit {$limit}";
// 	$sql = "select * from fb_betting where id=64732";
	$res = $objMySQLite->fetchAll($sql);
	
	if (!$res) {
		echo 'done:'.$i;
		break;
	}
	foreach ($res as $key=>$value) {
		$value['l_cn'] = ConvertData::gb2312ToUtf8($value['l_cn']);
		$value['h_cn'] = ConvertData::gb2312ToUtf8($value['h_cn']);
		$value['a_cn'] = ConvertData::gb2312ToUtf8($value['a_cn']);
		insertBetting($value);
	$i++;
	}
	
	$offset += $step;
}while (true);

function insertBetting($info) {
	$matchId = $info['id'];
	if (!Verify::int($matchId)) {
		return false;
	}
	$objBetting = new Betting(strtolower($info['s_code']));
	$old_info = $objBetting->get($matchId);
	if (!$old_info) {
		$objBetting->add($info);
	} else {
		$objBetting->modify($info);
	}
	return true;
}
exit;

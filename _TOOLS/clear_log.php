<?php 
/**
 * 清除日志
 * 自动删除3个月前的日志
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objZYLog = new ZYLog();
//90天前的时间点
$datetime = date('Y-m-d', time() - 30 * 86400) . ' 00:00:00';

$condition = array(
	'create_time' => SqlHelper::addCompareOperator('<=', $datetime),
);

$res = $objZYLog->delete($condition);
var_dump($res);
?>

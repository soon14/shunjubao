<?php
/**
 * 该文件的目标是用于支持跨域的js操作
 * 要求的调用参数：$_GET = array(
 * 	'cb'	=> //回调函数
 * 	'v'		=> //需要传递的数据
 * 	'uuid'	=> //全局唯一id，保证每一个跨域操作，都会被正确的传回调用者
 * );
 * @author gaoxiaogang@gmail.com
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$callback = Request::g('cb');
$v = Request::g('v', Filter::TRIM);
$uuid = Request::g('uuid');
if($callback) {
	if($v) $v = urldecode($v);
	echo "<script language='javascript'>parent.{$callback}('{$v}', '{$uuid}');</script>";
	exit;
}
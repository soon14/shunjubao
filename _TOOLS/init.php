<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

#只能在后台访问
if (!Runtime::isCLI()) {
	echo_exit('access denied');
}

/**
 *
 * 通过判断运行时环境，确定是输出 \r\n　还是 br
 * @param int $times 次数
 *
 */
function enter_newline($times = 1) {
	if (Runtime::isCLI()) {
		echo str_repeat("\r\n", $times);
	} else {
		echo str_repeat("<br />", $times);
	}
}

/**
 *
 * 输出消息到标准错误
 * @param string $msg
 * @return false | int 返回写入的字符数，出现错误时则返回 FALSE
 */
function output_stderr($msg, $type = '') {
	return log_result($msg, $type, true);
//	return fwrite(STDERR, $msg);
}

/**
 *
 * 判断脚本是否还能存活
 * @param int $alive_time 存活时间，单位是秒
 * @return Boolean
 */
function isAlive($alive_time) {
	static $time_init = null;
	if (is_null($time_init)) {
		$time_init = time();
	}

	$time_now = time();

    if ($time_now - $time_init >= $alive_time) {//超过脚本的生存时间
        return false;
    }

    return true;
}

/**
 * 命令行下的信息输出
 * @param string $msg
 */
function echo_cli($msg) {
	echo getCurrentDate() . ' ' . $msg . "\r\n";
}
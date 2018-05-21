<?php
# 开启 xhprof 性能监控
//$_REQUEST['xhprof'] = 1;

include dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

# 加载路由规则
$tmp_filename = Route::rewrite();
if (isset($tmp_filename)) {
	if (!file_exists($tmp_filename)) {
		echo_exit("文件 {$tmp_filename} 不存在");
	}
    include $tmp_filename;
}

<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$fp = fopen("auto_update_match.txt", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) {

$objMySQLite = new MySQLite($CACHE['db']['default']);

		$usql = "update `bk_betting` set status='Final'   where status='Selling'  and b_date<'2018-01-01'";
		$objMySQLite->query($usql);

	 // 释放锁定
	 flock($fp, LOCK_UN); 
} else {
   exit();//直接退出
}
fclose($fp);

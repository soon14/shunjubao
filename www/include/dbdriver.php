<?php
/* 作用：数据库连接文件 */ 
function db_r(){	
	$db_r=mysql_connect(DB_SERVER_R.':'.DB_PORT_R,DB_USER_R,DB_PASS_R);
	mysql_select_db(DB_DATABASE_R,$db_r);
	return $db_r;
}
function db_w(){
	$db_w=mysql_connect(DB_SERVER.':'.DB_PORT,DB_USER,DB_PASS);
	mysql_select_db(DB_DATABASE,$db_w); 
 	return $db_w;
}
$db_r=db_r();
$db_w=db_w();
?>
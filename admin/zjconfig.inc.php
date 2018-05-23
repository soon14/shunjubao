<?PHP
session_start();
error_reporting(E_ALL);



//数据库
define("MYSQL_TABLEPRE", 'zj_');	// 数据库表前缀
$GLOBALS["TABLE_NAME_INC"] = "zj_";//数据表前辍
$GLOBALS['MYSQL_HOST'] = "localhost";//主机地址
$GLOBALS['MYSQL_USER'] = "xiaowei";//用户名
$GLOBALS['MYSQL_PASS'] = "1q2w3e4R!";//密码
$GLOBALS['MYSQL_DB'] = "zhiying";//数据库名称
$GLOBALS['MYSQL_LOG'] = "";//日志地址
define('COOKIE_PATH', '/');//cookie路径
define('COOKIE_DOMAIN', '');//cookie作用域

date_default_timezone_set('Asia/Shanghai');//定义时区
include_once("include/mysql.class.php");//数据库操作文件$conn

	
include_once("include/function.inc.php");//公共函数文件
include_once("include/global_fun.php");//公共函数文件


$conn = new db();  # create a connection

$dip = get_ip();
$dtime = date("Y-m-d H:i:s");
$pageSize = 15;



?>

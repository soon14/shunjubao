<?PHP

error_reporting(0);
session_start();
//数据库
define("MYSQL_TABLEPRE", 'q_');	// 数据库表前缀
$GLOBALS["TABLE_NAME_INC"] = "q_";//数据表前辍
$GLOBALS['MYSQL_HOST'] = "localhost";//主机地址
$GLOBALS['MYSQL_USER'] = "root";//用户名
$GLOBALS['MYSQL_PASS'] = "meijun820526";//密码
$GLOBALS['MYSQL_DB'] = "zhiying_quan";//数据库名称
$GLOBALS['MYSQL_LOG'] = "";//日志地址
define('COOKIE_PATH', '/');//cookie路径
define('COOKIE_DOMAIN', '');//cookie作用域
date_default_timezone_set('Asia/Shanghai');//定义时区
include_once("mysql.class.php");//数据库操作文件$conn
include_once("function.inc.php");//公共函数文件
include_once("global_fun.php");//公共函数文件
$conn = new db();  # create a connection
$dip = get_ip();
$dtime = date("Y-m-d H:i:s");
$pageSize = 10;
include_once("file.class.php");//上传文件
$UPTYPE["myfiletype"] = array("jpg", "jpeg", "gif", "rar", "doc", "pdf", "pdg","txt","swf","png","flv","csv","txt","wav");//可以上传的文件类型
$myfile = new zdeFile(); //上传文件操作类


?>

<?PHP
session_start();
//error_reporting(0);	
$lifeTime = 43200; 
setcookie(session_name(), session_id(), time() + $lifeTime, "/"); 
//error_reporting(E_ALL & ~E_NOTICE);
ini_set('default_charset', "utf-8");
date_default_timezone_set('Asia/Shanghai');//定义时区
define('WEBPATH_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR); //整站系统路径
//$webpath = str_replace("\\","/",dirname(__FILE__));	// 网站路径	

//$webpath = 'http://'.$_SERVER['HTTP_HOST'].substr($webpath,strrpos($webpath, '/'),1000)."/";

$UPTYPE["myfiletype"] = array("jpg", "jpeg", "gif", "rar", "doc", "pdf", "pdg","txt","swf","png","flv","csv","txt","wav");//可以上传的文件类型

include_once(WEBPATH_DIR."smarty.class.php");//smarty

include_once(WEBPATH_DIR."include/db.config.inc.php");

include_once(WEBPATH_DIR."include/mysql.class.php");//数据库操作文件$conn
include_once(WEBPATH_DIR."include/function.inc.php");//公共函数文件
include_once(WEBPATH_DIR."include/global_fun.php");//公共函数文件
include_once(WEBPATH_DIR."include/file.class.php");//上传文件

$myfile = new zdeFile(); //上传文件操作类

$tpl = new Smarty;

$tpl->force_compile = true;
//$smarty->debugging = true;//调试
//$smarty->caching = false;//缓存
$tpl->cache_lifetime = 120;

$conn = new db();  # create a connection
$ip = get_ip();//获取IP
$dtime = time();//当时时间
$adminid = $_SESSION["adminid"];
$pageSize = 20;

$shop_title = "智赢圈子后台";


?>

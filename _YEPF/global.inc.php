<?php
/**
 * @name global.inc.php
 * @desc 通用文件包
 * @author caoxd
 * @createtime 2009-02-16 11:13
 * @updatetime
 **/
if(!defined('YOKA')) exit('Illegal Request');

if(PHP_VERSION < '5.0.0')
{
	echo 'PHP VERSION MUST > 5';
	exit;
}

//默认将显示错误关闭
ini_set('display_errors', false);
//默认将读外部文件的自动转义关闭
//set_magic_quotes_runtime(0);

//定义开始时间常量
define("YEPF_BEGIN_TIME",microtime());
//设置默认时区
date_default_timezone_set('PRC');
include YEPF_PATH.'/function.inc.php';
//默认自动转义,可能会对html及其它正则带来影响
if(!get_magic_quotes_gpc() && (!defined('YEPF_FORCE_CLOSE_ADDSLASHES') || YEPF_FORCE_CLOSE_ADDSLASHES !== true))
{
	foreach (array('_REQUEST', '_GET', '_POST', '_FILES', '_COOKIE') as $_v)
	{
		$$_v = yaddslashes($$_v );
	}
}

include YEPF_PATH.'/const.inc.php';
$CACHE = $USERINFO = $YOKA = $TEMPLATE = $CFG = array();

class YEPFCore {
    public static function registerAutoload($class = 'YEPFCore') {
        spl_autoload_register(array($class, 'autoload'));
    }

    public static function unregisterAutoload($class) {
    	spl_autoload_unregister(array($class, 'autoload'));
    }

    public static function autoload($class_name) {
        //YEPF系统类数组
        $classarray = array('Cache', 'CacheInterface', 'Cookie', 'Curl', 'DB', 'Debug', 'HtmlFilter', 'Images', 'Log', 'SmtpMail', 'MailInterface', 'Memcached', 'Mysql', 'Page', 'Rank', 'ServicesJson', 'Template', 'TidyFilter', 'Utilyty', 'ZhuYin', 'Keyword', 'IpLocation', 'Province', 'SysPager', 'LocalCache', 'YinHooMail', 'CommCache', 'ParseEnvConf', 'SphinxClient');
        //YOKA特有类数组
        $yokaclassarray = array('User', 'YokaServiceUtility', 'SearchEngine', 'YokaMail', 'YokaCookie','YokaMobileMessage');
        if(in_array($class_name, $classarray))
        {
            return include YEPF_PATH . DIRECTORY_SEPARATOR . 'CLASS' . DIRECTORY_SEPARATOR .$class_name.'.class.php';
        }elseif(in_array($class_name, $yokaclassarray))
        {
            return include YEPF_PATH . DIRECTORY_SEPARATOR . 'YOKA_CLASS' . DIRECTORY_SEPARATOR .$class_name.'.class.php';
        }elseif(defined('CUSTOM_CLASS_PATH'))
        {
        	$class_path = getCustomConstants('CUSTOM_CLASS_PATH') . DIRECTORY_SEPARATOR . $class_name.'.class.php';
        	if(file_exists($class_path)) {
        		return include $class_path;
        	}
        }
        return false;
    }
}

YEPFCore::registerAutoload();

/*---Debug Begin---*/
if((defined('YEPF_IS_DEBUG') && YEPF_IS_DEBUG === true) || (isset($_REQUEST['debug']) && $_REQUEST['debug'] == YEPF_DEBUG_PASS))
{
	//Debug模式将错误打开
	ini_set('display_errors', true);
	//设置错误级别
	error_reporting(YEPF_ERROR_LEVEL);
	//开启ob函数
	ob_start();
	//Debug开关打开
	Debug::start();
	//注册shutdown函数用来Debug显示
	register_shutdown_function(array('Debug', 'show'));
}
/*---Debug End---*/

if(defined('AUTOLOAD_CONF_PATH'))
{
	$handle = opendir(AUTOLOAD_CONF_PATH);
	while ($file = readdir($handle)) {
		if(substr($file, -11) == '.config.php' && is_file(AUTOLOAD_CONF_PATH . DIRECTORY_SEPARATOR . $file))
		{
			include AUTOLOAD_CONF_PATH . DIRECTORY_SEPARATOR . $file;
		}
	}
	unset($handle, $file);
}
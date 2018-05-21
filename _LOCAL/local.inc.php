<?php
/**
 * @name local.inc.php
 * @desc 配置文件
 * @author caoxd
 * @createtime 2009-02-16 11:25
 * @updatetime
 * @caution 路径和URL请不要加反斜线
 **/
/*---------------------------框架级别常量开始---------------------------------*/

//此项目绝对地址
define('ROOT_PATH', dirname(dirname(__FILE__)));

//框架根目录
define('YEPF_PATH', ROOT_PATH . DIRECTORY_SEPARATOR .'_YEPF');
define('YIC_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'YIC');

//是否被正确包含
define('YOKA', true);
//强制关闭转义开关,特殊情况下请设置为true,建议为false
define('YEPF_FORCE_CLOSE_ADDSLASHES', false);
/*--------可以被更小产品级覆盖常量开始,覆盖下面的常量请放在init.php程序中的第一行-------*/
//是否默认打开调试模式
if(!defined('YEPF_IS_DEBUG'))
{
	define('YEPF_IS_DEBUG', false);
}
//自定义错误级别,只有在调试模式下生效
if(!defined('YEPF_ERROR_LEVEL'))
{
	define('YEPF_ERROR_LEVEL', E_ALL);
}
/*--------可以被更小产品级覆盖常量结束-------*/
/*---------------------------框架级别常量结束---------------------------------*/

/*---------------------------项目级别常量开始---------------------------------*/

$tmp_http_host = empty($_SERVER['HTTP_HOST']) ? '127.0.0.1' : $_SERVER['HTTP_HOST'];

/**
 * 新闻系统地址
 */
define('ROOT_WEBSITE', "http://www.zhiying365365.com");
/**
 * 新闻系统地址
 */
define('ROOT_BBS_SITE', "http://bbs.zhiying365365.com");
/**
 * 新闻系统地址
 */
define('ROOT_CMS_SITE', "http://news.zhiying365365.com");

//此项目的根目录URL
define('ROOT_DOMAIN',"http://{$tmp_http_host}");

###################################################
## 定义一些业务相关的域名常量，以便可以在各业务处调用 ######
###################################################
# www 域下的，比如可以在所有项目的公共头调用。
define('WWW_ROOT_DOMAIN', ROOT_DOMAIN);

# passport中心的域名
define('PASSPORT_ROOT_DOMAIN', ROOT_DOMAIN);

# 购买流程的域名
define('PURCHASE_ROOT_DOMAIN', ROOT_DOMAIN);

# tuan频道的域名
define('TUAN_ROOT_DOMAIN', ROOT_DOMAIN);

# onlylady频道的域名
define('ONLYLADY_ROOT_DOMAIN', 'http://onlylady.gaojie.com');
###################################################
## 结束业务域名常量的定义 ######
###################################################

$tmpArrHost = explode('.', $tmp_http_host);
# 根域，目前用于写入passport的cookie域以及签名
define('DOMAIN', $tmpArrHost[count($tmpArrHost)-2].".".$tmpArrHost[count($tmpArrHost)-1]);

/*--------下面的常量定义都可以被更小项目中前缀为SUB_的同名常量所覆盖-------*/
//此项目日记文件地址
define('LOG_PATH',ROOT_PATH . '/_LOG');

# 测试站点域名正则
define('TEST_DOMAIN_MATCH', '#http://test.www.gaojie.com#i');

//wap版域名正则
define('WAP_DOMAIN_MATCH', '/^http:\/\/([a-zA-Z0-9]*\.){0,1}(wap|m)\.(zhiying|zhiying365365|hsy)\.com$/i');

//微信版域名正则
define('MP_DOMAIN_MATCH', '/^http:\/\/([a-zA-Z0-9]*\.){0,1}(mp)\.(zhiying|zhiying365365|hsy)\.com$/i');

//安桌域名正则
define('APP_DOMAIN_MATCH', '/^http:\/\/([a-zA-Z0-9]*\.){0,1}(app)\.(zhiying|zhiying365365|hsy)\.com$/i');

//ios域名正则
define('IOS_DOMAIN_MATCH', '/^http:\/\/([a-zA-Z0-9]*\.){0,1}(ios)\.(zhiying|zhiying365365|hsy)\.com$/i');

//模板文件目录
if(preg_match(WAP_DOMAIN_MATCH, ROOT_DOMAIN)) {
	define('TEMPLATE_PATH',ROOT_PATH . '/_TEMPLATE/wap');
	//模板文件编绎目录
	define('COMPILER_PATH',ROOT_PATH . '/_TEMPLATE_C/wap');
} elseif(preg_match(APP_DOMAIN_MATCH, ROOT_DOMAIN)) {
	define('TEMPLATE_PATH',ROOT_PATH . '/_TEMPLATE/app');
	//模板文件编绎目录
	define('COMPILER_PATH',ROOT_PATH . '/_TEMPLATE_C/app');
} elseif(preg_match(IOS_DOMAIN_MATCH, ROOT_DOMAIN)) {
	define('TEMPLATE_PATH',ROOT_PATH . '/_TEMPLATE/ios');
	//模板文件编绎目录
	define('COMPILER_PATH',ROOT_PATH . '/_TEMPLATE_C/ios');
} elseif(preg_match(MP_DOMAIN_MATCH, ROOT_DOMAIN)) {
	define('TEMPLATE_PATH',ROOT_PATH . '/_TEMPLATE/wap');
	define('COMPILER_PATH',ROOT_PATH . '/_TEMPLATE_C/wap');
}else {
	define('TEMPLATE_PATH',ROOT_PATH . '/_TEMPLATE/default');
	define('COMPILER_PATH',ROOT_PATH . '/_TEMPLATE_C/default');
}


//默认的模板文件后缀名
define('TEMPLATE_TYPE','html');
//配置文件目录
define('AUTOLOAD_CONF_PATH', ROOT_PATH . '/_AUTOLOAD');
//自定义类自动加载路径
define('CUSTOM_CLASS_PATH', ROOT_PATH . '/_CUSTOM_CLASS');

define('STATICS_BASE_URL', ROOT_DOMAIN . '/www/statics');

# 定义图片上传的url与path
define('IMG_UPLOAD_URL', ROOT_DOMAIN . '/upload');
define('IMG_UPLOAD_PATH', ROOT_PATH . '/upload');

#头像上传的url与path
define('USER_HEAD_IMG_URL', IMG_UPLOAD_URL . '/user_head_img');
define('USER_HEAD_IMG_PATH', IMG_UPLOAD_PATH . '/user_head_img');

/*--------常量覆盖结束-------*/
/*---------------------------项目级别常量开始---------------------------------*/

# 邮箱服务器与帐号定义
define("SMTP_HOSTNAME", "mail.zhiying365365.com");
define("SMTP_SERVER", "42.120.219.42");
define("SMTP_PORT", 25);
define("SMTP_USERNAME", "noreply");
define("SMTP_FROM", "noreply@zhiying365365.com");
define("SMTP_FROMNAME", "智赢网");
define("SMTP_PASSWORD", "YXqUG0vF8LxQ6");
define("SMTP_CHARSET", "UTF-8");
define("SMTP_TIMEOUT", 20);

# 支付中心密钥
define('SECRET_KEY', 'V42zqxrZP3Wdc');

# passport签名key
define('PASSPORT_SIGN_KEY', 'rG3WQSD4hsWwI');

# 短信帐号
define('MOBILE_MSG_APPKEY', '23284540');
define('MOBILE_MSG_APPSECRET', '3ffebcfa1074fecac2105fb61157992a');

# send_msg_for_shell.php 文件会用到这个密码。目的是只让知道指定密码的人使用该功能
define('SEND_MSG_PASSWD_FOR_SHELL', 't8Kg3oMICQrf2');

# 配置sphinx服务参数
$_SERVER['SPHINX_SSPROD_SERVER'] = '192.168.16.130';
$_SERVER['SPHINX_SSPROD_PORT'] = 9312;

# 定义常量，用于标识主数据库有写入操作。值为MASTER_DB_HAS_WRITE md5 16位后的值，避免明文被有心人猜测
# 使用场景，MySQLite类执行写入语句成功时，会给该常量为key写一个cookie。当php页面读到该cookie时，会把查询的sql强制走主库
define('MASTER_DB_HAS_WRITE', '17439a6561e7666b');

define('JS_CSS_MIN_BASE_URL', ROOT_DOMAIN);

# 库房签名key
define('DELIVER_SIGN_KEY', 'V42zqxrZP3Wdc');

# 库房系统的url
define('DELIVER_SYSTEMS_URL', 'http://wms_deliver.gaojie.com');

# 库房系统分配给高街的合作方id
define('PARTNERID', 1);

#session过期时间
define('SESSION_EXPIRE_TIME', 3600);

#投注倍数最大值
define('TOUZHU_MAX_MULTIPLE', 100000);

# 商城接口验证签名key
define('ZYSHOP_APP_SECRET_KEY', 'V85fbf9a5bZP378ca8cafbf9a56b68e0');

#query项目路径
define('QUERY_ITEM_PATH', dirname(ROOT_PATH) . DIRECTORY_SEPARATOR . 'query');
define('QUERY_ITEM_INFOHUB_PATH', QUERY_ITEM_PATH . DIRECTORY_SEPARATOR . 'infohub');
?>

<?php
/**
 * 定义YIC的类文件自动加载机制
 * @author gaoxiaogang@yoka.com
 *
 */

include YEPF_PATH . DIRECTORY_SEPARATOR . 'global.inc.php';

include YIC_PATH . DIRECTORY_SEPARATOR . 'function.inc.php';

# 加载 html dom 分析库
include YIC_PATH . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

$GLOBALS['XHPROF_LIB_ROOT'] = YIC_PATH . DIRECTORY_SEPARATOR . 'CLASS' . DIRECTORY_SEPARATOR . 'xhprof_lib';

#############################################
if (get_magic_quotes_runtime()) {//表示系统自动将数据库读入或文件读入的数据添加转义
    set_magic_quotes_runtime(0);//不需要做这步，由应用来管理
}
/**
 * 外部输入的数据，不需要转义。由应用自行处理即可！
 * @author gaoxiaogang@gmail.com
 */
if (!function_exists('ystripslashes')) {
    function ystripslashes($string) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = ystripslashes($val);
            }
        } else {
            $string = stripslashes($string);
        }
        return $string;
    }
}
if (get_magic_quotes_gpc()//系统开启了进站数据转义
    || !defined('YEPF_FORCE_CLOSE_ADDSLASHES')//没定义这个系统也会转义
    || YEPF_FORCE_CLOSE_ADDSLASHES == false//指定不关闭转义
) {//符合以上任意一条，都说明被YEPF添加了转义，所以去掉
    foreach (array('_REQUEST', '_GET', '_POST', '_FILES', '_COOKIE') as $_v) {
        $$_v = ystripslashes($$_v);
    }
}
#############################################

class YICCore {
	/**
	 * YIC自动加载类
	 * 优先级：项目级的类优先级最高。项目级的类优先级大于YIC的类、YIC类的优先级大于YEPF的类
	 * @param string $class_name
	 * @return Boolean true：加载成功；false：加载失败
	 */
    static public function autoload($class_name) {
        # 安全性处理
        $class_name = str_replace('/', '', $class_name);
        $class_name = str_replace('\\', '', $class_name);

        # 1、加载项目级的类
        if (defined('CUSTOM_CLASS_PATH')) {
	        if (preg_match('#[a-zA-Z_]+Front$#', $class_name)) {//前端类
	            $class_path = getCustomConstants('CUSTOM_CLASS_PATH') . DIRECTORY_SEPARATOR . '_FRONT_CLASS' . DIRECTORY_SEPARATOR . $class_name . '.class.php';
	        } else {//base 类
	            $class_path = getCustomConstants('CUSTOM_CLASS_PATH') . DIRECTORY_SEPARATOR . '_BASE_CLASS' . DIRECTORY_SEPARATOR . $class_name . '.class.php';
	        }
	        if (file_exists($class_path)) {
	            return include($class_path);
	        }

            $class_path = getCustomConstants('CUSTOM_CLASS_PATH') . DIRECTORY_SEPARATOR . $class_name.'.class.php';
            if (file_exists($class_path)) {
                return include $class_path;
            }
        }

        # 2、加载 YIC 提供的公共类
        if (preg_match('#[a-zA-Z_]+Front$#', $class_name)) {//前端类
            $class_path = YIC_PATH . DIRECTORY_SEPARATOR . 'CLASS' . DIRECTORY_SEPARATOR . '_FRONT_CLASS' . DIRECTORY_SEPARATOR . $class_name . '.class.php';
        } else {//base 类
            $class_path = YIC_PATH . DIRECTORY_SEPARATOR . 'CLASS' . DIRECTORY_SEPARATOR . '_BASE_CLASS' . DIRECTORY_SEPARATOR . $class_name . '.class.php';
        }
        if (file_exists($class_path)) {
            return include($class_path);
        }
        $class_path = YIC_PATH . DIRECTORY_SEPARATOR . 'CLASS' . DIRECTORY_SEPARATOR . $class_name . '.class.php';
        if (file_exists($class_path)) {
            return include($class_path);
        }

        # 3、加载 YEPF 框架提供的公共类
        if (YEPFCore::autoload($class_name)) {
        	return true;
        }

        return false;
    }
}

YEPFCore::unregisterAutoload('YEPFCore');
YEPFCore::registerAutoload('YICCore');
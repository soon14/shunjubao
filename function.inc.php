<?php

/**
 * 根据现有的参数和密钥计算出sign值
 * @param Array $params 参数集合
 * @return String
 */
function createSign($code, $params = null)
{
	if ($params && is_array($params))
	{
		ksort($params);
		$str = $code;
		foreach ($params as $key => $value)
		{
			if ($key != 'sign')
			{
				$str .= $key.$value;
			}
		}
		return strtoupper(md5($str));
	}
	return '';
}
/**
 * 写日志文件
 * @param str $word 记录的内容
 * @param str $type 记录的类型
 * @param boolean $isError 是否为记录错误的日志(普通或错误的区别仅在于文件名)
 */
function log_result($word, $type = '', $isError = false) {
	
	$org_word = $word;//原生日志内容
	$word = getCurrentDate().';'.$word;
	
	if (!$type) {
		$type = getCurrentScriptName();
	}
	
	$filename = date("Ymd")."_{$type}.log";
	
	$logfile_path = ROOT_PATH . "/_LOG/";
	if (!$isError)  {
		$logfile_path .= "success_log/";
	} else {
		$logfile_path .= "error_log/";
	}
	
	$filename = $logfile_path.$filename;
	$fp = fopen($filename, "a+");
	
	system('chmod 777 ' . $filename);
	fwrite($fp,$word."\r\n");
	fclose($fp);
	
	//记录日志
	$objZYLog = new ZYLog();
	$info = array();
	$info['status'] = $isError?ZYLog::LOG_STATUS_ERROR:ZYLog::LOG_STATUS_SUCCESS;
	$info['log'] = $org_word;
	$info['type'] = $type;
	$objZYLog->add($info);
}

/**
 * 获取当前脚本文件名
 * @param boolean $suffix 是否带文件后缀，默认不带
 * @return string 空|文件名
 */
function getCurrentScriptName($suffix = false) {
	$filPath = $_SERVER['PHP_SELF'];
	$filename = end(explode('/',$filPath));
	if (!$suffix) {
		$filename = preg_replace('/\.(.*)?/', '', $filename);
	}

	return $filename;
}

/**
 * 记录错误日志方法
 */
function log_result_error($word, $type = '') {
	return log_result($word, $type, true);
}

/**
 *
 * js、css文件自动合并压缩，该函数供smarty模板使用
 * @param string $files
 * @return string
 */
function jsCssCombin($files) {
	static $statics_version = null;
	if (is_null($statics_version)) {
		$statics_version = include ROOT_PATH . '/include/statics_version.php';
	}

	$now = time();
	$max_version = 0;
	$file_type = null;

	$tmpFiles = explode(',', $files);
	$arrFiles = array();
	foreach ($tmpFiles as $tmpFile) {
		$tmpFile = trim($tmpFile);

		if (!isset($statics_version[$tmpFile])) {
			$max_version = $now;
		} else {
			$max_version = ($statics_version[$tmpFile] > $max_version) ? $statics_version[$tmpFile] : $max_version;
		}

		$ext = strtolower(pathinfo($tmpFile, PATHINFO_EXTENSION));
		if (is_null($file_type)) {
			$file_type = $ext;
		} else {
			if ($file_type != $ext) {// 非相同的文件类型，不允许合并
				return "Ext Not Discord!";
			}
		}

		$arrFiles[] = $tmpFile;
	}

	if (!defined('JS_CSS_MIN_BASE_URL')) {
		define('JS_CSS_MIN_BASE_URL', 'http://wwwcdn.gaojie100.com');
	}

	$type_path = '';
	switch ($file_type) {
		case 'js':
			$type_path = 'j';
			break;
		case 'css':
			$type_path = 'c';
			break;
		default:
			# TODO
	}

	$min_url = JS_CSS_MIN_BASE_URL . "/ver{$max_version}/b=statics/{$type_path}&f=";
	return $min_url . join(',', $arrFiles);
}

/**
 *
 * 通过指定的$file_path，获取对应的静态资源url
 * 该url里含有版本号，用于管理静态资源的更新
 * @param string $file_path 如：jquery-1.5.2.min.js、admin/js.js、header.css
 * @return string
 */
function getStaticsUrl($file_path) {
	static $statics_version = null;
	if (is_null($statics_version)) {
		$statics_version = include ROOT_PATH . '/include/statics_version.php';
	}
	# 如果 $file_path 没有出现在配置文件里，则使用当前时间time()作为版本号
	# 理由：svn的trunk分支，已实现自动管理静态资源的版本号，所以线下的branches下所有分支，可以不再手动维护静态资源的版本号了
	if (!isset($statics_version[$file_path])) {
		$ver = time();
	} else {
		$ver = $statics_version[$file_path];
	}
	$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
	
	
	switch ($ext) {
		case 'js':
			$url = STATICS_BASE_URL . "/j/" . $file_path;
			break;
		case 'css':
			$url = STATICS_BASE_URL . "/c/" . $file_path;
			break;
		case 'htc':
			$url = ROOT_DOMAIN . "/statics/c/" . $file_path;
			break;
		default:
			# TODO
	}

	return $url;
}

	/**
	 *
	 * 操作失败提示函数、用于全环境，所以命名带的 _g，即global
	 * @param string $title 标题
	 * @param string $desc 详细描述
	 * @param array $redirect_navs 跳转导航 格式：array(
	 *     array(
	 *         'href'	=> (string),//必填。url
	 *         'title'	=> (string),//必填。描述
	 *         'target'	=> (string),//非必填。目标，默认是当前页跳转
	 *     ),
	 *     ... ,
	 * );
	 */
function fail_exit_g($title, $desc = null, array $redirect_navs = null) {
		global $TEMPLATE;
		$tpl = new Template();
		if (!isset($TEMPLATE['title'])) {
			$TEMPLATE['title'] = $title;
		}
		$tpl->assign('title', $title);
		$tpl->assign('msg', $desc);
		$tpl->assign('redirect_navs', $redirect_navs);
		$YOKA['output'] = $tpl->r('fail_exit_global');

		echo_exit($YOKA['output']);
}

/**
 *
 * 输出404页面
 */
function output_404() {
	global $TEMPLATE;
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	include ROOT_PATH . DIRECTORY_SEPARATOR . '404.php';
	return null;
}

/**
 * 恶意域名重定向
 */
function badDomainLocation() {
	//ip访问时
	if (isset($_SERVER['HTTP_HOST']) && $_SERVER["HTTP_HOST"] == '202.85.221.248') {
		redirect('http://www.shunjubao.xyz' , 301);
	}
	//其他域名访问时
	$all_domain_preg_match = '/^http:\/\/([hsy|wzc]*\.){0,1}(wap|m|www|pma|cms|news|bbs)\.(zhiying|zhiying365365|hsy|wzc)\.com$/i';
	if(isset($_SERVER['HTTP_HOST']) && !preg_match($all_domain_preg_match, ROOT_DOMAIN)) {
		output_404();
	}
	
}

/**
 *
 * 输出系统维护页面
 */
function output_maintain_page($msg = '') {
	global $TEMPLATE;
	$TEMPLATE['msg'] = $msg?$msg:'';
	$tpl = new Template();
	$TEMPLATE['title'] = "提示信息 - 系统维护中";
	$YOKA['output'] = $tpl->r('maintain');
	echo_exit($YOKA['output']);
	return null;
}

/**
 * 将数组转化为XML文本
 * @param mixed $data
 * @param string $rootNodeName
 * @param SimpleXMLElement $xml
 * @param string $keyName loop Nodename  default goods
 */
function arrayToXml(array $data, $rootNodeName = 'data', $xml=null, $keyName = 'goods') { 	// turn off compatibility mode as simple xml throws a wobbly if you don't.
	if (ini_get('zend.ze1_compatibility_mode') == 1) {
		ini_set ('zend.ze1_compatibility_mode', 0);
	}
	if ($xml == null) {
		$xml = simplexml_load_string('<?xml version="1.0" encoding="utf-8" ?> <' . $rootNodeName . ' />');
	}  	// loop through the data passed in.
	$index = 0;
	foreach($data as $key => $value) {
		$index++; 		 		// no numeric keys in our xml please!
		$attred = false;
		if (is_numeric($key)) {// make string key... $key = 'goods';
			$key = $keyName;
			$attred = true;
		}
		$key = preg_replace('/[^a-z_]/i', '', $key);  		// replace anything not alpha numeric
		if (is_array($value)) 		{				// if there is another array found recrusively call this function
			$node = $xml->addChild($key); 			// recrusive call.
			arrayToXml($value, $rootNodeName, $node);
		} else { 			// add single node.
			$value = htmlentities($value);
			$node = $xml->addChild($key, $value);
		}
		if($attred)	$node->addAttribute('id', $index);
	}	// pass back as string. or simple xml object if you want!
	return $xml->asXML();
}

/**
 * xml转换成数组
 * @param string $xml
 * @throws Exception 'xml转换成数组失败'
 * @author gaoxiaogang@gmail.com
 * @return array
 */
function xmlToArray($xml) {
    if (is_string($xml)) {
    	$tmpResult = simplexml_load_string($xml);
    	if (!is_object($tmpResult)) {
    		return array();
    	}
        $tmpArray = (array) $tmpResult; 
    } elseif (is_object($xml)) {
        $tmpArray = (array) $xml;
    } else {//凡正常调用时，都不可能出现这个异常
        throw new Exception('xml转换成数组失败');
    }
    foreach ($tmpArray as $tmpK => $tmpV) { 
        if (count($tmpV) == 0) {
            $tmpArray[$tmpK] = '';
        } else if (count($tmpV) == 1) {
            if (is_object($tmpV)) {
                $tmpArray[$tmpK] = xmlToArray($tmpV); 
            } else {
                $tmpArray[$tmpK] = (string) $tmpV; 
            }
        } else {
            $tmpArray[$tmpK] = xmlToArray($tmpV); 
        }
    }
    return $tmpArray;
}

/**
 * 把金额转换成大写,形如123.50转换为壹佰贰拾叁元伍角
 * 目前支持千元以内的转换
 * @param $money 带两位小数的浮点数
 * @return string 大写的数字
*/
function moneyToUpper($money){

	if (!$money) return '';

	$return = '';

	$upper = array(1=>'壹',2=>'贰',3=>'叁',4=>'肆',5=>'伍',6=>'陆',7=>'柒',8=>'捌',9=>'玖',0=>'零');
	$unit = array('分','角','元','拾','佰','仟');

	$money = $money*100;
	$money = (string)$money;

	$i = strlen($money);

	do {
		$i--;
		$p = substr($money, $i,1);
		$return = $upper[$p].$unit[strlen($money) - $i - 1].$return;
	}while($i);

	$return = str_replace('零佰零拾零元', '元', $return);
	$return = str_replace('零佰零拾', '零', $return);
	$return = str_replace('零拾零元', '元', $return);
	$return = str_replace('零佰', '零', $return);
	$return = str_replace('零拾', '零', $return);
	$return = str_replace('零元', '元', $return);
	$return = str_replace('零分', '', $return);
	$return = str_replace('零角', '', $return);

	return $return;

}

/**
 * 给导出表的列填充字母
 * 目前只支持26X2个列
 * @param array(列1，列2...)
 * @return array(列1=>A,列2=>B..列27=>AA..)
 */
function autoFillNameLists(array $name_lists) {
	if(!is_array($name_lists)) return $name_lists;
	$return = array();

	$ASCII_A = ord('A');//A的ascII码65
	$ASCII_Z = ord('Z');//Z的ascII码90
	$ASCII = $ASCII_A;//初始ascii码
	$A = '';
	//去掉空数据和重复的数据

	foreach ($name_lists as $k=>$v) {
		if(empty($v)) unset($name_lists[$k]);
	}
	$name_lists = array_unique($name_lists);
//	$num = count($name_lists);
	foreach ($name_lists as $value) {

		if(empty($value)) continue;

		$return[$value] = $A.chr($ASCII);

		$ASCII++;

		if($ASCII > $ASCII_Z) {
			$ASCII = $ASCII_A;
			$A = 'A';
		}

	}
	return $return;
}

/**
 * 获取uid最后一个数字
 * @param int $u_id 
 * @return int 默认为0
 */
function getUidLastNumber($u_id) {
	if (!Verify::int($u_id)) {
		return 0;
	}
	return $u_id%10;
}

/**
 * 获取当前日期-数据库格式
 * 形如：2014-01-01 21:10:10
 */
function getCurrentDate() {
	return date('Y-m-d H:i:s', time());
}

/**
 * 获取请求的参数集。依赖 REQUEST_METHOD 做判断
 * @return array
 */
function getRequestParams() {
	$params = array();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    $params = $_POST;
	    if (!$params) {
	    	$params = $_GET;
	    }
	} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	    $params = $_GET;
	} else {
	    throw new Exception('NOT_SUPPORT_REQUEST_METHOD');
	}
	return $params;
}

/**
 * 调试用的临时函数
 */
function pr($var, $v = false) {
	if ($v) {
		var_dump($var);
		exit;
	}
	print_r($var);
	exit;
}

	/**
	 *
	 * 操作失败
	 * @param string $msg 失败描述
	 * @param array $redirect_navs 跳转导航 格式：array(
	 *     array(
	 *         'href'	=> (string),//必填。url
	 *         'title'	=> (string),//必填。描述
	 *         'target'	=> (string),//非必填。目标，默认是当前页跳转
	 *     ),
	 *     ... ,
	 * );
	 */
function fail_exit($msg = '操作失败', array $redirect_navs = null) {
		$tpl = new Template();
		$TEMPLATE['title'] = "操作失败提示页";
		$tpl->assign('msg', $msg);
		$tpl->assign('redirect_navs', $redirect_navs);
		$YOKA['output'] = $tpl->r('../admin/fail_exit');

		echo_exit($YOKA['output']);
}


	/**
	 *
	 * 操作成功
	 * @param string $msg 成功描述
	 * @param array $redirect_navs 跳转导航 格式：array(
	 *     array(
	 *         'href'	=> (string),//必填。url
	 *         'title'	=> (string),//必填。描述
	 *         'target'	=> (string),//非必填。目标，默认是当前页跳转
	 *     ),
	 *     ... ,
	 * );
	 */
function success_exit($msg = '操作成功', array $redirect_navs = null) {
		$tpl = new Template();
		$TEMPLATE['title'] = "操作成功提示页";
		$tpl->assign('msg', $msg);
		$tpl->assign('referer', Request::getReferer());
		$tpl->assign('redirect_navs', $redirect_navs);
		$YOKA['output'] = $tpl->r('../admin/success_exit');

		echo_exit($YOKA['output']);
}
	
/**
 * 自动跳转的提示页面
 * @param string $tips 提示信息
 * @param string $url 跳转地址
 * @param int $secs 倒计时时间,单位：秒
 */
function redirect_html($tips, $url = ROOT_DOMAIN, $secs = 5) {
	$tpl = new Template();
	$tpl->assign('tips', $tips);
	$tpl->assign('url', $url);
	$tpl->assign('secs', $secs);
	echo_exit($tpl->r('redirect'));
}

/**
 * 华阳各参数转换
 * @param string $sport
 * @param string $pool 玩法
 * @return int $lotteryid  跟华阳相应的玩法id
 */
function getLotteryIdByPoolHY($sport, $pool) {
	$sport = strtolower($sport);
	$array_fb = $array_bk = array();
	//足球
	$array_fb['crosspool'] 		= 208;//竞彩足球_混合投注
	$array_fb['had'] 			= 209;//竞彩足球_胜平负
	$array_fb['hhad'] 			= 210;//竞彩足球_让球胜平负
	$array_fb['crs'] 			= 211;//竞彩足球_比分
	$array_fb['ttg'] 			= 212;//竞彩足球_总进球
	$array_fb['hafu'] 			= 213;//竞彩足球_半全场
	//篮球
	$array_bk['hdc'] 			= 214;//篮彩_让分胜负
	$array_bk['hilo'] 			= 215;//篮彩_大小分
	$array_bk['mnl'] 			= 216;//篮彩_胜负
	$array_bk['wnm'] 			= 217;//篮彩_胜分差
	$array_bk['crosspool'] 		= 218;//篮彩_混合过关
	
	$array = array();
	$array['fb'] = $array_fb;
	$array['bk'] = $array_bk;
	return $array[$sport][$pool];
}

/**
 * 华阳串关方式转换
 * 适用足球竞彩和篮球竞彩
 * @param string $select 2x1
 * @return string $childtype 102 | 03
 */
function getChildtypeBySelectHY($sport, $select) {
	
	$fb = $bk = array();
	
	$fb['1x1'] = '101';
	$fb['2x1'] = '102';$fb['3x1'] = '103';$fb['4x1'] = '104';
	$fb['5x1'] = '105';$fb['6x1'] = '106';$fb['7x1'] = '107';$fb['8x1'] = '108';
	
	$bk['1x1'] = '02';$bk['2x1'] = '03';$bk['3x1'] = '04';$bk['4x1'] = '05';
	$bk['5x1'] = '06';$bk['6x1'] = '07';$bk['7x1'] = '08';$bk['8x1'] = '09';
	
	return ${$sport}[$select];
	
}


/**
 * 华阳胜平负等关系的转换
 * had: ["胜", "平", "负"], hhad: ["胜", "平", "负"], 
 * had: ["h", "d", "a"], hhad: ["h", "d", "a"], 
 * 		  3		1	0
 ttg: ["0球", "1球", "2球", "3球", "4球", "5球", "6球", "7+球"],    
 ttg: ["s0", "s1", "s2", "s3", "s4", "s5", "s6", "s7"], 
  		0		1	2		3	4		5	6	7
 hafu: ["胜胜", "胜平", "胜负", "平胜", "平平", "平负", "负胜", "负平", "负负"],
 hafu: ["hh", "hd", "ha", "dh", "dd", "da", "ah", "ad", "aa"],
  		33		31	30		13	11		10	03		01	00
 crs: ["1:0", "2:0", "2:1", "3:0", "3:1", "3:2", "4:0", "4:1", "4:2", "5:0", "5:1", "5:2", "胜其他", 
 		"0:0", "1:1", "2:2", "3:3", "平其他", 
 		"0:1", "0:2", "1:2", "0:3", "1:3", "2:3", "0:4", "1:4", "2:4", "0:5", "1:5", "2:5", "负其他"],
 crs: ["0100", "0200", "0201", "0300", "0301", "0302", "0400", "0401", "0402", "0500", "0501", "0502", "-1-h", 
 		"0000", "0101", "0202", "0303", "-1-d", 
 		"0001", "0002", "0102", "0003", "0103", "0203", "0004", "0104", "0204", "0005", "0105", "0205", "-1-a"], 
 		10	20	21			90胜其他  99平其他  09负其他
 mnl: ["主负", "主胜"],
 mnl: ["h", "a"], 
 		3	0
 hdc: ["让分主负", "让分主胜"], 
 hdc: ["h", "a"], 
 		3	0
 hilo: ["大", "小"],
 hilo: ["h", "l"], 
 		1	 2
 wnm: ["客胜1-5", "客胜6-10", "客胜11-15", "客胜16-20", "客胜21-25", "客胜26+", "主胜1-5", "主胜6-10", "主胜11-15", "主胜16-20", "主胜21-25", "主胜26+"] };
 wnm: ["l1", "l2", "l3", "l4", "l5", "l6", "w1", "w2", "w3", "w4", "w5", "w6"]
 		7		8	9		10	11	12		1		2	3	4		5	6
 */
function transToHYByPoolCode($pool, $code) {
	$pool = strtolower($pool);
	$code = strtolower($code);
	$array = array();
	$array['had'] = array('h'=>3,'d'=>1, 'a'=>0);
	$array['hhad'] = array('h'=>3,'d'=>1, 'a'=>0);
	$array['ttg'] = array("s0"=>'0', "s1"=>'1', "s2"=>'2', "s3"=>'3', "s4"=>'4', "s5"=>'5', "s6"=>'6', "s7"=>'7');
	$array['hafu'] = array("hh"=>'33', "hd"=>'31', "ha"=>'30', "dh"=>'13', "dd"=>'11', "da"=>'10', "ah"=>'03', "ad"=>'01', "aa"=>'00');
	$array['crs'] = array(
	"0100"=>'10',"0200"=>'20',"0201"=>'21',"0300"=>'30',"0301"=>'31',"0302"=>'32',"0400"=>'40',"0401"=>'41',"0402"=>'42',"0500"=>'50',"0501"=>'51',"0502"=>'52',"-1-h"=>'90', 
 	"0000"=>'00',"0101"=>'11',"0202"=>'22',"0303"=>'33',"-1-d"=>'99', 
 	"0001"=>'01',"0002"=>'02',"0102"=>'12',"0003"=>'03',"0103"=>'13',"0203"=>'23',"0004"=>'04',"0104"=>'14',"0204"=>'24',"0005"=>'05',"0105"=>'15',"0205"=>'25',"-1-a"=>'09');
	$array['mnl'] = array('h'=>3, 'a'=>0);
	$array['hdc'] = array('h'=>3, 'a'=>0);
	$array['hilo'] = array('h'=>1, 'l'=>2);
	$array['wnm'] = array(
	"w1"=>'1', "w2"=>'2', "w3"=>'3', "w4"=>'4', "w5"=>'5', "w6"=>'6',
	"l1"=>'7', "l2"=>'8', "l3"=>'9', "l4"=>'10', "l5"=>'11', "l6"=>'12');
	return $array[$pool][$code];
}
/**
 * 
 * 按玩法代码获取中文解释
 * @param unknown_type $pool
 * @param unknown_type $code
 */
function getChineseByPoolCode($pool, $code) {
	/*　篮球让分胜负　*/ 
	$HDC["H"]="让分主胜";$HDC["A"]="让分主负";
	/*　篮球胜负　*/ 
	$MNL["H"]="主胜";$MNL["A"]="主负";
	/*　篮球大小分　*/ 
	$HILO["H"]="大分";$HILO["L"]="小分";
	/*　篮球胜分差　*/ 
	$WNM["L1"]="客胜1-5";$WNM["L2"]="客胜6-10";$WNM["L3"]="客胜11-15";$WNM["L4"]="客胜16-20";
	$WNM["L5"]="客胜21-25";$WNM["L6"]="客胜26+";
	$WNM["W1"]="主胜1-5";$WNM["W2"]="主胜6-10";$WNM["W3"]="主胜11-15";$WNM["W4"]="主胜16-20";
	$WNM["W5"]="主胜21-25";$WNM["W6"]="主胜26+";
	
	/*　足球让球胜平负　*/ 
	$HHAD["H"]="胜";$HHAD["D"]="平";$HHAD["A"]="负";
	/*　足球胜平负　*/	
	$HAD["H"]="胜";$HAD["D"]="平";$HAD["A"]="负";
	/*　足球半全场　*/ 
	$HAFU["HH"]="胜胜";$HAFU["HD"]="胜平";$HAFU["HA"]="胜负";
	$HAFU["DH"]="平胜";$HAFU["DD"]="平平";$HAFU["DA"]="平负";
	$HAFU["AH"]="负胜";$HAFU["AD"]="负平";$HAFU["AA"]="负负";
	/*　足球总进球　*/ 
	$TTG["S0"]="0球";$TTG["S1"]="1球";$TTG["S2"]="2球";$TTG["S3"]="3球";
	$TTG["S4"]="4球";$TTG["S5"]="5球";$TTG["S6"]="6球";$TTG["S7"]="7+球";
	/*　足球比分　*/	
	$CRS["0100"]="1:0";$CRS["0200"]="2:0";$CRS["0201"]="2:1";$CRS["0300"]="3:0";$CRS["0301"]="3:1";$CRS["0302"]="3:2";
	$CRS["0400"]="4:0";$CRS["0401"]="4:1";$CRS["0402"]="4:2";$CRS["0500"]="5:0";$CRS["0501"]="5:1";$CRS["0502"]="5:2";
	$CRS["-1-H"]="胜其他";$CRS["0000"]="0:0";$CRS["0101"]="1:1";$CRS["0202"]="2:2";$CRS["0303"]="3:3";$CRS["-1-D"]="平其他";
	$CRS["0001"]="0:1";$CRS["0002"]="0:2";$CRS["0102"]="1:2";$CRS["0003"]="0:3";$CRS["0103"]="1:3";$CRS["0203"]="2:3";
	$CRS["0004"]="0:4";$CRS["0104"]="1:4";$CRS["0204"]="2:4";$CRS["0005"]="0:5";$CRS["0105"]="1:5";$CRS["0205"]="2:5";
	$CRS["-1-A"]="负其他";
	/* 北单胜负和胜平负*/
	$SF  = $HHAD;
	$SPF = $HHAD;
	/* 北单总进球*/
	$JQS = $TTG;
	/* 北单比分*/
	$BF = $CRS;
	/* 北单半全场*/
	$BQC = $HAFU;
	/* 上下单双*/
	$SXDS["SD"] = "上+单";$SXDS["SS"] = "上+双";$SXDS["XD"] = "下+单";$SXDS["XS"] = "下+双";
	
	/*　竞彩玩法　*/
	$POOL["HDC"]	="让分胜负";
	$POOL["MNL"]	="胜负";
	$POOL["HILO"]	="大小分";
	$POOL["WNM"]	="胜分差";
	
	$POOL["HAD"]	="胜平负";
	$POOL["HHAD"]	="胜平负/让球胜平负";
	$POOL["HAFU"]	="半全场";
	$POOL["TTG"]	="总进球";
	$POOL["CRS"]	="比分";
	$POOL["CROSSPOOL"]="混合过关";
	
	return ${strtoupper($pool)}[strtoupper($code)];
}
/**
 * 场次信息
 * @param unknown_type $value 3001 周三001
 */
function show_num($value){
	$day=substr($value,0,1);
	$value=substr($value,1);
	switch($day){
		case 1;$day="周一";break;
		case 2;$day="周二";break;
		case 3;$day="周三";break;
		case 4;$day="周四";break;
		case 5;$day="周五";break;
		case 6;$day="周六";break;
		case 7;$day="周日";break;		
	}
	return $day.$value;	
}

/**
 * 
 * 获取投注方案说明
 * @param unknown_type $pool
 */
function getPoolDesc($sport, $pool) {
	$sport = strtolower($sport);
	$pool = strtolower($pool);
	$array_fb = $array_bk = array();
	//足球
	$array_fb['crosspool'] 		= '竞彩足球_混合投注';
	$array_fb['had'] 			= '竞彩足球_胜平负';
	$array_fb['hhad'] 			= '竞彩足球_让球胜平负';
	$array_fb['crs'] 			= '竞彩足球_比分';//
	$array_fb['ttg'] 			= '竞彩足球_总进球';//
	$array_fb['hafu'] 			= '竞彩足球_半全场';//
	//篮球
	$array_bk['hdc'] 			= '篮彩_让分胜负';//
	$array_bk['hilo'] 			= '篮彩_大小分';//
	$array_bk['mnl'] 			= '篮彩_胜负';//
	$array_bk['wnm'] 			= '篮彩_胜分差';//
	$array_bk['crosspool'] 		= '篮彩_混合过关';//
	//北单
	$array_bd['spf'] 			= '北京单场_胜平负';
	$array_bd['sf'] 			= '北京单场_胜负';
	$array_bd['bqc'] 			= '北京单场_半全场';
	$array_bd['jqs'] 			= '北京单场_进球数';//
	$array_bd['sxds'] 			= '北京单场_上下单双';//
	$array_bd['bf'] 			= '北京单场_比分';//
	
	$array = array();
	$array['fb'] = $array_fb;
	$array['bk'] = $array_bk;
	$array['bd'] = $array_bd;
	return $array[$sport][$pool];
}
/**
 * 产生一个20位的交易流水号 20140506132745122633
 * @return int
 */
function getUniqueOrderId(){
	$randNumber = rand('1','999999');
	$rands = str_pad($randNumber,6,'0',STR_PAD_LEFT);
	return 	 date('YmdHis',time()) .  $rands;
}

/**
 * 虚拟投注的用户uid
 * 线上创建一些用户进行虚拟投注，只是不会真实出票，其他更普通用户一致
 */
function getVirtualUserIds(){
	return array(
//		1,2,3,4,5
	);
}

/**
 * 玩法字符串转数组
 * had|53951|h#5.1,had|53952|h#3.1&d#3.2
 * crs|55280|0402#80,crs|55281|0402#50
 * @param string $sport
 * @param string $pool
 * @param string $combination
 * @return array('lotterycode'=>$lotterycode //131105-009(3);131105-001(0);
 * 				'betlotterymode'=>$betlotterymode  //131105-001^131105-009
 * 				)
 */
function combinationToLotterycode($sport, $pool, $combination) {
//	return '131105-009(3)';
	
	$sport = strtolower($sport);
	$pool_order = strtolower($pool);//系统票玩法
	
	$lottery = array();
	$lotterycode = '';
	
	$betlottery_max = true;//投注场次的最大、小
	$betlottery_min = false;
	
	$betlotterymode = '';
	$betlottery = array();
//	switch ($sport) {
//		case 'fb':
			$C = explode(",",$combination);
			foreach($C as $k => $v){
				$match = explode("|",$v);
				$match_id = $match[1];//比赛id
				$pool = $match[0];//当前注玩法
				$key = explode("#",$match[2]);
				$zy_code = $key[0];
				$hy_code = transToHYByPoolCode($pool, $zy_code);
				#TODO
				
				$objBetting = new Betting($sport);
				$matchInfo = $objBetting->get($match_id);
				
				$num = substr($matchInfo['num'], 1);//赛事编号，即投注场次
				
				$b_date = $matchInfo['b_date'];//赛事日期
				
				$date = getMatchDate($b_date, $sport);
				$lotteryId = getLotteryIdByPoolHY($sport, $pool);//玩法id
				
				if ($pool_order == 'crosspool') {
					//混合过关时
					$lottery[] = $lotteryId. '^' .$date . '-'. $num . '('.$hy_code.')';
				} else {
					$lottery[] = $date . '-'. $num . '('.$hy_code.')';
				}
				
				$betlottery[$date. '-'. $num] = $date . $num;
			}
			//先按$date . $num排序，第一个元素是最小日期的最小场次，最后一个元素是最大日期的最大场次
			asort($betlottery);
			
			foreach ($betlottery as $key=>$value) {
				if (!$betlottery_min) $betlottery_min = $key;
				if ($betlottery_max) $betlottery_max = $key;
			}
			
			$lotterycode = implode(';', $lottery);
			$betlotterymode = $betlottery_min . '^' . $betlottery_max;
			
//			break;
//		case 'bk':
//			
//			break;
//			
//	}
	
	return array('lotterycode'=>$lotterycode, 'betlotterymode'=>$betlotterymode);
}

/**
 * 
 * 获取赛事日期
 * @param string $b_date 2014-04-11
 * @param string $sport
 * @return $date 140411 or 20140411
 */
function getMatchDate($b_date, $sport) {
	
	$b_time = strtotime($b_date);
	if ($sport == 'fb') {
		return date('ymd', $b_time);
	} 
	if ($sport == 'bk'){
		return date('Ymd', $b_time);
	}
	return date('ymd', $b_time);
}

/**
 * 登录送积分
 * 规则：每人每天赠送一次积分
 * @return boolean
 */
function addScoreByLogin($u_id, $sum = 10) {
// 	$u_id = Runtime::getUid();

	//是否登录
	if (!Verify::int($u_id)) {
		return false;
	}
	
	$type = BankrollChangeType::SCORE_LOGIN;
	//当天是否已经获取积分
	$condition = array();
	$condition['u_id'] = $u_id;
	$condition['log_type'] = $type;
    $objUserScoreLogFront = new UserScoreLogFront();
    $scoreInfo = $objUserScoreLogFront->getsByCondition($condition, 1, 'create_time desc');
    	
    if ($scoreInfo) {
    	$scoreInfo = array_pop($scoreInfo);
    	$last_socre_time = strtotime($scoreInfo['create_time']);//最后一次登录送积分的时间
    	$today_last_second = strtotime(date('Y-m-d',time())) + 24 * 3600;//今天的最后一秒
    	if (($today_last_second - $last_socre_time) < 24 * 3600 ) {//不足一天
    		return false;
    	}
    }
    
	//登录送积分
	$objUserAccountFront = new UserAccountFront();
	$tmpResult = $objUserAccountFront->addScore($u_id, $sum);
	
	if (!$tmpResult->isSuccess()) {
		return false;
	}
	
	$userAccountInfo = $objUserAccountFront->get($u_id);
	$tableInfo = array();
    $tableInfo['u_id'] 			= $u_id;
    $tableInfo['score'] 		= $sum;
    $tableInfo['log_type'] 		= $type;
    $tableInfo['old_score'] 	= $userAccountInfo['score'];//原积分
    $tableInfo['record_table'] 	= 'user_account';//对应的表
    $tableInfo['record_id'] 	= $u_id;
    $tableInfo['create_time'] 	= getCurrentDate();
    //添加积分日志
    $tmpResult = $objUserScoreLogFront->add($tableInfo);
    
    if (!$tmpResult) {
    	return false;
    }
    
    return true;
}


/**
 * 验证天无局支付宝参数
 * @param $params
 * @param $sign
 * @return boolean
 */
function verifyTwjAlipayParams($params, $sign) {
	$signPars = "";
    ksort($params);

    foreach ($params as $key => $val) {
		if($key != "sign" && $key != "sign_type") {
                $signPars .= $key."={$val}&";
        }
    }
    $signPars = rtrim($signPars,'&');
    
    $configs = include ROOT_PATH . '/include/provider_config.php';
	$security_code = $configs['twjalipay']['security_code'];
    $sign1 = strtolower(md5($signPars . $security_code));
    return $sign == $sign1;
}

/**
 * 验证支付宝参数
 * @param $params
 * @param $sign
 * @return boolean
 */
function verifyAlipayParams($params, $sign) {
	$signPars = "";
    ksort($params);

    foreach ($params as $key => $val) {
		if($key != "sign" && $key != "sign_type") {
                $signPars .= $key."={$val}&";
        }
    }
    $signPars = rtrim($signPars,'&');
    
    $configs = include ROOT_PATH . '/include/provider_config.php';
	$security_code = $configs['alipay']['security_code'];
    $sign1 = strtolower(md5($signPars . $security_code));
    return $sign == $sign1;
}

/**
 * 获取赛果
 * @param string $combination 按玩法略有不同
 * TTG:3,
 * CRS:02:01,
 * HAFU:H:H,
 * HHAD:D,-1.00,
 * HAD:D,
 * HDC:A,+4.50,
 * MNL:A,
 * WNM:-3,
 * HILO:L,+206.50
 * @return string 
 */
function getResults($spool, $combination) {
//	$sport = strtoupper($sport);
	$spool = strtoupper($spool);
	$combination = rtrim($combination, ',');
	
	/*　篮球让分胜负　*/ 
	$HDC["H"]="让分主胜";$HDC["A"]="让分主负";
	if ($spool == 'HDC') {
		$combination = substr($combination, 0, 1);
	}
	
	/*　篮球胜负　*/ 
	$MNL["H"]="主胜";$MNL["A"]="主负";
	/*　篮球大小分　*/ 
	$HILO["H"]="大分";$HILO["L"]="小分";
	if ($spool == 'HILO') {
		$combination = substr($combination, 0, 1);
	}
	/*　篮球胜分差　*/ 
	$WNM["+1"]="主胜1-5";$WNM["+2"]="主胜6-10";$WNM["+3"]="主胜11-15";$WNM["+4"]="主胜16-20";
	$WNM["+5"]="主胜21-25";$WNM["+6"]="主胜26+";
	$WNM["-1"]="客胜1-5";$WNM["-2"]="客胜6-10";$WNM["-3"]="客胜11-15";$WNM["-4"]="客胜16-20";
	$WNM["-5"]="客胜21-25";$WNM["-6"]="客胜26+";
	
	/*　足球让球胜平负　*/ 
	$HHAD["H"]="胜";$HHAD["D"]="平";$HHAD["A"]="负";
	if ($spool == 'HHAD') {
		$combination = substr($combination, 0, 1);
	}
	/*　足球胜平负　*/	
	$HAD["H"]="胜";$HAD["D"]="平";$HAD["A"]="负";
	/*　足球半全场　*/ 
	$HAFU["H:H"]="胜胜";$HAFU["H:D"]="胜平";$HAFU["H:A"]="胜负";
	$HAFU["D:H"]="平胜";$HAFU["D:D"]="平平";$HAFU["D:A"]="平负";
	$HAFU["A:H"]="负胜";$HAFU["A:D"]="负平";$HAFU["A:A"]="负负";
	/*　足球总进球　*/ 
	$TTG["0"]="0球";$TTG["1"]="1球";$TTG["2"]="2球";$TTG["3"]="3球";
	$TTG["4"]="4球";$TTG["5"]="5球";$TTG["6"]="6球";$TTG["7"]="7+球";
	/*　足球比分　*/	
	$CRS["01:00"]="1:0";$CRS["02:00"]="2:0";$CRS["02:01"]="2:1";$CRS["03:00"]="3:0";$CRS["03:01"]="3:1";$CRS["03:02"]="3:2";
	$CRS["04:00"]="4:0";$CRS["04:01"]="4:1";$CRS["04:02"]="4:2";$CRS["05:00"]="5:0";$CRS["05:01"]="5:1";$CRS["05:02"]="5:2";
	$CRS["-1:-H"]="胜其他";
	$CRS["00:00"]="0:0";$CRS["01:01"]="1:1";$CRS["02:02"]="2:2";$CRS["03:03"]="3:3";$CRS["-1:-D"]="平其他";
	$CRS["00:01"]="0:1";$CRS["00:02"]="0:2";$CRS["01:02"]="1:2";$CRS["00:03"]="0:3";$CRS["01:03"]="1:3";$CRS["02:03"]="2:3";
	$CRS["00:04"]="0:4";$CRS["01:04"]="1:4";$CRS["02:04"]="2:4";$CRS["00:05"]="0:5";$CRS["01:05"]="1:5";$CRS["02:05"]="2:5";
	$CRS["-1:-A"]="负其他";
	
	/*北单的赛果*/
	$SPF["h"]="胜";$SPF["d"]="平";$SPF["a"]="负";
	$SF = $SPF;//胜负和生平负复用
	
	$BF = $JQS = $BQC = array();
	foreach ($CRS as $key=>$bf) {
		$key = str_replace(':', '', $key);
		$BF[strtolower($key)] = $bf;
	}
	foreach ($TTG as $key=>$jqs) {
		$JQS['s'.$key] = $jqs;
	}
	foreach ($HAFU as $key=>$bqc) {
		$key = str_replace(':', '', $key);
		$BQC[strtolower($key)] = $bqc;
	}
	$SXDS["sd"] = "上+单";$SXDS["ss"] = "上+双";$SXDS["xd"] = "下+单";$SXDS["xs"] = "下+双";
	return ${$spool}[$combination];
}

/**
 * 旧版的获取让球数方法，id>=21245 && id<=126451
 * id>=126451时使用新方式:hilo|66537|h#1.79|+203.50
 * @param string $odds  3.70(64310|-1.00),3.30&1.81(64315|-1.00)
 * @param int $matchid
 * @param float $sp 让球的sp值，处理同一matchid多个选项时让球数的取值问题
 * @return string
 */
function getGoallineByOdds($odds, $matchid, $sp = 0) {
	$goalline = '';
	$odds = explode(',', $odds);
	foreach ($odds as $odd) {
		if (stripos($odd,'(') !== false) {
			$om = explode('(', $odd);
			$om1 = $om[1];//50123|+1.00)
			$om1 = str_replace(')', '', $om1);//50123|+1.00
			$om2 = explode('|', $om1);//
			if ($sp) {
				$om3 = explode('&', $om[0]);
				foreach ($om3 as $k=>$v) {
					if ($v == $sp) {
						if ($om2[0] == $matchid) {
							$goalline = $om2[1];
							break 2;
						}
					}
				}
			} else {
				if ($om2[0] == $matchid) {
					$goalline = $om2[1];
					break;
				}
			}
		}
		
	}
	return $goalline;
}

/**
 * 新版的获取让球数方法，id>=21245 && id<=126451
 * id>=126451时使用新方式:hilo|66537|h#1.79|+203.50
 * @param string $combation  hilo|73624|l#1.75|+200.50,hilo|73627|l#1.75|+197.50,hilo|73628|l#1.75|+205.50
 * @param int $matchid
 * @return string
 */
function getGoallineByOddsV2($combation, $matchid, $pool) {
	$goalline = '';
	$m = explode(',', $combation);
	foreach ($m as $value) {
		$m1 = explode('|', $value);
		if ($matchid == $m1[1] && $pool == $m1[0]) {
			$goalline = $m1[3];
			break;
		}
	}
	return $goalline;
}

// 联赛颜色
function color($id){
	$C[47]="009900";$C[78]="009900";$C[77]="0CB9E4";$C[3]="567576";$C[60]="41BE76";$C[30]="297CA5";$C[14]="CC9900";
	$C[54]="009966";$C[56]="CB194C";$C[5]="37BE5A";$C[45]="003306";$C[21]="FF850B";$C[75]="3A5500";$C[15]="FF6699";
	$C[63]="054594";$C[31]="663333";$C[32]="6B2B2B";$C[17]="FF6699";$C[64]="57A87B";$C[71]="8EAD12";$C[66]="33BBCC";
	$C[24]="808080";$C[41]="3C3CFF";$C[57]="009966";$C[26]="DCB352";$C[2]="FF7000";$C[29]="128FCD";$C[18]="FF2F73";
	$C[12]="00A8A8";$C[46]="08855C";$C[50]="660033";$C[76]="CC3399";$C[48]="15DBAE";$C[11]="770088";$C[70]="CC9933";
	$C[67]="004488";$C[19]="3A794E";$C[10]="3A7500";$C[52]="666666";$C[73]="660000";$C[6]="DDDD00";$C[23]="A00800";
	$C[23]="003366";$C[1]="336600";$C[39]="005E5E";$C[61]="98CCFF";$C[38]="3C3CFF";$C[62]="006633";$C[40]="0066FF";
	$C[25]="FF3333";$C[37]="990099";$C[70]="CC9933";$C[7]="006633";$C[43]="22C126";$C[42]="009900";$C[49]="00A653";
	$C[69]="F75000";$C[58]="004488";$C[55]="008888";$C[34]="DB31EE";$C[51]="666666";$C[20]="CC3300";$C[36]="A05CA0";
	$C[72]="296CA0";$C[81]="5BC992";$C[82]="000000";$C[28]="2069C4";$C[80]="BE2B8F";$C[27]="2069C4";$C[93]="f157b9";
	$C[94]="f157b9";
	
	if (key_exists($id, $C)) {
		return "#".$C[$id];
	} else {
		if (preg_match('/英超/', $id)) return '#FFFF00';
		if (preg_match('/英冠/', $id)) return '#996699';
		if (preg_match('/英甲/', $id)) return '#99CC66';
		if (preg_match('/英乙/', $id)) return '#CC3333';
		if (preg_match('/意甲/', $id)) return '#333399';
		if (preg_match('/意乙/', $id)) return '#333300';
		if (preg_match('/西甲/', $id)) return '#FF9900';
		if (preg_match('/西乙/', $id)) return '#FFCC00';
		if (preg_match('/法甲/', $id)) return '#CC6600';
		if (preg_match('/法乙/', $id)) return '#99CCFF';
		if (preg_match('/德甲/', $id)) return '#999966';
		if (preg_match('/德乙/', $id)) return '#663300';
		if (preg_match('/葡超/', $id)) return '#FFFF00';
		if (preg_match('/葡甲/', $id)) return '#006633';
		if (preg_match('/苏超/', $id)) return '#333300';
		if (preg_match('/苏冠/', $id)) return '#33CC33';
		if (preg_match('/荷甲/', $id)) return '#CCCC33';
		if (preg_match('/荷乙/', $id)) return '#333366';
		if (preg_match('/比甲/', $id)) return '#99CC33';
		if (preg_match('/瑞典超/', $id)) return '#CCCC33';
		if (preg_match('/瑞典甲/', $id)) return '#339933';
		if (preg_match('/芬超/', $id)) return '#009966';
		if (preg_match('/挪超/', $id)) return '#FFFF00';
		if (preg_match('/挪甲/', $id)) return '#99CC00';
		if (preg_match('/丹超/', $id)) return '#339966';
		if (preg_match('/奥甲/', $id)) return '#9933CC';
		if (preg_match('/奥乙/', $id)) return '#000000';
		if (preg_match('/瑞士超/', $id)) return '#006633';
		if (preg_match('/瑞士甲/', $id)) return '#336666';
		if (preg_match('/爱超/', $id)) return '#993333';
		if (preg_match('/爱甲/', $id)) return '#990033';
		if (preg_match('/北爱超/', $id)) return '#663300';
		if (preg_match('/俄超/', $id)) return '#3F9F3F';
		if (preg_match('/俄甲/', $id)) return '#339999';
		if (preg_match('/波兰甲/', $id)) return '#009999';
		if (preg_match('/乌克兰超/', $id)) return '#003333';
		if (preg_match('/捷克甲/', $id)) return '#996699';
		if (preg_match('/希腊超/', $id)) return '#669999';
		if (preg_match('/罗甲/', $id)) return '#000000';
		if (preg_match('/冰岛超/', $id)) return '#663333';
		if (preg_match('/冰岛甲/', $id)) return '#666666';
		if (preg_match('/欧洲杯/', $id)) return '#003366';
		if (preg_match('/欧冠/', $id)) return '#333333';
		if (preg_match('/欧联/', $id)) return '#FFFF99';
		if (preg_match('/英足总杯/', $id)) return '#003399';
		if (preg_match('/英联杯/', $id)) return '#FF33CC';
		if (preg_match('/意大利杯/', $id)) return '#993333';
		if (preg_match('/德国杯/', $id)) return '#990033';
		if (preg_match('/法国杯/', $id)) return '#CC3399';
		if (preg_match('/法联杯/', $id)) return '#FF0033';
		if (preg_match('/西班牙国王杯/', $id)) return '#66CCCC';
		if (preg_match('/苏足总杯/', $id)) return '#FF9900';
		if (preg_match('/苏联杯/', $id)) return '#FF6666';
		if (preg_match('/葡联杯/', $id)) return '#CC6600';
		if (preg_match('/日职联/', $id)) return '#0099CC';
		if (preg_match('/日职乙/', $id)) return '#FF6666';
		if (preg_match('/天皇杯/', $id)) return '#CC0033';
		if (preg_match('/韩K联/', $id)) return '#990066';
		if (preg_match('/澳超/', $id)) return '#FF9933';
		if (preg_match('/亚洲杯/', $id)) return '#dc0000';
		if (preg_match('/亚冠/', $id)) return '#F00000';
		if (preg_match('/巴西甲/', $id)) return '#CC0033';
		if (preg_match('/巴西乙/', $id)) return '#FF9900';
		if (preg_match('/阿甲/', $id)) return '#663366';
		if (preg_match('/美洲杯/', $id)) return '#003366';
		if (preg_match('/解放者杯/', $id)) return '#99CC00';
		if (preg_match('/南球杯/', $id)) return '#CC3333';
		if (preg_match('/NBA/', $id)) return '#CC9933';
		if (preg_match('/WNBA/', $id)) return '#660033';
		if (preg_match('/欧洲篮球联赛/', $id)) return '#FF6600';
		if (preg_match('/世界杯/', $id)) return '#FF0033';
		if (preg_match('/美冠杯/', $id)) return '#FF0033';
		
	}
	return '#000000';
}

/**
 * 各类玩法中文
 * @param string $value
 */ 
function chinese($value,$pool){
/*　篮球让分胜负　*/ 
	$HDC["H"]="让分主胜";$HDC["A"]="让分主负";
/*　篮球胜负　*/ 
	$MNL["H"]="主胜";$MNL["A"]="主负";
/*　篮球大小分　*/ 
	$HILO["H"]="大分";$HILO["L"]="小分";
/*　篮球胜分差　*/ 
	$WNM["L1"]="客胜1-5";$WNM["L2"]="客胜6-10";$WNM["L3"]="客胜11-15";$WNM["L4"]="客胜16-20";
	$WNM["L5"]="客胜21-25";$WNM["L6"]="客胜26+";
	$WNM["W1"]="主胜1-5";$WNM["W2"]="主胜6-10";$WNM["W3"]="主胜11-15";$WNM["W4"]="主胜16-20";
	$WNM["W5"]="主胜21-25";$WNM["W6"]="主胜26+";
	
/*　足球让球胜平负　*/ 
	$HHAD["H"]="胜";$HHAD["D"]="平";$HHAD["A"]="负";
/*　足球胜平负　*/	
	$HAD["H"]="胜";$HAD["D"]="平";$HAD["A"]="负";
/*　足球半全场　*/ 
	$HAFU["HH"]="胜胜";$HAFU["HD"]="胜平";$HAFU["HA"]="胜负";
	$HAFU["DH"]="平胜";$HAFU["DD"]="平平";$HAFU["DA"]="平负";
	$HAFU["AH"]="负胜";$HAFU["AD"]="负平";$HAFU["AA"]="负负";
/*　足球总进球　*/ 
	$TTG["S0"]="0球";$TTG["S1"]="1球";$TTG["S2"]="2球";$TTG["S3"]="3球";
	$TTG["S4"]="4球";$TTG["S5"]="5球";$TTG["S6"]="6球";$TTG["S7"]="7+";
/*　足球比分　*/	
	$CRS["0100"]="1:0";$CRS["0200"]="2:0";$CRS["0201"]="2:1";$CRS["0300"]="3:0";$CRS["0301"]="3:1";$CRS["0302"]="3:2";
	$CRS["0400"]="4:0";$CRS["0401"]="4:1";$CRS["0402"]="4:2";$CRS["0500"]="5:0";$CRS["0501"]="5:1";$CRS["0502"]="5:2";
	$CRS["-1-H"]="胜其他";$CRS["0000"]="0:0";$CRS["0101"]="1:1";$CRS["0202"]="2:2";$CRS["0303"]="3:3";$CRS["-1-D"]="平其他";
	$CRS["0001"]="0:1";$CRS["0002"]="0:2";$CRS["0102"]="1:2";$CRS["0003"]="0:3";$CRS["0103"]="1:3";$CRS["0203"]="2:3";
	$CRS["0004"]="0:4";$CRS["0104"]="1:4";$CRS["0204"]="2:4";$CRS["0005"]="0:5";$CRS["0105"]="1:5";$CRS["0205"]="2:5";
	$CRS["-1-A"]="负其他";
	/*  北单上下单双 */
	$SXDS["SD"] = "上+单";$SXDS["SS"] = "上+双";$SXDS["XD"] = "下+单";$SXDS["XS"] = "下+双";
	
 	$values = explode(",", $value);
	$value = strtoupper($values[0]);
	
 	switch($pool){
		case "mnl":$chinese=$MNL[$value];break;
		case "wnm":$chinese=$WNM[$value];break;
		case "crs":$chinese=$CRS[$value];break;
		case "ttg":$chinese=$TTG[$value];break;
		case "hafu":$chinese=$HAFU[$value];break;
		case "had":$chinese=$HAD[$value];break;
		case "hhad":$chinese=$HHAD[$value];break;
		case "hilo":$chinese=$HILO[$value];break;
		case "hdc":$chinese=$HDC[$value];break;
		
		case "spf":$chinese=$HAD[$value];break;//复用竞彩足球
		case "sf":$chinese=$HAD[$value];break;
		case "jqs":$chinese=$TTG[$value];break;
		case "bqc":$chinese=$HAFU[$value];break;
		case "sxds":$chinese=$SXDS[$value];break;
		case "bf":$chinese=$CRS[$value];break;
	}
	$chinese.=$values[1];
	return $chinese?$chinese:$value;
}


/**
 * 废弃的方法
 * 获取竞彩开售时间和截止时间
 *  竞足 周一至周五 开售：09:00 停售：23：52
		周六、日 开售：09:00 停售：00：52
	竞篮 周一/二/五 09:00～23:52 
		周三/四 07:30～23:52 
		周六/日 09:00～00:52
	北单 全天
 * @param string $sport fb|bk
 * @param string $b_date 奖期
 * @return array('start_time'=>2014-12-21 09:00:00 ,'end_time'=>2014-12-21 23:52:00);
 */
function getSportStartEndTime($sport, $b_date = '') {
	$time = time();
	if ($b_date) $time = strtotime($b_date);
	$sport = strtolower($sport);
	$week = date('w', $time);
	$s_date = date('Y-m-d', $time);//开始日期
	$e_date = date('Y-m-d', $time);//截止日期
	
	$is_in_special_time = false;//是否在周日、周一的00:00:00~00:52:00这一特殊时段
	$special_time = 0;//特殊时段时长，单位s
	if ($week == 0 || $week == 1) {
		switch ($sport) {
			case 'fb':
				$special_time = 52 * 60;
				break;
			case 'bk':
				$special_time = 52 * 60;
				break;
			default:
				$special_time = 52 * 60;
			break;	
		}	
		if ((time() - strtotime(date('Y-m-d'))) < $special_time) {
			$is_in_special_time = true;
		}
	}
	
	if ($is_in_special_time) {
		if ($week == 0) $week = 6;
		if ($week == 1) $week = 0;
	}
	
	switch ($sport) {
		case 'fb':
			if ($week == 6 || $week == 0) {
				$start_time = '09:00:00';
				$end_time = '00:52:00';
				$e_date = date('Y-m-d', $time + 24 * 3600);//截止日期
			} else {
				$start_time = '09:00:00';
				$end_time = '23:52:00';
			}
			break;
		case 'bk':
			switch ($week) {
				case 1:case 2:case 5:
					$start_time = '09:00:00';
					$end_time = '23:52:00';
					break;
				case 3:case 4:
					$start_time = '07:30:00';
					$end_time = '23:52:00';
					break;
				case 6: case 0:
					$start_time = '09:00:00';
					$end_time = '00:52:00';
					$e_date = date('Y-m-d', $time + 24 * 3600);//截止日期
					break;
			}
			break;
		case 'bd':
			$start_time = '00:00:00';
			$end_time = '23:59:59';
			break;
	}
	
	return array('start_time'=>$s_date .' ' . $start_time, 'end_time'=>$e_date .' ' . $end_time);
}

/**
 * 新的方法，旧的已经废弃
 * 获取竞彩开售时间和截止时间数组
 *   竞足 周一至周五 开售：09:00 停售：23：52
	 周六、日 开售：09:00 停售：00：52
	 竞篮 周一/二/五 09:00～23:52
	 周三/四 07:30～23:52
	 周六/日 09:00～00:52
	 北单 全天
 * @param string $sport fb|bk
 * @return array(0=>array('start_time'=>09:00:00 ,'end_time'=>23:52:00),1=>...);
 */
function getSportStartEndTimeArray($sport) {
	$time = time();
	$sport = strtolower($sport);
	$week = date('N', $time);//1~7
	$return = array();
	
	if ($sport == 'fb') {
		switch ($week) {
			case 2:case 3:case 4:case 5:
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:51:00');
				break;
			case 6:
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:59:59');
				break;
			case 7:
				$return[] = array('start_time' => '00:00:00', 'end_time' => '00:51:00');
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:59:59');
				break;
			case 1:
				$return[] = array('start_time' => '00:00:00', 'end_time' => '00:51:00');
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:51:00');
				break;
		};
	}
	
	if ($sport == 'bk') {
		switch ($week) {
			case 2:case 5:
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:51:00');
				break;
			case 3:case 4:
				$return[] = array('start_time' => '07:30:00', 'end_time' => '23:51:00');
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:51:00');
				break;
			case 6:
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:59:59');
				break;
			case 7:
				$return[] = array('start_time' => '00:00:00', 'end_time' => '00:51:00');
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:59:59');
				break;
			case 1:
				$return[] = array('start_time' => '00:00:00', 'end_time' => '00:51:00');
				$return[] = array('start_time' => '09:00:00', 'end_time' => '23:51:00');
				break;
		};
	}
	
	if ($sport == 'bd') {
		$return[] = array('start_time' => '00:00:00', 'end_time' => '23:59:59');
	}

	//竞彩延长销售1小时
	$datetime = getCurrentDate();
	if ($datetime <= '2015-07-06 23:59:59') {
	//if ($datetime <= '2016-07-12 23:59:59') {
		$return[] = array('start_time' => '00:00:00', 'end_time' => '02:51:00');
		$return[] = array('start_time' => '09:00:00', 'end_time' => '23:59:59');
	}
	
	return $return;
}

/**
 * 获取当天的最后投注截止时间，只与彩种有关，用于在投注页面展示
 * 传递参数$g_datetime时，返回比赛日期的投注截止时间
 * @param string $sport
 * @param string $g_datetime 比赛日期:2014-10-11 08:00:00
 * @return string $time
 */
function getLastTouzhuTime($sport , $g_datetime = '') {
	$datetime = getCurrentDate();//当前时间
	$timestamp = time();
	if ($g_datetime) {
		$datetime = $g_datetime;
		$timestamp = strtotime($datetime);
	}
	
	$today = date('Y-m-d',$timestamp);//今天的日期
	$tommorrow = date('Y-m-d', $timestamp + 86400);
	$sport = strtolower($sport);
	$week = date('N', $timestamp);//1~7
	$return = array();
	
	if ($sport == 'fb') {
		switch ($week) {
			case 2:case 3:case 4:case 5:
				$date = $today;
				$time = '23:50:00';
				break;
			case 6:
				$date = $tommorrow;
				$time = '00:50:00';
				break;
			case 7:
				
				if ($datetime < $today . ' 00:50:00') {
					$date = $today;
					$time = '00:50:00';
				} else {
					$date = $tommorrow;
					$time = '00:50:00';
				}
				break;
			case 1:
				
				if ($datetime < $today . ' 00:50:00') {
					$date = $today;
					$time = '00:50:00';
				} else {
					$date = $today;
					$time = '23:50:00';
				}
				break;
		}
	}
	
	if ($sport == 'bk') {
		switch ($week) {
			case 2:case 5:case 3:case 4:
				$date = $today;
				$time = '23:50:00';
				break;
			case 6:
				$date = $tommorrow;
				$time = '00:50:00';
				break;
			case 7:
				if ($datetime < $today . ' 00:50:00') {
					$date = $today;
					$time = '00:50:00';
				} else {
					$date = $tommorrow;
					$time = '00:50:00';
				}
				break;
			case 1:
				if ($datetime < $today . ' 00:50:00') {
					$date = $today;
					$time = '00:50:00';
				} else {
					$date = $today;
					$time = '23:50:00';
				}
				break;
		}
	}
	if ($sport == 'bd') {
		$date = $today;
		$time = '23:59:59';
	}
	//竞彩延长销售1小时
	//if ($datetime <= '2016-07-12 23:59:59') {
	if ($datetime <= '2015-07-06 23:59:59') {	
		$date = $tommorrow;
		$time = '02:50:00';
	}
	return array('date'=>$date, 'time'=>$time);
}

/**
 * 获取足球比赛信息
 * @param unknown_type $p
 * @param unknown_type $date
 */
function fb_list($p, $date){
	
	$today = date("Y-m-d");
	$total=0;
	$sport = 'fb';
	
	$condition = array();
	if($date == $today){
		$condition['status'] = Betting::STATUS_SELLING;
	}else{
		$condition['date'] = $date;
	}
	
	$order = 'b_date asc';
	$dates = $str = array();
	$objBetting = new Betting($sport);
	$BettingInfos = $objBetting->getsByCondition($condition, null, $order);
	foreach ($BettingInfos as $value) {
		$total++;
		$dates[$value["b_date"]]++;;
	}
	
 	$str["total"] = $total;
	$str["group"]=count($dates);
	
 	foreach($dates as $k => $v){
		$datas=array();
		$D=array();
		$datas["day"] = $k;//场次日期
		$datas["size"] = $v;//数量
		$condition = array();
		if($date==$today){
			$condition['status'] = Betting::STATUS_SELLING;
			$condition['b_date'] = $k;
			$order = 'num asc , date asc , time asc';
		}else{
			$condition['date'] = $k;
			$order = 'date asc , time asc, num asc';
		}
		
		$BettingInfos = $objBetting->getsByCondition($condition, null, $order);
		foreach ($BettingInfos as $d) {
			
			$end_up_time = array();
			$end_up_time_m = getMatchEndTime($sport, $d["b_date"], $d["date"], $d["time"]);
			$end_up_time['date'] = $end_up_time_m['date'];
			$end_up_time['time'] = $end_up_time_m['time'];
			$end_up_time_t = getLastTouzhuTime($sport);//比赛结束时间跟最后停止投注时间比较，哪个在前用哪个
// 			$end_up_time_t = getLastTouzhuTime($sport, $end_up_time['date'].' '.$end_up_time['time'])
			if ($end_up_time_t['date']. ' '. $end_up_time_t['time'] < $end_up_time['date']. ' '. $end_up_time['time']) {
				
			if($d["b_date"]>$today){//只是作显示作用 //如果是明天或者后天的时间，不显示当天截止时间了
				$end_up_time['date'] = $end_up_time['date'];
				
			
				
				$end_up_time['time'] = $end_up_time['time'];
				
				
			}else{
				$end_up_time['date'] = $end_up_time_t['date'];
				$end_up_time['time'] = $end_up_time_t['time'];
			}
				/*$end_up_time['date'] = $end_up_time_t['date'];
				$end_up_time['time'] = $end_up_time_t['time'];*/
			} 
			
			if ($d['l_id'] == 72) {
				$game_touzhu_end_time = strtotime($d["date"] .' ' .$d['time']) - 10*60;//世界杯赛事的结束时间为赛前10分钟
				$end_up_time['date'] = date('Y-m-d', $game_touzhu_end_time);
				$end_up_time['time'] = date('H:i:s', $game_touzhu_end_time);//停止投注时间
			}
			
			$d["date"] = $end_up_time['date'];
			$d['time'] = $end_up_time['time'];
			//排除已经开赛的比赛
			if ($d["date"] . " " . $d["time"] <= getCurrentDate()) {
				$D[$d["id"]]['end'] = 0;//比赛是否结束，由于接口更新不同步导致，部分比赛的状态没有及时更新
				// 				$datas["size"]--;
				// 				//当天比赛都被筛选掉了，需要排除这个日期
				// 				if ($datas['size'] == 0) {
				// 					unset($dates[$k]);
				// 					continue 2;
				// 				}
				// 				continue;
			} else {
				$D[$d["id"]]['end'] = 0;
			}
			$datas["num"] = substr(show_num($d["num"]),0,-3);
			$D[$d["id"]]['id'] = $d["id"];
			$D[$d["id"]]['num']=substr($d["num"],1);
			$D[$d["id"]]['date'] = $d["date"];
			$D[$d["id"]]['time'] = $d["time"];
//			$D[$d["id"]]['l_cn']=iconv('gb2312','utf-8',$d["l_cn"]);
//			$D[$d["id"]]['l_color']=color($d["l_id"]);
//			$D[$d["id"]]['h_cn']=iconv('gb2312','utf-8',$d["h_cn"]);
//			$D[$d["id"]]['a_cn']=iconv('gb2312','utf-8',$d["a_cn"]);
			
			$D[$d["id"]]['l_cn']=$d["l_cn"];
			$D[$d["id"]]['h_cn']=$d["h_cn"];
			$D[$d["id"]]['a_cn']=$d["a_cn"];
			$D[$d["id"]]['l_color']='#'.$d["color"];
			
			$cond = array();
			$cond['m_id'] = $d["id"];
			
			//单关选项
			$objDanguanBetting = new DanguanBetting();
			
			if(substr_count($p,",hhad")){
				// hhad
				$objOdds = new Odds($sport, 'hhad');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					unset($D[$d["id"]]);
					continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['hhad']['h'] = $odds["h"];
					$D[$d["id"]]['hhad']['d'] = $odds["d"];
					$D[$d["id"]]['hhad']['a'] = $odds["a"];
					$D[$d["id"]]['hhad']['goalline']=substr($odds["goalline"],0,2);
				}
			}
			
			if(substr_count($p,",had")){
				// had
				$objOdds = new Odds($sport, 'had');
				$oddInfos = $objOdds->getsByCondition($cond);
// 				if (!$oddInfos && isset($D[$d["id"]])) {
// 					unset($D[$d["id"]]);
// 					continue;
// 				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['had']['h'] = $odds["h"];
					$D[$d["id"]]['had']['d'] = $odds["d"];
					$D[$d["id"]]['had']['a'] = $odds["a"];
				}
			}
			
			if(substr_count($p,",had,hhad")){
				$hhad_danguan = $objDanguanBetting->isDanguan('fb', $d["id"], 'hhad');
				//区分让球和非让球
				$D[$d["id"]]['danguan_hhad'] = $hhad_danguan;
				$had_danguan = $objDanguanBetting->isDanguan('fb', $d["id"], 'had');
				//区分让球和非让球
				$D[$d["id"]]['danguan_had'] = $had_danguan;
				if ($hhad_danguan||$had_danguan) {
					$D[$d["id"]]['danguan'] = true;
				} else {
					$D[$d["id"]]['danguan'] = false;
				}
			}
			
			if(substr_count($p,",crs")){
				// crs
				$objOdds = new Odds($sport, 'crs');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					unset($D[$d["id"]]);
					continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['crs']['-1-a'] = $odds["-1-a"];
					$D[$d["id"]]['crs']['-1-d'] = $odds["-1-d"];
					$D[$d["id"]]['crs']['-1-h'] = $odds["-1-h"];
					$D[$d["id"]]['crs']['0000'] = $odds["0000"];
					$D[$d["id"]]['crs']['0001'] = $odds["0001"];
					$D[$d["id"]]['crs']['0002'] = $odds["0002"];
					$D[$d["id"]]['crs']['0003'] = $odds["0003"];
					$D[$d["id"]]['crs']['0004'] = $odds["0004"];
					$D[$d["id"]]['crs']['0005'] = $odds["0005"];
					$D[$d["id"]]['crs']['0100'] = $odds["0100"];
					$D[$d["id"]]['crs']['0101'] = $odds["0101"];
					$D[$d["id"]]['crs']['0102'] = $odds["0102"];
					$D[$d["id"]]['crs']['0103'] = $odds["0103"];
					$D[$d["id"]]['crs']['0104'] = $odds["0104"];
					$D[$d["id"]]['crs']['0105'] = $odds["0105"];
					$D[$d["id"]]['crs']['0200'] = $odds["0200"];
					$D[$d["id"]]['crs']['0201'] = $odds["0201"];
					$D[$d["id"]]['crs']['0202'] = $odds["0202"];
					$D[$d["id"]]['crs']['0203'] = $odds["0203"];
					$D[$d["id"]]['crs']['0204'] = $odds["0204"];
					$D[$d["id"]]['crs']['0205'] = $odds["0205"];
					$D[$d["id"]]['crs']['0300'] = $odds["0300"];
					$D[$d["id"]]['crs']['0301'] = $odds["0301"];
					$D[$d["id"]]['crs']['0302'] = $odds["0302"];
					$D[$d["id"]]['crs']['0303'] = $odds["0303"];
					$D[$d["id"]]['crs']['0400'] = $odds["0400"];
					$D[$d["id"]]['crs']['0401'] = $odds["0401"];
					$D[$d["id"]]['crs']['0402'] = $odds["0402"];
					$D[$d["id"]]['crs']['0500'] = $odds["0500"];
					$D[$d["id"]]['crs']['0501'] = $odds["0501"];
					$D[$d["id"]]['crs']['0502'] = $odds["0502"]; 
				}
// 				$D[$d["id"]]['danguan'] = $objDanguanBetting->isDanguan('fb', $d["id"], 'crs');
				$D[$d["id"]]['danguan'] = true;
			}
			if(substr_count($p,",ttg")){
				// ttg
				$objOdds = new Odds($sport, 'ttg');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					unset($D[$d["id"]]);
					continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['ttg']['s0'] = $odds["s0"];
					$D[$d["id"]]['ttg']['s1'] = $odds["s1"];
					$D[$d["id"]]['ttg']['s2'] = $odds["s2"];
					$D[$d["id"]]['ttg']['s3'] = $odds["s3"];
					$D[$d["id"]]['ttg']['s4'] = $odds["s4"];
					$D[$d["id"]]['ttg']['s5'] = $odds["s5"];
					$D[$d["id"]]['ttg']['s6'] = $odds["s6"]; 
					$D[$d["id"]]['ttg']['s7'] = $odds["s7"];
				}
// 				$D[$d["id"]]['danguan'] = $objDanguanBetting->isDanguan('fb', $d["id"], 'ttg');
				$D[$d["id"]]['danguan'] = true;
			}
			if(substr_count($p,",hafu")){
				// hafu
				$objOdds = new Odds($sport, 'hafu');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					unset($D[$d["id"]]);
					continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['hafu']['hh'] = $odds["hh"];
					$D[$d["id"]]['hafu']['hd'] = $odds["hd"];
					$D[$d["id"]]['hafu']['ha'] = $odds["ha"];
					$D[$d["id"]]['hafu']['dh'] = $odds["dh"];
					$D[$d["id"]]['hafu']['dd'] = $odds["dd"];
					$D[$d["id"]]['hafu']['da'] = $odds["da"];
					$D[$d["id"]]['hafu']['ah'] = $odds["ah"]; 
					$D[$d["id"]]['hafu']['ad'] = $odds["ad"];
					$D[$d["id"]]['hafu']['aa'] = $odds["aa"];
				}
// 				$D[$d["id"]]['danguan'] = $objDanguanBetting->isDanguan('fb', $d["id"], 'hafu');
				$D[$d["id"]]['danguan'] = true;
			}
			// 比分
			$D[$d["id"]]['score']='';
			$D[$d["id"]]['had_key']='';
			$D[$d["id"]]['hhad_key']='';
			$D[$d["id"]]['ttg_key']='';
			
			$objPoolResult = new PoolResult($sport);
			$poolResultInfo = $objPoolResult->get($d["id"]);
			if ($poolResultInfo) {
				$D[$d["id"]]['score'] = $poolResultInfo["final"];
			}
			
			$condition = array();
			$condition['m_id'] = $d["id"];
			$condition['value'] = '';
			$poolResultInfos = $objPoolResult->getsByCondition($condition);
			foreach ($poolResultInfos as $result) {
				$p_code = $result["p_code"];
				switch ($p_code) {
					case "HAD":
						$D[$d["id"]]['had_key'] = substr($result["combination"],0,1);
						break;
					case "HHAD":
						$D[$d["id"]]['hhad_key'] = substr($result["combination"],0,1);
						break;
					case "TTG":
						$D[$d["id"]]['ttg_key'] = substr($result["combination"],0,1);
					break;
					default:
						;
					break;
				}
			}
		}
		$datas["matchs"][] = $D;
		$str["datas"][] = $datas;
 	}
// 	$str=json_encode($str);
	return $str;	
}

function bk_list($p, $date){
	//return array('total'=>0);
	$today = date("Y-m-d");
	$total=0;
	$sport = 'bk';
	
	$condition = array();
	if($date == $today){
		$condition['status'] = Betting::STATUS_SELLING;
	}else{
		$condition['date'] = $date;
	}
	
	//var_dump($condition);die();
	
	$order = 'b_date asc';
	$dates = $str = array();
	
	$objBetting = new Betting($sport);
	$BettingInfos = $objBetting->getsByCondition($condition, null, $order);
	

	foreach ($BettingInfos as $value) {
		$total++;
		$dates[$value["b_date"]]++;;
	}
	
 	$str["total"] = $total;
	$str["group"]=count($dates);
	
 	foreach($dates as $k => $v){
 		
 		$datas=array();
		$D=array();
		
		$datas["day"] = $k;//场次日期
		$datas["size"] = $v;//数量
		$condition = array();
		
		if($date==$today){
			$condition['status'] = Betting::STATUS_SELLING;
			$condition['b_date'] = $k;
			$order = 'num asc , date asc , time asc';
		}else{
			$condition['date'] = $k;
			$order = 'date asc , time asc, num asc';
		}
		
		$BettingInfos = $objBetting->getsByCondition($condition, null, $order);
		
		//var_dump($BettingInfos);
		foreach ($BettingInfos as $d) {
			
			$end_up_time = array();
			$end_up_time_m = getMatchEndTime($sport, $d["b_date"], $d["date"], $d["time"]);
			$end_up_time['date'] = $end_up_time_m['date'];
			$end_up_time['time'] = $end_up_time_m['time'];
			$end_up_time_t = getLastTouzhuTime($sport);//比赛结束时间跟最后停止投注时间比较，哪个在前用哪个
			if ($end_up_time_t['date']. ' '. $end_up_time_t['time'] < $end_up_time['date']. ' '. $end_up_time['time']) {
				$end_up_time['date'] = $end_up_time_t['date'];
				$end_up_time['time'] = $end_up_time_t['time'];
			}
			$d["date"] = $end_up_time['date'];
			$d['time'] = $end_up_time['time'];
			//排除已经开赛的比赛
			if ($d["date"] . " " . $d["time"] <= getCurrentDate()) {
				$D[$d["id"]]['end'] = 1;//比赛是否结束，由于接口更新不同步导致，部分比赛的状态没有及时更新
				// 				$datas["size"]--;
				// 				//当天比赛都被筛选掉了，需要排除这个日期
				// 				if ($datas['size'] == 0) {
				// 					unset($dates[$k]);
				// 					continue 2;
				// 				}
				// 				continue;
			} else {
				$D[$d["id"]]['end'] = 0;
			}
			$datas["num"]	= substr(show_num($d["num"]),0,-3);
			$D[$d["id"]]['id']	=$d["id"];
			$D[$d["id"]]['num']	=substr($d["num"],1);
			$D[$d["id"]]['date']	=$d["date"];
			$D[$d["id"]]['time']	=$d["time"];
//			$D[$d["id"]]['l_cn']=iconv('gb2312','utf-8',$d["l_cn"]);
//			$D[$d["id"]]['l_color']=color($d["l_id"]);
//			$D[$d["id"]]['h_cn']=iconv('gb2312','utf-8',$d["h_cn"]);
//			$D[$d["id"]]['a_cn']=iconv('gb2312','utf-8',$d["a_cn"]);
			
			$D[$d["id"]]['l_cn']=$d["l_cn"];
			$D[$d["id"]]['h_cn']=$d["h_cn"];
			$D[$d["id"]]['a_cn']=$d["a_cn"];
//			$D[$d["id"]]['l_color']='#'.$d["color"];
			#TODO 颜色问题待解决
			$D[$d["id"]]['l_color']='#FF0033';
			
			
			$cond = array();
			$cond['m_id'] = $d["id"];
			//单关选项
			$objDanguanBetting = new DanguanBetting();
			
			if(substr_count($p,",mnl")){
				// mnl
				$objOdds = new Odds($sport, 'mnl');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					//unset($D[$d["id"]]);
					//continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['mnl']['h'] = $odds["h"];
 					$D[$d["id"]]['mnl']['a'] = $odds["a"];
 				}
			}
			
			if(substr_count($p,",hdc")){
				// hdc
				$objOdds = new Odds($sport, 'hdc');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					unset($D[$d["id"]]);
					continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['hdc']['h'] = $odds["h"];
 					$D[$d["id"]]['hdc']['a'] = $odds["a"];
					$D[$d["id"]]['hdc']['goalline'] = $odds["goalline"];
				}
			}
			if(substr_count($p,",mnl,hdc")){
				$mnl_danguan = $objDanguanBetting->isDanguan('bk', $d["id"], 'mnl');
				//区分让球和非让球
				$D[$d["id"]]['danguan_mnl'] = $mnl_danguan;
				$hdc_danguan = $objDanguanBetting->isDanguan('bk', $d["id"], 'hdc');
				//区分让球和非让球
				$D[$d["id"]]['danguan_hdc'] = $hdc_danguan;
				if ($mnl_danguan||$hdc_danguan) {
					$D[$d["id"]]['danguan'] = true;
				} else {
					$D[$d["id"]]['danguan'] = false;
				}
			}
			if(substr_count($p,",hilo")){
				// hilo
				$objOdds = new Odds($sport, 'hilo');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
					unset($D[$d["id"]]);
					continue;
				}
				foreach ($oddInfos as $odds) {
					$D[$d["id"]]['hilo']['h'] = $odds["h"];
					$D[$d["id"]]['hilo']['l'] = $odds["l"];
					$D[$d["id"]]['hilo']['goalline'] = $odds["goalline"];
				}
				$D[$d["id"]]['danguan'] = $objDanguanBetting->isDanguan('bk', $d["id"], 'hilo');
			}
			if(substr_count($p,",wnm")){
				// wnm
				$objOdds = new Odds($sport, 'wnm');
				$oddInfos = $objOdds->getsByCondition($cond);
				if (!$oddInfos && isset($D[$d["id"]])) {
				    //暂时解决一个bug，wnm停售时混合过关不显示问题
// 					unset($D[$d["id"]]);
// 					continue;
				}
				foreach ($oddInfos as $odds) {
 					$D[$d["id"]]['wnm']['w1'] = $odds["w1"];
					$D[$d["id"]]['wnm']['w2'] = $odds["w2"];
					$D[$d["id"]]['wnm']['w3'] = $odds["w3"];
					$D[$d["id"]]['wnm']['w4'] = $odds["w4"];
					$D[$d["id"]]['wnm']['w5'] = $odds["w5"];
					$D[$d["id"]]['wnm']['w6'] = $odds["w6"]; 
					$D[$d["id"]]['wnm']['l1'] = $odds["l1"];
					$D[$d["id"]]['wnm']['l2'] = $odds["l2"];
					$D[$d["id"]]['wnm']['l3'] = $odds["l3"];
					$D[$d["id"]]['wnm']['l4'] = $odds["l4"];
					$D[$d["id"]]['wnm']['l5'] = $odds["l5"];
					$D[$d["id"]]['wnm']['l6'] = $odds["l6"]; 
 				}
 				$D[$d["id"]]['danguan'] = $objDanguanBetting->isDanguan('bk', $d["id"], 'wnm');
			}
		
		}
		$datas["matchs"][] = $D;
		$str["datas"][] = $datas;	
	}
//	$str=json_encode($str);

//var_dump($str);
	return $str;	
}

/**
 * @desc 北单赛事列表
 * @param string $lotteryId ,SPF
 * @param string $issueNumber
 */
function bd_list($lotteryId, $issueNumber){
	
	$lotteryId = substr($lotteryId, 1);
	$getNewest = false;//是否是取最新一期的比赛
	$objBDIssueInfos = new BDIssueInfos();
	$sport = 'bd';
	
	$today = date("Y-m-d");
	if ($issueNumber == $today) {
		//期数为一个日期时表示取最新一期的比赛
		$condition = array();
		$condition['lotteryId'] = $lotteryId;
		$condition['status'] 	= BDIssueInfos::STATUS_SELLING;
		$tmpResult = $objBDIssueInfos->getsByCondition($condition, 1, 'id desc');
		if (!$tmpResult) {
			#TODO找不到期数时
			$getNewest = false;
		}
		$getNewest = true;
		$result = array_pop($tmpResult);
		$issueNumber = $result['issueNumber'];
	}
	
	if (!$issueNumber) {
		return array("total"=>0);
// 		echo_exit('issueNumber is not find '.$lotteryId);
	}
	
	$total = 0;

	$condition = array();
	$condition['issueNumber'] 	= $issueNumber;
	$condition['lotteryId'] 	= $lotteryId;
	if ($getNewest) {
		//查找最新一期时，只找在售的
		$condition['matchstate'] = BettingBD::MATCH_STATE_SELLING;
	}

	$order = 'date asc , time asc, id asc';
	$dates = $str = array();
	$matchId_date = array();//比赛和日期的对应关系表
	$objBettingBD = new BettingBD();
	$BettingInfos = $objBettingBD->getsByCondition($condition, null, $order);
	//赛事按日期分组：原则-当日10：00 - 次日10：00
	foreach ($BettingInfos as $value) {
		$total++;
		$date = $value['date'];//比赛日期
		$time = $value['time'];//比赛时间
		$today_10 = strtotime($date . ' 10:00:00');//比赛日的10点
		$matchtime_timestamp = strtotime($value['matchtime']);
		
		if ($matchtime_timestamp <= $today_10) {
			//前一天的比赛
			$date = date('Y-m-d', $matchtime_timestamp - 36001);
		} else {
			//当天的比赛
		}
		$matchId_date[$date][] = $value['id'];
		$dates[$date]++;
	}

	foreach($dates as $k => $v){
			
		$datas = array();
		$D = array();

		$datas["day"] = $k;//场次日期
		$datas["size"] = $v;//数量
// 		$datas["w"] = date('N', strtotime($k));
		$datas["w"] = '';//周几数不需要显示
		$condition = array();
		//当前日期下的比赛
		$date_BettingInfos = array();
		foreach ($BettingInfos as $d) {
			if (in_array($d['id'], $matchId_date[$k])) {
				$date_BettingInfos[] = $d;
			}
		}
		//当前日期里所有比赛的sp值
// 		$cond = array();
// 		$cond['issueNumber'] = $issueNumber;
// 		$cond['matchid'] = $matchId_date[$k];
			
		$objOdds = new OddsBD($lotteryId);
// 		$oddInfos = $objOdds->getsByCondition($cond);
		$spFields = $objOdds->getSPFields();//sp值域
		
		foreach ($date_BettingInfos as $d) {
// 			$end_up_time = getMatchEndTime($sport, '', $d["date"], $d["time"]);
			//投注截止时间规则：按照赛程停售时间计算
			$sellouttime = $d['sellouttime'];
			$st = explode(' ', $sellouttime);
			$d["date"] = $st[0];
			$d['time'] = $st[1];
			$datas["num"] = $d["num"];
			$D[$d["id"]]['id'] = $d["id"];
			$D[$d["id"]]['num'] = $d["matchid"];
			$D[$d["id"]]['date'] = $d["date"];
			$D[$d["id"]]['time'] = $d["time"];
			$D[$d["id"]]['name'] = $d["name"];
			$D[$d["id"]]['l_cn'] = $d["l_cn"];
			$D[$d["id"]]['l_color'] = $d['l_color']?$d['l_color']:color($d["name"]);
			$D[$d["id"]]['h_cn'] = $d["hometeam"];
			$D[$d["id"]]['a_cn'] = $d["guestteam"];
			$D[$d["id"]]['goalline'] = $d["remark"];
			
			$cond = array();
			$cond['issueNumber'] = $issueNumber;
			$cond['matchid'] = $d["matchid"];
			
			//判断赛事sp值是否存在
			$sp_exist = false;
			
			$objOdds = new OddsBD($lotteryId);
			$oddInfos = $objOdds->getsByCondition($cond);//该数组中必定只有一个元素
			
			foreach ($oddInfos as $odds) {
				foreach ($spFields as $spField) {
					if ($odds[$spField]) {
						$sp_exist = true;
					}
					$D[$d["id"]][$lotteryId][$spField] = $odds[$spField];
					//$D[$odds["matchid"]]['SPF']['h'] = $odds["h"];
				}
			}
			
			//过滤掉没有sp的赛事，当天赛事都没有时删除整个数组
			if (!$sp_exist) {
				unset($D[$d["id"]]);
				$total--;
				$dates[$k]--;
				if ($dates[$k] == 0) {
					unset($dates[$k]);
				}
			}
		}
		 
		if ($D)	$datas["matchs"][] = $D;
		
		if ($datas["matchs"]) $str["datas"][] = $datas;
	}
	$str["total"] = $total;
	$str["group"] = count($dates);
	return $str;
}
/**
 * 
 * 是否在世界杯期间
 * @param unknown_type $date
 */
function isInWC($date, $time) {
	$date = $date.' '.$time;//比赛开始时间
	if ($date >= '2014-06-13 03:59:59' && $date <= '2014-07-14 03:00:00') {
//		return true;
	}
	return false;
}


/**
 * 此方法改为单纯地判断某场比赛的截止时间
 * 获取比赛的截止投注时间
 * 竞彩赛事提前8分钟，北单提前18分钟
 * @param $sport
 * @param $b_date
 * @param unknown_type $date
 * @param unknown_type $time
 * @return array('date','time');
 */
function getMatchEndTime_tmp($sport, $b_date, $date, $time) {
	
	$new_date = $date;
	$new_time = $time;
	
	$m_timestamp = strtotime($date.' '.$time);//赛事的开赛时间
	
	if ($sport == 'bd') {
		$m_timestamp -= (ZunAoTicketClient::TOUZHU_EARLIER_MINIUTES) * 60;//北单赛事的截止时间为赛前18分钟;
	} else {
		$m_timestamp -= 9 * 60;//提前10分钟
	}
	#去掉每日赛事时间的比较
// 	$end_up = getSportStartEndTime($sport, $b_date);
// 	$end_time = $end_up['end_time'];
	
// 	$d_timestamp = strtotime($end_time);//每天比赛的截止时间
// 	$timestamp = $d_timestamp;
// 	//比较赛事开赛时间和当日投注截止时间哪个在前用哪个
// 	if ($m_timestamp < $d_timestamp) {
// 		$timestamp = $m_timestamp;
// 	}
	
	$timestamp = $m_timestamp;
	$new_date = date('Y-m-d', $timestamp);
	$new_time = date('H:i:s', $timestamp);
	return array('date'=>$new_date, 'time'=>$new_time);
}


/**
 * 此方法改为单纯地判断某场比赛的截止时间
 * 获取比赛的截止投注时间
 * 竞彩赛事提前8分钟，北单提前18分钟
 * @param $sport
 * @param $b_date
 * @param unknown_type $date
 * @param unknown_type $time
 * @return array('date','time');
 */
function getMatchEndTime($sport, $b_date, $date, $time) {
	
	$new_date = $date;
	$new_time = $time;
	
	$m_timestamp = strtotime($date.' '.$time);//赛事的开赛时间
	
	if ($sport == 'bd') {
		$m_timestamp -= (ZunAoTicketClient::TOUZHU_EARLIER_MINIUTES) * 60;//北单赛事的截止时间为赛前18分钟;
	} else {
		$m_timestamp -= 10 * 60;//提前10分钟
	}
	#去掉每日赛事时间的比较
// 	$end_up = getSportStartEndTime($sport, $b_date);
// 	$end_time = $end_up['end_time'];
	
// 	$d_timestamp = strtotime($end_time);//每天比赛的截止时间
// 	$timestamp = $d_timestamp;
// 	//比较赛事开赛时间和当日投注截止时间哪个在前用哪个
// 	if ($m_timestamp < $d_timestamp) {
// 		$timestamp = $m_timestamp;
// 	}
	
	$timestamp = $m_timestamp;
	$new_date = date('Y-m-d', $timestamp);
	$new_time = date('H:i:s', $timestamp);
	return array('date'=>$new_date, 'time'=>$new_time);
}

/**
 * 基本的方法，支持9串1及以下
 * @param unknown $select
 * @param unknown $C
 * @return multitype:
 */
function make_c($select,$C){
  	// 全部组合
	$max="";
	for($i=1;$i<=count($C);$i++){
		$max.="1";
	}
 	// 过关过滤
	$c=array();
	$selects = explode("|",$select);
 	$select = '';
	foreach($selects as $k => $v){
		$select.=substr($v,0,1).",";
	}
	$select=substr($select,0,-1);
	
 	for($i=bindec($max);$i>=1;$i--){
		$value=decbin($i);
		$count=substr_count($value,"1");
		
 		if(!substr_count($select,$count)){
			continue;
		} 
		$zero='';
		if(strlen($value)!=count($C)){
			for($j=count($C);$j>strlen($value);$j--){
				$zero.="0";
			}
			$value=$zero.$value;
		} 
		
  		$new=show_combination($value);
		if(is_array($new)){
			$c=@array_merge($c,$new);
		}
	}
	return $c;
}

// 筛选比赛
function show_combination($value){
	$c=array();
	for($i=0;$i<strlen($value);$i++){
 		if(substr($value,$i,1)==1){
 			$c=make_array($i,$c);
 			if($c==""){
				return;	
			}
 		}	
	}
	return $c;
}

// 复选处理
function make_array($i,$c){
 	global $M;
  	$new=array();
  	if(count($c)>0){
 		foreach($c as $k =>$v){
 			$str=$v;
			for($j=1;$j<=$M[$i]["key"]["count"];$j++){
				if(substr_count($str,$M[$i]["id"])){
					return '';
				}else{
 					$new[] = $str.",".$M[$i]["pool"]."|".$M[$i]["id"]."|".$M[$i]["key"][$j]["value"]."#".$M[$i]["key"][$j]["odds"];
				}
 			}
		}
	}else{
 		for($j=1;$j<=$M[$i]["key"]["count"];$j++){
			$new[$j] = $M[$i]["pool"]."|".$M[$i]["id"]."|".$M[$i]["key"][$j]["value"]."#".$M[$i]["key"][$j]["odds"];
		}
	}
	return $new;
}


function gb2312toU8($str) {
	return ConvertData::gb2312ToUtf8($str);
}

function convertToMoney($str, $isStripSuffixZero = true) {
	return ConvertData::toMoney($str, $isStripSuffixZero);
}

/**
 * 定时送彩金
 * 1.注册送彩金活动，时间区间：2014-05-30 18:00:00 ~ 2014-05-31 18:00:00
 * 2.注册送彩金活动，时间区间：2014-06-06 09:00:00 ~ 2014-06-12 23:59:59
 */
function addGift($u_id, $gift = 10) {
	
	$start_time = '2014-06-06 09:00:00';
	$end_time = '2014-06-12 23:59:59';
	
	$currentDate = getCurrentDate();
	if ($currentDate < $start_time || $currentDate > $end_time) {
		return InternalResultTransfer::fail('时间已过');
	}
	
	$objUserAccountFront = new UserAccountFront();
	$tmpResult = $objUserAccountFront->addGift($u_id, $gift);
	
	if (!$tmpResult->isSuccess()) {
		return $tmpResult;
	}
	
	$userAccountInfo = $objUserAccountFront->get($u_id);
	
	$tableInfo = array();
	$tableInfo['u_id'] 			= $u_id;
	$tableInfo['gift'] 			= $gift;
	$tableInfo['log_type'] 		= BankrollChangeType::ACTIVITY_GIFT;
	$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
	$tableInfo['record_table'] 	= 'user_account';//对应的表
	$tableInfo['record_id'] 	= $u_id;
	$tableInfo['create_time'] 	= $currentDate;
	//添加账户日志
	$objUserGiftLogFront = new UserGiftLogFront();
	$tmpResult = $objUserGiftLogFront->add($tableInfo);
		
	if (!$tmpResult) {
		return InternalResultTransfer::fail('添加账户日志失败');
	}
	
	return InternalResultTransfer::success();
}

/**
 * 充值送彩金的活动集合
 * @param int $u_id
 * @param float $cash
 */
function chargeGift($u_id, $cash) {
	chargeAddGift($u_id, $cash);
	chargeAddScore($u_id, $cash);
}

/**
 * 客户端充值送彩金
活动时间：2014-12-24 20:00——2015-1-1 23:59 （注：以充值成功时间为准）
下载客户端用户首次充值送彩金
凡是聚宝网会员在活动期间充值可得相应购彩金
活动时间内首次充值以下金额可得相应彩金
500——送28
1000——送66
2000——送166
 * @param $cash 单位：元
 * @return InternalResultTransfer
 */
function chargeAddGift($u_id, $cash) {
	
	if (!$cash) {
		return InternalResultTransfer::fail('no gift');
	}
	
	$start_time = '2014-12-24 20:00:00';
	$end_time = '2015-01-01 23:59:59';
	
	$currentDate = getCurrentDate();
	if ($currentDate < $start_time || $currentDate > $end_time) {
		return InternalResultTransfer::fail('时间已过');
	}
	
	if (!preg_match(APP_DOMAIN_MATCH, ROOT_DOMAIN)){
    	return InternalResultTransfer::fail('非客户端充值');
    }
    
	//只给一次彩金
	$objUserGiftLogFront = new UserGiftLogFront();
	$condition = array();
	$condition['u_id'] = $u_id;
	$condition['log_type'] = BankrollChangeType::ACTIVITY_GIFT_CHARGE_2014_SHUANGJIE;
	$result = $objUserGiftLogFront->getsByCondition($condition, 1,'log_id desc');
	
	if ($result) {
		return InternalResultTransfer::fail('已经赠送');
	}
	
	$gift = 0;
	if ($cash == 500) {
		$gift = 28;
	}
	if ($cash == 1000) {
		$gift = 66;
	}
	if ($cash == 2000) {
		$gift = 166;
	}
	if ($gift == 0) {
		return InternalResultTransfer::fail('无法赠送');
	}
	
	$objUserAccountFront = new UserAccountFront();
	$tmpResult = $objUserAccountFront->addGift($u_id, $gift);
	
	if (!$tmpResult->isSuccess()) {
		return $tmpResult;
	}
	
	$userAccountInfo = $objUserAccountFront->get($u_id);
	
	$tableInfo = array();
	$tableInfo['u_id'] 			= $u_id;
	$tableInfo['gift'] 			= $gift;
	$tableInfo['log_type'] 		= BankrollChangeType::ACTIVITY_GIFT_CHARGE_2014_SHUANGJIE;
	$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
	$tableInfo['record_table'] 	= 'user_account';//对应的表
	$tableInfo['record_id'] 	= $u_id;
	$tableInfo['create_time'] 	= $currentDate;
	//添加账户日志
	
	$tmpResult = $objUserGiftLogFront->add($tableInfo);
		
	if (!$tmpResult) {
		return InternalResultTransfer::fail('添加账户日志失败');
	}
	
	return InternalResultTransfer::success();
}

/**
 * 充值送积分
 2015年2月18-2月24日期间充值，可得充值额度10%积分赠送，如充值100元，可得10个积分
 * @param $cash 单位：元
 * @return InternalResultTransfer
 */
function chargeAddScore($u_id, $cash) {

	$start_time = '2015-02-18 00:00:00';
	$end_time = '2015-02-24 23:59:59';

	$currentDate = getCurrentDate();
	if ($currentDate < $start_time || $currentDate > $end_time) {
		return InternalResultTransfer::fail('时间不在活动区间内');
	}

	$type = BankrollChangeType::ACTIVITY_SCORE_CHARGE_2015_CHUNJIE;
	//只给一次彩金
	$objUserScoreLogFront = new UserScoreLogFront();
	$condition = array();
	$condition['u_id'] = $u_id;
	$condition['log_type'] = $type;
	$result = $objUserScoreLogFront->getsByCondition($condition, 1);

	if ($result) {
		return InternalResultTransfer::fail('已经赠送');
	}

	$score = ConvertData::toMoney($cash * 0.1);
	if ($score<0.01) {
		return InternalResultTransfer::fail($score.'不足0.01积分');
	}
	
	$objUserAccountFront = new UserAccountFront();
	$tmpResult = $objUserAccountFront->addScore($u_id, $score);
	if (!$tmpResult->isSuccess()) {
		return $tmpResult;
	}

	$userAccountInfo = $objUserAccountFront->get($u_id);

	$tableInfo = array();
	$tableInfo['u_id'] 			= $u_id;
	$tableInfo['score'] 		= $score;
	$tableInfo['log_type'] 		= $type;
	$tableInfo['old_score'] 	= $userAccountInfo['score'];//原金额
	$tableInfo['record_table'] 	= 'user_account';//对应的表
	$tableInfo['record_id'] 	= $u_id;
	$tableInfo['create_time'] 	= $currentDate;
	//添加账户日志

	$tmpResult = $objUserScoreLogFront->add($tableInfo);

	if (!$tmpResult) {
		return InternalResultTransfer::fail('添加账户日志失败');
	}

	return InternalResultTransfer::success();
}
/**
 * 赢利排行榜
 * 赢利率=中奖金额/出票金额
 * @param $sport 
 * @param $select
 * @param $num 取多少个排名
 * @param $order  
 * @return array()
 */
function getSelectRank($sport, $select = '2x1', $num = 10, $order = 'desc') {
	
	$key = generateMemcachedKey(func_get_args(), 'getRank');
	
	$objZYMemcache = new ZYMemcache();
	$results = $objZYMemcache->get($key);
	
	if ($results) {
		return $results;
	}
	
	$condition = array();
	$condition['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
	$condition['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
	$condition['datetime'] = SqlHelper::addCompareOperator('>=', '2014-06-07 12:00:00');
	$condition['user_select'] = array('2x1');
	$condition['sport'] = $sport;
	
	$objUserMemberFront = new UserMemberFront();
	$objUserTicketAllFront = new UserTicketAllFront();
	$results = $objUserTicketAllFront->getsByCondition($condition);
	$rates = $users = array();
	foreach ($results as $value) {
		//胜率
		$win_prize = $value['prize'] - $value['money'];//利润
		
		if ($win_prize <= 0) continue;
		
		$user = $objUserMemberFront->get($value['u_id']);
		
		$users[$value['u_id']]['u_name'] = $user['u_name'];
		$users[$value['u_id']]['money'] += $value['money'];
		$users[$value['u_id']]['prize'] += $value['prize'];
	}
	$i = 0;
	foreach ($users as &$user) {
		$rate = ceil(($user['prize'] - $user['money'])/$user['money']*100);
		$user['rate'] = $rate;
		$rates[] = $rate;
	}
	
	if ($order == 'desc') {
		$order = SORT_DESC;
	} else {
		$order = SORT_ASC;
	}
	
	array_multisort($rates, $order, $users);
	$final = array();
	foreach ($users as $k=>$value) {
		if ($i == $num) break;
		$final[$k] = $value;
		$i++;
	}
	$objZYMemcache->set($key, $final, 0, 3600);
	return $final;
}

/**
 * 客户端购彩，中奖返彩金
活动时间：2014年12月24日 20:00——2015年1月1日 23:59
在活动期间，聚宝会员通过客户端购彩，中奖者可获得消费返点具体安排如下：
中奖2000元以下，返4%；
中奖2001元—6000元，返5%；
中奖6001以上，返6%
注：返奖为中奖部分加奖，如A用户投注100元，中奖400元，则获得加奖为300元4%，即12元彩金，以此类推。
 * @param int $userTicketId 订单号
 * @param float $prize
 * @return InternalResultTransfer
 */
function prizeAddGift($userTicketId) {
	
	
	$objUserTicketAllFront = new UserTicketAllFront();
	$userTicketInfo = $objUserTicketAllFront->get($userTicketId);
	
	if (!$userTicketInfo) return InternalResultTransfer::fail('userTicket not find');
	
	if ($userTicketInfo['source'] != UserMember::REGISTER_TYPE_APP) {
		return InternalResultTransfer::fail('source wrong');
	}
	if ($userTicketInfo['prize_state'] != UserTicketAll::PRIZE_STATE_WIN) {
		return InternalResultTransfer::fail('not win');
	}
	
	$prize = $userTicketInfo['prize'] - $userTicketInfo['money'];
	
	if ($prize < 0) {
		return InternalResultTransfer::fail('prize not enough');
	}
	
	$u_id = $userTicketInfo['u_id'];
	
	$objUserTicketLog = new UserTicketLog($u_id);
	$last_print_time = '3000-01-01 00:00:00';//最后一张系统票的出票时间
	$orderTickets = $objUserTicketLog->getsByCondition(array('ticket_id'=>$userTicketInfo['id']));
	
	foreach ($orderTickets as $value) {
		if ($last_print_time > $value['datetime']) {
			$last_print_time = $value['datetime'];
		}
	}
	
	$start_time = '2014-12-24 20:00:00';
	$end_time = '2015-01-01 23:59:59';
	
	if ($last_print_time < $start_time || $last_print_time > $end_time) {
		return InternalResultTransfer::fail('时间已过');
	}
	
	//只给一次彩金
	$objUserGiftLogFront = new UserGiftLogFront();
// 	$condition = array();
// 	$condition['u_id'] = $u_id;
// 	$condition['log_type'] = BankrollChangeType::ACTIVITY_GIFT_PRIZE_2014_SHUANGJIE;
// 	$result = $objUserGiftLogFront->getsByCondition($condition, 1);
	
// 	if ($result) {
// 		return InternalResultTransfer::fail('已经赠送');
// 	}
	
	$gift = 0;
	
	if ($userTicketInfo['prize'] <= 2000) {
		$gift = ceil($prize * 0.04);
	} elseif ($userTicketInfo['prize'] <=6000){
		$gift = ceil($prize * 0.05);
	} else {
		$gift = ceil($prize * 0.06);
	}
	
	$objUserAccountFront = new UserAccountFront();
	$tmpResult = $objUserAccountFront->addGift($u_id, $gift);
	
	if (!$tmpResult->isSuccess()) {
		return $tmpResult;
	}
	
	$userAccountInfo = $objUserAccountFront->get($u_id);
	
	$tableInfo = array();
	$tableInfo['u_id'] 			= $u_id;
	$tableInfo['gift'] 			= $gift;
	$tableInfo['log_type'] 		= BankrollChangeType::ACTIVITY_GIFT_PRIZE_2014_SHUANGJIE;
	$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
	$tableInfo['record_table'] 	= 'user_ticket_all';//对应的表
	$tableInfo['record_id'] 	= $userTicketId;
	$tableInfo['create_time'] 	= getCurrentDate();
	//添加账户日志
	$tmpResult = $objUserGiftLogFront->add($tableInfo);
		
	if (!$tmpResult) {
		return InternalResultTransfer::fail('添加账户日志失败');
	}
	
	return InternalResultTransfer::success();
}

/**
 * 获取让球数
 * +1.00；-3.50
 * @param string $goalline
 * @return +1 ;-3.5
 */
function getShortGoalline($goalline) {
	$g = '';
	$g3 = substr($goalline, 0, -3);
	$g1 = substr($goalline, 0, -1);
	if ($g3 != $g1) $g = $g1;
	else $g = $g3;
	return $g;
}

/**
 * 发送用户pms
 */
function sendUserPms($receive_uid, $subject, $body = '') {
	if (!Verify::int($receive_uid)) {
		return  false;
	}
	$tableInfo = array();
	$tableInfo['receive_uid'] 	= $receive_uid;
	$tableInfo['subject'] 			= $subject;
	$tableInfo['body'] 			= $body;
	
	$objUserPMSFront = new UserPMSFront();
	return $objUserPMSFront->addOnePMS($tableInfo);
}

/**
 * 当前用户是否为虚拟投注用户
 * @return boolean
 */
function isVirtualUser() {
	$curUname = Runtime::getUname();
	$objAdminOperate = new AdminOperate();
	$condition = array();
	$condition['type'] = AdminOperate::TYPE_VIRTUAL_USERS;
	$condition['status'] = AdminOperate::STATUS_AVILIBALE;
	$virtual_users_results = $objAdminOperate->getsByCondition($condition);
	foreach ($virtual_users_results as $virtual_users_result) {
		if ($curUname == $virtual_users_result['u_name']) {
			return true;
		} 
	}
	return false;
}

/**
 * 中奖用户发送站内信
 * @param int 中奖用户uid
 * @param string $prize 中奖金额
 * @return int | false
 */
function prizePms($uid, $prize) {
	return sendUserPms($uid, '中奖','尊敬的会员，恭喜您中奖，奖金&yen'.$prize.'元已派送至账户，<a href="'.ROOT_WEBSITE.'/account/user_ticket_log.php">请查收！</a>');
}


/**
 * 获取新的赛事名称
 * @param unknown $info
 */
function changeBDName($info) {
	$info['l_cn'] = '足球';
	//亚运会(足球)
	if (preg_match('/\S+\((\S+)\)/', $info['name'], $matches)) {
		$info['name'] = str_replace('('.$matches[1].')', '', $info['name']);
		$info['l_cn'] = $matches[1];
	}

	return $info;
}

/**
 * 获取l_color
 */
function getLColor($name) {
	if (preg_match('/英超/', $name)) return '#FFFF00';
	if (preg_match('/英冠/', $name)) return '#996699';
	if (preg_match('/英甲/', $name)) return '#99CC66';
	if (preg_match('/英乙/', $name)) return '#CC3333';
	if (preg_match('/意甲/', $name)) return '#333399';
	if (preg_match('/意乙/', $name)) return '#333300';
	if (preg_match('/西甲/', $name)) return '#FF9900';
	if (preg_match('/西乙/', $name)) return '#FFCC00';
	if (preg_match('/法甲/', $name)) return '#CC6600';
	if (preg_match('/法乙/', $name)) return '#99CCFF';
	if (preg_match('/德甲/', $name)) return '#999966';
	if (preg_match('/德乙/', $name)) return '#663300';
	if (preg_match('/葡超/', $name)) return '#FFFF00';
	if (preg_match('/葡甲/', $name)) return '#006633';
	if (preg_match('/苏超/', $name)) return '#333300';
	if (preg_match('/苏冠/', $name)) return '#33CC33';
	if (preg_match('/荷甲/', $name)) return '#CCCC33';
	if (preg_match('/荷乙/', $name)) return '#333366';
	if (preg_match('/比甲/', $name)) return '#99CC33';
	if (preg_match('/瑞典超/', $name)) return '#CCCC33';
	if (preg_match('/瑞典甲/', $name)) return '#339933';
	if (preg_match('/芬超/', $name)) return '#009966';
	if (preg_match('/挪超/', $name)) return '#FFFF00';
	if (preg_match('/挪甲/', $name)) return '#99CC00';
	if (preg_match('/丹超/', $name)) return '#339966';
	if (preg_match('/奥甲/', $name)) return '#9933CC';
	if (preg_match('/奥乙/', $name)) return '#000000';
	if (preg_match('/瑞士超/', $name)) return '#006633';
	if (preg_match('/瑞士甲/', $name)) return '#336666';
	if (preg_match('/爱超/', $name)) return '#993333';
	if (preg_match('/爱甲/', $name)) return '#990033';
	if (preg_match('/北爱超/', $name)) return '#663300';
	if (preg_match('/俄超/', $name)) return '#3F9F3F';
	if (preg_match('/俄甲/', $name)) return '#339999';
	if (preg_match('/波兰甲/', $name)) return '#009999';
	if (preg_match('/乌克兰超/', $name)) return '#003333';
	if (preg_match('/捷克甲/', $name)) return '#996699';
	if (preg_match('/希腊超/', $name)) return '#669999';
	if (preg_match('/罗甲/', $name)) return '#000000';
	if (preg_match('/冰岛超/', $name)) return '#663333';
	if (preg_match('/冰岛甲/', $name)) return '#666666';
	if (preg_match('/欧洲杯/', $name)) return '#003366';
	if (preg_match('/欧冠/', $name)) return '#333333';
	if (preg_match('/欧联/', $name)) return '#FFFF99';
	if (preg_match('/英足总杯/', $name)) return '#003399';
	if (preg_match('/英联杯/', $name)) return '#FF33CC';
	if (preg_match('/意大利杯/', $name)) return '#993333';
	if (preg_match('/德国杯/', $name)) return '#990033';
	if (preg_match('/法国杯/', $name)) return '#CC3399';
	if (preg_match('/法联杯/', $name)) return '#FF0033';
	if (preg_match('/西班牙国王杯/', $name)) return '#66CCCC';
	if (preg_match('/苏足总杯/', $name)) return '#FF9900';
	if (preg_match('/苏联杯/', $name)) return '#FF6666';
	if (preg_match('/葡联杯/', $name)) return '#CC6600';
	if (preg_match('/日职联/', $name)) return '#0099CC';
	if (preg_match('/日职乙/', $name)) return '#FF6666';
	if (preg_match('/天皇杯/', $name)) return '#CC0033';
	if (preg_match('/韩K联/', $name)) return '#990066';
	if (preg_match('/澳超/', $name)) return '#FF9933';
	if (preg_match('/亚洲杯/', $name)) return '#dc0000';
	if (preg_match('/亚冠/', $name)) return '#F00000';
	if (preg_match('/巴西甲/', $name)) return '#CC0033';
	if (preg_match('/巴西乙/', $name)) return '#FF9900';
	if (preg_match('/阿甲/', $name)) return '#663366';
	if (preg_match('/美洲杯/', $name)) return '#003366';
	if (preg_match('/解放者杯/', $name)) return '#99CC00';
	if (preg_match('/南球杯/', $name)) return '#CC3333';
	if (preg_match('/NBA/', $name)) return '#CC9933';
	if (preg_match('/WNBA/', $name)) return '#660033';
	if (preg_match('/欧洲篮球联赛/', $name)) return '#FF6600';
	if (preg_match('/世界杯/', $name)) return '#FF0033';
	if (preg_match('/美冠杯/', $name)) return '#FF0033';
	return '#000000';
}

/**
 * 获取取消的赛事，sp为1，中奖
 * 说明：将来可以做成数据库形式
 * @return array()
 */
function sp_1_match() {
	return array(
			UserTicketAll::SPORT_FOOTBALL => array(
				'65426',//周一002    阿根廷甲级联赛 兵工厂vs阿尔多西维
				'65323',//周五013	欧洲杯预选赛	黑山VS俄罗斯
				'66883',//周六014	英格兰冠军联赛	布莱克浦VS哈德斯菲尔德
				'67342',//周四008	南美解放者杯	博卡青年VS河床
				'69068',//周六004	群马温泉VS岐阜FC
				'69334',//周六071	天主大学VS拉卡莱拉联合
				'71910',//周六097	墨西哥超级联赛 “库利亚坎 VS 韦拉克鲁斯”
				'71883',//周六070 	法国甲级联赛 “尼斯vs南特”
				'71956',//周日044 	葡萄牙超级联赛“马德拉vs本菲卡”
				'72007',//周二003  英格兰锦标赛“布拉德福德 VS 巴恩斯利”
				'72656',//周六090  墨西哥超级联赛“阿特拉斯 VS 瓜达拉哈拉”
				'72772',//周三005 法国联赛杯“阿雅克肖GFCO vs 甘冈”
				'72961',//周六067	马德拉VS波尔图
				'73593',//周六035	法国杯“克维伊 VS 朗斯”
				'73603',//周日008	法国杯 “索肖 VS 斯特拉斯堡” 
				'73659',//周二030	国际赛 “比利时 VS 西班牙”
				'73660',//周二031	国际赛“德国 VS 荷兰”
				'74419',//周六038 凯尔特人VS汉密尔顿
				'74420',//周六039 哈茨VS因弗内斯
				'74422',//周六041 帕尔蒂克VS马瑟韦尔
				'74505',//周日052 智利甲级联赛“圣地亚哥漫步者VS科洛科洛”
				'74705',//周六048 意大利甲级联赛“萨索洛VS都灵”
				'74686',//周六029“布拉德福德VS南安联”
				'74690',//周六033“福利特伍德VS沃尔索尔”
				'74692',//周六035“奥德汉姆VS米尔沃尔”
			),
			UserTicketAll::SPORT_BASKETBALL => array(
				'68787',//周六301	美国女子篮球联盟	印第安纳狂热VS康涅狄格太阳
			),
			UserTicketAll::SPORT_BEIDAN => array(
			),
	);
}

/**
 * 说明：必须是未开奖的系统票
 * 按彩种区分算奖算法，算出用户票奖金；
 * @param array $orderTicket 用户系统票
 * @return InternalResultTransfer 成功：1、未中奖；2、中奖。失败：原因
 */
function manul_prize($orderTicket) {
	
	$objUserTicketAllFront = new UserTicketAllFront();
	$userTicketInfo = $objUserTicketAllFront->get($orderTicket['ticket_id']);
	
	if (!$userTicketInfo) {
		return InternalResultTransfer::fail('用户订单'.$orderTicket['ticket_id'].'未发现'.var_export($orderTicket,true));
	}
	
	//比赛取消的赛事集合，此类比赛的sp均为1，算作中奖
	$sp_1 = sp_1_match();
	
	$u_id = $orderTicket['u_id'];
	$objUserTicketLog = new UserTicketLog($u_id);

	//找出需要返奖的用户票
	//1、查询赛果，所有系统票均有赛果时返奖
	//2、计算奖金，奖金=sp!*倍数*2,注：北单需要再x65%
	//3、添加余额，记录日志
	$manu_prize = 0;
	$equal = 'prize(2x倍数xsp值):';

	$combination = $orderTicket['combination'];//had|55855|h#2.66,hhad|55857|h#2.65
	//是否所有比赛都有赛果
	$m = explode(',', $combination);
	$prize = 2 * $orderTicket['multiple'];//系统票奖金，中奖基数：2*倍数
	$equal .= '2x'.$orderTicket['multiple'].'x';//中奖公式

	if ($orderTicket['sport'] == 'bd') {
		$prize *= 0.65;
		$equal .= $orderTicket['multiple'].'65%x';
	}

	$not_prize = false;//系统票是否未中奖
	foreach ($m as $m1) {
		$m2 = explode('|', $m1);//$m1-had|55855|h#2.66
		$pool = $m2[0];
		$mid = $m2[1];
		$m3 = explode('#', $m2[2]);//$m2[2]-h#2.66
		$sp = $m3[1];
		//让球数
		if ($userTicketInfo['id'] >= 126451) {
			$goalline = getGoallineByOddsV2($userTicketInfo['combination'], $mid, $pool);
		} else {
			$goalline = getGoallineByOdds($userTicketInfo['odds'], $mid, $sp);
		}
		$sport = $orderTicket['sport'];
		//取消的比赛算做中奖
		$match_sp_1 = false;
		
		$objBetting = new Betting($sport);
		$bettingInfo = $objBetting->get($mid);
		
		if ($bettingInfo['status'] == Betting::STATUS_REBACK) {
			$match_sp_1 = true;
			$sp = 1;
		}
		
		$prize *= $sp;//sp值连乘
		$equal .= $sp.'x';
		
		if ($match_sp_1) {
			continue;
		}
		
		//竞彩返奖
		switch ($sport) {
			case 'fb':case 'bk':
				$objPoolResult = new PoolResult($sport);
				$objBetting = new Betting($sport);
				$bettingInfo = $objBetting->get($mid);
				$condition = array();
				$condition['m_id'] = $mid;
				$condition['s_code'] = strtoupper($sport);
				$condition['p_code'] = strtoupper($pool);
				$condition['value'] = '';
				$poolResults = $objPoolResult->getsByCondition($condition);//彩果
				break;
			case 'bd'://北单返奖
				$objPoolResult = new PoolResultBD();
				$objBettingBD = new BettingBD();
				$bettingInfo = $objBettingBD->get($mid);
				$cond = array();
				$cond['lotteryId'] = strtoupper($pool);
				$cond['issueNumber'] = $bettingInfo['issueNumber'];
				$cond['matchid'] = $bettingInfo['matchid'];
				$poolResults = $objPoolResult->getsByCondition($cond);//彩果
				break;
			default:
				return InternalResultTransfer::fail('未知的彩种');
				break;
		}
		//无赛果时中断返奖，确保所有比赛都有赛果
		if (!$poolResults) {
			return InternalResultTransfer::fail('ID:'.$userTicketInfo['id'].';'.$mid.'无赛果，无法返奖');
		}
		//做为返奖依据的彩果
		$poolResult = array();
		//多个赛果时的处理
		if (count($poolResults) >=2 ) {
			foreach ($poolResults as $value) {
				if ($goalline && stripos($value['combination'], $goalline)) {
					$poolResult = $value;
					break;
				}
			}
		} else {
			$poolResult = array_pop($poolResults);
		}
		if (!$poolResult) {
			return InternalResultTransfer::fail('ID:'.$userTicketInfo['id'].';'.$mid.'无准确赛果，无法返奖');
		}
		
		$results = getResults($pool, $poolResult['combination']);
		$user_option = getChineseByPoolCode($pool, $m3[0]);
		if ($results != $user_option) {
			//没中的情况，只要有没中的就不算中奖
			$not_prize = true;
		}
	}	
	$equal = substr($equal, 0, -1) .'=' .$prize;
	
	//未中奖的情况
	if ($not_prize) {
		$orderTicket['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_WIN;
	} else {
		$manu_prize = convertToMoney($prize, false);
		$orderTicket['prize'] = $manu_prize;
		$orderTicket['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
	}
	$orderTicket['print_time'] = getCurrentDate();
	$tempResult = $objUserTicketLog->modify($orderTicket);
	if (!$tempResult->isSuccess()) {
		return InternalResultTransfer::fail('修改系统订单:'.var_export($orderTicket,true).'失败，原因'.$tempResult->getData());
	}
	
	if ($not_prize) {
		return InternalResultTransfer::success('order:'.var_export($orderTicket,true).' 算奖成功:未中奖');
	}
	return InternalResultTransfer::success('order:'.var_export($orderTicket,true).' 算奖成功，中奖:'.$equal);
}

/**
 * 用户票操作
 * @param int $userTicketId
 * @param int $type
 * @return boolean
 */
function userTicketOperateSpeed($userTicketId, $type) {

	if (!$type || !$userTicketId) {
		return false;
	}

	$objUserTicketAllFront = new UserTicketAllFront();
	$userTicketInfo = $objUserTicketAllFront->get($userTicketId);

	if (!$userTicketInfo) {
		return false;
	}

	$info = array();
	$info['user_ticket_id'] = $userTicketId;
	$info['money'] 			= $userTicketInfo['money'];
	$info['datetime'] 		= $userTicketInfo['datetime'];
	$info['type']			= $type;

	$objUserTicketOperate = new UserTicketOperate();
	return $objUserTicketOperate->add($info);
}


function m_select_n($m, $n) {
	$m_n = array(
		'1'	=>	array('1'=> '1x1'),
		'2'	=>	array('1'=> '2x1'),
		'3'	=>	array('1'=> '3x1','3'=> '2x1','4'=> '2x1|3x1',),
		'4'	=>	array('1'=> '4x1','4'=> '3x1','5'=> '3x1|4x1','6'=> '2x1','11'=> '2x1|3x1|4x1',),
		'5'	=>	array('1'=> '5x1','5'=> '4x1','6'=> '4x1|5x1','10'=> '2x1','16'=> '3x1|4x1|5x1','20'=> '2x1|3x1','26'=> '2x1|3x1|4x1|5x1',),
		'6'	=>	array('1'=> '6x1','6'=> '5x1','7'=> '5x1|6x1','15'=> '2x1','20'=> '3x1','22'=> '4x1|5x1|6x1','35'=> '2x1|3x1','42'=> '3x1|4x1|5x1|6x1','50'=> '2x1|3x1|4x1','57'=> '2x1|3x1|4x1|5x1|6x1',),
		'7'	=>	array('1'=> '7x1','7'=> '6x1','8'=> '6x1|7x1','21'=> '5x1','35'=> '5x1','120'=> '2x1|3x1|4x1|5x1|6x1|7x1',),
		'8'	=>	array('1'=> '8x1','8'=> '7x1','9'=> '7x1|8x1','28'=> '6x1','56'=> '6x1','70'=> '4x1','247'=> '2x1|3x1|4x1|5x1|6x1|7x1|8x1',),
		'9'	=>	array('1'=> '9x1'),              
	);
}

/**
 * 理论奖金
 */
function getTheoreticalBonus($sport, $combination, $multiple, $money, $select, $userTicket = array()) {

	switch ($sport) {
		case 'fb': case 'bk':
			$objBetting = new Betting($sport);
			
			$return = $mids = $matchInfos = $spInfos = array();
			$matchs = explode(',', $combination);
			
			foreach($matchs as $k => $v) {
				$match = explode("|", $v);
				$mids[] = $match[1];
				$spInfos[$match[1]] = array();
			}
			$mids = array_unique($mids);
			$matchInfos = $objBetting->gets($mids);
			$hit_num = count($matchInfos);//命中场次最大值
			
			foreach($matchs as $k => $v) {
				$match = explode("|", $v);
				$mid = $match[1];
				$matchInfo = $matchInfos[$mid];
				$matchInfo['l_cn'] = $matchInfo['l_cn'];
				$matchInfo['a_cn'] = $matchInfo['a_cn'];
				$matchInfo['h_cn'] = $matchInfo['h_cn'];
				$matchInfo['num'] = show_num($matchInfo['num']);
			
				$return['matchInfo'][$mid] = $matchInfo;
			
				$return['detail'][$hit_num] = array();
				if ($hit_num != 2 ) $hit_num--;//至少命中两场，单关时为一场
				$spool = $match[0];
				$option = explode("&", $match[2]);
			
				$this_option = array();
				$goalline = array();
				$max_sp = 0;
				$min_sp = 99999;
			
				//赔率
				$cond = $goalline = array();
				$cond['m_id'] = $mid;
				$objOdds = new Odds($sport, $spool);
				$oddInfos = $objOdds->getsByCondition($cond);
				foreach ($oddInfos as $odds) {
					if ($odds["goalline"]) {
						if ($userTicket && $userTicket['id'] >= 126451) {
// 							$goalline_this = getGoallineByOdds($userTicket['odds'], $mid);
							$goalline_this = $match[3];
						} else {
							$goalline_this = $odds["goalline"];
						}
						$goalline[$mid][$spool] = getShortGoalline($goalline_this);
					}
				}
				foreach($option as $k1 => $v1){
					$key = explode("#",$v1);
					$spvalue = $key[1];
					$spInfos[$mid][] = $spvalue;
					// 		if ($spvalue > $max_sp) $max_sp = $spvalue;
					// 		if ($spvalue < $min_sp) $min_sp = $spvalue;
					$user_option = getChineseByPoolCode($match[0], $key[0]);
					if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
					$this_option[] = $user_option."[{$spvalue}]";
				}
				$return['matchInfo'][$mid]['options'] = $this_option;
			}
			
			break;
			
		case 'bd':
			$objBetting = new BettingBD();
			
			$return = $mids = $matchInfos = $spInfos = array();
			$matchs = explode(',', $combination);
			
			foreach($matchs as $k => $v) {
				$match = explode("|", $v);
				$mids[] = $match[1];
				$spInfos[$match[1]] = array();
			}
			$mids = array_unique($mids);
			$matchInfos = $objBetting->gets($mids);
			$hit_num = count($matchInfos);//命中场次最大值
			
			foreach($matchs as $k => $v) {
				$match = explode("|", $v);
				$mid = $match[1];
				$matchInfo = $matchInfos[$mid];
				$matchInfo['l_cn'] = $matchInfo['l_cn'];
				$matchInfo['a_cn'] = $matchInfo['guestteam'];
				$matchInfo['h_cn'] = $matchInfo['hometeam'];
				$matchInfo['num'] = show_num($matchInfo['num']);
			
				$return['matchInfo'][$mid] = $matchInfo;
			
				$return['detail'][$hit_num] = array();
				if ($hit_num != 2 ) $hit_num--;//至少命中两场，单关时为一场
				$spool = $match[0];//玩法
				$option = explode("&", $match[2]);
			
				$this_option = array();
				$goalline = array();
				$max_sp = 0;
				$min_sp = 99999;
			
				//赔率
				$cond = $goalline = array();
				$cond['m_id'] = $mid;
				$objOdds = new OddsBD($spool);
				$oddInfos = $objOdds->getsByCondition($cond);
				foreach ($oddInfos as $odds) {
					if ($odds["remark"]) {
						$goalline[$mid][$spool] = getShortGoalline($odds["goalline"]);
					}
				}
				foreach($option as $k1 => $v1){
					$key = explode("#",$v1);
					$spvalue = $key[1];
					$spInfos[$mid][] = $spvalue;
					// 		if ($spvalue > $max_sp) $max_sp = $spvalue;
					// 		if ($spvalue < $min_sp) $min_sp = $spvalue;
					$user_option = getChineseByPoolCode($match[0], $key[0]);
					if ($goalline[$mid][$match[0]]) $user_option .= '('.$goalline[$mid][$match[0]].')';
					$this_option[] = $user_option."[{$spvalue}]";
				}
				$return['matchInfo'][$mid]['options'] = $this_option;
			}
		break;
	}
	
	foreach ($spInfos as $mid => $spvalues) {
		$tmpSpvalues = $spvalues;
		asort($spvalues);//正序排列，最大值是最后一个
		$max_sp = array_pop($spvalues);
		arsort($tmpSpvalues);//反序排列，最小值是最后一个
		$min_sp = array_pop($tmpSpvalues);
	// 	$return['spInfo'] = $spInfos[$mid];//赔率数组
		$return['spInfo'][$mid]['max_sp'] = $max_sp;
		$return['spInfo'][$mid]['min_sp'] = $min_sp;
		
		$return['spMinInfo'][] = $min_sp;
		$return['spMaxInfo'][] = $max_sp;
	}
	
	$return['sport'] = $sport;
	$return['multiple'] = $multiple;
	$return['money'] = $money;
	$return['select'] = explode('|', $select);
	
	//计算不同命中场次、不同串关的注数
	foreach ($return['detail'] as $key=>$value) {
		$return['detail'][$key]['max_money'] = $return['detail'][$key]['min_money'] = 0;
		//$sel串关方式
		foreach ($return['select'] as $sel) {
	
			//$key为命中场次数
			$this_select = substr($sel, 0, 1);//串数,2x1中的2
			
			if ($key < $this_select) {
				$hit_num = 0;//中奖注数小于串关数
			} else {
				$hit_num = cNM($key, $this_select);
			}
			
			$return['detail'][$key][$sel]['hit_num'] = $hit_num;
				
			$prize_detail_max = $prize_detail_min = array();//中奖明细
				
			$prize_detail_max = getSpArray($return['spMaxInfo'], $key, $this_select);
			$prize_detail_min = getSpArray($return['spMinInfo'], $key, $this_select, false);
	
			$return['detail'][$key][$sel]['prize_detail_max'] = $prize_detail_max;
			$return['detail'][$key][$sel]['prize_detail_min'] = $prize_detail_min;
			//每行之和
			$prize_detail_max_money = $prize_detail_min_money = 0;
				
			foreach ($prize_detail_min as $value) {
				$min_money = 2 * $multiple;
				if ($sport == 'bd') {
					$min_money *= 0.65;//北单需要x65%
				}
				foreach ($value as $v) {
					$min_money *= $v;
				}
				$prize_detail_min_money += convertToMoney($min_money);
				$return['detail'][$key]['min_money'] += convertToMoney($min_money);
			}
				
			foreach ($prize_detail_max as $value) {
				$max_money = 2 * $multiple;
				if ($sport == 'bd') {
					$max_money *= 0.65;//北单需要x65%
				}
				foreach ($value as $v) {
					$max_money *= $v;
				}
				$prize_detail_max_money += convertToMoney($max_money);
				$return['detail'][$key]['max_money'] += convertToMoney($max_money);
			}
			$return['detail'][$key][$sel]['prize_detail_max_money'] = $prize_detail_max_money;
			$return['detail'][$key][$sel]['prize_detail_min_money'] = $prize_detail_min_money;
		}
	}
	//去除中奖注数均为0的场次
	foreach ($return['detail'] as $key=>$value) {
		$is_all_0 = true;
		foreach ($return['select'] as $sel) {
			if ($return['detail'][$key][$sel]['prize_detail_max_money'] && $return['detail'][$key][$sel]['prize_detail_min_money']) {
				$is_all_0 = false;
			}
		}
		if ($is_all_0) {
			unset($return['detail'][$key]);
		}
	}
	return $return;
}

/**
 * 求排列数合的可能 c(n,m) = xx
 * 条件 n>=m
 * @param int $n
 * @param int $m
 * @return $num
 */
function cNM($n, $m) {
	return cJ($n)/(cJ($n- $m)*cJ($m));
}

/**
 * 求阶乘
 * 条件 n>=0
 * @param int $n
 * @return $num
 */
function cJ($n) {
	$r = 1;
	if ($n == 0) return $r;
	for ($i = 1; $i <= $n; $i++) {
		$r *= $i;
	}
	return $r;
}

/**
 * 获取sp值的某种排列组合
 * 例：3场比赛中2x1为3个组合；4场比赛3x1为4个组合；4场比赛2x1为6个组合
 * @param unknown_type $hit_num 3
 * @param unknown_type $sel 2
 * @param unknown_type $sp_array = array(1,2,3)
 * @param boolean $max 是否取最大值，否则取最小值
 * @return array
 */
function getSpArray($sp_array, $hit_num, $sel, $max = true) {
	$return = array();

	//选择命中场次
	if ($max) {
		arsort($sp_array, SORT_NUMERIC);
	} else {
		asort($sp_array, SORT_NUMERIC);
	}
	$sp_array = array_slice($sp_array, 0, $hit_num);

	global $res;
	$res = array();
	combination($sp_array, $sel);

	foreach ($res as $value) {
		$return[] = explode('|', $value);
	}

	return $return;
}

/**
 * 获取排列组合的各种可能
 * @param unknown_type $arr
 * @param unknown_type $len
 * @param unknown_type $str
 */
function combination($arr, $len=0, $str="") {
	global $res;
	$arr_len = count($arr);
	if($len == 0){
		$res[] = $str;
	}else{
		for($i=0; $i<$arr_len-$len+1; $i++){
			$tmp = array_shift($arr);
			//			if ($str) $str .= '|';
			if ($str) combination($arr, $len-1, $str.'|'.$tmp);
			else combination($arr, $len-1, $tmp);
		}
	}
}

/**
 * 取出bom头
 */
function bomDelete($str) {
	$charset[1] = substr($str, 0, 1);
	$charset[2] = substr($str, 1, 1);
	$charset[3] = substr($str, 2, 1);
	if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
		$str = substr($str, 3);
	}
	return $str;
}


/**
 * 比分和彩果的转换,足球
 * @param string $pool had hhad hafu ttg crs
//      had=>竞彩足球_胜平负
//      hhad=>竞彩足球_让球胜平负
//      crs=>竞彩足球_比分
//      ttg=>竞彩足球_总进球
//      hafu=>竞彩足球_半全场
 * @param string $score 最终比分 1:2 主vs客
 * @param string $half_score 半场比分
 * @return string $combination
 */
function scoreToPoolResultFB($pool, $score, $goalline = '', $half_score = '') {
		$combination = '';
    	$match_value_array = explode(':', $score);
    	
    	$home_goal = $match_value_array[0];
    	$guest_goal = $match_value_array[1];
		
    	switch ($pool) {
    		case UserTicketAll::FB_HAD:
    			if ($home_goal > $guest_goal) {
    				$combination = 'h';
    			}
    			if ($home_goal == $guest_goal) {
    				$combination = 'd';
    			}
    			if ($home_goal < $guest_goal) {
    				$combination = 'a';
    			}
    			break;
    		case UserTicketAll::FB_HHAD:
	    		if ($goalline) {
	    			$home_goal += $goalline;
	    		}
    			if ($home_goal > $guest_goal) {
    				$combination = 'h';
    			}
    			if ($home_goal == $guest_goal) {
    				$combination = 'd';
    			}
    			if ($home_goal < $guest_goal) {
    				$combination = 'a';
    			}
    			break;
    		case UserTicketAll::FB_HAFU:
    			$half_match_value_array = explode(':', $half_score);
    			$home_goal_half = $half_match_value_array[0];
    			$guest_goal_half = $half_match_value_array[1];
    			//上半场
    			if ($home_goal_half > $guest_goal_half) {
    				$combination = 'h';
    			}
    			if ($home_goal_half == $guest_goal_half) {
    				$combination = 'd';
    			}
    			if ($home_goal_half < $guest_goal_half) {
    				$combination = 'a';
    			}
    			//全场
    			if ($home_goal > $guest_goal) {
    				$combination .= ':h';
    			}
    			if ($home_goal == $guest_goal) {
    				$combination .= ':d';
    			}
    			if ($home_goal < $guest_goal) {
    				$combination .= ':a';
    			}
    			break;
    		case UserTicketAll::FB_CRS:
    			//"1:0", "2:0", "2:1", "3:0", "3:1", "3:2", "4:0", "4:1", "4:2","胜其他", 
    			if ($home_goal > $guest_goal) {
    				$combination = '-1:-h';
    				if ($home_goal == 1 && $guest_goal == 0) {
    					$combination = '01:00';
    				}
    				if ($home_goal == 2 && $guest_goal == 0) {
    					$combination = '02:00';
    				}
    				if ($home_goal == 2 && $guest_goal == 1) {
    					$combination = '02:01';
    				}
    				if ($home_goal == 3 && $guest_goal == 0) {
    					$combination = '03:00';
    				}
    				if ($home_goal == 3 && $guest_goal == 1) {
    					$combination = '03:01';
    				}
    				if ($home_goal == 3 && $guest_goal == 2) {
    					$combination = '03:02';
    				}
    				if ($home_goal == 4 && $guest_goal == 0) {
    					$combination = '04:00';
    				}
    				if ($home_goal == 4 && $guest_goal == 1) {
    					$combination = '04:01';
    				}
    				if ($home_goal == 4 && $guest_goal == 2) {
    					$combination = '04:02';
    				}
    				if ($home_goal == 5 && $guest_goal == 0) {
    					$combination = '05:00';
    				}
    				if ($home_goal == 5 && $guest_goal == 1) {
    					$combination = '05:01';
    				}
    				if ($home_goal == 5 && $guest_goal == 2) {
    					$combination = '05:02';
    				}
    			}
    			//"0:0", "1:1", "2:2", "3:3", "平其他", 
    			if ($home_goal == $guest_goal) {
    				$combination = '-1:-d';
    				if ($home_goal == 0) {
    					$combination = '00:00';
    				}
    				if ($home_goal == 1) {
    					$combination = '01:01';
    				}
    				if ($home_goal == 2 ) {
    					$combination = '02:02';
    				}
    				if ($home_goal == 3) {
    					$combination = '03:03';
    				}
    			}
    			//"0:1", "0:2", "1:2", "0:3", "1:3", "2:3", "0:4", "1:4", "2:4", "负其他"
    			if ($home_goal < $guest_goal) {
    				$combination = '-1:-a';
    				if ($home_goal == 0 && $guest_goal == 1) {
    					$combination = '00:01';
    				}
    				if ($home_goal == 0 && $guest_goal == 2) {
    					$combination = '00:02';
    				}
    				if ($home_goal == 1 && $guest_goal == 2) {
    					$combination = '01:02';
    				}
    				if ($home_goal == 0 && $guest_goal == 3) {
    					$combination = '00:03';
    				}
    				if ($home_goal == 1 && $guest_goal == 3) {
    					$combination = '01:03';
    				}
    				if ($home_goal == 2 && $guest_goal == 3) {
    					$combination = '02:03';
    				}
    				if ($home_goal == 0 && $guest_goal == 4) {
    					$combination = '00:04';
    				}
    				if ($home_goal == 1 && $guest_goal == 4) {
    					$combination = '01:04';
    				}
    				if ($home_goal == 2 && $guest_goal == 4) {
    					$combination = '02:04';
    				}
    				if ($home_goal == 0 && $guest_goal == 5) {
    					$combination = '00:05';
    				}
    				if ($home_goal == 1 && $guest_goal == 5) {
    					$combination = '01:05';
    				}
    				if ($home_goal == 2 && $guest_goal == 5) {
    					$combination = '02:05';
    				}
    			}	
    			break;
    		case UserTicketAll::FB_TTG:
    			$jsq = $home_goal + $guest_goal;
    			if ($jsq >= 7) {
    				$combination = '7';
    			} else {
    				$combination = $jsq;
    			}
    			break;
    	}
    	return strtoupper($combination . ',' .$goalline);
}

/**
 * 比分和彩果的转换,篮球
 * @param string $pool hdc hilo wnm nml
//      hdc=>篮彩_让分胜负
//      hilo=>篮彩_大小分
//      mnl=>篮彩_胜负
//      wnm=>篮彩_胜分差
 mnl: ["主负", "主胜"],
 mnl: ["h", "a"], 
 hdc: ["让分主负", "让分主胜"], 
 hdc: ["h", "a"], 
 hilo: ["大", "小"],
 hilo: ["h", "l"], 
 wnm: ["客胜1-5", "客胜6-10", "客胜11-15", "客胜16-20", "客胜21-25", "客胜26+", "主胜1-5", "主胜6-10", "主胜11-15", "主胜16-20", "主胜21-25", "主胜26+"] };
 wnm: ["l1", "l2", "l3", "l4", "l5", "l6", "w1", "w2", "w3", "w4", "w5", "w6"]
 * @param string $score 最终比分 100:90 主vs客
 * @return string $combination
 */
function scoreToPoolResultBK($pool, $score, $goalline = '') {
	$combination = '';
    $match_value_array = explode(':', $score);
    	
    $home_goal = $match_value_array[0];
    $guest_goal = $match_value_array[1];
	switch ($pool) {
		case UserTicketAll::BK_HDC:
			$home_goal += $goalline;
			if ($home_goal > $guest_goal) {
				$combination = 'h';
			} else {
				$combination = 'a';
			}
			break;
		case UserTicketAll::BK_HILO:
			if (($home_goal + $guest_goal) > $goalline) {
				$combination = 'h';
			} else {
				$combination = 'l';
			}
			break;
		case UserTicketAll::BK_MNL:
			if ($home_goal > $guest_goal) {
				$combination = 'h';
			} else {
				$combination = 'a';
			}
			break;
		case UserTicketAll::BK_WNM:
			$abs = abs($home_goal - $guest_goal);
			$num = 6;
			switch ($abs) {
				case 1:case 2:case 3:case 4:case 5:
					$num = 1;
					break;
				case 6:case 7:case 8:case 9:case 10:
					$num = 2;
					break;
				case 11:case 12:case 13:case 14:case 15:
					$num = 3;
					break;
				case 16:case 17:case 18:case 19:case 20:
					$num = 4;
					break;
				case 21:case 22:case 23:case 24:case 25:
					$num = 5;
					break;
			}
			if ($home_goal > $guest_goal){
				$combination = '+'.$num;
			} else {
				$combination = '-'.$num;
			}
			break;
	}
	return strtoupper($combination . ',' .$goalline);
}

/**
 * 获取某一个玩法的所有让球数,按出现时间正序排列，即order by id asc
 * 一个玩法在不同时间的让球数不同，需要全部找到方便派奖
 * @param string $sport
 * @param int $matchId 足球或篮球的matchid，且唯一
 * @return 无结果时返回空 array('+1.00','-.2.00') | false
 */
function getAllGoallines($pool, $matchId) {
	$return = array();
	
	switch ($pool) {
		case UserTicketAll::FB_HHAD:
			$objOddsHis = new OddsHis(UserTicketAll::SPORT_FOOTBALL, $pool);
			$return = $objOddsHis->getDistinctGoallines(UserTicketAll::SPORT_FOOTBALL, $pool, $matchId);
			break;
		case UserTicketAll::BK_HILO:
			$objOddsHis = new OddsHis(UserTicketAll::SPORT_BASKETBALL, $pool);
			$return = $objOddsHis->getDistinctGoallines(UserTicketAll::SPORT_BASKETBALL, $pool, $matchId);
			break;
		case UserTicketAll::BK_HDC:
			$objOddsHis = new OddsHis(UserTicketAll::SPORT_BASKETBALL, $pool);
			$return = $objOddsHis->getDistinctGoallines(UserTicketAll::SPORT_BASKETBALL, $pool, $matchId);
			break;
		default:
			return false;
			break;
	}
	return $return;
}

/**
 * 比分主客转换，主要用于页面展示
 * 足球的比分是主vs客，篮球的比分是客vs主
 * @param string $sport
 * @param string $score
 * @return string $new_score
 */
function scoreChange($sport, $score) {
	$new_score = '';
	switch (strtolower($sport)) {
		case UserTicketAll::SPORT_BASKETBALL:
			$s = explode(':', $score);
			$new_score = $s[1].':'.$s[0];
			break;
		default:
			$new_score = $score;
			break;
	}
	return $new_score;
}
?>

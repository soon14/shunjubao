<?php
/**
 * YIC公共函数
 * @author gaoxiaogang@gmail.com
 */

/**
 * 判断是否是整数。
 * 1、支持正、负整数
 * 2、支持字数串表示法。如：'-200'、'125'。
 * 原由：php的is_int方法只能判断数值型变量，纯数字的字符串认为不是整数。但实际应用时，纯数字的字符串需要被当成整数来处理。
 * @author gaoxiaogang@gmail.com
 * @param mixed $str
 * @return boolean
 */
function isInt($str) {
    if (!is_scalar($str) || is_bool($str)) return false;
    return preg_match('#^\-?\d+$#', $str);
}

/**
 * gbk编码转utf8
 * @param string $gbstr
 * @return string
 * @error 没有安装相关的扩展时，返回'SystemError:convert encoding fail!'
 */
function gb2u8($gbstr) {
    if (function_exists('mb_convert_encoding')) {
     return mb_convert_encoding($gbstr, 'utf-8', 'gbk');
    } elseif (function_exists('iconv')) {
        return iconv('gbk', 'utf-8', $gbstr);
    } else
    return 'SystemError:convert encoding fail!';
}

/**
 * utf8编码转gbk
 * @param string $u8str
 * @return string
 * @error 没有安装相关的扩展时，返回'SystemError:convert encoding fail!'
 */
function u82gb($u8str) {
    if (function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($u8str, 'utf-8', 'gbk');
    } elseif (function_exists('iconv')) {
        return iconv('utf-8', 'gbk', $u8str);
    } else
    return 'SystemError:convert encoding fail!';
}

/**
 * 增强型mb_strimwidth()函数,如果 $width 为负，支持向前截取字符
 *
 * @param String $str
 * @param Int $start
 * @param Int $width
 * @param String $trimmarker
 * @param String $encoding
 * @return String
 */
function yoka_mb_strimwidth($str, $start, $width,$trimmarker='',$encoding=null) {
    if(!isset($encoding)) {
        $encoding = mb_internal_encoding();
    }
    if(0 > $width) {//向前截取
        $strBack = mb_substr($str,$start,mb_strlen($str,$encoding),$encoding);
        $iBackWidth = mb_strwidth($strBack,$encoding);
        $strFore = mb_substr($str,0,mb_strlen($str,$encoding)-mb_strlen($strBack,$encoding),$encoding);
        $iForeWidth = mb_strwidth($strFore,$encoding);
        if($iForeWidth <= -$width) {
            return $strFore;
        }
        $iForeWidth_1 = $iForeWidth + $width;
        $strFore_1 = mb_strimwidth($strFore,0,$iForeWidth_1,'',$encoding);
        $strFore_2 = mb_substr($strFore, mb_strlen($strFore_1,$encoding), $iForeWidth, $encoding);
        return $strFore_2;
    } else {
        return mb_strimwidth($str, $start, $width, $trimmarker, $encoding);
    }
}

/**
 * 以给定显示长度截取字符串，如果执行了截取操作，那么在最后加上$dot
 * utf-8 下的字宽 一般来说 一个中文是2 一个英文是 1
 * @author Gxg <gaoxiaogang@Gmail.com>
 * @param String $text
 * @param Int $length
 * @param string $dot
 * @return String
 */
function suitLength($text, $length, $middle = false, $dot = '...', $encoding = 'UTF-8') {
    $iLength = mb_strwidth($text, $encoding);
    if ($iLength < $length) { //要求的宽度咋能超过字符串总宽呢，原样返回
        return $text;
    }
    if ($middle) {
        if (floor($length / 2) < $length / 2) {
            $iLeftLength = floor($length / 2);
            $iRightLength = $iLeftLength + 1;
        } else {
            $iLeftLength = floor($length / 2);
            $iRightLength = $iLeftLength;
        }
        return mb_strimwidth($text, 0, $iLeftLength, '', $encoding) . $dot . yoka_mb_strimwidth($text, mb_strlen($text, $encoding), -$iRightLength, '', $encoding);
    } else {
        return mb_strimwidth($text, 0, $length, $dot, $encoding);
    }
}

/**
 * md5 16位编码算法
 * @param string $str
 * @return string
 */
function md5_16($str) {
    return substr(md5($str), 8, 16);
}

/**
 * md5 20位编码算法
 * 从第一位开始取前20位
 * @param string $str
 * @return string
 */
function md5_20($str) {
    return substr(md5($str), 0, 20);
}

/**
 * 抓取url
 * @param string $url
 * @param int $usleep_time 睡眠微秒数
 * @return false | string
 */
function grab_url($url, $usleep_time = 0) {
	if (!isInt($usleep_time) || $usleep_time < 0) {
		$usleep_time = 0;
	}
    $objCurl = new Curl($url);
    $objCurl->setHeader(1);
    $objCurl->setOptions(
        array(
            'timeout' => 30,
            'connecttimeout'    => 30,
        )
    );
    $result = $objCurl->get();
    if (!preg_match('#HTTP/1\.\d\s(\d+)#', $result, $match, PREG_OFFSET_CAPTURE)) {
    	return false;
    }

	if ($match[0][1] != 0) {
    	return false;
    }

    $status_code = $match[1][0];
    if ($status_code == '200') {
    	$content = substr($result, strpos($result, "\r\n\r\n") + strlen("\r\n\r\n"));

	    if ($usleep_time > 0) {
	    	usleep($usleep_time);
	    }
	    return $content;
    } elseif (in_array($status_code, array('301', '302'))) {
    	if (!preg_match('#Location:\s([^\s]*)#', $result, $match)) {
    		return false;
    	}
    	$true_url = $match[1];
    	return grab_url($true_url, $usleep_time);
    } else {
    	return false;
    }
}


/**
* 将ip转换成整数
* 转换后的值是32位无符号整数，设置数据库字段时请注意
* @param string $Ip
* @return int | false
*/
function ipToInt($ip) {
	$array = @explode('.', $ip);
	if (count($array) != 4) {
	    return false;
	}
	$ipNum = 0;
	$strBin = '';
	foreach ($array as $k => $v) {
	    if ($v > 255) {
	        return false;
	    }
	    $ipNum += $v * pow(2, 8 * (3 - $k));
	}
	return $ipNum;
}

/**
* 将整数值转换成ip
* @param int $ip
* @return string
*/
function intToIp($ipNum) {
	if (!isInt($ipNum) || $ipNum < 0 || $ipNum >= pow(2, 32)) {
		return false;
	}
	$strBin = base_convert($ipNum, 10, 2);
	$strBin = str_repeat('0', 32-strlen($strBin)) . $strBin;
	$arrTmpV = str_split($strBin, 8);
	foreach ($arrTmpV as & $tmpV) {
		$tmpV = base_convert($tmpV, 2, 10);
	}
	$ip = join('.', $arrTmpV);
	return $ip;
}

/**
 * 生成唯一id
 * @param string $prefix
 * @return string
 */
function generateUniqueId($prefix = '') {
	if (!is_string($prefix)) {
		$prefix = '';
	}

	if ($prefix != '') {
		$prefix .= '_';
	}

	return uniqid($prefix . rand());
}

/**
 * 验证邮箱是否正确
 * @param string $email
 * @return true/false
 */
function validEmail($email){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}


/**
 * echo and exit
 */
if (!function_exists('echo_exit')) {
    function echo_exit($str) {
        echo $str;
        exit;
    }
}

/**
 * 对 $info 使用 $securityKey 签名
 *
 * @param array $info
 * @param string $securityKey
 * @return string 签名字串
 */
function sign(array $info, $securityKey) {
    ksort($info);
    $tmpStr = '';
    foreach ($info as $k => $v) {
        if ($v != '' && $k != 'sign') {
            $tmpStr .= "{$k}={$v}&";
        }
    }
    $tmpStr .= "securityKey={$securityKey}";
    return strtolower(sha1($tmpStr));
}

/**
 * 校验签名
 *
 * @param array $info
 * @param string $securityKey
 * @return InternalResultTransfer
 */
function verifySign(array $info, $securityKey) {
	$sign = sign($info, $securityKey);
    if ($sign != $info['sign']) {
    	return InternalResultTransfer::fail("计算后的签名:{$sign} 不等于 待校验的签名:{$info['sign']}");
    }
    if (isset($info['expire'])) {
    	if ($info['expire'] < time()) {
    		return InternalResultTransfer::fail('签名已过期');
    	}
    }

    return InternalResultTransfer::success();
}

/**
 * 拼接url和参数，构造新的url
 * @param string $url 旧的url
 * @param array $args 需附加到url上的请求参数
 * @return string
 */
function jointUrl($url, array $args) {
    $new_url = $url . ((strpos($url, '?') === false) ? '?' : '&') . http_build_query($args);
    return $new_url;
}

/**
 *
 * 发送短消息
 * @param array $mobiles
 * @param string $content
 * @return InternalResultTransfer
 */
function sendMobileMsg(array $mobiles, $content) {
	if (!defined('MOBILE_MSG_SN')) {
		throw new ParamsException('请先定义MOBILE_MSG_SN常量');
	}
	if (!defined('MOBILE_MSG_PWD')) {
		throw new ParamsException('请先定义MOBILE_MSG_PWD常量');
	}
	$objSendMsg = new SendMobileMsg(array(
		'sn'	=> MOBILE_MSG_SN,
		'pwd'	=> MOBILE_MSG_PWD,
	));
	return $objSendMsg->send($mobiles, $content);
}

/**
 *
 * 构造memcached的key
 *
 * 我们对memcache的操作，通常是在方法里进行的，比如 SpecialSaleFront::getsSpecialSale 方法。
 * 这就需要针对不同的调用参数，构造不同的 key，以便区分并正确的从memcached里取到正确的数据。
 * 因此，就有了这个函数。
 * 用法如下：generateMemcachedKey(func_get_args(), $your_prefix);
 *
 * @param array $args
 * @param string $prefix key的前缀
 * @return string
 */
function generateMemcachedKey(array $args, $prefix = '') {
	$key = print_r($args, true);
	$key = Algorithm::md5_16($key);
	if (empty($prefix)) {
		return $key;
	} else {
		return "{$prefix}_{$key}";
	}
}

/**
 *
 * 用于显露的用户名保护(截取后面的字符)
 * @param string $username
 * @return string
 */
function cut_username ($username) {
	$last_char = mb_substr($username, mb_strlen($username, 'utf-8')-1, 1, 'utf-8');
	$len_cut = 1;
	if (0x00 <= ord($last_char) && 0x7f >= ord($last_char)) {//是个ascii码字符
		$last_char = mb_substr($username, mb_strlen($username, 'utf-8')-2, 1, 'utf-8');
		if (0x00 <= ord($last_char) && 0x7f >= ord($last_char)) {//是个ascii码字符
			$len_cut = 2;
		}
	}

	$cuted_username = mb_substr($username, 0, mb_strlen($username, 'utf-8')-$len_cut, 'utf-8');

	return $cuted_username . str_repeat('*', $len_cut);
}

/**
 *
 * 获取用于标识主库写入成功的cookie key
 * # 定义常量，用于标识主数据库有写入操作。值为MASTER_DB_HAS_WRITE md5 16位后的值，避免明文被有心人猜测
 * # 使用场景，MySQLite类执行写入语句成功时，会给该常量为key写一个cookie。当php页面读到该cookie时，会把查询的sql强制走主库
 * @return string
 */
function getCookieKeyForMasterDBHasWrite() {
	if (defined('MASTER_DB_HAS_WRITE')) {
		return MASTER_DB_HAS_WRITE;
	}

	return '17439a6561e7666b';
}

/**
 *
 * 把csv类型的字符串解析成二维数组
 * @param string $csv_content csv字符串
 * @param string $delimiter 字段分隔符，默认为,
 * @param string $enclosure 字段包裹字符
 * @return array
 */
function parse_csv($csv_content, $delimiter = ',', $enclosure='') {
	$db_quote = $enclosure . $enclosure;

	$newline="\n";

	// Clean up file
	$csv_content = trim($csv_content);
	$csv_content = str_replace("\r\n", $newline, $csv_content);

	$csv_content = str_replace($db_quote,'&quot;',$csv_content); // replace double quotes with &quot; HTML entities
	$csv_content = str_replace(',&quot;,',',,',$csv_content); // handle ,"", empty cells correctly

	$csv_content .= $delimiter; // Put a comma on the end, so we parse last cell


	$inquotes = false;
	$start_point = 0;
	$row = 0;

	for($i=0; $i<strlen($csv_content); $i++) {
		$char = $csv_content[$i];
		if ($char == $enclosure) {
			if ($inquotes) {
				$inquotes = false;
			}
			else {
				$inquotes = true;
			}
		}

		if (($char == $delimiter or $char == $newline) and !$inquotes) {
			$cell = substr($csv_content,$start_point,$i-$start_point);
			$cell = str_replace($enclosure,'',$cell); // Remove delimiter quotes
			$cell = str_replace('&quot;',$enclosure,$cell); // Add in data quotes
			$data[$row][] = $cell;
			$start_point = $i + 1;
			if ($char == $newline) {
				$row ++;
			}
		}
	}
	return $data;
}

/**
 *
 * 将数据编码成base64，并使之成为合法的url的一部分
 * @param string $data
 * @return string
 */
function base64url_encode($data) {
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 *
 * base64url_encode的反向函数
 * @param string $data
 * @return string
 */
function base64url_decode($data) {
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

if (!function_exists('ajax_fail_exit')) {
	/**
	 *
	 * 操作失败
	 * ！！如果页面请求的参数里含有 cross_cb，则认为是需要做跨域ajax的支持，跳转到 cross_cb 参数里指定的url
	 * @param string $msg 失败描述
	 */
	function ajax_fail_exit($msg) {
		$return = array(
			'ok'	=> false,
			'msg'	=> $msg,
		);

		# 支持跨域的AJAX POST
		$cross_cb_url = Request::r('cross_cb', Filter::TRIM);
		if ($cross_cb_url) {
			$cross_cb_url = jointUrl($cross_cb_url, array(
				'v'	=> json_encode($return),
			));
			redirect($cross_cb_url);
			exit;
		}

		# 支持跨域的AJAX GET，其实是基于jQuery的$.getJson实现的。之所以把AJAX POST、GET做不同实现，是出于性能和可用性考虑。
		$jsonp_cb = Request::r('jsonp_cb', Filter::TRIM);
		if ($jsonp_cb) {
			$jsonp_cb = Filter::htmlspecialchars($jsonp_cb);// 防止css漏洞
			echo_exit("{$jsonp_cb}(".json_encode($return).")");
		}

		echo_exit(json_encode($return));
	}
}

if (!function_exists('ajax_success_exit')) {
	/**
	 *
	 * 操作成功
	 * ！！如果页面请求的参数里含有 cross_cb，则认为是需要做跨域ajax的支持，跳转到 cross_cb 参数里指定的url
	 * @param string $msg 成功描述
	 */
	function ajax_success_exit($msg) {
		$return = array(
			'ok'	=> true,
			'msg'	=> $msg,
		);

		# 支持跨域的AJAX POST
		$cross_cb_url = Request::r('cross_cb', Filter::TRIM);
		if ($cross_cb_url) {
			$cross_cb_url = jointUrl($cross_cb_url, array(
				'v'	=> json_encode($return),
			));
			redirect($cross_cb_url);
			exit;
		}

		# 支持跨域的AJAX GET，其实是基于jQuery的$.getJson实现的。之所以把AJAX POST、GET做不同实现，是出于性能和可用性考虑。
		$jsonp_cb = Request::r('jsonp_cb', Filter::TRIM);
		if ($jsonp_cb) {
			$jsonp_cb = Filter::htmlspecialchars($jsonp_cb);// 防止css漏洞
			echo_exit("{$jsonp_cb}(".json_encode($return).")");
		}

		echo_exit(json_encode($return));
	}
}

/**
 *
 * 对nginx userid模块输出的uuid做反解。还原成与服务器端日志一致的uuid值。
 * @param string $str
 * @return string
 */
function nginx_uuid_decode($str) {
	$str_unpacked =  unpack('h*', base64_decode(str_replace(' ', '+', $str)));
	$str_split = str_split(current($str_unpacked), 8);
	$str_map = array_map('strrev', $str_split);
	$str_decoded = strtoupper(implode('', $str_map));

	return $str_decoded;
}
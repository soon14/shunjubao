<?php
/**
 * 转换数据类，如将 字符表示的ip转换为整数表示的
 * @author gaoxiaogang@gmail.com
 *
 */
class ConvertData {

	/**
	 * 字型型ip转换为长整型
	 * example：ConvertData::ip2long("59.151.9.90");
	 * @param string $ip
	 * @return int 32位无符号整型
	 */
	static public function ip2long($ip) {
		$array = @explode('.', $ip);
	    if (count($array) != 4) {
	        return false;
	    }
	    $long = 0;
	    $strBin = '';
	    foreach ($array as $k => $v) {
	        if ($v > 255) {
	            return false;
	        }
	        $long += $v * pow(2, 8 * (3 - $k));
	    }
	    return $long;
	}

	/**
	 * 将整数值转换成ip
	 * example：ConvertData::long2ip(999754074)
	 * @param int $long
	 * @return string
	 */
	static public function long2ip($long) {
		if (!isInt($long) || $long < 0 || $long >= pow(2, 32)) {
	        return false;
	    }
	    $strBin = base_convert($long, 10, 2);
	    $strBin = str_repeat('0', 32-strlen($strBin)) . $strBin;
	    $arrTmpV = str_split($strBin, 8);
	    foreach ($arrTmpV as & $tmpV) {
	        $tmpV = base_convert($tmpV, 2, 10);
	    }
	    $ip = join('.', $arrTmpV);
	    return $ip;
	}

	/**
	 * utf8编码转gbk
	 * @param string $u8str
	 * @throws Exception 'SystemError:convert encoding fail!'
	 * @return string
	 */
	static public function u82gb($u8str) {
		if (function_exists('mb_convert_encoding')) {
	        return mb_convert_encoding($u8str, 'gbk', 'utf-8');
	    } elseif (function_exists('iconv')) {
	        return iconv('gbk', 'utf-8', $u8str);
	    } else {
	    	throw new Exception('SystemError:convert encoding fail!');
	    }
	}

	/**
	 * gbk编码转utf8
	 * @param string $gbstr
	 * @throws Exception 'SystemError:convert encoding fail!'
	 * @return string
	 */
	static public function gb2u8($gbstr) {
		if (function_exists('mb_convert_encoding')) {
	        return mb_convert_encoding($gbstr, 'utf-8', 'gbk');
	    } elseif (function_exists('iconv')) {
	        return iconv('gbk', 'utf-8', $gbstr);
	    } else {
	    	throw new Exception('SystemError:convert encoding fail!');
	    }
	}
	
	/**
	 * gbk编码转utf8递归方法
	 * @param string $gbstr
	 * @throws Exception 'SystemError:convert encoding fail!'
	 * @return string
	 */
	static public function gb2312ToUtf8D($info) {
		if (!$info) {
			return $info;
		}
		if (is_string($info)) {
			return ConvertData::gb2312ToUtf8($info);
		} elseif (is_array($info)) {
			foreach ($info as $key=>$value) {
				$info[$key] = ConvertData::gb2312ToUtf8D($value);
			}
			return $info;
		} else {
			return $info;
		}
		
		throw new Exception('SystemError:not support var!'.var_dump($info));
	}
	
	/**
	 * gb2312编码转utf8
	 * @param string $gbstr
	 * @return string
	 */
	static public function gb2312ToUtf8($gbstr) {
		if (function_exists('iconv')) {
	        return iconv('gb2312', 'utf-8', $gbstr);
	    } else {
	    	throw new Exception('SystemError:convert encoding fail!');
	    }
	}
	
	/**
	 * utf8编码转gb2312
	 * @param string $gbstr
	 * @return string
	 */
	static public function utf8ToGb2312($gbstr) {
		if (function_exists('iconv')) {
	        return iconv('utf-8', 'gb2312', $gbstr);
	    } else {
	    	throw new Exception('SystemError:convert encoding fail!');
	    }
	}
		
	/**
	 * 转换为以元为单位的金额表示。即2位小数的浮点数
	 * example：ConvertData::toMoney("19.221");
	 * @param mixed $str
	 * @param Boolean $isStripSuffixZero 是否去掉后缀的0
	 * @return float 2位小数的浮点数
	 */
	static public function toMoney($str, $isStripSuffixZero = true) {
		$money = sprintf('%.2f', $str);
		if ($isStripSuffixZero) {
			$money = str_replace('.00', '', $money);
		}
		return $money;
	}

	/**
	 *
	 * 解密字符串成id
	 * @param string $str
	 * @return false | int
	 */
	static public function decryptStr2Id($str) {
		if (!preg_match('#^([a-j]+)[\x6b-\x7a]([a-j]+)$#', $str, $match)) {
			return false;
		}

		$id_1 = self::char2num($match[1]);
		$id_2 = self::char2num($match[2]);
		$id = $id_2 - $id_1;
		if (!Verify::unsignedInt($id)) {
			return false;
		}
		return $id;
	}

	/**
	 *
	 * 加密id成字符串，用于保护id不被人发现规律
	 * @param int $id
	 * @return false | string
	 */
	static public function encryptId2Str($id) {
		if (!Verify::unsignedInt($id)) {
			return false;
		}
		$id_1 = rand(pow(10, strlen($id)-1), pow(10, strlen($id)));
        $id_2 = $id_1 + $id;
        $dash = chr(rand(0x6b, 0x7a));
		return self::num2char($id_1) . $dash . self::num2char($id_2);
	}

	/**
	 *
	 * 数字转换成对应的字符
	 * @param int $num
	 * @return string
	 */
	static private function num2char($num) {
		$str = '';
        $num = (string) $num;
        for ($i = 0; $i < strlen($num); $i++) {
            $str .= chr($num[$i] + 97);
        }
        return $str;
	}

	/**
	 *
	 * 将字符转换成对应的数字
	 * @param string $str
	 * @return int
	 */
	static private function char2num($str) {
		$num = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $num .= (ord($str[$i]) - 97);
        }
        return $num;
	}
}
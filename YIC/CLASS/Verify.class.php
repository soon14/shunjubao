<?php
/**
 * 封装了一些验证数据的方法
 * @author gaoxiaogang@gmail.com
 *
 */
class Verify {
	/**
	 * 验证 $email 是否有效
	 *
	 * @param string $email
	 * @return Boolean
	 */
    static public function email($email) {
	    return (boolean) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

	/**
	 * 验证是否是整数。
	 * 1、支持正、负整数
	 * 2、支持字数串表示法。如：'-200'、'125'。
	 * 原由：php的is_int方法只能判断数值型变量，纯数字的字符串认为不是整数。但实际应用时，纯数字的字符串需要被当成整数来处理。
	 * @param mixed $str
	 * @return boolean
	 */
	static function int($str) {
	    if (!is_scalar($str)) return false;
	    # 修正bug。否则当$str === true时，该函数返回true：问题出在preg_match函数。
	    if (is_bool($str)) {
	        return false;
	    }
	    return (boolean) preg_match('#^\-?\d+$#', $str);
	}

	/**
	 * 验证是否是正整数。即大于0的整数
	 *
	 * @param mixed $str
	 * @return boolean
	 */
	static function unsignedInt($str) {
        return (self::int($str) && $str > 0);
	}

	/**
	 * 验证是否自然数。即大于等于0的整数
	 *
	 * @param mixed $str
	 * @return boolean
	 */
	static function naturalNumber($str) {
        return (self::int($str) && $str >= 0);
	}

	/**
	 * 验证是否有效的金额。即不超出2位的浮点数
	 * @param float $money
	 * @return boolean
	 */
	static function money($money) {
		return (boolean) preg_match('#^\d+(\.\d{1,2})?$#', $money);
	}

	/**
	 * 验证 $ip 是否有效的ipv4地址
	 * FILTER_FLAG_IPV4 - 要求值是合法的 IPv4 IP（比如 255.255.255.255）
	 * @param string $ip
	 * @return boolean
	 */
	static function ip($ip) {
        return (boolean) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	}

	/**
     * 验证 $ip 是否有效的 公网 ipv4地址
     * FILTER_FLAG_IPV4 - 要求值是合法的 IPv4 IP（比如 255.255.255.255）
     * FILTER_FLAG_NO_PRIV_RANGE - 要求值不是 RFC 指定的私域 IP （比如 192.168.0.90、10.0.0.90）
     * @param string $ip
     * @return boolean
     */
	static function publicIp($ip) {
		return (boolean) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE);
	}

	/**
	 * 验证手机号是否合法
	 * @param string $mobile
	 * @return boolean
	 */
	static function mobile($mobile){
		if (Utilyty::validMobile($mobile)) return true;
		return false;
	}
	
	/** 
	 * 
	 * 检查身份账号的格式是否正确
	  */ 
	static function isValidIDCard($id_card){
		if(strlen($id_card)!=18){ 
			return false; 
		}
		return true;
	} 
	 
}

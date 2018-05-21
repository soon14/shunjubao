<?php
/**
 *
 * cookie处理类
 * @author gaoxiaogang@gmail.com
 *
 */
class TMCookie {

	/**
	 * 封闭cookie的读操作，便于cookie的统一处理
	 *
	 * @param string $key
	 * @return string | Boolean 不存在返回false；存在返回值
	 */
    static public function get($key, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
    	return Request::c($key, $filters);
    }

    /**
     * 包装 php的 setcookie，便于cookie的统一处理
     *
     * @param string $key cookie名
     * @param string $value cookie值
     * @param int $expiration cookie过期的时间。 实际发送的值可以是一个Unix时间戳（自1970年1月1日起至失效时间的整型秒数），或者是一个从现在算起的以秒为单位的数字。
     *            对于后一种情况，这个秒数不能超过60×60×24×30（30天时间的秒数）;如果失效的值大于这个值，会将其作为一个真实的Unix时间戳来处理而不是自当前时间的偏移。
     * @param string $cookie_domain 默认为 DOMAIN常量，如未指定，则为 gaojie.com
     * @param string $cookie_path cookie保存路径，默认为根目录 /
     * @param boolean $secure 是否只能通过https协议访问。默认为false
     * @param boolean $httponly 是否只能通过http协议读取cookie。值为true时，客户端的javascript不能读到该cookie。默认为false。
     * @return boolean
     */
    static public function set($key, $value, $expiration = 0, $cookie_domain = null, $cookie_path = '/', $secure = false, $httponly = false) {
    	if (is_null($cookie_domain)) {
    		if (defined('DOMAIN')) {
    			$cookie_domain = DOMAIN;
    		} else {
    			$cookie_domain = 'gaojie.com';
    		}
    	}
    	if (is_null($cookie_path)) {
    		$cookie_path = '/';
    	}
    	if (is_null($secure)) {
    		$secure = false;
    	}
    	if (is_null($httponly)) {
    		$httponly = false;
    	}
    	# 如果 $expiration 指定的过期时间小于30天，则
    	if ($expiration > 0 && $expiration <= 60*60*24*30) {
    		$expiration += time();
    	}

    	# 设置 $_COOKIE 变量，否则当前进程写完cookie后是无法立即读取到的。
    	$_COOKIE[$key] = $value;
    	return setcookie($key, $value, $expiration, $cookie_path, $cookie_domain, $secure, $httponly);
    }
}

<?php
/**
 * session类控制方法
 */
class Session
{
	static private $_instance = null;

	static public function Init($exprie_time, $path, $domain)
	{
		self::$_instance = new Session();
//		session_set_cookie_params($exprie_time, $path, $domain);
		session_start();
	}

	/**
	 * 
	 * 设置session
	 * @param string $name 字段名
	 * @param mixed $v
	 */
	static public function Set($name, $v) 
	{
		$_SESSION[$name] = $v;
	}

	/**
	 * 
	 * 获取session
	 * @param string $name 字段名
	 * @param boolean $once 是否一次性使用 
	 * @return mix $v
	 */
	static public function Get($name, $once = false)
	{
		$v = null;
		if ( isset($_SESSION[$name]) )
		{
			$v = $_SESSION[$name];
			if ( $once ) unset( $_SESSION[$name] );
		}
		return $v;
	}

	function __construct()
	{
		
	}

	function __destruct()
	{
//		session_destroy();
	}
	
}
?>

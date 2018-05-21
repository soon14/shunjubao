<?php
/**
 * @name Template.class.php
 * @desc 模板操作类
 * @author caoxd
 * @createtime 2008-9-9 03:08
 * @updatetime
 * @usage
 **/
if(!defined('YOKA')) exit('Illegal Request');

include YEPF_PATH . "/CLASS/smarty/Smarty.class.php";

class Template extends Smarty
{
	/**
	 *
	 * 存放要自动注册的 函数 信息
	 * @var array
	 */
	static private $auto_registers = array();

	private $tpl_type ;  //静态文件的类型
	private $directory;  //模板子目录
	public function __construct($directory = '')
	{
		$this->left_delimiter = "<{";
		$this->right_delimiter = "}>";
		$this->directory = $directory;

		foreach (self::$auto_registers as $tmpV) {
			$this->register_function($tmpV['smarty_func'], $tmpV['php_func'], $tmpV['cacheable'], $tmpV['cache_attrs']);
		}
	}

	/**
	 *
	 * 类方法.通知模版引擎自动注册函数
	 * 目的：在使用项目处，方便的自动注册一些全局性的模版函数
	 * @param string $function 注册后,模版使用时的 函数名
	 * @param string $function_impl 要被注册的php函数名
	 * @param boolean $cacheable
	 * @param unknown_type $cache_attrs
	 * @author gxg@gaojie100.com
	 */
	static function auto_register_function($function, $function_impl, $cacheable=true, $cache_attrs=null) {
		self::$auto_registers[] = array(
			'smarty_func'	=> $function,
			'php_func'		=> $function_impl,
			'cacheable'		=> $cacheable,
			'cache_attrs'	=> $cache_attrs,
		);
	}

	/**
	 * @name d
	 * @desc 模板显示
	 **/
	public function d($resource_name, $cache_id = null, $compile_id = null)
	{
		$this->r($resource_name, $cache_id , $compile_id ,true);
	}
	/**
	 * @name r
	 * @desc 将模板值返回
	 **/
	public function r($resource_name, $cache_id = null, $compile_id = null, $display = false)
	{
		global $CFG, $YOKA, $TEMPLATE, $DEFINE ;
		$this->template_dir = getCustomConstants('TEMPLATE_PATH');
		$this->compile_dir = getCustomConstants('COMPILER_PATH');
		$this->tpl_type = getCustomConstants('TEMPLATE_TYPE');
		$this->assign('CFG', $CFG);
		$this->assign('YOKA', $YOKA);
		$this->assign('TEMPLATE', $TEMPLATE);
		$this->assign('DEFINE', $DEFINE);
		$s = $this->fetch($resource_name.".".$this->tpl_type, $cache_id , $compile_id , $display);

//		$s = str_replace('http://test.paycenter.gaojie.com/upload/', 'http://wwwcdn.gaojie1oo.com/upload/', $s);
		return $s;
	}
}

?>
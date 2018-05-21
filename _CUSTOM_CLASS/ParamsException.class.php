<?php
/**
 * 参数异常类
 * @author gaoxiaogang@gmail.com
 *
 */
class ParamsException extends Exception {
	public function __construct ($message = '参数异常', $code = 0) {
		parent::__construct($message, $code);
	}
}
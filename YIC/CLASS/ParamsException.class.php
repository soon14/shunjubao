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

	/**
	 *
	 * 无效的主键id
	 * @var string
	 */
	const INVALID_ID = 'INVALID_ID';

	/**
	 *
	 * 无效的整数
	 * @var string
	 */
	const INVALID_INT = 'INVALID_INT';

	/**
	 *
	 * 获取异常描述
	 * @return array
	 */
	static public function getDesc() {
		return array(
			self::INVALID_ID	=> array(
				'kw'	=> 'INVALID_ID',
				'desc'	=> '无效的主键id',
			),
			self::INVALID_INT	=> array(
				'kw'	=> 'INVALID_INT',
				'desc'	=> '无效的整数',
			),
		);
	}

	/**
	 *
	 * 根据异常的关键词获取文本型的描述
	 * @param string $kw
	 * @return false | string
	 */
	static public function getTextDescByKW($kw) {
		$descs = self::getDesc();
		if (isset($descs[$kw])) {
			return $descs[$kw]['desc'];
		}

		return false;
	}
}
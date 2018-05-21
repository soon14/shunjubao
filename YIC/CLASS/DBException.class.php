<?php
/**
 *
 * 数据库异常类
 * @author gxg
 *
 */
class DBException extends Exception {
	public function __construct ($message = 'DB异常', $code = 0) {
		parent::__construct($message, $code);
	}

	/**
	 *
	 * 未匹配到符合条件的记录
	 * @var string
	 */
	const NOT_MATCH = 'NOT_MATCH';

	/**
	 *
	 * 插入时已存在
	 * @var string
	 */
	const EXIST_ON_INSERT = 'EXIST_ON_INSERT';

	/**
	 *
	 * cas_token 不匹配
	 * @var string
	 */
	const CAS_TOKEN_NOT_MATCH = 'CAS_TOKEN_NOT_MATCH';

	/**
	 *
	 * 提交事务失败
	 * @var string
	 */
	const COMMIT_TRANSACTION_FAIL = 'COMMIT_TRANSACTION_FAIL';

	/**
	 * 
	 * 插入数据库失败
	 * @var string
	 */
	const INSERT_FAIL = 'INSTER_FAIL';
	
	/**
	 *
	 * 获取异常描述
	 * @return array
	 */
	static public function getDesc() {
		return array(
			self::NOT_MATCH	=> array(
				'kw'	=> 'NOT_MATCH',
				'desc'	=> '未匹配到符合条件的记录',
			),
			self::CAS_TOKEN_NOT_MATCH	=> array(
				'kw'	=> 'CAS_TOKEN_NOT_MATCH',
				'desc'	=> 'cas_token不匹配',
			),
			self::COMMIT_TRANSACTION_FAIL 	=> array(
				'kw'	=> 'COMMIT_TRANSACTION_FAIL',
				'desc'	=> '提交事务失败',
			),
			self::INSERT_FAIL 	=> array(
				'kw'	=> 'INSERT_FAIL',
				'desc'	=> '插入数据库失败',
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
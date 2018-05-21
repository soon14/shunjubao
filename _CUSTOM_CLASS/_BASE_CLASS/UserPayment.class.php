<?php
/**
 * 用户支付方式
 * @desc 用户选择自己的支付方式，主要用来给用户提现
 */
class UserPayment extends DBSpeedyPattern {
	protected $tableName = 'user_payment';
	protected $primaryKey = 'id';
	protected $real_field = array(
			'id',
			'u_id',
			'create_time',
			'pay_type',//支付类型：支付宝、财付通
			'pay_account',//接票截止时间
			'default',//是否默认,1为默认，0不是默认
	);
	
	/**
	 * 支付宝
	 */
	CONST PAY_TYPE_ZHIFUBAO = 1;
	
	/**
	 * 财付通
	 */
	CONST PAY_TYPE_CAIFUTONG = 2;
	
	static public function getPayTypeDesc() {
		return array(
				self::PAY_TYPE_ZHIFUBAO => array(
						'desc' => '支付宝',
				),
				self::PAY_TYPE_CAIFUTONG => array(
						'desc' => '财付通',
				),
		);
	}
	
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , $limit, $order);
		return $this->gets($ids);
	}
	
	/**
	 * 默认
	 */
	CONST DEFAULT_PAY_TYPE = 1;
	
	/**
	 * 非默认
	 */
	CONST DEFAULT_PAY_TYPE_NOT = 2;
}
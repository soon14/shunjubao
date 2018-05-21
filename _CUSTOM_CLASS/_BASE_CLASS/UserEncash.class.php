<?php 
class UserEncash extends DBSpeedyPattern {
	protected $tableName = 'user_encash';

	protected $primaryKey = 'encash_id';
	
	protected $real_field = array(
			'encash_id',   	
			'u_id',
			'money',
			'create_time',
			'encash_status',
			'payment',
			'process_message',
			'process_time',
			'process_uid',
			'realname',
			'mobile',
			'bank',
			'bankcard',
			'bank_province',
			'bank_city',
			'bank_branch',
    );
    
   /**
    * 未审核
    */
	const ENCASH_STATUS_UNVERIFY 		= 1;
	/**
    * 审核成功
    */
	const ENCASH_STATUS_VERIFIED 		= 2;
	/**
    * 审核失败
    */
	const ENCASH_STATUS_VERIFY_FAILED 	= 3;
	/**
    * 打款成功
    */
	const ENCASH_STATUS_ENCASH 			= 4;
	/**
    * 打款失败
    */
	const ENCASH_STATUS_ENCASH_FAILED 	= 5;
	/**
    * 提款撤销
    */
	const ENCASH_STATUS_ENCASH_CANCEL = 6;//cancel
	
 	/**
     * 	提款状态	
     */
    static private $EncashStatusDesc = array(
		self::ENCASH_STATUS_UNVERIFY => array(
    		'desc'	=> '未审核',
    		'kw'		=> 'ENCASH_STATUS_UNVERIFY',
    	),
    	self::ENCASH_STATUS_VERIFIED => array(
    		'desc'	=> '审核成功，等待提现',
    		'kw'		=> 'ENCASH_STATUS_VERIFIED',
    	),
    	self::ENCASH_STATUS_VERIFY_FAILED => array(
    		'desc'	=> '审核失败',
    		'kw'		=> 'ENCASH_STATUS_VERIFY_FAILED',
    	),
    	self::ENCASH_STATUS_ENCASH => array(
    		'desc'	=> '打款成功',
    		'kw'		=> 'ENCASH_STATUS_ENCASH',
    	),
    	self::ENCASH_STATUS_ENCASH_FAILED => array(
    		'desc'	=> '打款失败',
    		'kw'		=> 'ENCASH_STATUS_ENCASH_FAILED',
    	),
    	self::ENCASH_STATUS_ENCASH_CANCEL => array(
    		'desc'	=> '提款撤销',
    		'kw'		=> 'ENCASH_STATUS_ENCASH_CANCEL',
    	),
	);

	/**
	 *
	 * 提款状态描述
	 * @var array
	 */
	static public function getEncashStatusDesc() {
		return self::$EncashStatusDesc;
	}
   
	/**
	 * 提现方式
	 * 支付宝
	 */
	CONST PAYMENT_ZHIFUBAO = 1;
	/**
	 * 银行卡
	 */
	CONST PAYMENT_BANK = 2;
	
	static private $EncashPaymentDesc = array(
			self::PAYMENT_ZHIFUBAO => array(
					'desc'	=> '支付宝',
			),
			self::PAYMENT_BANK => array(
					'desc'	=> '银行卡',
			),
	);
	
	static public function getEncashPaymentDesc() {
		return self::$EncashPaymentDesc;
	}
}
?>
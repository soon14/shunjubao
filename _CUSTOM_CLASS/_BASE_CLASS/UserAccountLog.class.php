<?php 
class UserAccountLog extends DBSpeedyPattern {
	protected $tableName = 'user_account_log10';
	protected $primaryKey = 'log_id';

	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
        'log_id',
		'u_id',
		'money',
		'old_money',
		'log_type',
		'record_table',
		'record_id',
		'create_time',
    );
    
	/**
	 * 获取资金变化类型表述
	 * @return array
	 */
	static public function getsBankrollChangeType() {
		$objBankrollChangeType = new BankrollChangeType();
		return $objBankrollChangeType->getChargeTypeDesc();
	}
	
	/**
	 * 支付宝付款 
	 */
	CONST PAY_ALIPAY = 1;
	
	/**
	 * 财富通付款
	 */
	CONST PAY_TENPAY = 2;
	
	/**
	 * 后台管理员添加 
	 */
	CONST MANUAL_BY_ADMIN = 3;
	
    /**
     * 
     * 用户账户记录日志构造函数，表的尾数为用户id的最后一位
     * @param int $last_id
     */
	public function __construct($u_id) {
		//用户在不登陆的情况时仍可进行日志记录，适应情况：支付宝充值异步通知
		$last_id = getUidLastNumber($u_id);
    	$this->tableName = $this->tableName . $last_id;
    	parent::__construct();
    }
}
?>
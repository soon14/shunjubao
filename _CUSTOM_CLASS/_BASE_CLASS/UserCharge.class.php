<?php
/**
 * 
 * 用户充值表，记录充值的过程和结果
 * @author administrator
 *
 */
class UserCharge extends DBSpeedyPattern {
	protected $tableName = 'user_charge';

	protected $primaryKey = 'charge_id';
	
	protected $real_field = array(   	
			'charge_id',		
			'u_id',
			'money',
			'create_time',
			'charge_status',
			'charge_type',
			'charge_source',//充值来源:主站、wap、ios、安桌
			'pay_order_id',
			'return_time',
			'return_code',
			'return_message',
			'provider',//原始渠道
			'bank_type',//银行参数
			'o_uid',//管理员id
			'o_uname',//管理员帐号
			'manu_income',//手动入帐方式
			'manu_desc',//手动入帐备注			
    );
    
	 const CHARGE_manu_income1   	= 1;//客服微信
/*	 const CHARGE_manu_income2 		= 2;//小锋支付宝
	 const CHARGE_manu_income3 		= 3;//贝贝支付宝
	 const CHARGE_manu_income4 		= 4;//小芮支付宝
	 const CHARGE_manu_income5 		= 5;//其它
	 const CHARGE_manu_income6 		= 6;//其它
	 const CHARGE_manu_income7 		= 7;//客服微信2*/
	 const CHARGE_manu_income8 		= 8;//
	 const CHARGE_manu_income9 		= 9;//
	 
	  static private $CHARGE_manu_incomeDesc = array(
		self::CHARGE_manu_income1 => array(
    		'desc'	=> '客服微信',
    		'kw'		=> 'CHARGE_manu_income1',
    	),
		self::CHARGE_manu_income8 => array(
    		'desc'	=> '支付宝',
    		'kw'		=> 'CHARGE_manu_income8',
    	),
		self::CHARGE_manu_income9 => array(
    		'desc'	=> '客服QQ',
    		'kw'	=> 'CHARGE_manu_income9',
    	),
		
	);
	 
	 
	 static public function getCHARGEmanuincomeDesc() {
		return self::$CHARGE_manu_incomeDesc;
	}
	
	/**
	 * 充值中
	 */
    const CHARGE_STATUS_ING 		= 1;
    /**
	 * 充值成功
	 */
    const CHARGE_STATUS_SUCCESS 	= 2;
    /**
	 * 充值失败
	 */
    const CHARGE_STATUS_FAILED 		= 3;
    /**
	 * 活动充值
	 */
    const CHARGE_STATUS_ACTIVITY 	= 4;

    static private $ChargeStatusDesc = array(
		self::CHARGE_STATUS_ING => array(
    		'desc'	=> '充值中',
    		'kw'		=> 'CHARGE_STATUS_ING',
    	),
    	self::CHARGE_STATUS_SUCCESS => array(
    		'desc'	=> '充值成功',
    		'kw'		=> 'CHARGE_STATUS_SUCCESS',
    	),
    	self::CHARGE_STATUS_FAILED => array(
    		'desc'	=> '充值失败',
    		'kw'		=> 'CHARGE_STATUS_FAILED',
    	),
    	self::CHARGE_STATUS_ACTIVITY => array(
    		'desc'	=> '活动充值',
    		'kw'		=> 'CHARGE_STATUS_ACTIVITY',
    	),
	);

	/**
	 *
	 * 充值状态描述
	 * @var array
	 */
	static public function getChargeStatusDesc() {
		return self::$ChargeStatusDesc;
	}
	
	const CHARGE_TYPE_ALIPAY 		= 1;
    const CHARGE_TYPE_MANUAL 		= 2;
	const CHARGE_TYPE_TENPAY 		= 3;
	const CHARGE_TYPE_WEIXIN 		= 4;
	const CHARGE_TYPE_YEEPAY 		= 5;
	const CHARGE_TYPE_ALIPAY_QR     = 6;
	const CHARGE_TYPE_ONLINE_BANK     = 7;//在线网银行
	
	
    static private $ChargeTypesDesc = array(
		self::CHARGE_TYPE_ALIPAY => array(
    		'desc'	=> '支付宝',
    		'kw'		=> 'CHARGE_TYPE_ALIPAY',
    	),
    	self::CHARGE_TYPE_MANUAL => array(
    		'desc'	=> '手工充值',
    		'kw'		=> 'CHARGE_TYPE_MANUAL',
    	),
    	self::CHARGE_TYPE_TENPAY => array(
    		'desc'	=> '财付通充值',
    		'kw'		=> 'CHARGE_TYPE_TENPAY',
    	),
    	self::CHARGE_TYPE_WEIXIN => array(
    		'desc'	=> '微信充值',
    		'kw'		=> 'CHARGE_TYPE_WEIXIN',
    	),
    	self::CHARGE_TYPE_YEEPAY => array(
    		'desc'	=> '易宝充值',
    		'kw'		=> 'CHARGE_TYPE_YEEPAY',
    	),	
    	self::CHARGE_TYPE_ALIPAY_QR => array(
    		'desc'	=> '支付宝扫码',
    		'kw'		=> 'CHARGE_TYPE_ALIPAY_QR',
    	),
		self::CHARGE_TYPE_ONLINE_BANK => array(
    		'desc'	=> '在线网银',
    		'kw'		=> 'CHARGE_TYPE_ONLINE_BANK',
    	),				
	);

	/**
	 * 充值类型描述
	 * @var array
	 */
	static public function getChargeTypeDesc() {
		return self::$ChargeTypesDesc;
	}
	
	
	public function getTotalByCondition($start_time, $end_time, $charge_status, $charge_type, $u_id,$return_message,$o_uname,$manu_income) {
		if ($start_time) {
			$wheres .= " and create_time >='".$start_time."'";
		}

		if ($end_time) {
			$wheres .= " and create_time <='".$end_time."'";
		}
		
		if ($u_id) {
			$wheres .= " and u_id ='".$u_id."'";
		}
		
		if ($charge_status) {
			$wheres .= " and charge_status ='".$charge_status."'";
		}

		if ($charge_type) {
			$wheres .= " and charge_type ='".$charge_type."'";
		}
		
		if ($return_message) {
			$wheres .= " and return_message ='".$return_message."'";
		}
		
		if ($o_uname) {
			$wheres .= " and o_uname ='".$o_uname."'";
		}
		if ($manu_income) {
			$wheres .= " and manu_income ='".$manu_income."'";
		}
		
	
		 $sql = " select sum(`money`) as total_money  from  user_charge where  1 ".$wheres;
		
		$results = $this->db->fetchOne($sql);
		return $results["total_money"];

	}
	
	

}
?>
<?php
/**
 * 
 * 资金变化类型表
 * @author Administrator
 *
 */
class BankrollChangeType extends DBSpeedyPattern {
	
	protected $tableName = 'bankroll_change_type';
	
	protected $primaryKey = 'type_id';
	
	protected $real_field = array(   	
    		'type_message',
    		'type_id'
    );
    
    /**
     *	1 充值
     */
    CONST CHARGE 			= 1;
    /**
     * 2 充值退款
     */
    CONST CHARGE_REFUND 	= 2;
    /**
     * 3 购彩扣款
     */
    CONST BUY 				= 3;
    /**
     * 4 购彩退款
     */
    CONST BUY_REFUND 		= 4;
    /**
     * 5 提现扣款，有专门的表记录，已不用
     */
    CONST ENCASH 			= 5;
    /**
     * 6 提现退款
     */
    CONST ENCASH_REFUND 	= 6;
    /**
     * 7 派奖
     */
    CONST PAIJIANG 			= 7;
    /**
     * 8 派发返点,已经不用
     */
    CONST REBATE 			= 8;
    /**
     * 9 返点兑换
     */
    CONST REBATE_TO_ACCOUNT = 9;
    /**
     *	后台充值余额
     */
    CONST ADMIN_CHARGE 		= 10;
    
    /**
     *	冻结资金
     */
    CONST CASH_TO_FROZEN 	= 12;
    /**
     *	资金解冻
     */
    CONST FROZEN_TO_CASH	= 13;
    /**
     *	赠送彩金
     */
    CONST GIFT_TO_ACCOUNT	= 14;   
    /**
     *	后台充值彩金
     */
    CONST ADMIN_GIFT		= 15; 
    /**
     *	彩金消费
     */
    CONST GIFT_CONSUME		= 16; 
    
    /**
     *	活动赠送彩金
     */
    CONST ACTIVITY_GIFT		= 17;
     
    /**
     *	活动赠送彩金之充值
     */
    CONST ACTIVITY_GIFT_CHARGE	= 18;
    
    /**
     *	世界杯期间充值赠送彩金
     */
    CONST ACTIVITY_GIFT_CHARGE_WORLDCUP	= 19;
    
    /**
     *	世界杯期间加奖赠送彩金
     */
    CONST ACTIVITY_GIFT_PRIZE_WORLDCUP	= 20;
    
    /**
     *	活动赠送彩金之双“十一”充值
     */
    CONST ACTIVITY_GIFT_CHARGE_SHUANGSHIYI	= 21;
    
    /**
    *	订阅扣费
    */
    CONST DINGYUE	= 22;
    
    /**
     *	活动赠送彩金之双“十二”加奖
     */
    CONST ACTIVITY_GIFT_PRIZE_SHUANGSHIER	= 23;
    
    /**
     *	活动赠送彩金之2014年双节加奖
     */
    CONST ACTIVITY_GIFT_PRIZE_2014_SHUANGJIE	= 24;
    
    /**
     *	活动赠送彩金之2014双节充值
     */
    CONST ACTIVITY_GIFT_CHARGE_2014_SHUANGJIE	= 25;
    
    /**
     * 2015年春节充值赠送积分活动
     */
    CONST ACTIVITY_SCORE_CHARGE_2015_CHUNJIE = 26;
    
    /**
     * 虚拟比赛积分投注扣款
     */
    CONST SCORE_TOUZHU = 27;
    
    /**
     * 虚拟比赛积分派奖
     */
    CONST SCORE_PAIJIANG = 28;
    
    /**
     * 登录送积分
     */
    CONST SCORE_LOGIN = 29;
    
    /**
     * 推广用户赠送彩金
     */
    CONST GIFT_TUIGUANG = 30;
    
    /**
     * 积分扣除，兑换彩金
     */
    CONST SOCRE_TRANTO_GIFT = 31;
    
    /**
     * 后台赠送积分
     */
    CONST ADMIN_CHARGE_SCORE = 32;
    
    /**
     * 彩金扣除，兑换积分
     */
    CONST GIFT_TRANTO_SOCRE = 33;
    
    /**
     *	赠送积分
     */
    CONST SCORE_TO_ACCOUNT	= 34;
    
    /**
     * 第三方 圈子消费金额
     */
    CONST CASH_API_CONSUME = 35;
    
    /**
     * 第三方 圈子消费积分
     */
    CONST SCORE_API_CONSUME = 36;
    
    /**
     * 第三方 打赏消费金额
     */
    CONST CASH_API_CONSUME_DASHANG = 37;
    /**
     * 第三方 打赏增加金额
     */
    CONST CASH_API_ADD_DASHANG = 38;
    
    /**
     * 第三方 打赏消费积分
     */
    CONST SCORE_API_CONSUME_DASHANG = 39;
    /**
     * 第三方 打赏增加积分
     */
    CONST SCORE_API_ADD_DASHANG = 40;
    /**
     * 众筹项目扣款
     */
    CONST CASH_API_CONSUME_ZC = 41;
    /**
     * 众筹项目分红
     */
    CONST CASH_API_ADD_ZC = 42;
	
	
	 /**
     * 大乐透扣款
     */
    CONST CASH_API_CONSUME_DLT = 43;
	
	 /**
     * 投注送积分 
     */
    CONST  GIFT_API_BET = 44;
	
	
	 /**
     * 大乐透退款
     */
    CONST CASH_API_DLT_REFUND = 45;
	
	
	
	 /**
     * 系统扣款，由于各种错误需要手动扣款
     */
    CONST CASH_CONSUME_CUT = 46;
	CONST GIFT_CONSUME_CUT = 47;
	CONST SCORE_CONSUME_CUT = 48;
	
	CONST CASH_TO_GIFT = 49;//余额换积分
	
	/*
	     * 分成扣款
     */
    CONST FOLLOW_CASH_CONSUME = 50;
    /**
     * 分成收入
     */
    CONST FOLLOW_CASH_ADD = 51;
	
	
	/*
	     * 分成扣款
     */
    CONST TIPS_CASH_CONSUME = 52;
    /**
     * 分成收入
     */
    CONST TIPS_CASH_ADD = 53;
	
    /**
     * 资金流向
     * @var int
     */
    CONST ACCOUNT_DIRECTION_IN 	= 1;//收入
    CONST ACCOUNT_DIRECTION_OUT	= 2;//支出
     
    static private $ChargeTypesDesc = array(
			self::CASH_API_DLT_REFUND => array(
    				'desc'	=> '大乐透退款',
    				'kw'	=> 'CASH_API_DLT_REFUND',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::CASH_API_CONSUME_DLT => array(
    				'desc'	=> '大乐透扣款',
    				'kw'	=> 'CASH_API_CONSUME_DLT',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
			self::CASH_API_CONSUME_ZC => array(
    				'desc'	=> '众筹项目扣款',
    				'kw'	=> 'CASH_API_CONSUME_ZC',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::CASH_API_ADD_ZC => array(
    				'desc'	=> '众筹项目分红',
    				'kw'	=> 'CASH_API_ADD_ZC',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::CASH_API_CONSUME_DASHANG => array(
    				'desc'	=> '打赏消费金额',
    				'kw'	=> 'CASH_API_CONSUME_DASHANG',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::CASH_API_ADD_DASHANG => array(
    				'desc'	=> '打赏增加金额',
    				'kw'	=> 'CASH_API_ADD_DASHANG',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::SCORE_API_CONSUME_DASHANG => array(
    				'desc'	=> '打赏消费积分',
    				'kw'	=> 'SCORE_API_CONSUME_DASHANG',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::SCORE_API_ADD_DASHANG => array(
    				'desc'	=> '打赏增加积分',
    				'kw'	=> 'SCORE_API_ADD_DASHANG',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::SCORE_API_CONSUME => array(
    				'desc'	=> '圈子消费积分',
    				'kw'	=> 'SCORE_API_CONSUME',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::CASH_API_CONSUME => array(
    				'desc'	=> '圈子消费金额',
    				'kw'	=> 'CASH_API_CONSUME',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::SCORE_TO_ACCOUNT => array(
    				'desc'	=> '赠送积分',
    				'kw'	=> 'SCORE_TO_ACCOUNT',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::GIFT_TRANTO_SOCRE => array(
    				'desc'	=> '彩金扣除，兑换积分',
    				'kw'	=> 'GIFT_TRANTO_SOCRE',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::ADMIN_CHARGE_SCORE => array(
    				'desc'	=> '后台赠送积分',
    				'kw'	=> 'ADMIN_CHARGE_SCORE',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::SOCRE_TRANTO_GIFT => array(
    				'desc'	=> '积分扣除，兑换彩金',
    				'kw'	=> 'SOCRE_TRANTO_GIFT',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::GIFT_TUIGUANG => array(
    				'desc'	=> '推广用户赠送彩金',
    				'kw'	=> 'GIFT_TUIGUANG',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::SCORE_LOGIN => array(
    				'desc'	=> '登录送积分',
    				'kw'	=> 'SCORE_LOGIN',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::SCORE_PAIJIANG => array(
    				'desc'	=> '运营比赛积分派奖',
    				'kw'	=> 'SCORE_PAIJIANG',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
    		self::SCORE_TOUZHU => array(
    				'desc'	=> '虚拟比赛积分投注扣款',
    				'kw'	=> 'SCORE_TOUZHU',
    				'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    		),
    		self::ACTIVITY_SCORE_CHARGE_2015_CHUNJIE => array(
    				'desc'	=> '2015年春节充值赠送积分活动',
    				'kw'	=> 'ACTIVITY_SCORE_CHARGE_2015_CHUNJIE',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),self::GIFT_API_BET => array(
    				'desc'	=> '投注送积分',
    				'kw'	=> 'GIFT_API_BET',
    				'direction'	=> self::ACCOUNT_DIRECTION_IN,
    		),
			
		self::CHARGE => array(
    		'desc'	=> '用户充值',
    		'kw'	=> 'CHARGE',
			'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::CHARGE_REFUND => array(
    		'desc'	=> '充值退款',
    		'kw'		=> 'CHARGE_REFUND',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::BUY => array(
    		'desc'	=> '购彩扣款',
    		'kw'		=> 'BUY',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
    	self::BUY_REFUND => array(
    		'desc'	=> '购彩退款',
    		'kw'		=> 'BUY_REFUND',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ENCASH => array(
    		'desc'	=> '提现扣款',
    		'kw'		=> 'ENCASH',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
    	self::ENCASH_REFUND => array(
    		'desc'	=> '提现退款',
    		'kw'		=> 'ENCASH_REFUND',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::PAIJIANG => array(
    		'desc'	=> '派奖',
    		'kw'		=> 'PAIJIANG',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::REBATE => array(
    		'desc'	=> '派发返点',
    		'kw'		=> 'REBATE',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::REBATE_TO_ACCOUNT => array(
    		'desc'	=> '返点兑换',
    		'kw'		=> 'REBATE_TO_ACCOUNT',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ADMIN_CHARGE => array(
    		'desc'	=> '后台充值',
    		'kw'		=> 'ADMIN_CHARGE',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::CASH_TO_FROZEN => array(
    		'desc'	=> '冻结资金',
    		'kw'		=> 'CASH_TO_FROZEN',
   		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
    	self::FROZEN_TO_CASH => array(
    		'desc'	=> '资金解冻',
    		'kw'		=> 'FROZEN_TO_CASH',
   		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::GIFT_TO_ACCOUNT => array(
    		'desc'	=> '赠送彩金',
    		'kw'		=> 'GIFT_TO_ACCOUNT',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ADMIN_GIFT => array(
    		'desc'	=> '后台充值彩金',
    		'kw'		=> 'ADMIN_GIFT',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::GIFT_CONSUME => array(
    		'desc'	=> '彩金消费',
    		'kw'		=> 'GIFT_CONSUME',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
    	self::ACTIVITY_GIFT => array(
    		'desc'	=> '活动赠送彩金',
    		'kw'		=> 'ACTIVITY_GIFT',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ACTIVITY_GIFT_CHARGE => array(
    		'desc'	=> '充值赠送彩金',
    		'kw'		=> 'ACTIVITY_GIFT_CHARGE',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ACTIVITY_GIFT_CHARGE_SHUANGSHIYI => array(
    			'desc'	=> '双“十一”充值赠送彩金活动',
    			'kw'		=> 'ACTIVITY_GIFT_CHARGE_SHUANGSHIYI',
    			'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ACTIVITY_GIFT_CHARGE_WORLDCUP => array(
    		'desc'	=> '世界杯期间充值赠送彩金',
    		'kw'		=> 'ACTIVITY_GIFT_CHARGE_WORLDCUP',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ACTIVITY_GIFT_PRIZE_WORLDCUP => array(
    		'desc'	=> '世界杯期间加奖赠送彩金',
    		'kw'		=> 'ACTIVITY_GIFT_PRIZE_WORLDCUP',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::DINGYUE => array(
    		'desc'	=> '订阅扣费',
    		'kw'	=> 'DINGYUE',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
    	self::ACTIVITY_GIFT_PRIZE_SHUANGSHIER => array(
    		'desc'	=> '活动赠送彩金之双“十二”加奖',
    		'kw'	=> 'ACTIVITY_GIFT_PRIZE_SHUANGSHIER',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ACTIVITY_GIFT_PRIZE_2014_SHUANGJIE => array(
    		'desc'	=> '活动赠送彩金之2014年双节加奖',
    		'kw'	=> 'ACTIVITY_GIFT_PRIZE_2014_SHUANGJIE',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
    	self::ACTIVITY_GIFT_CHARGE_2014_SHUANGJIE => array(
    		'desc'	=> '活动赠送彩金之2014双节充值',
    		'kw'	=> 'ACTIVITY_GIFT_CHARGE_2014_SHUANGJIE',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
		self::CASH_CONSUME_CUT => array(
    		'desc'	=> '后台扣款',
    		'kw'		=> 'CASH_CONSUME_CUT',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
		self::GIFT_CONSUME_CUT => array(
    		'desc'	=> '后台彩金扣除',
    		'kw'		=> 'GIFT_CONSUME_CUT',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
		self::SCORE_CONSUME_CUT => array(
    		'desc'	=> '后台积分扣除',
    		'kw'		=> 'SCORE_CONSUME_CUT',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
		self::CASH_TO_GIFT => array(
    		'desc'	=> '余额扣除，兑换积分',
    		'kw'		=> 'CASH_TO_GIFT',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
		self::FOLLOW_CASH_CONSUME => array(
    		'desc'	=> '分成扣款',
    		'kw'		=> 'FOLLOW_CASH_CONSUME',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
		self::FOLLOW_CASH_ADD => array(
    		'desc'	=> '分成收入',
    		'kw'		=> 'FOLLOW_CASH_ADD',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
		self::TIPS_CASH_CONSUME => array(
    		'desc'	=> '跟单打赏扣款',
    		'kw'		=> 'TIPS_CASH_CONSUME',
    		'direction'	=> self::ACCOUNT_DIRECTION_OUT,
    	),
		self::TIPS_CASH_ADD => array(
    		'desc'	=> '跟单打赏收入',
    		'kw'		=> 'TIPS_CASH_ADD',
    		'direction'	=> self::ACCOUNT_DIRECTION_IN,
    	),
	);
	

	/**
	 * 充值类型描述
	 * @var array
	 */
	public function getChargeTypeDesc() {
		return self::$ChargeTypesDesc;
	}
	  
}
?>
<?php
/**
 * 用户接触任务类
 * 用于列出需要每天完成的与外站绑定用户（新浪微博等）的接触任务
 * @author gaoxiaogang@gmail.com
 *
 */
class TouchTask extends DBSpeedyPattern {
	protected $tableName = 'touch_task';

	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $other_field = array(
	    'type',
		'user_type',
		'uid',
		'connect_uid',
		'status',
	);


	/**
	 *
	 * 类型之有新的代金券
	 * @var int
	 */
	const TYPE_NEW_COUPON = 100;

	/**
	 *
	 * 类型之：代金券将过期
	 * @var int
	 */
	const TYPE_COUPON_WILL_EXPIRE = 200;


	/**
	 *
	 * 类型之：通知晒单
	 * @var int
	 */
	const TYPE_NOTICE_SUN_ORDER = 300;

	/**
	 *
	 * 类型之：催单
	 * @var int
	 */
	const TYPE_REMINDER = 400;

	/**
	 *
	 * 类型之：生日
	 * @var int
	 */
	const TYPE_BIRTHDAY = 500;

	/**
	 *
	 * 类型之：成为VIP
	 * @var int
	 */
	const TYPE_BECOME_VIP = 600;


	private static $typeDesc = array(
		self::TYPE_NEW_COUPON => array(
    		'desc'	=> '有新的代金券',
    		'kw'		=> 'TYPE_NEW_COUPON',
    	),
    	self::TYPE_COUPON_WILL_EXPIRE => array(
    		'desc'	=> '代金券将过期',
    		'kw'		=> 'TYPE_COUPON_WILL_EXPIRE',
    	),
    	self::TYPE_NOTICE_SUN_ORDER => array(
    		'desc'	=> '通知晒单',
    		'kw'		=> 'TYPE_NOTICE_SUN_ORDER',
    	),
    	self::TYPE_REMINDER => array(
    		'desc'	=> '催单',
    		'kw'		=> 'TYPE_REMINDER',
    	),
    	self::TYPE_BIRTHDAY => array(
    		'desc'	=> '生日提醒',
    		'kw'		=> 'TYPE_BIRTHDAY',
    	),
    	self::TYPE_BECOME_VIP => array(
    		'desc'	=> '成为VIP提醒',
    		'kw'		=> 'TYPE_BECOME_VIP',
    	),
	);


	/**
     * 返回所有的类型描述
     * @return array
     */
    static public function getTypeDesc() {
    	return self::$typeDesc;
    }

	/**
	 *
	 * 状态之：待处理
	 * @var int
	 */
	const STATUS_WAIT_PROCESS = 100;


	/**
	 *
	 * 绑定的外站：新浪微博
	 * @var int
	 */
	const USER_TYPE_SINA = 100;

	/**
	 *
	 * 绑定的外站：开心
	 * @var int
	 */
	const USER_TYPE_KX = 200;

	private static $userTypeDesc = array(
		self::USER_TYPE_SINA => array(
    		'desc'	=> '新浪微博',
    		'kw'		=> 'USER_TYPE_SINA',
    	),
    	self::USER_TYPE_KX => array(
    		'desc'	=> '开心',
    		'kw'		=> 'USER_TYPE_KX',
    	),
    );


	/**
     * 返回所有的用户绑定站点类型描述
     * @return array
     */
    static public function getUserTypeDesc() {
    	return self::$userTypeDesc;
    }

}
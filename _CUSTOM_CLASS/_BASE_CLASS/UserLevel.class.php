<?php
/**
 * 用户级别后端类
 * @author lsm
 */
class UserLevel extends DBSpeedyPattern {
	
	protected $tableName = 'user_level';
	
	/**
	 * 数据库里真实字段
	 * @var array
	 */
	protected $other_field = array(
		'uid',
		'uname',
		'real_name',
		'level',	// 级别
		'birthday',
		'start_time',
		'end_time',
	);
	
	/**
	 * 级别之：普通用户
	 * @var int
	 */
	const LEVEL_ORDINARY = 100;
	
	/**
	 * 级别之：VIP用户
	 * @var int
	 */
	const LEVEL_VIP	= 200;
	
	/**
	 * 级别之：SVIP用户
	 * @var int
	 */
	const LEVEL_SVIP = 300;
	
	/**
	 * 级别描述
	 * @var array
	 */
	static private $levelDesc = array(
		self::LEVEL_ORDINARY	=>array(
			'desc'	=> '普通',
			'kw'	=> 'LEVEL_ORDINARY',
		),
		self::LEVEL_VIP	=> array(
			'desc'	=> 'vip',
			'kw'	=> 'LEVEL_VIP',
		),
		self::LEVEL_SVIP	=> array(
			'desc'	=> 'svip',
			'kw'	=> 'LEVEL_SVIP',
		),
	);
	
	/**
	 * 获取级别表述
	 * @return array
	 */
	static public function getLevelDesc() {
		return self::$levelDesc;
	}
	
	
	/**
	 * 用户是否一年内有一次性消费满1500元
	 * @param int $uid
	 * @param int $last_pay_time 用户7天前最后发货的订单支付时间
	 * @return boolean
	 */
	public function isDisposable($uid, $last_pay_time) {
		if (!Verify::unsignedInt($uid)) {
			return false;
		}
		if (!Verify::unsignedInt($last_pay_time)) {
			return false;
		}
		
		$status = array(
			UserOrder::STATUS_CONFIRMED,
			UserOrder::STATUS_PAID,
			UserOrder::STATUS_SIGN_AND_PAID,
		);
		
		$statusStr = implode(",", $status);
		$st_pay_time = strtotime(date("Y-m-d", $last_pay_time - 86400 * 365)."00:00:00"); // 7天前最后一个有效订单 往前一年
		
		$sql = "
			SELECT * FROM `user_order_forStatis` WHERE 
			`uid`  =  {$uid} && `status` IN ({$statusStr}) && `money`  >=  1500 && `pay_time` <= {$last_pay_time} && `pay_time` >= {$st_pay_time} 
		";
		$r =  $this->db->fetchAll($sql);
		
		if (!$r) {
			return false;
		}

		return true;
	}
	
	/**
	 * 用户是否一年内累计消费满3000元
	 * @param int $uid
	 * @param int $last_pay_time 用户7天前最后发货的订单支付时间
	 * @return boolean
	 */
	public function isAccumulative($uid, $last_pay_time) {
		if (!Verify::unsignedInt($uid)) {
			return false;
		}
		if (!Verify::unsignedInt($last_pay_time)) {
			return false;
		}
		
		$status = array(
			UserOrder::STATUS_CONFIRMED,
			UserOrder::STATUS_PAID,
			UserOrder::STATUS_SIGN_AND_PAID,
		);
		
		$statusStr = implode(",", $status);
		$st_pay_time = strtotime(date("Y-m-d", $last_pay_time - 86400 * 365)."00:00:00"); // 7天前最后一个有效订单 往前一年
		
		$sql = "
			SELECT sum(money) FROM `user_order_forStatis` WHERE 
			`uid`  =  {$uid} && `status` IN ({$statusStr}) && `pay_time`  <=  {$last_pay_time} && `pay_time`  >=  {$st_pay_time} 
		";
		$r =  array_pop($this->db->fetchAll($sql));
		
		if ($r['sum(money)'] >= 3000) {
			return true;
		}

		return false;
	}
	
	/**
	 * 获取用户一年内累计消费金额
	 * @param int $uid
	 * @param int $last_pay_time
	 * @return int
	 */
	public function getAccumulativeByUid($uid, $last_pay_time) {
		if (!Verify::unsignedInt($uid)) {
			return false;
		}
		if (!Verify::unsignedInt($last_pay_time)) {
			return false;
		}
		
		$status = array(
			UserOrder::STATUS_CONFIRMED,
			UserOrder::STATUS_PAID,
			UserOrder::STATUS_SIGN_AND_PAID,
		);
		
		$statusStr = implode(",", $status);
		$st_pay_time = strtotime(date("Y-m-d", $last_pay_time - 86400 * 365)."00:00:00"); // 7天前最后一个有效订单 往前一年
		
		$sql = "
			SELECT sum(money) FROM `user_order_forStatis` WHERE 
			`uid`  =  {$uid} && `status` IN ({$statusStr}) && `pay_time`  <=  {$last_pay_time} && `pay_time`  >=  {$st_pay_time} 
		";
		$r =  array_pop($this->db->fetchAll($sql));
		
		return $r['sum(money)'] ? $r['sum(money)'] : 0;
	}
	
	/**
	 * 获取vip用户开始有效期至7天前累计消费金额
	 * @param int $uid
	 * @param int $start_time
	 * @return int
	 */
	public function getAccByVipUid($uid, $start_time) {
		if (!Verify::unsignedInt($uid)) {
			return false;
		}
		if (!Verify::unsignedInt($start_time)) {
			return false;
		}
		
		$status = array(
			UserOrder::STATUS_CONFIRMED,
			UserOrder::STATUS_PAID,
			UserOrder::STATUS_SIGN_AND_PAID,
		);
		
		$statusStr = implode(",", $status);
		$last_pay_time = strtotime(date("Y-m-d", time() - 86400 * 7)."23:59:59"); // 7天前最后一个有效订单 往前一年
		
		$sql = "
			SELECT sum(money) FROM `user_order_forStatis` WHERE 
			`uid`  =  {$uid} && `status` IN ({$statusStr}) && `pay_time`  <=  {$last_pay_time} && `pay_time`  >=  {$start_time} 
		";
		$r =  array_pop($this->db->fetchAll($sql));
		
		return $r['sum(money)'] ? $r['sum(money)'] : 0;
	}
	
}
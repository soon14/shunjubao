<?php
/**
 * 后台管理操作类
 * 1、设置是否开启投注功能
 * 2、添加、删除、修改受限制的投注
 * 3、
 */
class AdminOperate extends DBSpeedyPattern {
	protected $tableName = 'admin_operate';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
			'id',
			'u_id',
			'operate_uname',
			'extend',
			'type',
			'status',
			'create_time',
			'start_time',
			'end_time',
			'leitai',//是否设置为擂台
			's_recomond',//定制推荐
			's_hondanshu',//红单数
			'show_prize_state1',//一周红单量
			'show_prize_state2',//一周黑单量
			's_shenglv',//胜率
	);

	/**
	 * 操作类型:受限制的投注
	 * @var int
	 */
	const TYPE_TOUZHU_LIMIT		= '1';
	
	/**
	 * 虚拟投注人
	 * @var int
	 */
	const TYPE_VIRTUAL_USERS = '2';
	
	/**
	 * 晒单人
	 * @var int
	 */
	const TYPE_SHOW_TICKET = '3';
	
	/**
	 * 竞彩投注开关
	 * @var int
	 */
	const TYPE_TOUZHU_LOCK = '4';
	
	/**
	 * 首页单关投注
	 * @var int
	 */
	const TYPE_TOUZHU_INDEX = '5';
	
	/**
	 * 北单投注开关
	 * @var int
	 */
	const TYPE_BD_TOUZHU_LOCK = '6';
	
	/**
	 * 竞彩人工投注开关
	 * @var int
	 */
	const TYPE_JC_MANUAL = 7;
	
	/**
	 * 北单人工投注开关
	 * @var int
	 */
	const TYPE_BD_MANUAL = 8;
	
	/**
	 * 投注限额
	 * @var int
	 */
	const TYPE_MANUAL_TOUZHU_MONEY_LIMIT = 9;
	
	
	static private $adminOperateTypeDesc = array(
			self::TYPE_MANUAL_TOUZHU_MONEY_LIMIT => array(
					'desc'			=> '投注限额',
					'kw'			=> 'TYPE_MANUAL_TOUZHU_MONEY_LIMIT',
					'type'			=>	self::TYPE_MANUAL_TOUZHU_MONEY_LIMIT,
			),
			self::TYPE_BD_MANUAL => array(
					'desc'			=> '北单人工投注开关',
					'kw'			=> 'TYPE_BD_MANUAL',
					'type'			=>	self::TYPE_BD_MANUAL,
			),
			self::TYPE_JC_MANUAL => array(
					'desc'			=> '竞彩人工投注开关',
					'kw'			=> 'TYPE_JC_MANUAL',
					'type'			=>	self::TYPE_JC_MANUAL,
			),
			self::TYPE_TOUZHU_LIMIT => array(
					'desc'			=> '受限制的投注',
					'kw'			=> 'TYPE_TOUZHU_LIMIT',
					'type'			=>	self::TYPE_TOUZHU_LIMIT,
			),
			self::TYPE_VIRTUAL_USERS => array(
					'desc'			=> '运营投注人',
					'kw'			=> 'TYPE_VIRTUAL_USERS',
					'type'			=>	self::TYPE_VIRTUAL_USERS,
			),
			self::TYPE_SHOW_TICKET => array(
					'desc'			=> '晒单人',
					'kw'			=> 'TYPE_SHOW_TICKET',
					'type'			=>	self::TYPE_SHOW_TICKET,
			),
			self::TYPE_TOUZHU_LOCK => array(
					'desc'			=> '投注开关',
					'kw'			=> 'TYPE_TOUZHU_LOCK',
					'type'			=>	self::TYPE_TOUZHU_LOCK,
			),
			self::TYPE_BD_TOUZHU_LOCK => array(
					'desc'			=> '北单投注开关',
					'kw'			=> 'TYPE_BD_TOUZHU_LOCK',
					'type'			=>	self::TYPE_BD_TOUZHU_LOCK,
			),
			self::TYPE_TOUZHU_INDEX => array(
					'desc'			=> '首页单关投注',
					'kw'			=> 'TYPE_TOUZHU_INDEX',
					'type'			=>	self::TYPE_TOUZHU_INDEX,
			),
	);
	
	/**
	 * 状态：可用
	 */
	CONST STATUS_AVILIBALE = 1;
	
	/**
	 * 状态：不可用
	 */
	CONST STATUS_NOT_AVILIBALE = 2;
	
	/**
	 * 获取所有管理操作描述
	 * @return array
	*/
	static public function getAdminOperateTypeDesc() {
		return self::$adminOperateTypeDesc;
	}
	
	/**
	 * 创建一个推荐cms
	 * @param array $info
	 * @return int or false
	 */
	public function add($info) {
		$info['status'] = self::STATUS_AVILIBALE;
		$info['create_time'] = getCurrentDate();
		$info['u_id'] = Runtime::getUid();//操作人uid
		$info['operate_uname'] = Runtime::getUname();//操作人uname
		$info = parent::parseExtend($info);
		if (!$info) {
			return false;
		}
		return parent::add($info);
	}
	
	/**
	 * 按条件获取信息
	 * @param array $condition
	 * @return array | false
	 */
	public function getsByCondition($condition, $limit  = null, $order = 'create_time asc') {
		$ids = $this->findIdsBy($condition, $limit, $order);
		return $this->gets($ids);
	}
	
	public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}
	
		return array_pop($tmpResult);
	}
	
	public function gets($ids) {
		$result = parent::gets($ids);
		foreach ($result as & $tmpV) {
			$tmpExtend = array();
			$tmpExtend = unserialize($tmpV['extend']);
			unset($tmpV['extend']);
	
			# 将存在扩展字段里的信息提出来
			if (is_array($tmpExtend)) foreach ($tmpExtend as $tmpKK => $tmpVV) {
				if (!in_array($tmpKK, $this->real_field)) {
					$tmpV[$tmpKK] = $tmpVV;
				}
			}
		}
		return $result;
	}
	
	public function modify($info, $condition = null) {
		$info = parent::parseExtend($info);
		return parent::modify($info, $condition, $cas_token = null);
	}
	
	/**
	 * 是否晒单人
	 * @param unknown_type $u_id
	 * @return boolean
	 */
	public function isShowTickeUser($u_id) {
		$show_ticket_users = $this->getsByCondition(array('type'=>AdminOperate::TYPE_SHOW_TICKET));
		foreach ($show_ticket_users as $s_t_u) {
			if ($u_id == $s_t_u['show_uid']) {
				return true;
			}
		}
		return false;
	}
}

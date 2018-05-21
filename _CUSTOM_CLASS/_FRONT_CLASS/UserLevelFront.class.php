<?php
/**
 * 用户级别前端类
 * @author lishuming
 */
class UserLevelFront {

	protected $objUserLevel;

	public function __construct() {
		$this->objUserLevel = new UserLevel();
	}

	public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}

		return array_pop($tmpResult);
	}

	/**
	 * 批量获取
	 * @param array $ids
	 * @return array 无结果时返回空数组
	 */
	public function gets(array $ids) {
		$return = array();

		if (empty($ids)) {
			return $return;
		}

		$return = $this->objUserLevel->gets($ids);

		return $return;
	}

	/**
     * 批量获取
     * @param string $limit 该参数用于支持分页，默认为不使用分页。格式 "offset, length"
     * @param string $order 排序方式。默认以主键倒序;有效的格式："create_time desc"
     * @return array 返回所有信息
     */
    public function getsAll($limit = 20, $order = null) {
    	return $this->objUserLevel->getsAll($order, $limit);
    }

    /**
     *
     * 判断指定用户$uid 是否vip
     * @param int $uid 用户id
     * @param int $compare_time 比较时间。如果指定了，还需判断下在该时间点用户是否vip
     * @return boolean
     */
    public function isVip($uid, $compare_time = null) {
    	if (!Verify::unsignedInt($uid)) {
			return false;
		}

		$condition = array(
			'uid'	=> $uid,
		);
		$userLevels = $this->objUserLevel->findBy($condition);
		if (!$userLevels) {
			return false;
		}
		$userLevel = array_pop($userLevels);
		if ($userLevel['level'] != UserLevel::LEVEL_VIP) {
			return false;
		}

		if (Verify::int($compare_time)) {
			if ($userLevel['start_time'] > $compare_time) {// 说明这个时间，还没成为vip
				return false;
			}
		}


		return true;
    }

	/**
	 * 添加记录
	 * @param array $info
	 * @return int | boolean
	 */
	public function add($info) {
		return $this->objUserLevel->add($info);
	}

	/**
	 * 修改记录
	 * @param array $info
	 * @return InternalResultTransfer
	 */
	public function modify($info) {
		return $this->objUserLevel->modify($info);
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

		return $this->objUserLevel->isDisposable($uid, $last_pay_time);
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

		return $this->objUserLevel->isAccumulative($uid, $last_pay_time);
	}

	/**
	 * 按uid获取
	 * @param int $uid
	 * @return array
	 */
	public function getByUid($uid) {
		if (!Verify::unsignedInt($uid)) {
			return false;
		}

		$condition = array(
			'uid'	=> $uid,
		);
		$id = array_pop($this->objUserLevel->findIdsBy($condition));

		return $this->get($id);
	}

	/**
	 * 判断是否需要评级
	 * @param array $userLevelInfo
	 * @return boolean
	 */
	public function isRatingLevel($userLevelInfo) {
		if (!$userLevelInfo) { // 不存在，当然要评级的
			return true;
		}

		$level = $userLevelInfo['level'];
		if ($level == UserLevel::LEVEL_ORDINARY) { // 普通用户是要评级的
			return true;
		}

		$expire_time = $userLevelInfo['expire_time'];
		if (date("Ymd", $expire_time) == date("Ymd")) { // vip过期时间刚好是当天，同样需要判断是否需要延长vip
			return true;
		}

		return false;
	}

	/**
	 * 按条件获取用户级别信息
	 * @param array $condition
	 * @param string | int $limit
	 * @param string $order
	 * @return array
	 */
	public function getIdsByCondition(array $condition = null, $limit = null, $order = 'create_time desc') {
		return $this->objUserLevel->findIdsBy($condition, $limit, $order);
	}

	/**
	 * 获取级别表述
	 * @return array
	 */
	static public function getLevelDesc() {
		return UserLevel::getLevelDesc();
	}

	/**
	 * 获取总记录条数
	 */
	public function totals() {
		return $this->objUserLevel->totals();
	}

	/**
	 * 获取用户一年内累计消费金额
	 * @param int $uid
	 * @param int $last_pay_time
	 * @return int
	 */
	public function getAccumulativeByUid($uid, $last_pay_time) {
		return $this->objUserLevel->getAccumulativeByUid($uid, $last_pay_time);
	}

	/**
	 * 获取vip用户开始有效期至7天前累计消费金额
	 * @param int $uid
	 * @param int $start_time
	 * @return int
	 */
	public function getAccByVipUid($uid, $start_time) {
		return $this->objUserLevel->getAccByVipUid($uid, $start_time);
	}
}

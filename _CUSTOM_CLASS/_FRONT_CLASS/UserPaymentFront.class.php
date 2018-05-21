<?php
class UserPaymentFront {
	/**
	 * 用户账户信息
	 */
	public function __construct() {
		$this->objUserPayment = new UserPayment();
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
		$userInfo = array();

		if (empty($ids)) {
			return $userInfo;
		}

		return $this->objUserPayment->gets($ids);
	}

	public function add($info) {
		$info['create_time'] = getCurrentDate();
		if (!Verify::int($info['u_id'])) {
			$info['u_id'] = Runtime::getUid();
		}
		return $this->objUserPayment->add($info);
	}
	/**
	 * 获取用户默认支付帐号信息
	 * @param int $uid
	 * @return Ambigous <boolean, mixed>|multitype:
	 */
	public function getDefaultPaymentInfo($uid) {
		$ids = $this->objUserPayment->findIdsBy(array('u_id'=>$uid,'default'=>UserPayment::DEFAULT_PAY_TYPE) , 1);
		if ($ids) {
			return $this->get(array_pop($ids));
		}
		return array();
	}

	public function modify($tableInfo,$condition = null) {
		return $this->objUserPayment->modify($tableInfo, $condition);
	}
	
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->objUserPayment->findIdsBy($condition , $limit, $order);
		return $this->gets($ids);
	}
}
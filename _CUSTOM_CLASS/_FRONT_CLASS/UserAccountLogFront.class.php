<?php 
class UserAccountLogFront {
	/**
	 * 用户账户日志
	 */
	public function __construct($u_id) {
    	$this->objUserAccountLog = new UserAccountLog($u_id);
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

		return $this->objUserAccountLog->gets($ids);
	}
	
    public function add($info) {
    	$info['create_time'] = getCurrentDate();
    	$objUserAccountFront = new UserAccountFront();
    	if (Verify::int($info['u_id'])) {
    		$userAccount = $objUserAccountFront->get($info['u_id']);
    		$info['old_money'] = $userAccount['cash'];//old_money统一使用交易后的剩余金额
    	}
    	return $this->objUserAccountLog->add($info);
    }
    
    public function modify($tableInfo,$condition) {
    	return $this->objUserAccountLog->modify($tableInfo, $condition);
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->objUserAccountLog->findIdsBy($condition , null, $limit, '*', $order);
    	return $this->gets($ids);
    }
    
	public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition =  array(), $limit = null, $order = 'create_time desc') {
    	return $this->objUserAccountLog->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
}
<?php
class UserGiftLogFront {
	/**
	 * 用户彩金
	 */
	public function __construct() {
    	$this->objUserGiftLog = new UserGiftLog();
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

		return $this->objUserGiftLog->gets($ids);
	}
	
    public function add($info) {
    	//添加余额
    	$u_id = $info['u_id'];
    	$objUserAccountFront = new UserAccountFront();
    	$userAccountInfo = $objUserAccountFront->get($u_id);
    	if ($userAccountInfo) {
    		$info['old_gift'] = $userAccountInfo['gift'];
    	}
    	return $this->objUserGiftLog->add($info);
    }
    
    public function modify($tableInfo,$condition) {
    	return $this->objUserGiftLog->modify($tableInfo, $condition);
    }
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		return  $this->objUserGiftLog->findBy($condition , null, $limit, '*', $order);
    }
	public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition =  array(), $limit = null, $order = 'create_time desc') {
    	return $this->objUserGiftLog->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
}
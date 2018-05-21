<?php

class UserMessageFront {
	
	private  $objUserMessage;
	/**
	 * 用户信息前端类
	 */
	public function __construct() {
    	$this->objUserMessage = new UserMessage();
    }
    
    public function add(array $info) {
    	$info['create_time'] = getCurrentDate();
    	$info['u_id'] = Runtime::getUid();
    	$info['u_name'] = Runtime::getUname();
    	if (!isset($info['status'])) {
    		$info['status'] = UserMessage::STATUS_NOT_SHENHE;
    	}
    	return $this->objUserMessage->add($info);
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

		$userInfo = $this->objUserMessage->gets($ids);
		return $userInfo;
	}
	
	public function modify(array $info, $condition = null, $cas_token = null) {
		$tmpResult = $this->objUserMessage->modify($info, $condition, $cas_token);
		return $tmpResult;
	}
	
	public function getsByCondition($condition, $limit = null, $order = 'id asc') {
		$ids = $this->objUserMessage->findIdsBy($condition, $limit, $order);
		return $this->gets($ids);
	}
	
	public function getsByCondtionWithField($start, $end, $field = 'u_id', $condition = array(), $limit = null, $order = 'id desc')  {
		return $this->objUserMessage->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
	}
}

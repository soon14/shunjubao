<?php
/**
 * 用户积分
 * @author hushiyu
 */
class UserScoreLogFront {
	/**
	 * 用户积分
	 */
	public function __construct() {
    	$this->objUserScoreLog = new UserScoreLog();
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

		return $this->objUserScoreLog->gets($ids);
	}
	
    public function add($info) {
    	//添加余额
    	$u_id = $info['u_id'];
    	$objUserAccountFront = new UserAccountFront();
    	$userAccountInfo = $objUserAccountFront->get($u_id);
    	if ($userAccountInfo) {
    		$info['old_score'] = $userAccountInfo['score'];
    	}
    	$info['create_time'] = getCurrentDate();
    	return $this->objUserScoreLog->add($info);
    }
    
    public function modify($tableInfo,$condition) {
    	return $this->objUserScoreLog->modify($tableInfo, $condition);
    }
    
    public function getsByCondition(array $condition, $limit = null, $order = null) {
    	return $this->objUserScoreLog->findBy($condition , null, $limit, '*', $order);
    }
}
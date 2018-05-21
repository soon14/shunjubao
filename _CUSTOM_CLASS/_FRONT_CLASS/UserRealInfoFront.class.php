<?php 
class UserRealInfoFront {
	
	private $objUserRealInfo;
	
	/**
	 * 用户真实信息
	 */
	public function __construct() {
    	$this->objUserRealInfo = new UserRealInfo();
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

		return $this->objUserRealInfo->gets($ids);
	}
	
	public function add($info) {
    	return $this->objUserRealInfo->add($info);
    }
    
    public function modify($tableInfo,$condition = null, $cas_token = null) {
    	return $this->objUserRealInfo->modify($tableInfo, $condition, null);
    }
    
    public function getsByCondition(array $condition, $limit = null, $order = 'u_id desc') {
    	return $this->objUserRealInfo->findBy($condition, null, $limit,  '*', $order);
    }
    
    /**
     * 用户是否已经实名认证
     * @param int $u_id
     * @return boolean
     */
    public function isUserIdentify($u_id) {
    	if (!Verify::int($u_id)) {
    		return false;
    	}
    	$user= $this->get($u_id);
    	if (!$user['idcard']) {
    		return false;
    	}
    	return true;
    }

	/**
	 * 手机号是否能够注册
	 * @param string $mobile
	 * @return boolean
	 */
	public function isMobileCanRegister($mobile) {
		if (!Verify::mobile($mobile)) {
			return false;
		}
		$res = $this->getsByCondition(array('mobile'=>$mobile), 1);
		if ($res) {
			return false;
		} else {
			return true;
		}
	}
}
?>
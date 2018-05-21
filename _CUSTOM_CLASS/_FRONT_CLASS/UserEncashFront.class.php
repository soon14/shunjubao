<?php 
class UserEncashFront {
	
	private $objUserEncash;
	
	public function __construct() {
    	$this->objUserEncash = new UserEncash();
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

		return $this->objUserEncash->gets($ids);
	}
	
	public function add($info) {
		if (!$info) return false;
		
		$info['create_time'] = getCurrentDate();
		$info['encash_status'] = UserEncash::ENCASH_STATUS_UNVERIFY;
		
    	return $this->objUserEncash->add($info);
    }
    
    public function modify($tableInfo,$condition) {
    	return $this->objUserEncash->modify($tableInfo, $condition);
    }
	public function getsByCondition($condition, $limit, $order) {
    	 $ids = $this->objUserEncash->findIdsBy($condition, $limit, $order);
    	 return $this->gets($ids);
    }
    public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition = array(), $limit = null, $order = 'create_time desc')  {
    	return $this->objUserEncash->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
}
?>
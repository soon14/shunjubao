<?php
/**
 *
 * 后台cms功能操作类
 * @author gaoxiaogang@gmail.com
 *
 */
class SubscribeSecret extends DBSpeedyPattern {
	protected $tableName = 'subscribe_secret';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'email',
    	'pwd',
    	'create_time',
    );  
    
 	/**
 	 * 创建
 	 * @param array $info
 	 * @return int or false
 	 */
    public function add($info) {
    	if (!$info) {
    		return false;
    	}
    	if (!$info['pwd']) {
    		return false;
    	}
    	$info['pwd'] = self::createPWD($info['pwd']);
    	$info['create_time'] = getCurrentDate();
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
    
    /**
     * 通过email获取记录
     * @param string $email
     * @return false | array
     */
    public function getByEmail($email) {
    	if (!$email) return false;
    	$condition = array();
    	$condition['email'] = $email;
    	$results = $this->getsByCondition($condition);
    	if (!$results) {
    		return false;
    	}
    	return array_pop($results);
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
        return $result;
    }
    public function updatePwd($email, $pwd) {
    	if (!$email || !$pwd) return false;
    	$condition = $tableInfo = array();
    	$condition['email'] = $email;
    	$tableInfo['pwd'] = self::createPWD($pwd);
    	return $this->update($tableInfo, $condition);
    }
    public function modify($info, $condition = null, $cas_token = null) {
    	if (isset($info['pwd'])) unset($info['pwd']);
    	return parent::modify($info, $condition, $cas_token);
    }
    
    private function createPWD($string) {
    	return md5_16($string);
    }
    
    /**
     * 
     * @param unknown_type $email
     * @param unknown_type $pwd
     * @return InternalResultTransfer
     */
    public function verifyEmailAndPwd($email,$pwd) {
    	$result = self::getByEmail($email);
    	if (!$result) {
    		return InternalResultTransfer::fail('密码未设定');
    	}
    	$this_pwd = self::createPWD($pwd);
    	if ($this_pwd != $result['pwd']) {
    		return InternalResultTransfer::fail('密码不正确');
    	}
    	return InternalResultTransfer::success();
    }
}
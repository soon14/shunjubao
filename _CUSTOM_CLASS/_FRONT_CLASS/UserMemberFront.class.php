<?php

class UserMemberFront {
	
	private  $objUserMemeber;
	/**
	 * 用户信息前端类
	 */
	public function __construct() {
    	$this->objUserMemeber = new UserMember();
    }

    /**
     * 校验用户名
     * 1、字宽不能超过20
     * 2、只允许中文、a-z、A-Z、0-9、_ 这些字符。
     *
     * @param string $name
     * @return InternalResultTransfer。失败时：数据里含失败原因。
     */
    static public function verifyName($name) {
    	
    	if (empty($name)) {
    		return InternalResultTransfer::fail('name字段不能为空');
    	}
        
        if (mb_strlen($name,'UTF-8') > 20) {
            return InternalResultTransfer::fail('用户名宽度不能超过20');
        }
        
        if (preg_match('#^(?:(?:\xe4[\xb8-\xbf][\x80-\xbf]|[\xe5-\xe9][\x80-\xbf][\x80-\xbf])|[\w\d])+$#', $name)) {
            return InternalResultTransfer::success();
        }

        return InternalResultTransfer::fail('只允许 中文、_、a-z、A-Z、0-9');
    }

    /**
     * 创建一个用户
     *
     * @param array $info 要求的字段 array(
     *     'name'       => (string),//用户名
     *     'password'   => (string),//用户密码
     *     'email'      => (string),//用户邮箱
     * )
     * @return InternalResultTransfer 成功：返回用户记录，包括用户id；失败：返回失败原因
     */
    public function add(array $info) {
    	$sourceFrom = TMCookie::get(UserMember::OTHER_SITES_FROM_COOKIE_KEY);
    	$sourceId = UserMember::verifySiteFrom($sourceFrom);
    	if ($sourceId) {
    		$info['u_source'] = $sourceId;
    	}
    	return $this->objUserMemeber->add($info);
    }
    
    /**
     * 
     * 创建扩展信息
     * @param array $info
     * @return InternalResultTransfer 成功：返回用户记录，包括用户id；失败：返回失败原因
     */
	public function addRealInfo(array $info) {
		#TODO这里要做信息的过滤
    	return $this->objUserMemeber->addRealInfo($info);
    }
    
    /**
     * 验证用户名是否存在，并且密码正确
     *
     * @param string $name
     * @param string $password
     * @return InternalResultTransfer
     */
    public function getByNameAndPassword($name, $password) {
    	$user = $this->getByName($name);
        if (!$user) {
        	return InternalResultTransfer::fail("用户 {$name} 不存在");
        }
		
        if ($user['u_pwd'] != $this->objUserMemeber->getPWD($password)) {
        	return InternalResultTransfer::fail("密码 {$password} 不正确");
        }
        return InternalResultTransfer::success($user);
    }

    /**
     * 
     * 按用户名查询
     * @param string $name
     * @return array()
     */
    public function getByName($name) {
		$uid = $this->objUserMemeber->getIdByName($name);
		return $this->get($uid);
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

		$userInfo = $this->objUserMemeber->gets($ids);
		return $userInfo;
	}

    /**
     * 某一个ip是否可以注册
     * 逻辑：同一个ip10分钟只能注册一次
     * @return boolean true可以注册|false不能注册
     */
    public function isIPCanReg($ip = false) {
    	
    	if (!$ip) {
    		$ip = getClientIp();
    	}
    	
    	$cond = array('u_loginip'=>$ip);
    	$res = $this->objUserMemeber->fetchOne($cond , 'u_jointime' , 'u_id desc');
    	if (!$res) {
    		return true;
    	}
    	
    	$u_jointime = $res['u_jointime'];
    	
    	if ((time() - strtotime($u_jointime)) <= UserMember::IP_REGISTER_TIME_MIN ) {
    		return false;
    	}
    	return true;
    }
    
	/**
     * 根据用户名修改密码
     * @param string $name 用户名
     * @param string $password 用户密码
     * @return boolean
     */
	public function updatePasByName ($name, $password) {
		if (empty($name) || empty($password)) {
			return FALSE;
		}
    	return $this->objUserMemeber->updatePasByName($name, $password);
    }

	public function modify(array $info, $condition = null, $cas_token = null) {
    	$tmpResult = $this->objUserMemeber->modify($info, $condition, $cas_token);
    	return $tmpResult;
    }  
    
	public function getsByCondition($condition, $limit = null, $order = 'u_id desc') {
    	 $ids = $this->objUserMemeber->findIdsBy($condition, $limit, $order);
    	 return $this->gets($ids);
    }
    
    public function getsByCondtionWithField($start, $end, $field = 'u_jointime', $condition = array(), $limit = null, $order = 'u_jointime desc')  {
    	return $this->objUserMemeber->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
}
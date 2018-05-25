<?php 
class UserAccountFront {
	/**
	 * 用户账户信息
	 */
	public function __construct() {
    	$this->objUserAccount = new UserAccount();
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

		return $this->objUserAccount->gets($ids);
	}
	
    public function add($info) {
    	return $this->objUserAccount->addAccount($info);
    }
    
    public function modify($tableInfo,$condition = null) {
    	return $this->objUserAccount->modify($tableInfo, $condition);
    }
    
    /**
     * 消费积分-目前的积分操作都只与账户有关，包括各类的消费都是从账户上扣除的
     * 1、修改账户
     * 2、添加日志
     * @param float $money 
     * @param int $u_id
     * @param int $type 类型
     * @return InternalResultTransfer
     */
    public function consumeScore($u_id, $score) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['score'] = $user['score'] - $score;
    	//积分最小值为0
    	if ($user['score'] <= 0.00) {
    		$user['score'] = 0.00;
    	}
    	return $this->modify($user);
    }
    
    /**
     * 获取积分-目前包括登录和注册时赠送的积分
     * 1、修改账户
     * 2、添加日志
     * 规则：每日登录送积分
     * @param int $u_id
     * @param float $socre
     * @param int $type
     * @return InternalResultTransfer
     */
    public function addScore($u_id, $score) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['score'] = $user['score'] + $score;

    	return $this->modify($user);
    }
    
    /**
     * 消费余额-目前的积分操作都只与账户有关，包括各类的消费都是从账户上扣除的
     * 1、修改账户
     * 2、添加日志
     * @param float $cash 
     * @param int $u_id
     * @param int $type 类型
     * @return InternalResultTransfer
     */
    public function consumeCash($u_id, $cash) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['cash'] = $user['cash'] - $cash;
    	//积分最小值为0
    	if ($user['cash'] <= 0.00) {
    		$user['cash'] = 0.00;
    	}
    	return $this->modify($user);
    }
    
    /**
     * 添加彩金
     * @param int $u_id
     * @param float $cash
     * @return InternalResultTransfer
     */
    public function addGift($u_id, $gift) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['gift'] = $user['gift'] + $gift;
		sendUserPms($u_id, '赠送彩金', '尊敬的会员，谢谢您参与聚宝网活动，彩金&yen'.$gift.'元已派送至账户，<a href="'.ROOT_WEBSITE.'/account/user_gift_log.php">请查收！</a>');
    	return $this->modify($user);
    } 
    
    /**
     * 消费彩金-目前的积分操作都只与账户有关，包括各类的消费都是从账户上扣除的
     * 1、修改账户
     * 2、添加日志
     * @param float $cash 
     * @param int $u_id
     * @param int $type 类型
     * @return InternalResultTransfer
     */
    public function consumeGift($u_id, $gift) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['gift'] = $user['gift'] - $gift;
    	//积分最小值为0
    	if ($user['gift'] <= 0.00) {
    		$user['gift'] = 0.00;
    	}
    	return $this->modify($user);
    }
    
    /**
     * 添加返点
     * @param int $u_id
     * @param float $cash
     * @return InternalResultTransfer
     */
    public function addRebate($u_id, $rebate) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['rebate'] = $user['rebate'] + $rebate;

    	return $this->modify($user);
    }       
    /**
     * 添加余额
     * 1、第三方支付
     * 2、后台添加
     * 3、中奖
     * @param int $u_id
     * @param float $cash
     * @return InternalResultTransfer
     */
    public function addCash($u_id, $cash) {
    	$user = $this->get($u_id);
    	if (!$user) {
    		return InternalResultTransfer::fail(DBException::NOT_MATCH);
    	}
    	
    	$user['cash'] = $user['cash'] + $cash;

    	return $this->modify($user);
    } 
    
    /**
     * 金额转为冻结，为提现准备
     * @param int $u_id
     * @param float $money
     * @return InternalResultTransfer
     */
    public function moneyToFrozen($u_id, $money) {
    	if (!Verify::int($u_id) || !Verify::money($money)) {
    		return InternalResultTransfer::fail('bad data');
    	}
    	$userAccountInfo = $this->get($u_id);
    	if (!$userAccountInfo) {
    		return InternalResultTransfer::fail('no info');
    	}
    	$userAccountInfo['cash'] = $userAccountInfo['cash'] - $money;
    	if ($userAccountInfo['cash'] < 0) {
    		$userAccountInfo['cash'] = 0.00;
    	}
    	$userAccountInfo['frozen_cash'] = $userAccountInfo['frozen_cash'] + $money;
    	
    	return $this->modify($userAccountInfo);
    }
    
    /**
     * 冻结转为金额
     * @param int $u_id
     * @param float $money
     * @return InternalResultTransfer
     */
    public function frozenToMoney($u_id, $money) {
    	if (!Verify::int($u_id) || !Verify::money($money)) {
    		return InternalResultTransfer::fail('bad data');
    	}
    	$userAccountInfo = $this->get($u_id);
    	if (!$userAccountInfo) {
    		return InternalResultTransfer::fail('no info');
    	}
    	
    	$userAccountInfo['frozen_cash'] = $userAccountInfo['frozen_cash'] - $money;
    	if ($userAccountInfo['frozen_cash'] < 0) {
    		$userAccountInfo['frozen_cash'] = 0.00;
    	}
    	
    	$userAccountInfo['cash'] = $userAccountInfo['cash'] + $money;
    	return $this->modify($userAccountInfo);
    }
        
    /**
     * 清除冻结资金
     * @param int $u_id
     * @param float $frozen_cash 待清除的金额
     * @return InternalResultTransfer
     */
    public function frozenTOEncash($u_id, $frozen_cash) {
    	if (!Verify::int($u_id) || !Verify::money($frozen_cash)) {
    		return InternalResultTransfer::fail('bad data');
    	}
    	$userAccountInfo = $this->get($u_id);
    	if (!$userAccountInfo) {
    		return InternalResultTransfer::fail('no info');
    	}
    	
    	if ($frozen_cash > $userAccountInfo['frozen_cash']) {
    		return InternalResultTransfer::fail('冻结资金不足');
    	}
    	
    	$userAccountInfo['frozen_cash'] = $userAccountInfo['frozen_cash'] - $frozen_cash;
    	
    	return $this->modify($userAccountInfo);
    }
    
    /**
     * 获取各项账户总额、总人数
     * @return array $total = array('cash'=>111,'gift'=>222, 'rebate'=>,'frozen_cash'=>, count=>)
     */
    public function getTotal() {
    	return $this->objUserAccount->getTotal();
    } 
    
    /**
     * 获取虚拟帐号信息
     * @return array $total = array('cash'=>111,'gift'=>222, 'rebate'=>,'frozen_cash'=>, count=>)
     */
    public function getVirtualTotal() {
    	//获取虚拟帐号信息
    	$objAdminOperate = new AdminOperate();
    	$virtual_uids = array();
    	$condition = array();
    	$condition['type'] = AdminOperate::TYPE_VIRTUAL_USERS;
    	$condition['status'] = AdminOperate::STATUS_AVILIBALE;
    	$virtual_users_results = $objAdminOperate->getsByCondition($condition);
    	
    	$objUserMemberFront = new UserMemberFront();
    	foreach ($virtual_users_results as $virtual_users_result) {
    		$virtual_user = $objUserMemberFront->getByName($virtual_users_result['u_name']);
    		$virtual_uids[] = $virtual_user['u_id'];
    	}
    	
    	if (!$virtual_uids) {
    		return array('cash'=>0,'gift'=>0,'rebate'=>0,'frozen_cash'=>0,'count'=>0);
    	}
    	
    	return $this->objUserAccount->getVirtualTotal($virtual_uids);
    	
    }
}
?>
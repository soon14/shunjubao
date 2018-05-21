<?php
/**
 * 用户订单类
 * @author administrator
 *
 */
class UserTicketAllFront{
	
	private $objUserTicketAll;
	
	public function __construct(){
		$this->objUserTicketAll = new UserTicketAll();
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

		return $this->objUserTicketAll->gets($ids);
	}
	
	public function add($tableInfo) {
    	return $this->objUserTicketAll->add($tableInfo);
    }
    
	public function modify($tableInfo,$condition = null) {
    	return $this->objUserTicketAll->modify($tableInfo, $condition, null);
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		return $this->objUserTicketAll->findBy($condition , null, $limit, '*', $order);
    }
    
    public function getsByCondtionWithField($start, $end, $field, $condition = null, $limit = null, $order = 'datetime desc') {
    	return $this->objUserTicketAll->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
    
    /**
     * 返还本金
     * 场景：投注失败时退还系统票金额，并做相应的日志
     * 注：此方法已废止
     * @param array $order_ticket | int
     * @return InternalResultTransfer
     */
    public function returnOrderTicketMoney($order_ticket) {
    	if (!is_array($order_ticket)) {
    		return InternalResultTransfer::fail('无效系统票');
    	}
    	
    	$u_id = $order_ticket['u_id'];
    	$money = $order_ticket['money'];//返还金额，单位：元
    	
    	//返还本金
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($u_id);
		
		if (!$userAccountInfo) {
			return InternalResultTransfer::fail('账户信息不存在');
		}
		
    	$objDBTransaction = new DBTransaction();
    	$strTransactionId = $objDBTransaction->start();
    	
		//添加账户余额
		$tmpResult = $objUserAccountFront->addCash($u_id, $money);
		if (!$tmpResult->isSuccess()) {
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail($tmpResult->getData());
		}
		
		$objUserAccountLogFront = new UserAccountLogFront($u_id);
		
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['money'] 		= $money;
		$tableInfo['log_type'] 		= BankrollChangeType::BUY_REFUND;
		$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
		$tableInfo['record_table'] 	= 'user_ticket_log10'.getUidLastNumber($u_id);//对应的表
		$tableInfo['record_id'] 	= $order_ticket['id'];
		//添加账户日志
		$tmpResult = $objUserAccountLogFront->add($tableInfo);
		if (!$tmpResult) {
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('添加账户日志失败');
		}
		if (!$objDBTransaction->commit($strTransactionId)) {
			return InternalResultTransfer::fail('commit fail');
		}
		return InternalResultTransfer::success();
    }
    
    /**
     * 返还用户票本金
     * 场景：投注失败时退还用户票金额，并做相应的日志
     * @param array $order_ticket | int
     * @return InternalResultTransfer
     */
    public function returnTicketMoney($userTicketId) {
    	
    	if (!Verify::int($userTicketId)) {
    		return InternalResultTransfer::fail('无效用户票id');
    	}
    	
    	$userTicketInfo = $this->get($userTicketId);
    	if (!$userTicketInfo) {
    		return InternalResultTransfer::fail('无效用户票id');
    	}
    		    	
    	$u_id = $userTicketInfo['u_id'];
    	$money = $userTicketInfo['money'];//返还金额，单位：元
    	
    	//返还本金
    	$objUserAccountFront = new UserAccountFront();
    	$userAccountInfo = $objUserAccountFront->get($u_id);
    	
    	if (!$userAccountInfo) {
    		return InternalResultTransfer::fail('账户信息不存在');
    	}
    	
    	$objDBTransaction = new DBTransaction();
    	$strTransactionId = $objDBTransaction->start();
    	 
    	//添加账户余额
    	$tmpResult = $objUserAccountFront->addCash($u_id, $money);
    	if (!$tmpResult->isSuccess()) {
    		$objDBTransaction->rollback($strTransactionId);
    		return InternalResultTransfer::fail($tmpResult->getData());
    	}
    
    	$objUserAccountLogFront = new UserAccountLogFront($u_id);
    
    	$tableInfo = array();
    	$tableInfo['u_id'] 			= $u_id;
    	$tableInfo['money'] 		= $money;
    	$tableInfo['log_type'] 		= BankrollChangeType::BUY_REFUND;
    	$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
    	$tableInfo['record_table'] 	= 'user_ticket_all';//对应的表
    	$tableInfo['record_id'] 	= $userTicketInfo['id'];
    	
    	//添加账户日志
    	$tmpResult = $objUserAccountLogFront->add($tableInfo);
    	if (!$tmpResult) {
    		$objDBTransaction->rollback($strTransactionId);
    		return InternalResultTransfer::fail('添加账户日志失败');
    	}
    	
    	if (!$objDBTransaction->commit($strTransactionId)) {
    		return InternalResultTransfer::fail('commit fail');
    	}
    	
    	return InternalResultTransfer::success();
    }   
	/**
     * 获取奖金总额
     * @return float
     */
    public function getTotalPrize($u_id) {
    	return $this->objUserTicketAll->getTotalPrize($u_id);
    }
    
    /**
     * 获取时间段内总投注金额
     */
	public function getTotalTicketMoney($start, $end, $u_id) {
    	return $this->objUserTicketAll->getTotalTicketMoney($start, $end, $u_id);
    }
    
    /**
     * 获取时间段内总奖金金额
     */
    public function getTotalPrizeMoney($start, $end, $u_id) {
    	return $this->objUserTicketAll->getTotalPrizeMoney($start, $end, $u_id);
    }
    
    /**
     * 获取跟单信息
     * 跟单人数和投注总额
     * @return array('total_sum'=>,'total_money'=>)
     */
    public function getFollowInfo($partent_id) {
    	return $this->objUserTicketAll->getFollowInfo($partent_id);
    }
    
    /**
     * 北单的订单期数查询
     * @param int $userTicketId | array $userTicketInfo
     * @return string $issueNumber | false
     */
    public function getIssueNumberByUserTicketId($userTicketInfo){
    	
    	$issueNumber = false;
    	
    	if (Verify::int($userTicketInfo)) {
    		$userTicketInfo = $this->get($userTicketInfo);
    	}
    	
    	$combination = $userTicketInfo['combination'];
    	
    	if (!$combination) {
    		return $issueNumber;
    	}
    	
    	$m = explode(',', $combination);
    	$m1 = explode('|', $m[0]);
    	$id = $m1[1];
    	$objBettingBD = new BettingBD();
    	$bettingInfo = $objBettingBD->get($id);
    	$issueNumber = $bettingInfo['issueNumber'];
    	return $issueNumber;
    }
}

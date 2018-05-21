<?php 
class UserRebateFront {
	
	private $objUserRebate;
	/**
	 * 用户返点记录 
	 */
	public function __construct() {
    	$this->objUserRebate = new UserRebate();
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

		return $this->objUserRebate->gets($ids);
	}
	
	/**
	 * 
	 * 添加返点记录
	 * @param array $info
	 */
	public function add($info) {
    	return $this->objUserRebate->add($info);
    }
    
    public function modify($tableInfo,$condition) {
    	return $this->objUserRebate->modify($tableInfo, $condition);
    }
	public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition =  array(), $limit = null, $order = 'create_time desc') {
    	return $this->objUserRebate->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
    
    /**
     * 添加用户投注订单返点
     * @param int $u_id 
     * @param int $ticket_id
     * @return InternalResultTransfer
     */
    public function addUserTicketRebate($u_id, $ticket_id) {
    	
    	if (!Verify::int($u_id) || !Verify::int($ticket_id)) {
    		return InternalResultTransfer::fail('id wrong');
    	}
    	
    	$objUserAccountFront = new UserAccountFront();
    	$userAccountInfo = $objUserAccountFront->get($u_id);
    	if (!$userAccountInfo) {
    		return InternalResultTransfer::fail('account not found');
    	}
    	
    	$rebate_per = $userAccountInfo["rebate_per"];
    	
    	if ($rebate_per <= 0) {
    		return InternalResultTransfer::fail('rebate must >0');
    	}
    	
    	$objUserTicketAllFront = new UserTicketAllFront();
    	$userTicketInfo = $objUserTicketAllFront->get($ticket_id);
    	if ($userTicketInfo['u_id'] != $u_id) {
    		return InternalResultTransfer::fail('uid not match');
    	}
    	
    	//返点逻辑开始
    	$score 		= $userTicketInfo['money'] * $rebate_per;
    	$datetime	= getCurrentDate();
    	//记录返点日志
    	$tableInfo = array();
    	$tableInfo['u_id'] 			= $u_id;
    	$tableInfo['create_time'] 	= $datetime;
    	$tableInfo['rebate_score'] 	= $score;
    	$tableInfo['percent'] 		= $rebate_per;
    	$tableInfo['ticket_id'] 	= $ticket_id;
    	$tableInfo['ticket_money'] 	= $userTicketInfo['money'];
    	$record_id = $this->add($tableInfo);
    	if (!$record_id) {
    		return InternalResultTransfer::fail('记录返点失败');
    	}
    	//添加到余额
    	$tmpResult = $objUserAccountFront->addCash($u_id, $score);
    	if (!$tmpResult->isSuccess()) {
    		return InternalResultTransfer::fail('返点自动流入账户失败');
    	}
    	//添加余额日志
    	$userAccountInfo = $objUserAccountFront->get($u_id);
    	$tableInfo = array();
    	$tableInfo['u_id'] 			= $u_id;
    	$tableInfo['create_time'] 	= $datetime;
    	$tableInfo['money'] 		= $score;
    	$tableInfo['old_money'] 	= $userAccountInfo['cash'];
    	$tableInfo['log_type'] 		= BankrollChangeType::REBATE_TO_ACCOUNT;
    	$tableInfo['record_table'] 	= 'user_rebate';
    	$tableInfo['record_id'] 	= $record_id;
    	
    	$objUserAccountLogFront = new UserAccountLogFront($u_id);
    	$ticket_log_id = $objUserAccountLogFront->add($tableInfo);
    	if (!$ticket_log_id) {
    		return InternalResultTransfer::fail('记录返点流水失败');
    	}
    	
    	return InternalResultTransfer::success();
    }
}
?>
<?php
/**
 * 帐户前端类
 * @author gaoxiaogang@gmail.com
 *
 */
class AccountFront {
	/**
	 * @var Account $objAccount
	 */
    protected $objAccount;

    public function __construct() {
        $this->objAccount = new Account();
    }

    public function get($uid) {
    	return $this->objAccount->get($uid);
    }

    /**
     * 消费
     * @param int $uid 用户id
     * @param int $money 金额 单位：分
     *  @param array accountlog_meg 需要记录到账户日志中的信息
	 *         accountlog_meg=array
	 *         (
	 *         		'status'=> 账户消费类别, (必填)
	 *         		'account_log_no'=>账户记录的流水号(必填)
	 *         		'handle_uid' => 操作者（必填）
	 *         		'outTradeNo' => 消费针对哪一个用户订单号
	 *         		'reason'=> 账户充值原因-- 如:订单消费
	 *
	 *         )
     * @throws ParamsException '无效的uid参数'
     * @throws ParamsException '无效的money参数'
     * @return InternalResultTransfer 失败：数据里返回失败描述；
     */
    public function consume($uid, $money,$accountlog_msg=array('status'=>'')) {
    	if(empty($accountlog_msg['status']))
		{
			return InternalResultTransfer::fail('请指定账户消费类别');
		}
		if(empty($accountlog_msg['account_log_no']))
		{
			return InternalResultTransfer::fail('请指定账户消费流水账号');
		}

		$accountlog_msg['account_log_no'] = $accountlog_msg['status'] . $accountlog_msg['account_log_no'];
		$accountlog_msg['log_no_idx'] = md5($accountlog_msg['account_log_no']);

		$objDBTransaction = new DBTransaction();
 		$strTransactionId = $objDBTransaction->start();
    	$conResult = $this->objAccount->consume($uid, $money);
   		 if(!$conResult->isSuccess())
		{
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('账户消费失败');
		}
		$tmpResult = $conResult->getData();
		##记录信息到账户记录中
		$logInfo = $accountlog_msg;
		$logInfo['uid'] = $uid;
		//后期添加 不可提现金额 的时候  需要 详细的记录 是哪种金额 ；目前money全为可提现金额
		$logInfo['widthdraw'] = ConvertData::toMoney($tmpResult['account']['widthdraw']/100);  //账户中的剩余可提现金额
		$logInfo['balance'] = ConvertData::toMoney($tmpResult['account']['balance']/100);   //账户中的可用金额
		$logInfo['totalMoney']	= ConvertData::toMoney($tmpResult['log']['balance']/100);// 已扣除的可用余额
		$logInfo['WidthdrawMoney'] = ConvertData::toMoney($tmpResult['log']['widthdraw']/100);// 已扣除的可提现金额

		$objAccountLogFront = new AccountLogsFront();
		$logResult = $objAccountLogFront->add($logInfo);
		if(!$logResult)
		{
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('账户记录失败');
		}
	  	if (!$objDBTransaction->commit($strTransactionId)) {
			return InternalResultTransfer::fail('提交事务失败');
		}

		return InternalResultTransfer::success($tmpResult);
    }

    /**
	 * 金额的充值，传递充值总金额和可提现金额，不可提现金额计算得出
	 * @param int $uid 用户id
	 * @param int $money 金额 单位：分  总金额
	 * @param int $widthDrawMoney  可提现金额 单位：分
	 * @param array accountlog_meg 需要记录到账户日志中的信息
	 *         accountlog_meg=array
	 *         (
	 *         		'status'=> 账户充值类别, (必填)
	 *         		'account_log_no'=>账户记录的流水号(必填)
	 *         		'handle_uid' => 操作者（必填）支付宝默认为0
	 *         		'reason'=> 账户充值原因-- 如:退款充值
	 *         		'outTradeNo' => 如果是退款充值，针对哪一个用户订单号
	 *         )
	 * @throws ParamsException '无效的uid参数'
	 * @throws ParamsException '无效的money参数'
	 * @return InternalResultTransfer 失败：数据里返回失败描述；成功：返回可用余额
	 */
	public function topUp($uid, $money,$widthDrawMoney,$accountlog_msg=array('status'=>''))
	 {
		if(empty($accountlog_msg['status']))
		{
			return InternalResultTransfer::fail('请指定账户充值类别');
		}
		 if(empty($accountlog_msg['account_log_no']))
		{
			return InternalResultTransfer::fail('请指定账户充值流水账号');
		}

		$accountlog_msg['account_log_no'] = $accountlog_msg['status'].$accountlog_msg['account_log_no'];
		$accountlog_msg['log_no_idx'] = md5($accountlog_msg['account_log_no']);

      	 $objDBTransaction = new DBTransaction();
 		 $strTransactionId = $objDBTransaction->start();
		$topupResult = $this->objAccount->topUp($uid, $money,$widthDrawMoney);
		if(!$topupResult->isSuccess())
		{
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('账户充值失败');
		}
		$tmpblance = $topupResult->getData();
		$logInfo = $accountlog_msg;
		$logInfo['uid'] = $uid;
		$logInfo['totalMoney'] = ConvertData::toMoney($money/100);
		$logInfo['WidthdrawMoney'] = ConvertData::toMoney($widthDrawMoney/100);
		$logInfo['balance'] = ConvertData::toMoney($tmpblance/100);

		$objAccountLogFront = new AccountLogsFront();
		$logResult = $objAccountLogFront->add($logInfo);
		if(!$logResult)
		{
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('账户记录失败');
		}
	  	if (!$objDBTransaction->commit($strTransactionId)) {
			return InternalResultTransfer::fail('提交事务失败');
		}

		return InternalResultTransfer::success($tmpblance);
	 }
	 
	 
	 
	/**
     * 后台提现操作
     * @param int $uid 用户id
     * @param int $money 金额 单位：分
     *  @param array accountlog_meg 需要记录到账户日志中的信息
	 *         accountlog_meg=array
	 *         (
	 *         		'status'=> 账户消费类别, (必填)
	 *         		'account_log_no'=>账户记录的流水号(必填)
	 *         		'handle_uid' => 操作者（必填）
	 *         		'outTradeNo' => 消费针对哪一个用户订单号
	 *         		'reason'=> 账户充值原因-- 如:订单消费
	 *
	 *         )
     * @throws ParamsException '无效的uid参数'
     * @throws ParamsException '无效的money参数'
     * @return InternalResultTransfer 失败：数据里返回失败描述；
     */
    public function cash($uid, $money,$accountlog_msg=array('status'=>'')) {
    	if(empty($accountlog_msg['status']))
		{
			return InternalResultTransfer::fail('请指定账户提现类别');
		}
		if(empty($accountlog_msg['account_log_no']))
		{
			return InternalResultTransfer::fail('请指定账户提现流水账号');
		}

		$accountlog_msg['account_log_no'] = $accountlog_msg['status'] . $accountlog_msg['account_log_no'];
		$accountlog_msg['log_no_idx'] = md5($accountlog_msg['account_log_no']);

		$objDBTransaction = new DBTransaction();
		$userAccountRes = $this->objAccount->get($uid);
		
		if(!isset($userAccountRes['widthdraw']) || $userAccountRes['widthdraw'] < $money){
			return InternalResultTransfer::fail('提现金额大于可此用户账户可提现金额');
		}
 		$strTransactionId = $objDBTransaction->start();
 		$conResult = $this->objAccount->cash($uid, $money);
   		 if(!$conResult->isSuccess())
		{
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('账户提现失败');
		}
		$tmpResult = $conResult->getData();
		##记录信息到账户记录中
		$logInfo = $accountlog_msg;
		$logInfo['uid'] = $uid;
		//后期添加 不可提现金额 的时候  需要 详细的记录 是哪种金额 ；目前money全为可提现金额
		$logInfo['widthdraw'] = ConvertData::toMoney($tmpResult['account']['widthdraw']/100);  //账户中的剩余可提现金额
		$logInfo['balance'] = ConvertData::toMoney($tmpResult['account']['balance']/100);   //账户中的可用金额
		$logInfo['totalMoney']	= ConvertData::toMoney($tmpResult['log']['balance']/100);// 已扣除的可用余额
		$logInfo['WidthdrawMoney'] = ConvertData::toMoney($tmpResult['log']['widthdraw']/100);// 已扣除的可提现金额

		$objAccountLogFront = new AccountLogsFront();
		$logResult = $objAccountLogFront->add($logInfo);
		if(!$logResult)
		{
			$objDBTransaction->rollback($strTransactionId);
			return InternalResultTransfer::fail('账户记录失败');
		}
	  	if (!$objDBTransaction->commit($strTransactionId)) {
			return InternalResultTransfer::fail('提交事务失败');
		}

		return InternalResultTransfer::success($tmpResult);
    }
	 
	 
	 
	 
	 
	 
	 
}
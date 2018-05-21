<?php
/*
 * 帐户日志前端类
 */
class AccountLogsFront
{
	/**
	 * @var AccountLogs $$objAccountLogs
	 */
    protected $objAccountLogs;

    public function __construct()
    {
        $this->objAccountLogs = new AccountLogs();
    }

    public function add(array $info)
    {
        $tmpResult = $this->objAccountLogs->add($info);
        return $tmpResult;
    }

	/**
     * 获得状态信息
     */
   public function getLogsDesc()
    {
    	return $this->objAccountLogs->getLogsDesc();
    }

	/**
     * 按条件获取指定用户的账户日志列表
     * @param int $uid
     * @param mixed $limit
     * @return array
     */
    public function getsByUid($uid, $limit = null,$order) {
    	$tmpResult = $this->objAccountLogs->getsByUid($uid, $limit,$order);
    	return $tmpResult;
    }

    /**
     * 获得所有日志
     */
    public function getsAll($order,$limit)
    {
    	return $this->objAccountLogs->getsAll($order,$limit);
    }
}

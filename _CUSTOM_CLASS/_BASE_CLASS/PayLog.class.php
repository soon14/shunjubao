<?php
/**
 * 支付平台流水日志后端类
 * @author lihuanchun
 */
class PayLog extends DBSpeedyPattern {
	
	protected $tableName = 'pay_log';
	
	protected $primaryKey = 'charge_id';
	
	protected $real_field = array(   	
			'id',		
			'u_id',
			'money',
			'provider',
			'create_time',
			'update_time',
			'status',
			'out_trade_no',
			'extend',
    );
    
    /**
     * 
     * 状态常量
     * 1、交易中
     * 2、交易成功
     * 3、交易失败
     * @var int
     */
    const PAY_LOG_STATUS_INTRADE = 1;
    const PAY_LOG_STATUS_SUCCESS = 2;
    const PAY_LOG_STATUS_FAILED  = 3;
    
	/**
	 * 添加一条日志
	 *
	 * @param array $tableInfo
	 * @return boolean
	 */
	public function addPayLog(array $tableInfo) {
		if (empty($tableInfo)) return false;
		$tableInfo['create_time'] = getCurrentDate();
		$tableInfo['update_time'] = $tableInfo['create_time'];
		$tableInfo['status'] = self::PAY_LOG_STATUS_INTRADE;
		
		$info = array();
		$info = $this->parseExtend($tableInfo);
		return $this->add($info);
	}
	

	/**
	 * 更新一条信息
	 * @param array $tableInfo
	 * @return InternalResultTransfer
	 */
	public function updatePayLog(array $tableInfo) {
		if (empty($tableInfo)) return InternalResultTransfer::fail('empty info');
		$tableInfo = $this->parseExtend($tableInfo);
		return $this->modify($tableInfo);
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
    
    public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}

		return array_pop($tmpResult);
    }
    
    public function gets($ids) {
    	$result = parent::gets($ids);
        return $this->UnparseExtend($result);
    }

}
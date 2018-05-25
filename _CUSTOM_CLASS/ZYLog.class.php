<?php
/**
 * 聚宝日志类：记录各种日志
 */

class ZYLog extends DBSpeedyPattern {
	
	protected $primaryKey = 'id';
	
	protected $real_field = array(
			'id',
			'status',//日志状态，错误或正常
			'log',//日志内容，字符串
			'type',//日志类型，
			'create_time',
	);
	
	protected $tableName = 'zy_log';
	
	//日志状态：成功
	CONST LOG_STATUS_SUCCESS = 1;
	//日志状态：失败
	CONST LOG_STATUS_ERROR = 2;
	
	static public function getlogStatusDesc() {
		return array(
			self::LOG_STATUS_SUCCESS	=> array(
				'desc'	=> '成功',
			),
			self::LOG_STATUS_ERROR	=> array(
				'desc'	=> '失败',
			),
		);
	}
	
	/**
	 * 添加一条记录，并把id转成字符串添加进去
	 * @param array
	 * @return int| false
	 */
	public function add($info) {
	
		$info['status'] 	= $info['status']?$info['status']:self::LOG_STATUS_SUCCESS;//默认是成功
		$info['type'] 		= $info['type']?$info['type']:self::LOG_TYPE_ALIPAY;//默认是支付宝接口
		$info['create_time']= getCurrentDate();
	
		return  parent::add($info);
	}
	
	/**
	 * 日志类型：支付宝接口
	 */
	CONST LOG_TYPE_ALIPAY = 1;
	/**
	 * 华阳出票
	 */
	CONST LOG_TYPE_HY = 2;
	/**
	 * 尊傲出票
	 */
	CONST LOG_TYPE_ZA = 3;
	
	static public function getTYPEDesc() {
		return array(
			self::LOG_TYPE_ALIPAY	=> array(
				'desc'	=> '支付宝接口',
			),
			self::LOG_TYPE_HY	=> array(
				'desc'	=> '华阳出票',
			),
			self::LOG_TYPE_ZA	=> array(
				'desc'	=> '尊傲出票',
			),
		);
	}
	
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		return $this->findBy($condition , null, $limit, '*', $order);
	}
	
    public function getNum($start, $end, $status) {
    	$status == 'all'?
    	$sql = "select count(*) as num from ".$this->tableName . " where `create_time`>='{$start}' and `create_time`<='{$end}' ":
    	$sql = "select count(*) as num from ".$this->tableName . " where `create_time`>='{$start}' and `create_time`<='{$end}' and `status`={$status}";
    	$res = $this->db->fetchOne($sql);
    	return $res['num'];
    }
}
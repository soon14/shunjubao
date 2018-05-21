<?php
class LakalaRefundLog extends DBAbstract {
	protected $tableName = 'lakala_refund_log';
	
	/**
	 * 退款请求成功
	 */
	const STATUS_SUCCESS = 5;
	
	/**
	 * 退款请求失败
	 */
	const STATUS_FAILURE = 1;
}
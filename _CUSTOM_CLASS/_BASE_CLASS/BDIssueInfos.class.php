<?php
/**
 * 北单期次信息表
 */
class BDIssueInfos extends DBSpeedyPattern {
	protected $tableName = 'bd_issue_infos';
	protected $primaryKey = 'id';
	protected $real_field = array(
			'id',
			'lotteryId',
			'issueNumber',
			'starttime',//开始接票时间
			'stoptime',//接票截止时间
			'closetime',//官方截止时间
			'prizetime',//兑奖时间
			'status',//未开售=0, 销售中=1,已截止=2,已开奖=3,已派奖=4
	);
	/**
	 * 期次状态之：未开售
	 */
	CONST STATUS_NOT_SELLING = '0';
	/**
	 * 期次状态之：销售中
	 */
	CONST STATUS_SELLING = '1';
	/**
	 * 期次状态之：已截止
	 */
	CONST STATUS_END = '2';
	/**
	 * 期次状态之：已开奖
	 */
	CONST STATUS_OPEN_PRIZE = '3';
	/**
	 * 期次状态之：已派奖
	 */
	CONST STATUS_SEND_PRIZE = '4';
	
	static public function getStatusDesc() {
		return array(
			self::STATUS_NOT_SELLING => array(
					'desc' => '未开售',
			),
			self::STATUS_SELLING => array(
					'desc' => '销售中',
			),
			self::STATUS_END => array(
					'desc' => '已截止',
			),
			self::STATUS_OPEN_PRIZE => array(
					'desc' => '已开奖',
			),
			self::STATUS_SEND_PRIZE => array(
					'desc' => '已派奖',
			),
		);
	}
	
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , $limit, $order);
		return $this->gets($ids);
	}
}
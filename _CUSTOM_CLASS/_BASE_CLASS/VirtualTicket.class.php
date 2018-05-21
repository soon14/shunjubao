<?php
/**
 * 虚拟票基础类
 * @author hushiyu
 *
 */
class VirtualTicket extends DBSpeedyPattern {
	protected $tableName = 'virtual_ticket';
	protected $primaryKey = 'id';
	
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
			'id',// int(10) unsigned NOT NULL AUTO_INCREMENT,
			'u_id',// int(10) NOT NULL,
			'u_name',// varchar(40) COLLATE latin1_general_ci NOT NULL,
			'status',// tinyint(3) NOT NULL,
			'select',// varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT '串关数暂时用不到',
			'multiple',// int(6) NOT NULL COMMENT '倍数：最大10w',
			'money',// float(10,2) NOT NULL COMMENT '实际指积分',
			'prize',// float(10,2) NOT NULL,
			'combination',// text COLLATE latin1_general_ci NOT NULL,
			'odds',// varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT '实时的赔率和让球数',
			'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
			'source',// tinyint(3) NOT NULL COMMENT '含义同出票的source',
			'sport',// varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT '玩法字段预留',
	);
	
	/**
	 * 投注失败
	 */
	CONST VIRTUAL_TICKET_STATUS_NOT_TOUZHU = 10;
	/**
	 * 已投注
	 */
	CONST VIRTUAL_TICKET_STATUS_TOUZHU = 1;
	/**
	 * 未中奖
	 */
	CONST VIRTUAL_TICKET_STATUS_NOT_PRIZE = 2;
	/**
	 * 已中奖
	 */
	CONST VIRTUAL_TICKET_STATUS_PRIZE = 3;
	
	static public function getStatusDesc() {
		return array(
			self::VIRTUAL_TICKET_STATUS_NOT_TOUZHU 	=>array('desc'=>'投注失败'),
			self::VIRTUAL_TICKET_STATUS_TOUZHU 		=>array('desc'=>'已投注'),
			self::VIRTUAL_TICKET_STATUS_NOT_PRIZE 	=>array('desc'=>'未中奖'),
			self::VIRTUAL_TICKET_STATUS_PRIZE 		=>array('desc'=>'已中奖'),
		);
	}
}
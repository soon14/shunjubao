<?php
/**
 * 推广链接结算
 * @author hushiyu
 *
 */
class SiteFromAccount extends DBSpeedyPattern {
	protected $tableName = 'site_from_account';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
		'id',// int(10) NOT NULL AUTO_INCREMENT,
		'site_from_id',// int(10) NOT NULL COMMENT '推广id',
		'start_time',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '结算开始时间',
		'end_time',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '结算结束时间',
		'gift',// int(10) NOT NULL COMMENT '结算的彩金',
		'rebate_score',// float(10,2) NOT NULL COMMENT '结算的返点',
		'rebate_per',// float(3,2) NOT NULL COMMENT '返点比例',
		'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
		'cash',// float(10,2) NOT NULL,
	);
	
}
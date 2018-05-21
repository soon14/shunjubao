<?php
/**
 * 
 * 出票接口的流水信息
 * 1、记录发送信息
 * 2、记录返回信息
 * @author administrator
 *
 */
class TicketFlow extends DBSpeedyPattern {
	
	protected $real_field = array(
		'id',
		'flow_id',//交易流水号，唯一
		'extend',
		'company',//出票接口公司
		'create_time',
		'return_time',//接口返回时间
		'return_code',
		'return_message',
	
	);
    
	protected $tableName = 'ticket_flow';
	
	/**
	 * 出票公司：华阳
	 */
	CONST COMPANY_HUAYANG = 1;
	
	static public function getAllCompany() {
		return array(
			self::COMPANY_HUAYANG	=> array(
				'code'	=> self::COMPANY_HUAYANG,
				'desc'	=> '华阳',
			),
		);
	}
}
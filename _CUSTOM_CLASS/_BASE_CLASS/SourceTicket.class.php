<?php
/**
 * 用户来源与订单关系类
 * @author hushiyu
 *
 */
class SourceTicket extends DBSpeedyPattern {
	protected $tableName = 'source_ticket';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'ticket_id',
    	'u_id',
    	'u_name',
    	'money',
    	'source',
    	'create_time',
    );
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , $limit, $order);
    	return $this->gets($ids);
    }
}
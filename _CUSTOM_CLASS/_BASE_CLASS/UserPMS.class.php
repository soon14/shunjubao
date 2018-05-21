<?php
/*
 * 站内用户短消息后端类
 */
class UserPMS extends DBSpeedyPattern{
	protected $tableName = 'user_pms';
	protected $primaryKey = 'id';
	
	protected $real_field = array(
		'receive_uid',//接收人uid
		'send_uid',//发信人uid
		'status',
		'subject',//简短主题，var:string
		'body',//内容，var:string
		'start_time',//开始时间
		'end_time',//结束时间
		'create_time',
	);
	
	static private $statusDesc = array(
    	self::STATUS_NOT_RECEIVING => array(
    		'desc'	=> '未接收',
    		'kw'		=> 'STATUS_NOT_RECEIVING',
    	),
    	self::STATUS_RECEIVING	=> array(
    		'desc'	=> '已接收',
    		'kw'	=> 'STATUS_RECEIVING',
    	),
    	self::STATUS_DELETE	=> array(
    		'desc'	=> '已删除',
    		'kw'	=> 'STATUS_DELETE',
    	),
    );
	
    
	public function getStatusDesc() {
    	return self::$statusDesc;
    }
    
    /**
     * 未接收状态
     */
    const STATUS_NOT_RECEIVING = 1;
    
    /**
     * 已接收状态
     */
    const STATUS_RECEIVING = 2;
    
	/**
	 * 已删除
	 */
    CONST STATUS_DELETE = 3;
	
    public function getUnRecieviSum($u_id) {
    	$sql = "select count(*) from ". $this->tableName . " where receive_uid = ". $u_id . " and status = ". self::STATUS_NOT_RECEIVING;
    	return $this->db->fetchSclare($sql);;
    }
}
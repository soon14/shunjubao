<?php 
class UserGiftLog extends DBSpeedyPattern {
	protected $tableName = 'user_gift_log';
	protected $primaryKey = 'log_id';

	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
        'log_id',
		'u_id',
		'gift',
		'old_gift',
		'log_type',
		'record_table',
		'record_id',
		'create_time',
    );
    
    /**
     * 彩金变化类型
     * 增加
     * 1、购买赠送
     * 2、注册赠送
     * 
     * 减少
     * 21、购彩消费
     * 
     */
    
    CONST BUY = 1;
    CONST REGISTER = 2;
    
    CONST CONSUME_BUY = 21;
    
    private static $giftTypes = array(
    	self::BUY 			=> '购买赠送',
    	self::REGISTER		=> '注册赠送',
    	self::CONSUME_BUY	=> '购彩消费',
    );
    
	/**
	 * 获取积分变化类型表述
	 * @return array
	 */
	static public function getGiftTypes() {
		return self::$giftTypes;
	}
	
	
	  public function getNum($start, $u_id) {
    	$sql = "select count(*) as num from ".$this->tableName . " where `create_time`>='{$start}' and log_type='17' and `u_id`='{$u_id}'  ";
    	$res = $this->db->fetchOne($sql);
    	return $res['num'];
    }
	
	
	
	
	
	
}
?>

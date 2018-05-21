<?php
/**
 * 
 * 用户积分日志后端类
 * @author Administrator
 *
 */
class UserScoreLog extends DBSpeedyPattern {
	
	protected $tableName = 'user_score_log';
	protected $primaryKey = 'log_id';
	
	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
        'log_id',
		'u_id',
		'score',
		'old_score',
		'log_type',
		'record_table',
		'record_id',
		'create_time',
    );
	
    /**
     * 积分变化类型
     * 增加
     * 1、注册
     * 2、登录
     * 3、投注
     * 4、充值
     * 5、直接赠送 
     * 
     * 减少
     * 21、购彩消费
     * 
     */
    CONST REGISTER = 1;
    CONST LOGIN = 2;
    CONST TICKER = 3;
    CONST CHARGE = 4;
    CONST PRESENT = 5;
    
    CONST CONSUME_BUY = 21;
    
    private static $scoreTypes = array(
    	self::REGISTER	=> '注册',
    	self::LOGIN		=> '登录',
    	self::TICKER	=> '投注',
    	self::CHARGE	=> '充值',
    	self::PRESENT	=> '赠送',
    	self::CONSUME_BUY	=>'购彩消费',
    );
    
	/**
	 * 获取积分变化类型表述
	 * @return array
	 */
	static public function getScoreTypes() {
		return self::$scoreTypes;
	}
}
?>
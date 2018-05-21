<?php
/**
 * 用户留言表
 * @author administrator
 *
 */
class UserMessage extends DBSpeedyPattern {
	protected $tableName = 'user_message';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'u_id',
    	'u_name',
    	'title',//标题
    	'create_time',//开始时间
    	'status',//2 初始状态：待审核| 1：审核通过
    	'message',//消息
    	'img',//上传的图片
    );
    
	/**
	 * 待审核
	 */
    CONST STATUS_NOT_SHENHE = 2;
    
    /**
	 * 审核通过
	 */
    CONST STATUS_SHENHE = 1; 
    
    static private $statusDesc = array(
    		self::STATUS_NOT_SHENHE => array(
    				'desc'			=> '待审核',
    				'kw'			=> 'STATUS_NOT_SHENHE',
    		),
    		self::STATUS_SHENHE => array(
    				'desc'			=> '审核通过',
    				'kw'			=> 'STATUS_SHENHE',
    		),
    );
    
    /**
     * 获取所有状态描述
     * @return array
     */
    static public function getStatusDesc() {
    	return self::$statusDesc;
    }
    
}

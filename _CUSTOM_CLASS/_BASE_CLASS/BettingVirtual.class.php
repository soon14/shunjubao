<?php
/**
 * 虚拟赛事类
 * @author hushiyu
 *
 */
class BettingVirtual extends DBSpeedyPattern {
	protected $tableName = 'virtual_betting';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
		'id',
		'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
		'start_time',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '比赛开始时间',
		'end_time',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '比赛结束时间',
		'host_team',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '主队',
		'guest_team',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '客队',
		'sport',// varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT '赛事类型：足球、篮球',
		'status',// tinyint(3) NOT NULL COMMENT '赛事状态：1开始、2进行中、3结束',
		'remark',// varchar(5) COLLATE latin1_general_ci NOT NULL COMMENT '让球数',
		'h',// float(3,2) NOT NULL COMMENT '上盘赔率',
		'a',// float(3,2) NOT NULL COMMENT '下盘赔率',
		'num',//含义同竞彩足球, 
		'result',// varchar(5) COLLATE latin1_general_ci NOT NULL COMMENT '赛果：胜平负',
		'lottery_result',// varchar(3) COLLATE latin1_general_ci NOT NULL COMMENT '彩果：胜平负',
		'score',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '完场比分'
	);
	
	/**
	 * 比赛销售中，即可投注状态
	 * @var unknown
	 */
	CONST VB_STATUS_SELLING = 1;
	/**
	 * 比赛进行中，即不可投注状态
	 * @var unknown
	 */
	CONST VB_STATUS_START = 2;
	/**
	 * 比赛已结束，即不可投注状态
	 * @var unknown
	 */
	CONST VB_STATUS_END = 3;
	
	/**
	 * 比赛推迟，即不可投注状态
	 * @var unknown
	 */
	CONST VB_STATUS_DELAY = 4;
	/**
	 * 比赛取消，即不可投注状态
	 * @var unknown
	 */
	CONST VB_STATUS_CANCEL = 5;
	
	static private $statusDesc = array(
    		self::VB_STATUS_SELLING => array(
    				'desc'			=> '销售中',
    		),
    		self::VB_STATUS_START => array(
    				'desc'			=> '进行中',
    		),
    		self::VB_STATUS_END => array(
    				'desc'			=> '结束',
    		),
    		self::VB_STATUS_DELAY => array(
    				'desc'			=> '推迟',
    		),
    		self::VB_STATUS_CANCEL => array(
    				'desc'			=> '取消',
    		),
    );
    
    /**
     * 获取所有状态描述
     * @return array
     */
    static public function getStatusDesc() {
    	return self::$statusDesc;
    }
    
    CONST VB_SPORT_FB = 'fb';
    CONST VB_SPORT_BK = 'bk';
    
    /**
     * 获取所有状态描述
     * @return array
     */
    static public function getSportDesc() {
    	return array(
    		self::VB_SPORT_FB => array(
    				'desc'			=> '足球',
    		),
    		self::VB_SPORT_BK => array(
    				'desc'			=> '篮球',
    		)
    	);
    }
    
    CONST VB_RESULT_H = 'h';
    CONST VB_RESULT_D = 'd';
    CONST VB_RESULT_A = 'a';
    CONST VB_RESULT_NONE = '';
    /**
     * 获取所有状态描述
     * @return array
     */
    static public function getResultDesc() {
    	return array(
    			self::VB_RESULT_NONE => array(
    					'desc'			=> '暂无',
    			),
    			self::VB_RESULT_H => array(
    					'desc'			=> '胜',
    			),
    			self::VB_RESULT_D => array(
    					'desc'			=> '平',
    			),
    			self::VB_RESULT_A => array(
    					'desc'			=> '负',
    			),
    	);
    }
}
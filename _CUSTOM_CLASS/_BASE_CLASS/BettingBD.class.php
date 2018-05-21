<?php
/**
 * 赛事表，北单
 * 接口数据来源：尊傲，编码utf-8
 * @author administrator
 *
 */
class BettingBD extends DBSpeedyPattern {
	protected $tableName = 'bd_betting';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'lotteryId',//玩法代码
    	'issueNumber',//期数
    	'num',//含义同竞彩
    	'name',//联赛
    	'matchid',//
    	'hometeam',//主队
    	'guestteam',//客队
    	'l_cn',//联赛名称
    	'l_color',//联赛颜色
    	'matchtime',//比赛时间 yyyy-MM-dd HH:mm
    	'sellouttime',//停售时间 yyyy-MM-dd HH:mm
    	'date',//比赛开始日期 yyyy-MM-dd
    	'time',//比赛开始时间 HH:mm:ss
    	'matchstate',//比赛状态销售中=0,中断=1,推迟=2取消=3,完场=4   	
    	'remark',//扩展字段,存放主队的让球数
    );
    
	/**
	 * 销售中
	 * @var int
	 */
    CONST MATCH_STATE_SELLING = '0';
    
    /**
	 * 中断
	 * @var int
	 */
    CONST MATCH_STATE_INTERRUPT = '1'; 
    
    /**
	 * 推迟
	 * @var int
	 */
    CONST MATCH_STATE_DELAY = '2';
    
    /**
	 * 取消
	 * @var int
	 */
    CONST MATCH_STATE_CANCEL = '3';
    
    /**
     * 完场
     * @var int
     */
    CONST MATCH_STATE_FINISHED = '4';
    
    static private $statusDesc = array(
    		self::MATCH_STATE_SELLING => array(
    				'desc'			=> '销售中',
    				'kw'			=> 'MATCH_STATE_SELLING',
    		),
    		self::MATCH_STATE_INTERRUPT => array(
    				'desc'			=> '中断',
    				'kw'			=> 'MATCH_STATE_INTERRUPT',
    		),
    		self::MATCH_STATE_DELAY => array(
    				'desc'			=> '推迟',
    				'kw'			=> 'MATCH_STATE_DELAY',
    		),
    		self::MATCH_STATE_CANCEL => array(
    				'desc'			=> '取消',
    				'kw'			=> 'MATCH_STATE_CANCEL',
    		),
    		self::MATCH_STATE_FINISHED => array(
    				'desc'			=> '完场',
    				'kw'			=> 'MATCH_STATE_FINISHED',
    		),
    );
    
    /**
     * 获取所有状态描述
     * @return array
     */
    static public function getStatusDesc() {
    	return self::$statusDesc;
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , $limit, $order);
    	return $this->gets($ids);
    }
    
    /**
     * 转换时间戳，从12位数字到14位字符串
     * @param timestamp $timestamp yyyyMMddHHmm
     * @return string yyyy-MM-dd HH:mm:00
     */
   static public function tranTimeTo14($timestamp) {
    	return date('Y-m-d H:i:s', strtotime($timestamp));
    }
}

<?php
/**
 * 赛事表
 * @author administrator
 *
 */
class Betting extends DBSpeedyPattern {
	
	protected $tableName = '_betting';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	's_code',//sport code
    	'num',//match id
    	'date',//比赛开始日期
    	'time',//开始时间
    	'b_date',//
    	'status',//selling | final
    	'hot',//
    	'l_code',//联赛code
    	'l_id',
    	'l_en',
    	'l_cn',
    	'h_code',
    	'h_id',
    	'h_en',
    	'h_cn',
    	'a_code',
    	'a_id',
    	'a_en',
    	'a_cn',
    	'index_show',//赛事信息锁，0为不锁，1为锁(含义是：若赛事锁定，则不接收官方数据更新)
    	'danguan',//是否单关比赛
    	'show',
    	'color',
    	'message',
    );
    
	/**
	 * 在售
	 * @var unknown_type
	 */
    CONST STATUS_SELLING = 'Selling';
    
    /**
	 * 暂时未知
	 * @var unknown_type
	 */
    CONST STATUS_DEFINE = 'Define'; 
    
    /**
	 * 停售
	 * @var unknown_type
	 */
    CONST STATUS_CLOSE = 'Close';
    
    /**
	 * 完结
	 * @var unknown_type
	 */
    CONST STATUS_FINAL = 'Final';
    
    /**
     * 退款
     * @var unknown
     */
    CONST STATUS_REBACK = 'Reback';
    
    static private $statusDesc = array(
    		self::STATUS_SELLING => array(
    				'desc'			=> '在售',
    				'kw'			=> 'STATUS_SELLING',
    		),
    		self::STATUS_CLOSE => array(
    				'desc'			=> '停售',
    				'kw'			=> 'STATUS_CLOSE',
    		),
    		self::STATUS_FINAL => array(
    				'desc'			=> '完结',
    				'kw'			=> 'STATUS_FINAL',
    		),
    		self::STATUS_REBACK => array(
    				'desc'			=> '退款',
    				'kw'			=> 'STATUS_REBACK',
    		),
    );
    
    /**
     * 获取所有状态描述
     * @return array
     */
    static public function getStatusDesc() {
    	return self::$statusDesc;
    }
    
    public function __construct($sport) {
    	$this->tableName = $sport . $this->tableName;
    	parent::__construct('default');
    }
    
    /**
     * 通过赛事时间和场次信息获取比赛id
     * @return int 
     */
    public function getMatchInfoByDateAndNum($b_date, $num) {
    	$condition = array(
    			'b_date'	=> $b_date,
    			'num'		=> $num,
    	);
    	return $this->fetchOne($condition);
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , $limit, $order);
    	return $this->gets($ids);
    }
    
    public function getXmlListDesc() {
		return array(
			'2_1_0'		=> '足球联赛信息',
			'2_2_0'		=> '联赛信息',
			'4_1_0' 	=> '足球赛事对阵',
			'4_2_0' 	=> '篮球赛事对阵',
			'5_1_0'		=> '足球赛事状态',
			'5_2_0'		=> '篮球赛事状态',
			'6_1_0'		=> '足球赛事让球数',
			'6_2_0'		=> '足球赛事让球数',
			'9_1_0'		=> '足球赛果',
			'9_2_0'		=> '篮球赛果',
			'10_1_0'	=> '足球彩果',
			'10_2_0'	=> '篮球彩果',
			'13_1_1'	=> '让球胜平负赔率',
			'13_1_2'	=> '半全场赔率',
			'13_1_3'	=> '比分赔率',
			'13_1_4'	=> '总进球赔率',
		//	'13_1_5'	=> '上下盘单双赔率',
			'13_1_10'	=> '足球胜平负赔率',
			'13_2_6'	=> '让分胜负赔率',
			'13_2_7'	=> '篮球胜负赔率',
			'13_2_8'	=> '胜分差赔率',
			'13_2_9'	=> '大小分赔率',
		//	'1_0_0'		=> 'AppParam',
		//	'11_0_0'	=> '国家代码',
		//	'3_1_0'		=> '足球球队代码',
		//	'3_2_0'		=> '篮球球队代码',
		//	'7_1_1'		=> 'PoolDefined','7_1_2'=> 'PoolDefined','7_1_3'=> 'PoolDefined','7_1_4'=> 'PoolDefined','7_1_5'=> 'PoolDefined','7_1_10'=> 'PoolDefined',
		//	'7_2_6'		=> 'PoolDefined','7_2_7'=> 'PoolDefined','7_2_8'=> 'PoolDefined','7_2_9'=> 'PoolDefined',
		//	'12_1_0'	=> 'AllupFormula','12_2_0'	=> 'AllupFormula',
		//	'25_1_41'	=> 'TournOdds','25_1_42'	=> 'TournOdds','25_1_43'	=> 'TournOdds','25_2_41'	=> 'TournOdds','25_2_42'	=> 'TournOdds','25_2_43'	=> 'TournOdds',
		//	'23_1_0'	=> 'TournPool','23_2_0'	=> 'TournPool',
		//	'8_1_1'		=> 'MatchSPValue','8_1_2'	=> 'MatchSPValue','8_1_3'	=> 'MatchSPValue','8_1_4'	=> 'MatchSPValue','8_1_5'	=> 'MatchSPValue',
		//	'8_1_10'	=> 'MatchSPValue','8_2_6'	=> 'MatchSPValue','8_2_7'	=> 'MatchSPValue','8_2_9'	=> 'MatchSPValue','8_2_8'	=> 'MatchSPValue',
		);
	}
}
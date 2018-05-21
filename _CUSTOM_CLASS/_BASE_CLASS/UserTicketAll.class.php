<?php
/**
 * 用户票类说明
 * 1、系统票只有未出票、已出票、出票中和出票失败这几种状态
 * 2、用户票增加部分出票的状态
 * 3、一张用户票正常的状态线应该是：
 * 0未出票(投注)->7投注失败
 * 5已投注(查询是否出票)->3出票失败->8退本金
 * 4出票中(查询是否出票)->3出票失败->8退本金
 * 1已出票(查询是否中奖)
 * 已中奖或未中奖
 */
class UserTicketAll extends DBSpeedyPattern {
	protected $tableName = 'user_ticket_all';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'u_id',
    	'sport',//体育类型 fb|bk
    	'pool',//玩法 hhad|had|….
    	'select',//串关 2x1|3x1|….
    	'user_select',//用户串关方式 mxn
    	'num',//`num` INT(5) NOT NULL DEFAULT '0' COMMENT '比赛场次数量';统计规则：不同的matchid算做不同的比赛
    	'multiple',//投注倍数
    	'money',//投注总金额
    	'datetime',//投注时间
    	'combination',//投注选项 玩法|比赛id|选项&选项,玩法|比赛id|选项&选项,
    	'odds',//投注赔率
    	'return_time',//预计反馈时间
    	'results',//彩果
    	'prize_state',//中奖状态 0 未开奖 1 中奖 2 未中奖 
    	'prize',//总派奖金额
    	'print_state',//出票状态 0 未出票 1 已出票 2 部分出票 3 出票失败
    	'print_time',//出票时间
    	'return_money',//出票总金额
    	'partent_id',//原始单id
    	'combination_type',//跟单类别0 不公开 1：方案公开 2：跟单后可见 3：截止后可见 4：方案保密
    	'endtime',//跟单截止时间
    	'company_id',//出票公司id
    	'source',//来源，主站或手机端
		'recommend',//推荐晒单
		'leitai',//推荐晒单
		'show_range',//晒单设置，1为所有人可见2,跟单人可见
		'pay_rate',//跟单提成比例0,1,2,3,4,5%
    );
    
    /**
     * 中奖状态:未开奖
     * @var int
     */
    const PRIZE_STATE_NOT_OPEN		= 0;
    
    /**
     * 中奖状态:中奖
     * @var int
     */
    const PRIZE_STATE_WIN			= 1;
    
    /**
     * 中奖状态:未中奖
     * @var int
     */
    const PRIZE_STATE_NOT_WIN		= 2;
    
    
    static private $prizeStateDesc = array(
    	self::PRIZE_STATE_NOT_OPEN => array(
    		'desc'			=> '未开奖',
    		'kw'			=> 'PRIZE_STATE_NOT_OPEN',
    	),
    	self::PRIZE_STATE_WIN => array(
    		'desc'			=> '中奖',
    		'kw'			=> 'PRIZE_STATE_WIN',
    	),
    	self::PRIZE_STATE_NOT_WIN => array(
    		'desc'			=> '未中奖',
    		'kw'			=> 'PRIZE_STATE_NOT_WIN',
    	),
    );
    
    /**
     * 获取所有中奖状态描述
     * @return array
     */
    static public function getPrizeStateDesc() {
    	return self::$prizeStateDesc;
    }
    
    /**
     * 出票状态:未出票
     * @var int
     */
    const TICKET_STATE_NOT_LOTTERY		= 0;
    
    /**
     * 出票状态:出票
     * @var int
     */
    const TICKET_STATE_LOTTERY_SUCCESS	= 1;
    
    /**
     * 出票状态:部分出票
     * @var int
     */
    const TICKET_STATE_LOTTERY_PART	= 2;
    
    /**
     * 出票状态:出票失败
     * @var int
     */
    const TICKET_STATE_LOTTERY_FAILED	= 3;
    
     /**
     * 出票状态:出票中
     * 状态说明，体彩中心出票中
     * @var int
     */
    const TICKET_STATE_LOTTERY_ING	= 4;
    
    /**
     * 出票状态:已投注，等待出票
     * 状态说明，此状态的票表示我们已经发送给出票公司，并且对方正确接收，等待出票
     * @var int
     */
    const TICKET_STATE_LOTTERY_TOUZHU	= 5;
    
     /**
     * 出票状态:部分投注
     * 状态说明，此状态的票表示我们已经发送给出票公司，并且对方只正确接收部分，其他投注失败，部分等待出票
     * @var int
     */
    const TICKET_STATE_LOTTERY_TOUZHU_PART	= 6;
    
     /**
     * 出票状态:投注失败
     * 指全部投注均失败
     * @var int
     */
    const TICKET_STATE_LOTTERY_TOUZHU_FAILED	= 7;
    
    /**
     * 出票状态:出票失败已退本金
     * 出票失败退款
     * @var int
     */
    const TICKET_STATE_LOTTERY_TOUZHU_RETURN_MONEY	= 8;
    
    /**
     * 出票状态:部分出票失败已退本金(暂时不用的状态)
     * 部分出票失败退款
     * @var int
     */
    const TICKET_STATE_LOTTERY_TOUZHU_PART_RETURN_MONEY	= 9;
    
    /**
     * 出票状态:投注完结
     * 不再进行后续处理的状态
     * @var int
     */
    const TICKET_STATE_LOTTERY_TOUZHU_FINISNED	= 999;
    
    /**
     * 虚拟投注
     * 除出票外，模拟用户投注过程
     * @var int
     */
    const TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU = 9999;
    
    static private $printStateDesc = array(
    	self::TICKET_STATE_NOT_LOTTERY => array(
    		'desc'			=> '未出票',
    		'kw'			=> 'TICKET_STATE_NOT_LOTTERY',
    	),
    	self::TICKET_STATE_LOTTERY_SUCCESS => array(
    		'desc'			=> '已出票',
    		'kw'			=> 'TICKET_STATE_LOTTERY_SUCCESS',
    	),
    	self::TICKET_STATE_LOTTERY_PART => array( 
    		'desc'			=> '部分出票',
    		'kw'			=> 'TICKET_STATE_LOTTERY_PART',
    	),
    	self::TICKET_STATE_LOTTERY_FAILED => array(
    		'desc'			=> '出票失败',
    		'kw'			=> 'TICKET_STATE_LOTTERY_FAILED',
    	),
    	self::TICKET_STATE_LOTTERY_ING => array(
    		'desc'			=> '出票中',
    		'kw'			=> 'TICKET_STATE_LOTTERY_ING',
    	),
    	self::TICKET_STATE_LOTTERY_TOUZHU => array(
    		'desc'			=> '已投注，等待出票',
    		'kw'			=> 'TICKET_STATE_LOTTERY_TOUZHU',
    	),
    	self::TICKET_STATE_LOTTERY_TOUZHU_PART => array(
    		'desc'			=> '部分投注',
    		'kw'			=> 'TICKET_STATE_LOTTERY_TOUZHU_PART',
    	),
    	self::TICKET_STATE_LOTTERY_TOUZHU_FAILED => array(
    		'desc'			=> '投注失败',
    		'kw'			=> 'TICKET_STATE_LOTTERY_TOUZHU_FAILED',
    	),
    	self::TICKET_STATE_LOTTERY_TOUZHU_RETURN_MONEY => array(
    		'desc'			=> '出票失败已退本金',
    		'kw'			=> 'TICKET_STATE_LOTTERY_TOUZHU_RETURN_MONEY',
    	),
    	self::TICKET_STATE_LOTTERY_TOUZHU_PART_RETURN_MONEY => array(
    		'desc'			=> '部分出票失败已退本金',
    		'kw'			=> 'TICKET_STATE_LOTTERY_TOUZHU_PART_RETURN_MONEY',
    	),
    	self::TICKET_STATE_LOTTERY_TOUZHU_FINISNED => array(
    		'desc'			=> '投注完结',
    		'kw'			=> 'TICKET_STATE_LOTTERY_TOUZHU_FINISNED',
    	),
    	self::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU => array(
    		'desc'			=> '运营投注',
    		'kw'			=> 'TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU',
    	),
    );
    
    CONST FB_CROSSPOOL 		= 'fbcrosspool';
    CONST FB_HAD 			= 'had';
    CONST FB_HHAD 			= 'hhad';
    CONST FB_CRS 			= 'crs';
    CONST FB_TTG 			= 'ttg';
    CONST FB_HAFU			= 'hafu';
    CONST BK_CROSSPOOL 		= 'bkcrosspool';
    CONST BK_HILO 			= 'hilo';
    CONST BK_HDC 			= 'hdc';
    CONST BK_WNM 			= 'wnm';
    CONST BK_MNL 			= 'mnl';
    CONST BD_SPF			= 'SPF';
    CONST BD_SF				= 'SF';
    CONST BD_JQS			= 'JQS';
    CONST BD_BQC			= 'BQC';
    CONST BD_BF				= 'BF';
    CONST BD_SXDS			= 'SXDS';
//      fbcrosspool=>竞彩足球-混合投注
//      bkcrosspool=>竞彩篮球-混合过关
//      had=>竞彩足球_胜平负
//      hhad=>竞彩足球_让球胜平负
//      crs=>竞彩足球_比分
//      ttg=>竞彩足球_总进球
//      hafu=>竞彩足球_半全场

//      hdc=>篮彩_让分胜负
//      hilo=>篮彩_大小分
//      mnl=>篮彩_胜负
//      wnm=>篮彩_胜分差

    static private $sportAndPoolDesc = array(
    	self::FB_CROSSPOOL => array(
    		'desc'			=> '竞彩足球-混合投注',
    		'kw'			=> 'FB_CROSSPOOL',
    	),
    	self::FB_HAD => array(
    		'desc'			=> '竞彩足球_胜平负',
    		'kw'			=> 'FB_HAD',
    	),
    	self::FB_HHAD => array(
    		'desc'			=> '竞彩足球_让球胜平负',
    		'kw'			=> 'FB_HHAD',
    	),
    	self::FB_CRS => array(
    		'desc'			=> '竞彩足球_比分',
    		'kw'			=> 'FB_CRS',
    	),
    	self::FB_TTG => array(
    		'desc'			=> '竞彩足球_总进球',
    		'kw'			=> 'FB_TTG',
    	),
    	self::FB_HAFU => array(
    		'desc'			=> '竞彩足球_半全场',
    		'kw'			=> 'FB_HAFU',
    	),
    	
    	self::BK_CROSSPOOL => array(
    		'desc'			=> '竞彩篮球-混合过关',
    		'kw'			=> 'BK_CROSSPOOL',
    	),
    	self::BK_HILO => array(
    		'desc'			=> '篮彩_大小分',
    		'kw'			=> 'BK_HILO',
    	),
    	self::BK_HDC => array(
    		'desc'			=> '篮彩_让分胜负',
    		'kw'			=> 'BK_HDC',
    	),
    	self::BK_WNM => array(
    		'desc'			=> '篮彩_胜分差',
    		'kw'			=> 'BK_WNM',
    	),
    	self::BK_MNL => array(
    		'desc'			=> '篮彩_胜负',
    		'kw'			=> 'BK_MNL',
    	),
    	
    	self::BD_SPF => array(
    			'desc'			=> '北单_胜平负',
    			'kw'			=> 'BK_BF',
    	),
    	self::BD_SF => array(
    			'desc'			=> '北单_胜负',
    			'kw'			=> 'BD_SF',
    	),
    	self::BD_BF => array(
    			'desc'			=> '北单_比分',
    			'kw'			=> 'BK_BF',
    	),
    	self::BD_BQC => array(
    			'desc'			=> '北单_半全场',
    			'kw'			=> 'BD_BQC',
    	),
    	self::BD_JQS => array(
    			'desc'			=> '北单_进球数',
    			'kw'			=> 'BD_JQS',
    	),
    	self::BD_SXDS => array(
    			'desc'			=> '北单_上下单双',
    			'kw'			=> 'BD_SXDS',
    	),
    	
    );
    
    /**
     * 体育赛事之竞彩足球
     */
    CONST SPORT_FOOTBALL = 'fb';
    /**
     * 体育赛事之竞彩篮球
     */
    CONST SPORT_BASKETBALL = 'bk';
    /**
     * 体育赛事之北京单场
     */
    CONST SPORT_BEIDAN = 'bd';
    
    /**
     * 所有体育赛事类型
     */
    static private $sportDesc = array(
    		self::SPORT_FOOTBALL => array(
    				'desc'			=> '竞彩足球',
    		),
    		self::SPORT_BASKETBALL => array(
    				'desc'			=> '竞彩篮球',
    		),
    		self::SPORT_BEIDAN => array(
    				'desc'			=> '北京单场',
    		),
    );
    
    /**
     * 所有竞彩足球玩法
     */
    static public $allFBPoolDesc = array(
    		self::FB_HAD,
    		self::FB_HHAD,
    		self::FB_CRS,
    		self::FB_TTG,
    		self::FB_HAFU,
    );
    
    /**
     * 所有竞彩篮球玩法
     */
    static public $allBKPoolDesc = array(
    		self::BK_HDC,
    		self::BK_HILO,
    		self::BK_MNL,
    		self::BK_WNM,
    );
    
    /**
     * 所有北京单场玩法
     */
    static public $allBDPoolDesc = array(
    		self::BD_BF,
    		self::BD_BQC,
    		self::BD_JQS,
    		self::BD_SF,
    		self::BD_SPF,
    		self::BD_SXDS,
    );
    
    /**
     * 0:不公开 即可以不晒单 
     */
    CONST COMBINATION_TYPE_NOT_OPEN 	= 0;
     /**
     * 1：方案公开 即可以晒单
     */
    CONST COMBINATION_TYPE_OPEN 		= 1;
     /**
     * 2：跟单后可见 
     */
    CONST COMBINATION_TYPE_FOLLOW_SEE 	= 2;
     /**
     * 3：截止后可见 
     */
    CONST COMBINATION_TYPE_TOUZHU_SEE 	= 3;
     /**
     * 4：方案保密
     */
    CONST COMBINATION_TYPE_SECRET 		= 4;
    
    static private $combinationTypeDesc = array(
    	self::COMBINATION_TYPE_NOT_OPEN => array(
    		'desc'			=> '不公开',
    		'kw'			=> 'COMBINATION_TYPE_NOT_OPEN',
    	),
    	self::COMBINATION_TYPE_OPEN => array(
    		'desc'			=> '方案公开',
    		'kw'			=> 'COMBINATION_TYPE_OPEN',
    	),
    	self::COMBINATION_TYPE_FOLLOW_SEE => array(
    		'desc'			=> '跟单后可见',
    		'kw'			=> 'COMBINATION_TYPE_FOLLOW_SEE',
    	),
    	self::COMBINATION_TYPE_TOUZHU_SEE => array(
    		'desc'			=> '截止后可见',
    		'kw'			=> 'COMBINATION_TYPE_TOUZHU_SEE',
    	),
    	self::COMBINATION_TYPE_SECRET => array(
    		'desc'			=> '方案保密',
    		'kw'			=> 'COMBINATION_TYPE_SECRET',
    	),
    );
    
    /**
     * 获取所有玩法描述
     * @return array
     */
    static public function getSportAndPoolDesc() {
    	return self::$sportAndPoolDesc;
    }
    
    /**
     * 获取所有出票状态描述
     * @return array
     */
    static public function getPrintStateDesc() {
    	return self::$printStateDesc;
    }
    
	/**
     * 获取晒单状态描述
     * @return array
     */
    static public function getCombinationTypeDesc() {
    	return self::$combinationTypeDesc;
    }
    
    /**
     * 获取体育赛事描述
     * @return array
     */
    static public function getSportDesc() {
    	return self::$sportDesc;
    }
    
    /**
     * 获取奖金总额
     */
    public function getTotalPrize($u_id) {
    	$sql = "select sum(`prize`) as total_prize from ".$this->tableName . " where `u_id`={$u_id} and `prize_state`=".self::PRIZE_STATE_WIN;
    	$res = $this->db->fetchOne($sql);
    	return $res['total_prize'];
    }
    
	/**
     * 获取投注总额
     */
    public function getTotalTicketMoney($start, $end, $u_id) {
    	$sql = "select sum(`money`) as total_money from ".$this->tableName . " where `datetime`>='{$start}' and `datetime`<='{$end}' and `u_id`={$u_id} and `print_state` in(".self::TICKET_STATE_LOTTERY_SUCCESS.",".self::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU.")";
    	$res = $this->db->fetchOne($sql);
    	return $res['total_money'];
    }
    
    /**
     * 获取时间段内奖金总额
     */
    public function getTotalPrizeMoney($start, $end, $u_id) {
    	$sql = "select sum(`prize`) as total_money from ".$this->tableName . " where `datetime`>='{$start}' and `datetime`<='{$end}' and `u_id`={$u_id} and `prize_state`=".self::PRIZE_STATE_WIN;
    	$res = $this->db->fetchOne($sql);
    	return $res['total_money'];
    }
    
    /**
     * 获取跟单信息
     */
    public function getFollowInfo($partent_id) {
    	//默认的$partent_id为0，排除这种情况
    	if (!$partent_id) return array('total_sum' => 0, 'total_money' => 0);
    	
    	$sql = "select count(*) as total_sum, sum(`money`) as total_money from ".$this->tableName . " where `partent_id` = {$partent_id} and `print_state` in (".self::TICKET_STATE_LOTTERY_SUCCESS." ,".self::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU ." ) ";
		
    	$res = $this->db->fetchOne($sql);
    	if (!$res['total_sum']) $res['total_money'] = 0;
    	return $res;
    }
    
    /**
     * 通过系统交易订单号反向查询用户订单信息
     * @param string $return_id 第三方交易平台订单号
     * @return array | empty
     */
    public function getUserTicetInfoByTicketId($return_id) {
    	$orderTicketInfo = array();
    	for ($i=0;$i<10;$i++) {
    		$objUserTicketLog = new UserTicketLog($i);
    		$condition = array();
    		$condition['return_id'] = $return_id;
    		$orderTicketInfo = $objUserTicketLog->getsByCondition($condition, 1);
    		//找到即可跳出，存在两张票号相同的订单的概率可以忽略
    		if ($orderTicketInfo) {
    			$orderTicketInfo = array_pop($orderTicketInfo);
    			break;
    		}
    	}
    	
    	if (!$orderTicketInfo) {
    		return array();
    	}
    	
    	return $this->get($orderTicketInfo['ticket_id']);
    }
}
               
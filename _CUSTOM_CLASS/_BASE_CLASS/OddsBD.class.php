<?php
/**
 * 北单赔率表
 * @author Administrator
 *
 */
class OddsBD extends DBSpeedyPattern {
	protected $tableName = 'bd_odds_';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    );
    
    protected $sp_field = array();
    
    public function __construct($lotteryId, $his = false) {
    	$this->tableName =  $this->tableName . strtolower($lotteryId);
    	if ($his) {
    		$this->tableName .= '_HIS';
    	}
    	$this->setSPField($lotteryId);
    	$this->real_field[] = 'id';
    	$this->real_field[] = 'issueNumber';//期数
    	$this->real_field[] = 'matchid';
    	$this->real_field[] = 'm_id';//赛事记录在本平台内的id
    	$this->real_field[] = 'matchtime';//比赛开始时间
    	$this->real_field[] = 'date';//开始日期
    	$this->real_field[] = 'time';//开始时间
    	$this->real_field[] = 'm_num';//期数；例：1041，周一041场;暂时用不到这个字段
//     	$this->real_field[] = 'remark';//让球数
    	$this->real_field = array_merge($this->real_field, $this->sp_field);
    	parent::__construct();
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , null, $limit, '*', $order);
    	return $this->gets($ids);
    }
    
    /**
     * @desc 不可随意改变字段的排列顺序
     *  SPF 胜平负 胜平负
		BF 1:0,2:0,2:1,3:0,3:1,3:2,4:0,4:1,4:2,胜其他, 比分
         	0:0,1:1,2:2,3:3,平其他, 
           0:1,0:2,1:2,0:3,1:3,2:3,0:4,1:4,2:4,负其他 
		SXDS 上+单,上+双,下+单,下+双 上下单双
		JQS 0 球,1 球,2 球,3 球,4 球,5 球,6 球,7+球 进球数
		BQC 胜-胜,胜-平,胜-负,平-胜,平-平,平-负,负-胜,负-平,负-负 半全场
		SF 胜,负 单场过关
     * @param  $lotteryId
     */
    public function setSPField($lotteryId) {
    	switch ($lotteryId) {
    		case ZunAoTicketClient::LOTTERY_CODE_SPF://胜平负
    			$this->sp_field = array(
    				'h',
	    			'd',
	    			'a',
    			);
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_BF://比分
    			$this->sp_field = array(
	    			'0100',
	    			'0200','0201',
	    			'0300','0301','0302',
	    			'0400','0401','0402','-1-h',
	    				
	    			'0000','0101','0202','0303','-1-d',
    			
    				'0001','0002','0003','0004',
    				'0102','0103','0104',
    				'0203','0204','-1-a',
    				);
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_SF://单场过关
    			$this->sp_field = array(
    				'h',
    				'a',
    			);
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_SXDS://上下单双
    			//上+单,上+双,下+单,下+双,玩法代码不同与半全场
    			$this->sp_field = array(
    					'sd',
    					'ss',
    					'xd',
    					'xs',
    			);
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_JQS://总进球
    			$this->sp_field = array(
    				's0',
    				's1',
    				's2',
    				's3',
    				's4',
    				's5',
    				's6',
    				's7',
    			);
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_BQC://半全场
    			$this->sp_field = array(
    				'hh','hd','ha',
    				'dh','dd','da',
    				'ah','ad','aa',
    			);
    			break;
    	}
    }
    
    /**
     * @desc 获取sp字段
     * @return multitype:
     */
    public function getSPFields() {
    	return $this->sp_field;
    }
    
    /**
     * 获取m_num
     * @param string $matchtime 时间戳
     * @param string $matchtid
     */
    static public function getMnum($matchtime, $matchtid) {
    	return date('N', $matchtime).$matchtid;//星期数
    }
}
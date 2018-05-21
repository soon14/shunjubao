<?php
/**
 * 赔率表
 * @author Administrator
 *
 */
class OddsHis extends DBSpeedyPattern {
	protected $tableName = '_odds_';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    );
    
    public function __construct($sport, $pool) {
    	$this->tableName = $sport . $this->tableName . $pool . '_HIS';
    	$this->getRealField($sport, $pool);
    	$this->real_field[] = 'id';//matchID
    	$this->real_field[] = 'm_id';//matchID
    	$this->real_field[] = 's_code';//sportCODE
    	$this->real_field[] = 'date';//开始日期
    	$this->real_field[] = 'time';//开始时间
    	$this->real_field[] = 'm_num';//期数；例：1041，周一041场
    	$this->real_field[] = 'p_id';//
		$this->real_field[] = 'createtime';//
    	parent::__construct('default');
    }
    
    public function getRealField($sport, $pool) {
    	switch ($pool) {
    		case 'hdc'://让分胜负
    			$this->real_field = array(
	    			'a',
	    			'h',	
	    			'goalline',	
    			);
    			break;
    		case 'hilo'://大小分
    			$this->real_field = array(
    				'l',
    				'h',
    				'goalline',
    			);
    			break;
    		case 'mnl'://胜负
    			$this->real_field = array(
    				'a',
    				'h',
    			);
    			break;
    		case 'wnm'://胜分差
    			$this->real_field = array(
    					'w1',	
    					'w2',	
    					'w3',	
    					'w4',	
    					'w5',	
    					'w6',	
    					'l1',	
    					'l2',	
    					'l3',	
    					'l4',	
    					'l5',	
    					'l6',
    			);
    			break;
																		    			
    		case 'crs'://比分
    				$this->real_field = array(
    						'-1-a',
    						'-1-d',
    						'-1-h',
    						'0001','0002','0003','0004','0005',
    						'0102','0103','0104','0105',
    						'0203','0204','0205',
    						
    						'0000','0101','0202','0303',
    						
    						'0100',
    						'0200','0201',
    						'0300','0301','0302',
    						'0400','0401','0402',
    						'0500','0501','0502',
    				);
    			break;
    		case 'had'://胜负
    			$this->real_field = array(
    					'a',
    					'd',
    					'h',
    			);
    			break;
    		case 'hafu'://半全场
    			$this->real_field = array(
    					'aa',	
    					'ad',	
    					'ah',	
    					'da',	
    					'dd',	
    					'dh',	
    					'ha',	
    					'hd',	
    					'hh',
    			);
    			break;
    		case 'hhad'://让分胜负
    			$this->real_field = array(
    					'a',
    					'd',
    					'h',
    					'goalline',
    			);
    			break;
    				 
    		case 'ttg'://总进球
    			$this->real_field = array(
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
    	}
    }
    
    /**
     * 列出某一个玩法错有的让球数
     * @param unknown $sport
     * @param unknown $pool
     * @param unknown $matchId
     * @return array(goalline1,goalline2...) | array()
     */
    public function getDistinctGoallines($sport, $pool, $matchId) {
    	$return = array();
    	$objOddsHis = new OddsHis($sport, $pool);
	    $condition = array(
	    	's_code' 	=> strtoupper($sport),
	    	'm_id'		=> $matchId,
	    );
    	$results = $objOddsHis->getsByCondition($condition,null, 'id asc');
	    foreach ($results as $result) {
	    	if (!$result['goalline']) {
	    		continue;
	    	}
	    	$return[$result['goalline']] = $result['goalline'];
	    }
	    return $return;
    }
}
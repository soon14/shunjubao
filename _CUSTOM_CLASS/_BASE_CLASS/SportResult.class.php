<?php
/**
 * 赛果表(比分)
 * @author administrator
 */
class SportResult extends DBSpeedyPattern {
	protected $tableName = '_result';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    );

    public function __construct($sport) {
    	switch ($sport) {
    		case 'bk':
    			$this->real_field = array(
    				'id',
    				's_code',
    				'm_num',
    				'status',
    				's1',
    				's2',
    				's3',
    				's4',
				's5',
    				's6',
    				's7',
    				'final',
    			);
    			break;
    		case 'fb':
    			$this->real_field = array(
    				'id',
    				's_code',
    				'm_num',
    				'status',
    				'half',
    				'full',
    				'final',
    			);
    			break;
    	}
    	$this->tableName = $sport . $this->tableName;
    	parent::__construct();
    }
    
    /**
     * ‘Conclude’完结
     * @var unknown
     */
    CONST RESULT_STATUS_CONCLUED = 'Conclude';
    /**
     * ‘FinalResultIn’赛果录入
     * @var unknown
     */
    CONST RESULT_STATUS_FINAL = 'FinalResultIn';
    /**
     * ‘Abandon’取消
     * @var unknown
     */
    CONST RESULT_STATUS_ABANDON = 'Abandon';
    /**
     * ‘Close’关闭
     * @var unknown
     */
    CONST RESULT_STATUS_CLOSE = 'Close';
    
    static public function getSportStatusDesc() {
    	return array(
    		self::RESULT_STATUS_ABANDON 	=> array('desc' => '取消'),
    		self::RESULT_STATUS_CLOSE 		=> array('desc' => '关闭'),
    		self::RESULT_STATUS_CONCLUED 	=> array('desc' => '完结'),
    		self::RESULT_STATUS_FINAL 		=> array('desc' => '赛果录入'),
    	);
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , null, $limit, '*', $order);
    	return $this->gets($ids);
    }
}

<?php
/**
 * 彩果表
 * @author administrator
 *
 */
class PoolResult extends DBSpeedyPattern {
	protected $tableName = '_poolresult';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	's_code',//类型；fb bk
	    'm_id',//赛事id
	    'm_num',//场次
	    'p_code',//玩法代码 had hhad
	    'o_type',//
	    'p_id',
	    'refund',
	    'totals',
	    'combination',
	    'value',
	    'winunit',
    );

    public function __construct($sport) {
    	$this->tableName = $sport . $this->tableName;
    	parent::__construct();
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition, $limit, $order);
    	return $this->gets($ids);
    }
}

<?php 
class UserAccount extends DBSpeedyPattern {
	protected $tableName = 'user_account';

	protected $primaryKey = 'u_id';
	
	protected $real_field = array(
			'u_id',	
    		'cash',
			'frozen_cash',//冻结金额
    		'score',
	    	'gift',
	    	'bank',
	    	'rebate',
    		'rebate_per',//float(3,2)
    );
    
	/**
	 * 返点比例-前期固定数值，后期根据用户等级会有不同的数字
	 * @var float
	 */
	protected $rebate_per = 0.07;    
   

    /**
     * 使用用户账户信息表
     * 单位:float(10.2)
     * @return InternalResultTransfer 成功：返回用户记录，包括用户id；失败：返回失败原因
     */
    public function addAccount($info) {
    	$info['rebate_per'] = $this->rebate_per;
    	$tableInfo =  array(
            'cash' 			=> 0.00,
    		'frozen_cash'	=> 0.00,
    		'score' 		=> 0.00,
	    	'gift' 			=> 0.00,
	    	'rebate' 		=> 0.00,
	    	'rebate_per'	=> 0.00,//$info['rebate_per'],
        );

        $uid = parent::add($tableInfo);
        if (!$uid) {
        	return InternalResultTransfer::fail('插入余额信息失败');
        }       

        $user = $tableInfo;
        $user[$this->primaryKey] = $uid;

        return InternalResultTransfer::success($user);
    }
    
    public function getTotal() {
    	$sql = "select sum(cash) as cash , sum(gift) as gift, sum(rebate) as rebate, sum(frozen_cash) as frozen_cash , count(*) as count from {$this->tableName}";
    	return $this->db->fetchOne($sql);
    }
    
    public function getVirtualTotal($u_ids) {
		foreach( $u_ids as $k=>$v){   
			if( !$v )   
				unset( $u_ids[$k] );   
		}   
		
		
    	$u_ids = implode(',', $u_ids);
    	$sql = "select sum(cash) as cash , sum(gift) as gift, sum(rebate) as rebate, sum(frozen_cash) as frozen_cash , count(*) as count from {$this->tableName} where u_id in({$u_ids})";
		
    	return $this->db->fetchOne($sql);
    }
}
?>
<?php 
class UserRealInfo extends DBSpeedyPattern {
	protected $tableName = 'user_realinfo';

	protected $primaryKey = 'u_id';
	
	protected $real_field = array(
			'u_id',
    		'realname',
    		'idcard',
	    	'mobile',
	    	'bank',
	    	'bankcard',
	    	'bank_province',
	    	'bank_city',
	    	'bank_branch',
    );
	
	
	 public function getIdByMobile($mobile) {
        if (empty($mobile)) {
        	return false;
        }
        $condition = array(
            'mobile'   => trim($mobile),
        );
        
        $result = $this->fetchOne($condition, $this->primaryKey);
        if (!$result) {
        	return false;
        }
        return array_pop($result);
    }
	
    
    /**
     * 创建用户扩展信息
     * @return InternalResultTransfer 成功：返回用户记录，包括用户id；失败：返回失败原因
     */
    public function add($info) {
    	
    	$tableInfo =  array(
            'realname' 		=> $info['realname'],	
    		'idcard' 		=> $info['idcard'],
	    	'mobile' 		=> $info['mobile'],
	    	'bank' 			=> $info['bank'],
	    	'bankcard' 		=> $info['bankcard'],
	    	'bank_province' => $info['bank_province'],
	    	'bank_city' 	=> $info['bank_city'],
	    	'bank_branch' 	=> $info['bank_branch'],
        );

        $uid = parent::add($tableInfo);
        if (!$uid) {
        	return InternalResultTransfer::fail('插入账户扩展信息失败');
        }

        $user = $tableInfo;
        $user[$this->primaryKey] = $uid;

        return InternalResultTransfer::success($user);
    }
}
?>
<?php
/**
 * 单关赛事类，添加单关赛事信息
 */
class BettingLog extends DBSpeedyPattern {
	
	protected $tableName = 'betting_log';
	
	protected $primaryKey = 'id';
	
	protected $real_field = array(
		'id',
		'm_id',//赛事ID
    	'pre_log',
        'after_log',
    	'u_id',
    	'operate_uname',
    	'create_time',
	);
	
	public function add($info) {
		if (!isset($info['create_time'])) {
			$info['create_time'] = getCurrentDate();
		}
		$info['u_id'] = Runtime::getUid();//操作人uid
		$info['operate_uname'] = Runtime::getUname();//操作人uname
		
		return parent::add($info);
	}
	

}
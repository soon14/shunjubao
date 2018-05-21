<?php 
class UserRebate extends DBSpeedyPattern {
	protected $tableName = 'user_rebate';

	protected $primaryKey = 'rebate_id';
	
	protected $real_field = array( 
			'rebate_id',  	
			'u_id',
			'create_time',
			'rebate_score',
			'percent',
			'ticket_id',
			'ticket_money',
    );
   
}
?>
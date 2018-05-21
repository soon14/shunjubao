<?php
class UserAddtipsLog extends DBSpeedyPattern {
	protected $tableName = 'user_addtips_log';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
			'id',// int(10) NOT NULL AUTO_INCREMENT,
			'u_id',// 打赏人
			'u_nick',// 打赏人昵称
			'to_u_id',// 被打赏人U_ID
			'to_u_nick',// 被打赏人昵称
			'addtips_money',// 金额
			'ticket_id',// 跟单ID
			'addtime',// 添加时间
			'addip',// 操作ip
	);
	

}
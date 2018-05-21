<?php
class ShortMessageLog extends DBSpeedyPattern {
	protected $tableName = 'short_message_log';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
			'id',// int(10) NOT NULL AUTO_INCREMENT,
			'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
			'project_id',// tinyint(3) NOT NULL,
			'mobile',// varchar(11) COLLATE latin1_general_ci NOT NULL,
			'content',// varchar(100) COLLATE latin1_general_ci NOT NULL,
			'feedback',// varchar(50) COLLATE latin1_general_ci NOT NULL,
	);
	
	/**
	 * 应用场景之密码找回
	 */
	CONST PROJECT_ID_SECRET_BACK = 1;
	/**
	 * 应用场景之串关错误
	 */
	CONST PROJECT_ID_SELECT_WRONG = 2;
	/**
	 * 应用场景之注册验证
	 */
	CONST PROJECT_ID_REGISTER = 3;

	/**
	 * 短信通道报错
	 */
	CONST PROJECT_ID_ERROR = 99;

	static public function getProjectDesc() {
		return array(
			self::PROJECT_ID_SECRET_BACK 	=> array('desc' => '密码找回'),
			self::PROJECT_ID_SELECT_WRONG 	=> array('desc' => '串关错误'),
			self::PROJECT_ID_REGISTER 		=> array('desc' => '注册验证'),
			self::PROJECT_ID_ERROR 			=> array('desc' => '短信通道报错'),
		);
	}
}
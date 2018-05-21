<?php
/**
 *
 * 系统角色定义类
 * @author gaoxiaogang@gmail.com
 *
 */
class Role {

	/**
	 *
	 * 超级权限角色，比admin更高一级
	 * @var string
	 */
	const SUPER			= 'super';

	/**
	 *
	 * 管理员
	 * @var string
	 */
	const ADMIN 		= 'admin';

	/**
	 *
	 * 客服
	 * @var string
	 */
	const CUSTOMER_SERVICE	= 'customer_service';

	/**
	 * 外站人员
	 */
	const OUTSIDE = 'outside';

	
	/**
	 * 推荐专家
	 */
	const RECOMMEND_SPECIAL = 'recommend_special';
	
	/**
	 * 人工出票专员
	 */
	CONST MANUL_TICKET = 'manul_ticket';
	
	/**
	 * 赛事管理人员
	 */
	CONST GAME_MANAGER = 'game_manager';
	
	/**
	 *
	 * 角色描述
	 * @var array
	 */
	static private $roleDesc = array(
		self::SUPER		=> array(
			'desc'	=> '超级管理员',
			'kw'	=> 'SUPER',
		),
		self::ADMIN		=> array(
			'desc'	=> '管理员',
			'kw'	=> 'ADMIN',
		),
		self::CUSTOMER_SERVICE	=> array(
			'desc'	=> '客服人员',
			'kw'	=> 'CUSTOMER_SERVICE',
		),
		self::OUTSIDE	=> array(
			'desc'	=> '外站人员',
			'kw'	=> 'OUTSIDE',
		),
		self::RECOMMEND_SPECIAL => array(
			'desc'	=> '推荐专家',
			'kw'	=> 'RECOMMEND_SPECIAL',
		),
		self::MANUL_TICKET	=> array(
			'desc'	=> '人工出票专员',
			'kw'	=> 'MANUL_TICKET',
		),
	);

	/**
	 *
	 * 获取角色描述
	 * @return array
	 */
	static public function getRoleDesc() {
		return self::$roleDesc;
	}
}
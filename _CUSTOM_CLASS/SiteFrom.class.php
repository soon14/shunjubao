<?php
/**
 * 外站来源类，用来记录用户来源
 */
class SiteFrom extends DBSpeedyPattern {
	
	protected $primaryKey = 'id';
	
	protected $real_field = array(
			'id',//这个id即user_member里的u_source
			'describe',//外站描述
			'admin_group',//外站管理员用户组，用户名之间用逗号间隔
			'type',//推广类型
			'link',//给外站的链接
			'create_uid',//创建人
			'create_uname',//创建人名
			'source_key',//外站唯一key，用来标识外站
			'total_registers',// INT(10) NOT NULL COMMENT '总注册人数' AFTER `source_key`;
			'total_idcards',// INT(10) NOT NULL COMMENT '总认证人数' AFTER `total_registers`;
			'total_money',// FLOAT(10,2) NOT NULL COMMENT '总投注量' AFTER `total_idcards`;
			'create_time',
	);
	
	protected $tableName = 'site_from';
	
	/**
	 * 推广类型：站内
	 * @var int
	 */
	CONST SITE_FROM_TYPE_IN =1;
	
	/**
	 * 推广类型：站外
	 * @var int
	 */
	CONST SITE_FROM_TYPE_OUT =2;
	
	static public function getSiteFromDesc() {
		return array(
			self::SITE_FROM_TYPE_IN => array(
				'desc'	=> '站内推广',
			),
			self::SITE_FROM_TYPE_OUT => array(
				'desc'	=> '站外推广',
			),
		);
	}
	
	/**
	 * 获取一个外站id的字符串
	 * @param int $id
	 * @return string | false 
	 */ 
	public function getSiteFromKey($id) {
		if (!Verify::int($id)) {
			return false;
		}
		return ConvertData::encryptId2Str($id);
	}
	
	/**
	 * 添加一条记录，并把id转成字符串添加进去
	 * @param array
	 * @return InternalResultTransfer
	 */
	public function addSFRecord($info) {
		
		$info['create_uid'] 	= Runtime::getUid();
		$info['create_uname'] 	= Runtime::getUname();
		$info['create_time'] 	= getCurrentDate();
		
		$id = parent::add($info);
		
		if (!$id) {
			return InternalResultTransfer::fail('add fail');
		}
		
		$SFkey = $this->getSiteFromKey($id);
		$info['id'] = $id;
		$info['source_key'] = $SFkey;
		$info['link'] = ROOT_DOMAIN . '/sites?'.UserMember::OTHER_SITES_FROM_COOKIE_KEY . '=' .$SFkey;
		return $this->modify($info);
	}
	
	/**
	 * 外站key转成id
	 * @param string key
	 * @return int $id
	 */
	public function keyToId($key) {
		return ConvertData::decryptStr2Id($key);
	}
	
	/**
	 * 获取某个用户自己的推广链接
	 * @param int $u_id
	 * @return boolean|array
	 */
	public function getUserSiteFromInfo($u_id) {
		
		if (!Verify::int($u_id)) {
			return false;
		}
		
		$siteFromInfo = $this->getsByCondition(array('create_uid'=>$u_id,'type'=>self::SITE_FROM_TYPE_IN));
		if (!$siteFromInfo) {
			return false;
		}
		
		return array_pop($siteFromInfo);
	}
	
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		return $this->findBy($condition , null, $limit, '*', $order);
	}
	
	/**
	 * 增加统计信息，在原有的基础上增加
	 * @param int $id
	 * @param int $total_registers
	 * @param int $total_idcards
	 * @param float $total_money
	 * @return InternalResultTransfer
	 */
	public function increaseStat($id, $total_registers, $total_idcards, $total_money) {
		
		$info = $this->get($id);
		
		if (!$info) {
			return InternalResultTransfer::fail('info not found');
		}
		
		$info['total_registers'] 	+= $total_registers;
		$info['total_idcards'] 		+= $total_idcards;
		$info['total_money'] 		+= $total_money;
		
		return $this->modify($info);
	}
}
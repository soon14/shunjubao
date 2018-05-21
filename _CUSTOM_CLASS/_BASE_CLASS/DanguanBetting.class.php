<?php
/**
 * 单关赛事类，添加单关赛事信息
 */
class DanguanBetting extends DBSpeedyPattern {
	
	protected $tableName = 'danguan_betting';
	
	protected $primaryKey = 'id';
	
	protected $real_field = array(
		'id',
		'sport',// varchar(10) COLLATE latin1_general_ci NOT NULL,
		'matchid',// int(10) NOT NULL COMMENT '赛事id',
		'pool',// varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT '玩法',
		'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
	);
	
	public function add($info) {
		if (!isset($info['create_time'])) {
			$info['create_time'] = getCurrentDate();
		}
		return parent::add($info);
	}
	
	/**
	 * 一场比赛是否可以单关
	 * @param string $sport
	 * @param int $matchid
	 * @return boolean
	 */
	public function isDanguan($sport, $matchid, $pool) {
		$condition = array();
		$condition['sport'] = $sport;
		$condition['matchid'] = $matchid;
		$condition['pool'] = $pool;
		$res = $this->findBy($condition);
		if ($res) {
			return true;
		}
		return false;
	}
}
<?php
/**
 * api接口日志类
CREATE TABLE IF NOT EXISTS `api_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `appId` tinyint(3) NOT NULL,
  `type` tinyint(3) NOT NULL COMMENT '接口类型',
  `status` tinyint(3) NOT NULL COMMENT '状态：1成功；0失败',
  `extend` text COLLATE latin1_general_ci NOT NULL,
  `create_time` varchar(20) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='api接口日志' AUTO_INCREMENT=1 ;
 */
class APILog extends DBSpeedyPattern {
	protected $tableName = 'api_log';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
			'id',
			'appId',//应用id
			'type',//接口类型
			'status',//状态：1成功；0失败
			'extend',
			'create_time',
	);
	
	CONST API_STATUS_S = 1;
	CONST API_STATUS_F = 0;
	
	static public function getStatusDesc() {
		return array(
			self::API_STATUS_S => array('desc'=>'调用成功'),
			self::API_STATUS_F => array('desc'=>'调用失败'),
		);
	}
	
	/**
	 * 
	 */
	public function add($info) {
		//传入的信息
		$info['params'] = Request::getRequestParams();
		
		if (isset($info['params']['appId'])) {
			$api_config = include ROOT_PATH . '/include/api_config.php';
			$info['app_desc'] = $api_config[$info['params']['appId']]['desc'];
			$info['appId'] = $info['params']['appId'];
		} else {
			//没有appid说明没有通过验证
			$info['appId'] = 0;
		}
		
		if (isset($info['params']['type'])) {
			$desc = ApiItems::getItemsDesc();
			$info['type_desc'] = $desc[$info['params']['type']]['desc'];
			$info['type'] = $info['params']['type'];
		} else {
			//没有通过验证
			$info['type'] = 0;
		}
		
		$info['create_time'] = getCurrentDate();
		if (isset($_SERVER['HTTP_REFERER'])) {
			$info['referer'] = $_SERVER['HTTP_REFERER'];
		}
		$info = parent::parseExtend($info);
		return parent::add($info);
	}
	
	/**
	 * 按条件获取信息
	 * @param array $condition
	 * @return array | false
	 */
	public function getsByCondition($condition, $limit  = null, $order = 'create_time asc') {
		$ids = $this->findIdsBy($condition, $limit, $order);
		return $this->gets($ids);
	}
	
	public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}
	
		return array_pop($tmpResult);
	}
	
	public function gets($ids) {
		$result = parent::gets($ids);
		foreach ($result as & $tmpV) {
			$tmpExtend = array();
			$tmpExtend = unserialize($tmpV['extend']);
			unset($tmpV['extend']);
	
			# 将存在扩展字段里的信息提出来
			if (is_array($tmpExtend)) foreach ($tmpExtend as $tmpKK => $tmpVV) {
				if (!in_array($tmpKK, $this->real_field)) {
					$tmpV[$tmpKK] = $tmpVV;
				}
			}
		}
		return $result;
	}
	
	public function modify($info, $condition = null) {
		$info = parent::parseExtend($info);
		return parent::modify($info, $condition, $cas_token = null);
	}
}
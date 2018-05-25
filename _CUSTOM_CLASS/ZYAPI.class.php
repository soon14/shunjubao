<?php
/**
 * 聚宝api接口
 * @author hushiyu
 */
class ZYAPI {
	
	/**
	 * 应用id和key为一一对应的关系
	 */
	const APPID_WWW 		= 1;//聚宝主项目
	const APPID_SHOP 		= 2;//聚宝商城项目
	const APPID_WANGZUOZHU 	= 3;//王作柱同学的项目
	const APPID_HEZHENGDE 	= 4;//何正德同学的项目
	
	public function __construct() {
		$api_config = include ROOT_PATH . '/include/api_config.php';
		if (!is_array($api_config)) {
			echo_exit('配置文件未找到');
		}
		$this->api_config = $api_config;
	}
	
	static public function getAllAppIds() {
		return array(
			self::APPID_WWW,
			self::APPID_SHOP,
			self::APPID_WANGZUOZHU,
			self::APPID_HEZHENGDE,		
		);
	}
	
	/**
	 * appId和appKey
	 * 各个站的id和key
	 * @return string
	 */
	public function getKeyById($appId) {
		if (array_key_exists($appId, $this->api_config)) {
			return $this->api_config[$appId]['appKey'];
		}
		return '';
	}
	
	/**
	 * 成功时的输出
	 * @param unknown_type $params
	 */
	public function outPutS($params = '') {
		if (!$params) {
			$params = array();
		} else {
			//u8转码
			$params = ConvertData::gb2312ToUtf8D($params);
		}
		
		if (!isset($params['return_desc'])) {
			$params['return_desc'] = '接口调用成功';
		}
		
		$log_info = array();
		$log_info['return_info'] = $params;
		$log_info['status'] = APILog::API_STATUS_S;
		$objAPILog = new APILog();
		$objAPILog->add($log_info);
		
		return $this->outPut($params);
	}
	
	/**
	 * 失败时的输出
	 * @param unknown_type $params
	 */
	public function outPutF($error_code) {
		$desc = ApiItems::getErrorDesc();
		$params = array(
			'error_code' => $error_code,
			'error_desc' => $desc[$error_code]['desc'],
		);
		
		$log_info = array();
		$log_info['return_info'] = $params;
		$log_info['status'] = APILog::API_STATUS_F;
		$objAPILog = new APILog();
		$objAPILog->add($log_info);
		
		return $this->outPut($params, false);
	}
	
	/**
	 * api公共输出
	 * @param $params 输出参数
	 * @param $isSuccess 接口调用是否成功
	 */
	private function outPut($params, $isSuccess = true) {
		
		if (!isset($params['return_time'])) {
			$params['return_time'] = time();
		}
		
		if ($isSuccess) ajax_success_exit($params);
		ajax_fail_exit($params);
	}
	
	/**
	 * 加密方法，获取加密后的appkey
	 * @param array $params 待验证的参数：必须的字段appid和msg(原生的)
	 * @return 加密方法：md5_16($appId.$appKey.$msg)
	 */
	public function getToken($params) {
		
		if (!is_array($params)) return '';
		
		ksort($params);
		
		$string = '';
		
		foreach ($params as $key=>$value) {
			if ($key == 'token') {
				continue;
			}
			$string .= $key . $value;
		}
		//应用id
		$appId = $params['appId'];
		//加密key
		$appKey = self::getKeyById($appId);
		//传输的内容
		$string .= $appKey;
		return md5_16($string);
	}
	
	/**
	 * 验证加密数据是否合法
	 * @param array $params 传过来的参数
	 * @return boolean
	 */
	public function verifyToken($params) {
		$thisToken = $this->getToken($params);
		return $thisToken == $params['token'];
	}
}
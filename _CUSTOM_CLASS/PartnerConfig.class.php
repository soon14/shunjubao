<?php
/**
 * 合作商配置类
 * 主要用于包装配置文件的细节
 * 本人对于配置文件的看法：配置文件表示的是一种数据结构，而数据结构应该尽量私有（用专用的业务逻辑来处理它），不应该到处加载使用，对外扩散。否则一旦后期发现该
 * 数据结构不合理，需要修改时，想回收就难了！
 * @author gaoxiaogang@gmail.com
 *
 */
class PartnerConfig {
	private $config;
	
	public function __construct($partner) {
		if (!isset($this->config)) {
			$tmpConfig = include(ROOT_PATH . '/include/partner_config.php');
			if (!isset($tmpConfig[$partner])) {
				throw new ParamsException("不存在的合作方");
			}
			$this->config = $tmpConfig[$partner];
		}
	}
	
	/**
	 * 获取安全码
	 * @return string
	 */
	public function getSecuritCode() {
		return $this->config['security_code'];
	}
	
	/**
	 * 获取合作商的简称，目前用于订单前缀
	 * @return string
	 */
	public function getShortName() {
		return $this->config['order_key'];
	}
}

?>
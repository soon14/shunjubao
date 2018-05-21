<?php
/**
 * 比分异常接口
 */
class UnResult {
	protected $host = 'http://prize.zhiying365365.com/KJCenter/getUnResult.php';
	
	public function __construct() {
		
	}
	/**
	 * 比分异常接口数据
	 * @return InternalResultTransfer
	 */
	public function getUnResult($sport) {
		
		$url = $this->host ."?sport={$sport}";
		$obj = new Curl($url);
		$res = $obj->get();
		
		if (!$res) {
			return InternalResultTransfer::fail('接口调用失败');
		}
		$return = json_decode($res, true);
		if (!$return) {
			return InternalResultTransfer::fail($url.'解析数据失败');
		}
		return $return;
	}
}
<?php
/**
 * 即时比分接口
 */
class ScoreApi {
	protected $host = 'http://prize.zhiying365365.com/KJCenter/getResult.php';
	
	public function __construct() {
		
	}
	/**
	 * 获取一个开售时间的所有比赛
	 * @return InternalResultTransfer
	 */
	public function getScoreAllByLotttime($sport, $lotttime) {
		if (!$lotttime) {
			$lotttime = date('Y-m-d');
		}
		$url = $this->host ."?sport={$sport}&lotttime={$lotttime}";
		$obj = new Curl($url);
		$res = $obj->get();
		
		if (!$res) {
			return InternalResultTransfer::fail('接口调用失败');
		}
		$return = json_decode($res, true);
		if (!$return) {
			return InternalResultTransfer::fail($url.'解析数据失败');
		}
		return InternalResultTransfer::success($return);
	}
}
<?php
/*
 * 异步通知app接入商
 * 必要参数(防止错误，参数名称都小写):
 * @param method : 订单行为,默认为pay
 * @param uid : app接入商用户ID
 * @param order : 订单号
 * @param money : 订单金额
 * @param format : 传输格式,默认为json
 * @param sign ： md5密钥串
 */
class tellAppNotify {
	//通知app的数组，包含必要的参数
	private  $order;
	/*
	 * 初始化
	 * 传入必要的订单号
	 */
	public function __construct( $param) {
		$this->order = $param;
	}
	//通知优享团
	public function tell_this_pay_order(){
		global $partnerConfig;
		//日志类
		$objErrorLogFront = new PayErrorLogFront();
		//订单类
		$objPayOrderFront = new PayOrderFront();
		$tradeMes = $objPayOrderFront->getOneOrder($this->order);
		if (!$tradeMes || !$tradeMes['notify_url'] || !$tradeMes['out_trade_no']) {
			$objErrorLogFront->addOneErrorLog('get_tellAppNotify_order',0,'',$this->order.':数据库订单信息缺失');
			return false;
		}
		//订单状态
		//$status_code = $tradeMes['status'];
		//构造url头部
		$tell_url = $tradeMes['notify_url'];
		//url参数
		$params = array(
			'method' => 'pay',
			'yoka_user_id' => $tradeMes['yoka_user_id'],
			'out_trade_no' => $tradeMes['out_trade_no'],
			
			'total_fee' => $tradeMes['total_fee'],
			'format' => 'json',
		);
		$sign = createSign($partnerConfig[$tradeMes['provider']]['security_code'],$params);
		$url = "{$tell_url}?method={$params['method']}&format={$params['format']}&yoka_user_id={$params['yoka_user_id']}&out_trade_no={$params['out_trade_no']}&total_fee={$params['total_fee']}&sign={$sign}";
		$ret = file_get_contents($url);
	    $json = json_decode($ret, true);
	    if($json && $json['content']["result"] != "ok")
	    {
	    	$objErrorLogFront->addOneErrorLog('get_tellAppNotify_order',1,$json,$this->order.":通知{$tradeMes['partner']}未成功");
	        return  false;
	    } else {
	        log_result("{$params['deal_id']}\t{$params['money']}\t".date("Y-m-d H:i:s")."\t".$url, "{$tradeMes['provider']}_notify");
	        return  true;
	    }
	}
	
}
?>
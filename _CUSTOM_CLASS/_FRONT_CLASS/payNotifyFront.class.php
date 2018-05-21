<?php
/**
 * 支付平台异步通知类
 * @author lifugang@yoka.com
 */
class payNotifyFront{
	
	private $objpayNotify;

	public function __construct()
	{
		
		$this->objpayNotify = new payNotify();
	}
	
	/**
	 * 添加一条异步通知记录
	 * @param array $params 交易平台返回的参数
	 * @return boolean
	 */
	public function addOnepayNotify(array $params)
	{
		if(empty($params['inner_out_trade_no'])) return  false;
		$params['createtime'] = time();
		return $this->objpayNotify->add($params);
	}
	
	
}
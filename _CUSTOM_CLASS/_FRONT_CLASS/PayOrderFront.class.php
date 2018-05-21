<?php
/**
 * 支付平台订单前端类
 * @author lihuanchun
 */
class PayOrderFront {
	
	private $objPayOrder;
	
	public function __construct() {
		$this->objPayOrder = new PayOrder ( );
	}
	
	/**
	 * 获取一条订单
	 * @param int $id 订单id
	 * @return false | array
	 */
	public function get($id) {
		return $this->objPayOrder->get($id);
	}
	
	/**
	 * 初始化一条订单记录
	 */
	public function  initializeOneOrder($params) {
		if (! is_array ( $params ))return false;
		if($params['inner_out_trade_no'] == '') return false;
		$bOrderData = $this->objPayOrder->getOrder( $params['inner_out_trade_no'] );
		
		if(count($bOrderData) == 0||$bOrderData == false){
			//可以插入
			$tableInfo ['inner_out_trade_no_md5'] = md5_16($params ['inner_out_trade_no']);
			$tableInfo ['inner_out_trade_no'] = $params ['inner_out_trade_no'];
			$tableInfo ['out_trade_no'] = $params ['out_trade_no'];
			$tableInfo ['provider'] = $params ['provider'];	
			$tableInfo ['partner'] = $params ['partner'];
			$tableInfo ['yoka_user_id'] = $params ['yoka_user_id'];
			$tableInfo ['total_fee'] = $params ['total_fee'];
			$tableInfo ['show_url'] = $params ['show_url'];
			$tableInfo ['notify_url'] = $params ['notify_url'];
			$tableInfo ['return_url'] = $params ['return_url'];
			if(isset($params ['extra_common_param'])){
				$tableInfo ['extra_common_param'] = $params ['extra_common_param'];
			}
			$tableInfo ['updatetime'] = time();
			return $this->objPayOrder->add ( $tableInfo );
		}else{
			//有此条订单 对比一下 是否要更新
			if($bOrderData[0]['trade_status'] == PayOrder::WAIT_BUYER_PAY){
				if($params['provider'] != $bOrderData[0]['provider'] || $params['total_fee'] != $bOrderData[0]['total_fee']){
					//执行更新操作
					$tableInfo = array(
						'inner_out_trade_no_md5' => md5_16($params ['inner_out_trade_no']),
						'inner_out_trade_no' => $params ['inner_out_trade_no'],
						'provider' => $params ['provider'],
						'total_fee' => $params ['total_fee'],
						'show_url' => $params ['show_url'],
						'notify_url' => $params ['notify_url'],
						'return_url' => $params ['return_url'],
						'updatetime' => time(),
					);
					if(isset($params ['extra_common_param'])){
							$tableInfo ['extra_common_param'] = $params ['extra_common_param'];
					}
					$condition = array(
					    'inner_out_trade_no_md5' => md5_16($params ['inner_out_trade_no']),
					    'trade_status'        => PayOrder::WAIT_BUYER_PAY,//做严格校验，确保原子级别上数据准确
					);
					return $this->objPayOrder->updateOrder($tableInfo, $condition);	
				}
			}
		}
		return $bOrderData[0]['out_trade_no'];
	}
	
	/*
	 * 通过ID查询订单数据
	 */
	public function getOneOrder($inner_out_trade_no){
		if($inner_out_trade_no == '') return false;
		$data = $this->objPayOrder->getOrder( $inner_out_trade_no );
		
		if(count($data) != 0){
			return $data[0];
		}else{
			return false;
		}
	}
	
	
	/*
     * 更改订单状态
     * inner_out_trade_no = XXX_XXXXX
     */
	public function updateOrderStatus($inner_out_trade_no,$trade_status,$provider){
		if($inner_out_trade_no == '') return false;
		$allOrderStatus = $this->objPayOrder->getAllStatus();
		$boo = false;
		foreach($allOrderStatus as $data){
			if($data == $trade_status) $boo = true;
		}
		if($boo){
			$tableInfo = array('trade_status' => $trade_status,'provider'=>$provider);
			$inner_out_trade_no_md5 = md5_16($inner_out_trade_no);
			$condition = array( 'inner_out_trade_no_md5' => $inner_out_trade_no_md5);
			
			return $this->objPayOrder->updateOrder($tableInfo,$condition);
		}else{
			return $boo;
		}
	}
	
	/**
	 * 更新订单状态。供外部调用，通过分析要变更的状态，再决定调用哪个子方法。
	 * 外部不用管改变状态时需要调用哪个子方法，由这个方法来处理细节。
	 * @param string $inner_out_trade_no
	 * @param int $status
	 * @param string $provider
	 * @param int $total_fee 金额，单位：分。应该以支付过来的金额为准
	 * @return Boolean
	 */
	public function updateStatus($inner_out_trade_no, $trade_status, $provider, $total_fee) {
		switch ($trade_status) {
			case PayOrder::TRADE_SUCCESS:
				return $this->updateStatus_to_TRADE_SUCCESS($inner_out_trade_no, $provider, $total_fee);
				break;
			case PayOrder::TRADE_CLOSED:
				return $this->updateStatus_to_TRADE_CLOSE($inner_out_trade_no);
			    break;
			default:
				
				return false;
				break;
		}
	}
	
	/**
     * 将订单状态更新为：关闭
     * @param string $inner_out_trade_no 支付平台传递给支付商的订单号
     * @return Boolean
     */
	public function updateStatus_to_TRADE_CLOSE($inner_out_trade_no) {
		$tableInfo = array(
            'trade_status'      => PayOrder::TRADE_CLOSED,
        );
        
        # 只有待付款状态(PayOrder::WAIT_BUYER_PAY)的订单，才可以被关闭
        $condition = array(
            'inner_out_trade_no_md5'   => md5_16($inner_out_trade_no),
            'trade_status'             => PayOrder::WAIT_BUYER_PAY,
        );
        
        return $this->objPayOrder->updateOrder($tableInfo, $condition);
	}
	
    /**
     * 将订单状态更新为：支付成功
     * 即时到帐交易中，会调用这个方法。支付提供商与金额，应以本次传递进来的参数为准，覆盖库里的
     * @param string $inner_out_trade_no 支付平台传递给支付商的订单号
     * @param string $provider  支付商（只有该方法才需要传递这个参数）
     * @param int $total_fee 金额，单位：分。应该以支付过来的金额为准
     * @return Boolean
     */
    public function updateStatus_to_TRADE_SUCCESS($inner_out_trade_no, $provider, $total_fee) {
    	if (!isInt($total_fee) || $total_fee < 1) {
    		return false;
    	}
        $tableInfo = array(
            'trade_status'      => PayOrder::TRADE_SUCCESS,
            'provider'    => $provider,
            'total_fee'     => $total_fee,
        );
        
        # 只有待付款状态(PayOrder::WAIT_BUYER_PAY)的订单，才可以被置为交易成功结束(PayOrder::TRADE_SUCCESS)
        $condition = array(
            'inner_out_trade_no_md5'   => md5_16($inner_out_trade_no),
            'trade_status'          => PayOrder::WAIT_BUYER_PAY,
        );
        
        return $this->objPayOrder->updateOrder($tableInfo, $condition);
    }
	
	/*
	 * 	直接付款 把订单 等待买家付款 改成 交易已经成功结束
	 */
	public function update_WAIT_BUYER_PAY_to_TRADE_FINISHED($inner_out_trade_no,$provider){
		return $this->updateOrderStatus($inner_out_trade_no,PayOrder::TRADE_FINISHED,$provider);
	}
	
	
	
	/*
	 * 	把订单 等待买家付款 改成 表示买家付款成功,等待卖家发货
	 */
	public function update_WAIT_BUYER_PAY_to_WAIT_SELLER_SEND_GOODS($inner_out_trade_no,$provider){
		return $this->updateOrderStatus($inner_out_trade_no,PayOrder::WAIT_SELLER_SEND_GOODS,$provider);
	}
	
	/*
	 * 把订单 买家付款成功,等待卖家发货 改成 卖家已经发货等待买家确认
	 */
	public function update_WAIT_SELLER_SEND_GOODS_to_WAIT_BUYER_CONFIRM_GOODS($inner_out_trade_no,$provider){
		return $this->updateOrderStatus($inner_out_trade_no,PayOrder::WAIT_BUYER_CONFIRM_GOODS,$provider);
	}
	
	/*
	 * 把订单 卖家已经发货等待买家确认 改成 交易已经成功结束
	 */
	public function update_WAIT_BUYER_CONFIRM_GOODS_to_TRADE_FINISHED($inner_out_trade_no,$provider){
		return $this->updateOrderStatus($inner_out_trade_no,PayOrder::TRADE_FINISHED,$provider);
	}
	
	/*
	 * 把订单 表示等待买家付款 改成 交易成功
	 * 
	 */
	public function updete_WAIT_BUYER_CONFIRM_GOODS_to_TRADE_SUCCESS($inner_out_trade_no,$provider){
		return $this->updateOrderStatus($inner_out_trade_no,PayOrder::TRADE_SUCCESS,$provider);
	}
	
	
}
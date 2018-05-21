<?php
/**
 * 支付平台订单后端类
 * @author lihuanchun
 */
class PayOrder extends DaoAbstract {
	protected $tableName = 'pay_order';
	
	const WAIT_BUYER_PAY 			= 0;//表示等待买家付款
	const WAIT_SELLER_SEND_GOODS 	= 1;//表示买家付款成功,等待卖家充值
	const WAIT_BUYER_CONFIRM_GOODS 	= 2;//表示卖家已经充值等待买家确认
	
	/**
	 * 交易成功结束。在担保交易里，当买家确认收货并且支付宝打款给卖家后，订单状态变成这个。
	 * @var int
	 */
	const TRADE_FINISHED 			= 3;//表示交易已经成功结束
	
	const TRADE_CLOSED 				= 4; //交易关闭
	
	/**
	 * 表示支付成功。在即时到帐交易里（非担保交易），用户付款后，要求订单状态变成这个。
	 * @var int
	 */
 	const TRADE_SUCCESS 			= 5; //交易成功
	
	#TODO 还有很多状态
	
	public function getAllStatus(){
		return array(
			'WAIT_BUYER_PAY'			=>self::WAIT_BUYER_PAY,
			'WAIT_SELLER_SEND_GOODS'	=>self::WAIT_SELLER_SEND_GOODS,
			'WAIT_BUYER_CONFIRM_GOODS'	=>self::WAIT_BUYER_CONFIRM_GOODS,
			'TRADE_FINISHED'			=>self::TRADE_FINISHED,
			'TRADE_CLOSED' 				=>self::TRADE_CLOSED,
			'TRADE_SUCCESS' 			=>self::TRADE_SUCCESS,
		);
	}
	
	/**
	 * 通知状态值返回状态的描述
	 * @param int $status 支付平台内部状态
	 * @return false | string 外部描述
	 */
	public function getStatusDesc($status) {
		$allStatus = $this->getAllStatus();
		$index = array_search($status, $allStatus);
		if ($index === false) {
			return false;
		}
		return $index;
	}
	
	/**
	 * 是否有效的状态
	 * @param int $status
	 * @return Boolean
	 */
	public function isValidStatus($trade_status) {
		$allStatus = $this->getAllStatus();
		return in_array($trade_status, $allStatus);
	}
	
	/**
	 * 添加一条订单
	 *
	 * @param array $tableInfo
	 * @return boolean
	 */
	public function add(array $tableInfo) {
		if (empty ( $tableInfo ))
			return false;
		$tableInfo ['createtime'] = time ();
		$tableInfo ['trade_status'] = self::WAIT_BUYER_PAY;
		return $this->create ( $tableInfo, true );
	}
	
	/*
	 * 更具条件查询订单数据
	 * $inner_out_trade_no = XXX_XXXXX
	 */
	public function getOrder($inner_out_trade_no) {
		$inner_out_trade_no_md5 = md5_16($inner_out_trade_no);
		$condition = array('inner_out_trade_no_md5' => $inner_out_trade_no_md5);
		$style = $this->findBy($condition);
		return $style;
	}
	
	/**
	 * 更改订单状态
	 * @param array $tableInfo
	 * @param array $condition
	 * @return Boolean | int false：失败；true：成功，但没有影响到任何记录；int：影响到的记录条数
	 */
	public function updateOrder(array $tableInfo, array $condition) {
		$tableInfo['updatetime'] = time();
		$result = $this->update($tableInfo, $condition);
		if (!$result) {
			return false;
		}
		$affectedRows = $this->mdb->affectedRows();
		if (isInt($affectedRows) && $affectedRows > 0) {
			return $affectedRows;
		}
		return true;
	}
}
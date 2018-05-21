<?php 
class UserChargeFront {
	
	private $objUserCharge;
	/**
	 * 用户充值记录
	 */
	public function __construct() {
    	$this->objUserCharge = new UserCharge();
    }
    
	public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}

		return array_pop($tmpResult);
	}

	/**
	 * 批量获取
	 * @param array $ids
	 * @return array 无结果时返回空数组
	 */
	public function gets(array $ids) {
		$userInfo = array();

		if (empty($ids)) {
			return $userInfo;
		}

		return $this->objUserCharge->gets($ids);
	}
	
	public function add($info) {
		if (!isset($info['charge_source'])) {
			$info['charge_source'] = UserMember::getUserSource();
		}
    	return $this->objUserCharge->add($info);
    }
    
    public function modify($tableInfo,$condition = null) {
    	return $this->objUserCharge->modify($tableInfo, $condition);
    }
    
    public function getsByCondition($condition, $limit = null , $order = 'create_time desc') {
    	 $ids = $this->objUserCharge->findIdsBy($condition, $limit, $order);
    	 return $this->gets($ids);
    }
    
    public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition =  array(), $limit = null, $order = 'create_time desc') {
    	return $this->objUserCharge->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
    /**
     * 通过交易号获取用户充值信息
     * @param string $out_trade_no
     * @return InternalResultTransfer
     */
    public function getUserChargeInfoByOutTradeNo($out_trade_no) {
    	$condition = array();
    	$condition['pay_order_id'] = $out_trade_no;
    	$tmpResults = $this->getsByCondition($condition);
    	if (!$tmpResults) {
    		return InternalResultTransfer::fail('获取用户充值记录失败');
    	}
    	if (count($tmpResults) > 1) {
    		return InternalResultTransfer::fail('获取到多条充值记录');
    	}
    	return InternalResultTransfer::success(array_pop($tmpResults));
    }
    
    /**
     * 初始化用户充值订单
     * 默认状态为：充值中；
     * 类型为：支付宝充值；
     * @param array $params
     * @param string $provider 支付方
     * @return int | false
     */
    public function initUserCharge($params, $provider = 'alipay',$bank_type='0') {
    	$tableInfo = array();
    	$tableInfo['u_id'] 			= $params['yoka_user_id'];
    	$tableInfo['money'] 		= $params['total_fee'];//total_fee的单位为元
    	$tableInfo['create_time'] 	= getCurrentDate();
    	$tableInfo['charge_status'] = UserCharge::CHARGE_STATUS_ING;//状态：充值中
		$tableInfo['provider'] = $provider;//充值渠道原始数据
		$tableInfo['bank_type'] = $bank_type;//银行参数
		if($provider == 'online_bank'){//在线网银
			$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_ONLINE_BANK;
		}elseif($provider == 'alipay_qr'){//支付宝扫码
			$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_ALIPAY_QR;
		}elseif($provider == 'yeepay'){
			$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_YEEPAY;
		}elseif($provider == 'weixin'){	
			$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_WEIXIN;
		}elseif ($provider == 'tenpay') {
    		$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_TENPAY;
    	} else {
    		$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_ALIPAY;
    	}

    	//$tableInfo['charge_type'] 	= UserCharge::CHARGE_TYPE_ALIPAY;
    	$tableInfo['pay_order_id'] 	= $params['out_trade_no'];
    	return $this->add($tableInfo);
    }
}
?>
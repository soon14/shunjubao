<?php
class LakalaPayCenter implements PayCenterInterface {
	# 请求拉卡拉地址
	private $action;
	
	# 固定账单号
	private $fixed_bill;
	
	# 商户号
	private $mer_id;
	
	# 商户密码
	private $partnerPwd;
	
	public function __construct( array $params) {
		if (empty($params)) {
			throw new ParamsException("支付宝参数无效数据");
		}
		$this->action = $params['action'];
		$this->fixed_bill = $params['fixed_bill'];
		$this->mer_id = $params['mer_id'];
		$this->partnerPwd = $params['partnerPwd'];
    }
    
	/**
	 * 获取支付表单数组信息
     * 这些信息返回给调用方，供生成提交表单
     * @param array $params
     * @return InternalResultTransfer 成功：返回数组，格式：array(
     *     'action'    => (string)//作为html form元素的action属性值
     *     'params'      => (array)//处理后的支付有关的参数集
     * );
	 */
    public function getPayFormArray(array $args) {
    	//通知地址
        $action = $this->action;
        
        $params = $args;
        $params['billNo'] = $this->fixed_bill.$args['out_trade_no'];
        $params['merID'] = $this->mer_id;
        $params['amount'] = round($args['amount'] / 100, 2);
        
        unset($params['out_trade_no']);
        unset($params['notify_url']);
        unset($params['return_url']);
        
        $params['verCode'] = $this->createVerCode($params);
        
        return InternalResultTransfer::success(array (
            'action'   => $action,
            'params'   => $params,
        ));
    }
    
    public function verify_notify(array $params) {
    	if(empty($params)) {
            return InternalResultTransfer::fail("LakalaPayCenter->verify_notify的调用参数为空");
        }
        
    	$data = "amount={$params['amount']}&amount_pay={$params['amount_pay']}&currency={$params['currency']}&lakala_bill_no={$params['lakala_bill_no']}&lakala_pay_time={$params['lakala_pay_time']}&mer_id={$params['mer_id']}&partner_bill_no={$params['partner_bill_no']}&pay_type={$params['pay_type']}&req_id={$params['req_id']}&sec_id={$params['sec_id']}&service={$params['service']}&trade_no={$params['trade_no']}&v={$params['v']}".$this->partnerPwd;
	    if ($params['sign'] != md5($data)) {
			return InternalResultTransfer::fail("传递进来的signMsg值:{$params['sign']} 不等于计算后的 signMsg值：".md5($data));
		}
    	
        return InternalResultTransfer::success(array(
            'total_fee'     => round($params['amount_pay'] * 100),
            'inner_out_trade_no'  => $params['trade_no'],
            'trade_status'  => 'SUCCESS',
        ));
    }
    
    public function response_notify_success() {
    	$params = getRequestParams();
    	$time = date("YmdHis");
    	$sign = md5("is_success=y&lakala_bill_no={$params['lakala_bill_no']}&mer_id={$params['mer_id']}&partner_bill_no={$params['partner_bill_no']}&partner_pay_time={$time}&req_id={$params['req_id']}&sec_id={$params['sec_id']}&service={$params['service']}&v={$params['v']}".$this->partnerPwd);
    	$feedbackInfo = array(
			'v'						=> $params['v'],
			'service'				=> $params['service'],
			'mer_id'				=> $params['mer_id'],
			'sec_id'				=> $params['sec_id'],
			'req_id'				=> $params['req_id'],
			'is_success'			=> 'y',
			'lakala_bill_no'		=> $params['lakala_bill_no'],
			'partner_bill_no'		=> $params['partner_bill_no'],
			'amount'				=> $params['amount'],
			'partner_pay_time'		=> $time,
			'sign'					=> $sign,
		);
		
		echo substr( jointUrl(null, $feedbackInfo), 1 );
    }
    
    public function closeTrade(array $params) {
    	return InternalResultTransfer::fail('TRADE_NOT_EXIST');
    }
    
	/**
     * 生成请求参数的varCode
     * @param array $params
     * @return String
     */
    public function createVerCode(array $params) {
    	if ( empty($params) ) {
    		return false;
    	}
    	return md5($this->mer_id.$params['billNo'].$this->partnerPwd);
    }
}
<?php
class TwjAliPayCenter implements PayCenterInterface {

	//支付宝商家身份ID
	private  $partner;
	//密钥串
	private  $key;
	//请求支付宝地址
	private  $action;

	/**
	 *
	 * 卖家email
	 * @var string
	 */
	private $seller_email;

	//构造方法
	public function __construct( array $params) {
		if (empty($params)) {
			throw new ParamsException("支付宝参数无效数据");
		}
		$this->action = $params['action'];
		$this->partner = $params['partner'];
		
		$this->seller_email = $params['seller_email'];
    	$this->key = $params['security_code'];
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
	    //签名方式
	    $sign_type = 'MD5';
	    //编码集
	    $charset = 'UTF-8';
	    $alipayDefault = array(
    		//接口名称，即时到帐接口
	       'service'          	=> 'create_direct_pay_by_user',
	       //支付类型：1 购买,4捐赠
	       'payment_type'     	=> 1,
	       //编码字符集
	       '_input_charset'   	=> $charset,
           //身份ID
	       'partner'  			=> $this->partner,
    	   //支付宝账户
     	   'seller_email'     	=> $this->seller_email,
    	);
		
		
		
    	$params = $args + $alipayDefault;

    	if (isset($params['defaultbank'])) {
    		$params['paymethod'] = 'bankPay';
    	}

    	# 对subject字段超长的处理
    	if (isset($params['subject']) && mb_strlen($params['subject']) > 256) {
    		$params['subject'] = mb_substr($params['subject'], 0, 256, $charset);
    	}

    	# 对body字段超长的处理。
    	# ps：支付宝文档的要求是不超过400，但测试发现，其实是不能超过1000。但还是以文档为准吧，说不定啥时就会变
        if (isset($params['body']) && mb_strlen($params['body']) > 400) {
        	$params['body'] = mb_substr($params['body'], 0, 400, $charset);
        }

    	//交易金额,有分变为元
//    	$params['total_fee'] = floatval($params['total_fee']/100) ;


    	//安全验证码
    	$params['sign'] = $this->createSign($params);
    	//签名方式
    	$params['sign_type'] = $sign_type;
    	return InternalResultTransfer::success(array (
            'action'   => $action . "?_input_charset={$charset}",
            'params'   => $params,
        ));
    }

    /**
     * 验证通知的有效性
     * @param array $request_params 请求的参数
     * @return InternalResultTransfer 失败：返回数据是String型描述；成功：格式为 array(
     *     'total_fee' => (int),//交易金额，单位元
     *     'inner_out_trade_no'  => (string),//平台传给财付通的交易号
     *     'trade_status' => (string),//本次通知的交易状态
     * );
     */
	public function verify_notify(array $params) {
		if(empty($params)) {
            return InternalResultTransfer::fail("AliPayCenter->verify_notify的调用参数为空");
		}
		//验证sign值
		if ($params['sign_type'] == 'MD5') {
			if(!$this->verifySign($params)) {
                return InternalResultTransfer::fail("传递进来的sign值:{$params['sign']} 不等于计算后的 sign值：{$this->createSign($params)}");
			}
		}
		if (empty($params['notify_id'])) {
            return InternalResultTransfer::fail("notify_id值为空");
		}
		$post = array(
			'service' => 'notify_verify',
			'partner' => $this->partner,
			'notify_id' => $params['notify_id'],
		);
		$gate_way = $this->action . "?_input_charset=utf-8";
		$objCurl = new Curl($gate_way);
		$result = $objCurl->post($post);

		if ($result != 'true') {
            return InternalResultTransfer::fail("Curl->post返回值不全等于字符串true。gate_way是:{$gate_way}；返回结果是：" . var_export($result, true));
		}

		return InternalResultTransfer::success(array(
            'total_fee'     		=> $params['total_fee'],//金额转成分单位
            'inner_out_trade_no'  	=> $params['out_trade_no'],
            'trade_status'  		=> $params['trade_status'],
        ));
	}
    /*
	 * 输出内容
	 */
	public function response_notify_success() {
		echo 'success';
	}
    /*
     * 通知关闭订单方法
     * 添加通知日志
     * 通知支付宝的参数：
     * @param string service
     * @param string partner
     * @param string _input_charset
     * @param string inner_out_trade_no(唯一订单号)
     * return boolean
	 */
    public function closeTrade(array $params) {
    	if(empty($params['inner_out_trade_no'])) {
		    return InternalResultTransfer::fail('支付提供商订单号缺失');
    	}
		//获取订单
		$inner_out_trade_no = $params['inner_out_trade_no'];
		$close_params = array(
				'service' 			=> 'close_trade',
				'_input_charset'   	=> 'UTF-8',
				'partner' 			=> $this->partner,
				'out_order_no' 		=> $inner_out_trade_no,
			);
		//得到MD5加密串
		$sign = $this->createSign($close_params);
		$close_params['sign'] = $sign;
		$close_params['sign_type'] = 'MD5';
		//得到构造的url
		$url = jointUrl($this->action,$close_params);
		$objCurl = new Curl($url);
		$rt = $objCurl->get();
		if($rt == FALSE) {
			return InternalResultTransfer::fail('支付宝关闭交易接口调用失败');
		}
		$rtxml = simplexml_load_string($rt);
		if($rtxml->is_success == 'T') {
			return InternalResultTransfer::success();
		} else {
			return InternalResultTransfer::fail($rtxml->error);
		}
    }

    /**
     * 校验请求的合法性
     * @param array $request_params
     * @return Boolean
     */
    public function verifySign(array $request_params) {
        $tenpay_sign = strtolower($request_params['sign']);
        $sign = $this->createSign($request_params);
        if ($tenpay_sign != $sign) {
            return false;
        }
        return true;
    }

    /**
     * 生成请求参数的sign
     * @param array $params
     * @return String
     */
    public function createSign(array $params) {
        $signPars = "";
        ksort($params);

        foreach ($params as $key => $val) {
            if($key != "sign" && $key != "sign_type") {
                $signPars .= $key."={$val}&";
            }
        }
        $signPars = rtrim($signPars,'&');

        $sign = strtolower(md5($signPars . $this->key));
        return $sign;
    }
}
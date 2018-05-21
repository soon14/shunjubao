<?php
/**
 * 支付平台客户端
 * 用于封装对支付平台的调用
 * @author gaoxiaogang@gmail.com
 *
 */
class PayCenterClient {
	const PAY_PLATFORM_URL_PREFIX = ROOT_DOMAIN;
	
	
	/**
	 * 支付商：天无居支付宝
	 * @var int
	 */
	const PROVIDER_TWJ_ALIPAY = 'twjalipay';


	/**
	 * 支付商：支付宝
	 * @var int
	 */
	const PROVIDER_ALIPAY = 'alipay';

	/**
	 * 支付商：财付通
	 * @var int
	 */
	const PROVIDER_TENPAY = 'tenpay';

	/**
	 * 支付商：快钱
	 * @var int
	 */
	const PROVIDER_PAY99BILL = 'pay99bill';
	
	/**
	 * 支付商：拉卡拉
	 * @var int
	 */
	const PROVIDER_LAKALA = 'lakala';
	
	/**
	 * 支付商：国付宝
	 * @var int
	 */
	const PROVIDER_GOPAY = 'gopay';

	/**
	 * 签名密钥
	 * @var string
	 */
	private $key;

	/**
	 * 商户标识
	 * @var string
	 */
	private $partner;

	public function __construct() {
		$this->partner = 'zhiying';
		$this->key     = SECRET_KEY;
	}

	/**
	 * 获取支付表单数组
	 * @param array $params 格式：array(
	 *     'notify_url'    => (string),//服务器异步通知页面路径。支付平台服务器主动通知商户网站里指定的页面http路径
	 *     'return_url'    => (string),//页面跳转同步通知页面路径。支付平台处理完请求后，当前页面自动跳转到商户网站里指定页面的http路径
	 *     'out_trade_no'  => (int | string),//商户网站唯一订单号（必填）。请确保在商户网站的唯一性
	 *     'subject'       => (string),//商品名称（必填）。商品的标题/交易标题/订单标题/订单关键字等。该参数最长为256个汉字。
	 *     'total_fee'     => (float),//交易金额（必填）。该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
	 *     'exter_invoke_ip'   => (string),//客户端ip（必填）。用户在创建交易时，该用户使用的ip地址
	 *     'yoka_user_id'      => (int),//YOAK网的用户id（必填）
	 *     'providers'     => (string),//指定的支付提供商标识（必填）。如：providers = 'alipay,tenpay,cmpay'，表示同时返回alipay、tenpay、cmpay三家的支付表单
	 *
	 *     '_input_charset' => (string),//参数编码字符集（可空）。商户网站使用的编码格式，如utf-8、gbk、gb2312等。默认值是utf-8
	 *     'body'          => (string),//商品描述（可空）。对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body
	 *     'show_url'      => (string),//商品展示网址（可空）。收银台页面上，商品展示的超链接。
	 *     'extra_common_param'    => (string),//公用回传参数（可空）。用于商户回传参数。如果用户请求时传递了该参数，则返回给商户时会原样回传该参数。
	 * );
	 * @return InternalResultTransfer 错误：返回数据是 String 型错误描述；正确：返回数据是数组，格式是 array(
	 *     '支付商标识'     => array(
	 *         'action'    => (string),//作为html form元素的action属性值,
	 *         'params'    => (array),//处理后的支付有关的参数集
	 *     ),
	 *     ... ,
	 *     ... ,
	 * );
	 */
	public function getsPayFormArray(array $params) {
		$gate_way = self::PAY_PLATFORM_URL_PREFIX . '/partner/get_pay_forms.php';

		$order = $params;
		$default = array(
		    'partner' => $this->partner,
		);
		$order = $default + $order;

		$sign = $this->createSign($order);
		$order['sign'] = $sign;

        $objCurl = new Curl($gate_way);
        $result = $objCurl->post($order);
        $tmpArr = json_decode($result, true);
        if (!is_array($tmpArr)) {
        	return InternalResultTransfer::fail('请求失败，可能是超时');
        }
        if ($tmpArr['status'] == 'F') {
        	return InternalResultTransfer::fail($tmpArr['data']);
        }

        return InternalResultTransfer::success($tmpArr['data']);
	}

	/**
	 * 获取直接到银行支付的url。这些url可以直接跳转到指定银行，请求支付。
	 * @param array $params 格式：array(
     *     'notify_url'    => (string),//服务器异步通知页面路径。支付平台服务器主动通知商户网站里指定的页面http路径
     *     'return_url'    => (string),//页面跳转同步通知页面路径。支付平台处理完请求后，当前页面自动跳转到商户网站里指定页面的http路径
     *     'out_trade_no'  => (int | string),//商户网站唯一订单号（必填）。请确保在商户网站的唯一性
     *     'subject'       => (string),//商品名称（必填）。商品的标题/交易标题/订单标题/订单关键字等。该参数最长为256个汉字。
     *     'total_fee'     => (float),//交易金额（必填）。该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
     *     'exter_invoke_ip'   => (string),//客户端ip（必填）。用户在创建交易时，该用户使用的ip地址
     *     'yoka_user_id'      => (int),//YOAK网的用户id（必填）
     *
     *     '_input_charset' => (string),//参数编码字符集（可空）。商户网站使用的编码格式，如utf-8、gbk、gb2312等。默认值是utf-8
     *     'body'          => (string),//商品描述（可空）。对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body
     *     'show_url'      => (string),//商品展示网址（可空）。收银台页面上，商品展示的超链接。
     *     'extra_common_param'    => (string),//公用回传参数（可空）。用于商户回传参数。如果用户请求时传递了该参数，则返回给商户时会原样回传该参数。
     * );
     * @param array $providerAndbanks 支付商和银行的列表，格式：array(
     *     array(
     *         'provider'   => (string),//支付商，比如tenpay。表示使用财付通
     *         'bank_type'  => (string),//银行，比如 ICBC。表示使用工行支付
     *     ),
     *     ... ,
     *     ... ,
     * );
     * @return InternalResultTransfer 失败：数据里含String类型的错误描述；成功：数据是数组，格式 array(
     *     array(
     *         'provider'   => (string),//支付商，比如tenpay。表示使用财付通
     *         'bank_type'  => (string),//银行，比如 ICBC。表示使用工行支付
     *         'pay_url'    => (string),//支付url。该url可直接放到a标签的href属性，跳转到指定支付商
     *     ),
     *     ... ,
     *     ... ,
     * );
	 */
	public function getsBankPayUrl(array $params, array $providerAndbanks) {
		$gate_way = self::PAY_PLATFORM_URL_PREFIX . '/partner/bank_pay_request.php';

		if (!$providerAndbanks) {
			return InternalResultTransfer::fail('支付商与银行类别不能为空');
		}
		if (!$params) {
			return InternalResultTransfer::fail('参数不能为空');
		}

		$ip = Request::getIpAddress();

		$return = array();
		foreach ($providerAndbanks as $tmpV) {
			$provider = $tmpV['provider'];
			$bank_type = $tmpV['bank_type'];

			$order = $params;
			$order['provider']     = $provider;
			$order['bank_type']    = $bank_type;
			$order['partner']      = $this->partner;
			$order['user_ip']      = $ip;

			$order['sign']         = $this->createSign($order);
			$return[$provider.'_'.$bank_type] = array(
			    'provider'   => $provider,
			    'bank_type'  => $bank_type,
			    'pay_url'    => jointUrl($gate_way, $order),
			);
		}
		return InternalResultTransfer::success($return);
	}

	/**
	 * 关闭指定定单的交易
	 * @param string $out_trade_no
	 * @return InternalResultTransfer 失败：数据里含String型失败原因；成功：不含数据
	 */
	public function closeTrade($out_trade_no) {
		$gate_way = self::PAY_PLATFORM_URL_PREFIX . '/partner/close_trade.php';

		$close_order = array(
		    'out_trade_no'    => $out_trade_no,
		    'partner'         => $this->partner,
		);

		$sign = $this->createSign($close_order);
		$close_order['sign'] = $sign;
		$objCurl = new Curl($gate_way);
        $result = $objCurl->post($close_order);
        $tmpArr = json_decode($result, true);
	    if (!is_array($tmpArr)) {
            return InternalResultTransfer::fail('请求失败，可能是超时');
        }
        if ($tmpArr['status'] == 'F') {
            return InternalResultTransfer::fail($tmpArr['data']);
        }

        return InternalResultTransfer::success();
	}

	/**
     * 校验请求的合法性
     * @param array $request_params
     * @param string $sign
     * @return Boolean
     */
    public function verifySign(array $request_params, $sign) {
    	if (empty($sign)) {
    		return false;
    	}
        $new_sign = $this->createSign($request_params);
        if (strtolower($new_sign) != strtolower($sign)) {
            return false;
        }
        return true;
    }

    /**
     * 生成请求参数的sign
     * @param array $params
     * @return String
     */
    private function createSign(array $params) {
    	$objYokaServiceUtility = new YokaServiceUtility();
        $objYokaServiceUtility->secret = $this->key;
        return $objYokaServiceUtility->createSign($params);
    }

	static private $providerDesc = array(
		self::PROVIDER_TWJ_ALIPAY => array(
    		'desc'	=> '支付宝',
    		'kw'		=> 'PROVIDER_TWJ_ALIPAY',
    	),
		self::PROVIDER_ALIPAY => array(
    		'desc'	=> '支付宝',
    		'kw'		=> 'PROVIDER_ALIPAY',
    	),
    	self::PROVIDER_TENPAY => array(
    		'desc'	=> '财付通',
    		'kw'		=> 'PROVIDER_TENPAY',
    	),
		self::PROVIDER_PAY99BILL => array(
			'desc'	=> '快钱',
			'kw'	=> 'PROVIDER_PAY99BILL',
		),
		self::PROVIDER_LAKALA => array(
			'desc'	=> '拉卡拉',
			'kw'	=> 'PROVIDER_LAKALA',
		),
		self::PROVIDER_GOPAY => array(
			'desc'	=> '国付宝',
			'kw'	=> 'PROVIDER_GOPAY',
		),
	);

	/**
	 *
	 * 获取支付商的描述
	 * @var array
	 */
	static public function getProviderDesc() {
		return self::$providerDesc;
	}
}

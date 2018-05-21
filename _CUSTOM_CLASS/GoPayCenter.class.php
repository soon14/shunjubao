<?php
class GoPayCenter implements PayCenterInterface {
    #请求交易地址
    private  $action;
    #国付宝账户
    private  $virCardNoIn;
    #国付宝网关版本号
    private  $version = 2.1;
    #字符集
    private  $charset = 2; // 1:GBK,2:UTF-8
    #国付宝网卡语言版本
    private  $language = 1; // 1:ZH,2:EN
    #报文加密方式
    private  $signType = 1; // 1:MD5,2:SHA
    #交易代码
    private  $tranCode = 8888;
    #币种
    private  $currencyType = 156;
    #签约国付宝商户唯一用户ID
    private  $merchantID;
    #密文串
    private  $signValue;
    #商户识别码
    private  $VerficationCode;
    
    #初始化数据
    public function __construct( array $params) {
        if (empty($params)) {
            throw new ParamsException("国付宝参数无效数据");
        }
        $this->action = $params['action'];
        $this->virCardNoIn = $params['virCardNoIn'];
        $this->merchantID = $params['merchantID'];
        $this->VerficationCode = $params['VerficationCode'];
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
    	$action = $this->action;
    	$params = $args;
    	
    	$params = array_merge($params, array(
    		'version'	=> $this->version,
    		'charset'	=> $this->charset,
    		'language'	=> $this->language,
    		'signType'	=> $this->signType,
    		'tranCode'	=> $this->tranCode,
    		'merchantID'=> $this->merchantID,
    		'currencyType'	=> $this->currencyType,
    		'frontMerUrl'	=> $args['return_url'],
    		'backgroundMerUrl'	=> $args['notify_url'],
			'tranDateTime'	=> date("YmdHis"),
    		'virCardNoIn'	=> $this->virCardNoIn,
    		'gopayServerTime'	=> HttpClient::getGopayServerTime(), // 服务器时间，从国付宝服务器获取的当前时间
    	));
    	
    	if ($params['bankCode']) {
    		$params['userType'] = '1';
    	}
    	
    	$params['tranAmt'] =  round($params['tranAmt'] / 100, 2);
    	$params['signValue'] = $this->createSign($params);
    	
    	unset($params['notify_url']);
        unset($params['return_url']);
       	
        return InternalResultTransfer::success(array (
            'action'   => $action,
            'params'   => $params,
        ));
    }
    
    /*
	 * 输出内容
	 */
	public function response_notify_success() {
		$params = getRequestParams();
		
		$return_url = $params['frontMerUrl'];
		$url = jointUrl($return_url, $params);
		if ($params['tranCode'] == '0000') {
			echo "RespCode=0000|JumpURL={$url}";
		} else {
			echo "RespCode=9999|JumpURL={$url}";
		}
	}
	
    /**
     * 关闭交易
     * @param array $params 
     * @return InternalResultTransfer
     */
    public function closeTrade(array $params) {
    	return InternalResultTransfer::fail('TRADE_NOT_EXIST');
    }
    
    public function verify_notify(array $params) {
    	if(empty($params)) {
            return InternalResultTransfer::fail("GoPayCenter->verify_notify的调用参数为空");
        }
        
        $signValue = $this->createSign($params);
		if ($params['signValue'] != $signValue) {
			return InternalResultTransfer::fail("传递进来的signMsg值:{$params['signValue']} 不等于计算后的 signMsg值：{$signValue}");
		}
    	
        return InternalResultTransfer::success(array(
            'total_fee'     => round($params['tranAmt'] * 100),
            'inner_out_trade_no'  => $params['merOrderNum'],
            'trade_status'  => 'SUCCESS',
        ));
    }
    
	/**
     * 生成请求参数的sign
     * @param array $params
     * @return String
     */
    public function createSign(array $params) {
    	$data = array(
    		'version'	=> $params['version'],
    		'tranCode'	=> $params['tranCode'],
    		'merchantID'	=> $params['merchantID'],
    		'merOrderNum'	=> $params['merOrderNum'],
    		'tranAmt'	=> $params['tranAmt'],
    		'feeAmt'	=> $params['feeAmt'],
    		'tranDateTime'	=> $params['tranDateTime'],
    		'frontMerUrl'	=> $params['frontMerUrl'],
    		'backgroundMerUrl'	=> $params['backgroundMerUrl'],
    		'orderId'	=> $params['orderId'],
    		'gopayOutOrderId'	=> $params['gopayOutOrderId'],
    		'tranIP'	=> $params['tranIP'],
    		'respCode'	=> $params['respCode'],
    		'gopayServerTime'	=> $params['gopayServerTime'],
    		'VerficationCode'	=> $this->VerficationCode,
    	);
    	
    	$signStr = '';
    	foreach ($data as $tmpkey => $tmpval) {
    		$signStr .= "{$tmpkey}=[{$tmpval}]";
    	}
    	
    	return md5($signStr);
    }
    
}
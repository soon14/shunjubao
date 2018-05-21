<?php
class Pay99billCenter implements PayCenterInterface {
    #人民币账号
    private  $partner;
    #密钥串
    private  $key;
    #请求快钱地址
    private  $action;
    #初始化数据
    public function __construct( array $params) {
        if (empty($params)) {
            throw new ParamsException("支付宝参数无效数据");
        }
        $this->action = $params['action'];
        $this->merchantAcctId = $params['merchantAcctId'];
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
        $alipayDefault = array(
            'merchantAcctId' => $this->merchantAcctId,#人民币账号
	        'inputCharset' => 1,#字符集，1为UTF-8
	        'payType' => '00',#支付方式
	        'language' => 1,#中文显示
	        'signType' => 4,#签名类型
	        'version' => 'v2.0',#网关版本
            #'productNum' =>1,#产品数量为1 
            'orderTime' => date('YmdHis'),
            'redoFlag' => 0,#同一订单禁止重复提交标志，0表示没有成功，可以多次提交
        );
        $params = $args + $alipayDefault;
        $params['pageUrl'] = $params['return_url'];
        $params['bgUrl'] = $params['notify_url'];
        unset($params['return_url']);
        unset($params['notify_url']);
        #银行直连
        if ($params['bankId'])
        $params['payType'] = '10';
        #信用卡支付
        if ($params['bankId'] == 'DEFAULT') {
            $params['payType'] = '15';
            unset($params['bankId']);
        }
        //if (isset($params['defaultbank'])) {
        //    $params['paymethod'] = 'bankPay';
        //}
        //编码集
        $charset = 'UTF-8';
        # 对subject字段超长的处理
        if (isset($params['productName']) && mb_strlen($params['productName']) > 50) {
            $params['productName'] = mb_substr($params['productName'], 0, 50, $charset);
        }
        
        # 对body字段超长的处理。
        # ps：支付宝文档的要求是不超过400，但测试发现，其实是不能超过1000。但还是以文档为准吧，说不定啥时就会变
        if (isset($params['productDesc']) && mb_strlen($params['productDesc']) > 100) {
            $params['productDesc'] = mb_substr($params['productDesc'], 0, 100, $charset);
        }

        //安全验证码
        $params['signMsg'] = $this->createSign($params);
        return InternalResultTransfer::success(array (
            'action'   => $action,
            'params'   => $params,
        ));
    }
    
    
    /**
     * 验证通知的有效性
     * @param array $request_params 请求的参数
     * @return InternalResultTransfer 失败：返回数据是String型描述；成功：格式为 array(
     *     'total_fee' => (int),//交易金额，单位分
     *     'inner_out_trade_no'  => (string),//平台传给财付通的交易号
     *     'trade_status' => (string),//本次通知的交易状态
     * );
     */
    public function verify_notify(array $params) {
        if(empty($params)) {
            return InternalResultTransfer::fail("Pay99billCenter->verify_notify的调用参数为空");
        }
        
        if(!$this->verifyReturnSign($params)) {
                return InternalResultTransfer::fail("传递进来的signMsg值:{$params['signMsg']} 不等于计算后的 signMsg值：{$this->createSign($params)}");
        }
        
        return InternalResultTransfer::success(array(
            'total_fee'     => $params['payAmount'],//金额分单位
            'inner_out_trade_no'  => $params['orderId'],
            'trade_status'  => $params['payResult'],
        ));
    }
    
    /**
     * 给支付商确认本次通知成功
     */
    public function response_notify_success() {
    	echo '<result>1</result><redirecturl>'.ROOT_DOMAIN . '/provider/return/pay99bill</redirecturl>';
    }
    
    /**
     * 关闭交易
     * 快钱不支持关闭交易接口
     * @param array $params 
     * @return InternalResultTransfer
     */
    public function closeTrade(array $params) {
    	return InternalResultTransfer::fail('TRADE_NOT_EXIST');
    }
    
    /**
     * 生成请求参数的sign
     * @param array $params
     * @return String
     */
    public function createSign(array $params) {
        if (empty($params))
        return false;
        $verifyParams = array(
            'inputCharset',//字符集.固定选择值。可为空。1代表UTF-8; 2代表GBK; 3代表gb2312
            'pageUrl',//接受支付结果的页面地址.与[bgUrl]不能同时为空。必须是绝对地址。
            'bgUrl',//服务器接受支付结果的后台地址.与[pageUrl]不能同时为空。必须是绝对地址。
            'version' ,//网关版本.固定值
            'language' ,//语言种类.固定选择值 1代表中文；2代表英文
            'signType' ,//签名类型.固定值 1代表MD5签名
            'merchantAcctId' ,//人民币网关账户号
            'payerName' ,//支付人姓名
            'payerContactType' => '',//支付人联系方式类型.固定选择值
            'payerContact' => '',//支付人联系方式
            'orderId' ,//商户订单号
            'orderAmount' ,//订单金额
            'orderTime' ,//订单提交时间
            'productName' ,//商品名称
            'productNum',//商品数量
            'productId' ,//商品代码
            'productDesc' ,//商品描述
            'ext1' ,//扩展字段1
            'ext2' ,//扩展字段2
            'payType',//支付方式.固定选择值 00：组合支付（网关支付页面显示快钱支持的各种支付方式，推荐使用）10：银行卡支付（网关支付页面只显示银行卡支付）.11：电话银行支付（网关支付页面只显示电话支付）.12：快钱账户支付（网关支付页面只显示快钱账户支付）.13：线下支付（网关支付页面只显示线下支付方式）.14：B2B支付（网关支付页面只显示B2B支付，但需要向快钱申请开通才能使用.15：信用卡直接预授权的大额支付）
            'bankId',//$order_info['payment_bank'],//银行代码
            'redoFlag',//同一订单禁止重复提交标志 1代表同一订单号只允许提交1次；0表示同一订单号在没有支付成功的前提下可重复提交多次。
            'pid' //快钱的合作伙伴的账户号
        );
        $signPars = '';
        foreach ( $verifyParams as $value ) {
        	if (isset($params[$value]) && $params[$value] !== '') {
        		$signPars .= "$value=".$params[$value]."&";
        	}
        }
		$signPars=substr($signPars,0,strlen($signPars)-1);
        
		$STRAGE_FILE_PATH = ROOT_PATH . '/99bill_pki/strategy.xml';
		$mpf=array('membercode'=>'10021512471','feature_code'=>'F22');
		require_once ROOT_PATH . '/99bill_pki/config.php';
		
		$sealed = crypto_service_seal($signPars, $mpf);
		$signed_data = $sealed['signed_data'];
		$sign = base64_encode($signed_data);
        return $sign;
    }
    /**
     * 生成返回参数的sign
     * @param array $params
     * @return String
     */
    public function verifyReturnSign($params) {
    	if (empty($params))
        return false;
        
    	$signPars = '';
		$signPars = $this->kq_ck_null($params['merchantAcctId'],'merchantAcctId').$this->kq_ck_null($params['version'],'version').$this->kq_ck_null($params['language'],'language').$this->kq_ck_null($params['signType'],'signType').$this->kq_ck_null($params['payType'],'payType').$this->kq_ck_null($params['bankId'],'bankId').$this->kq_ck_null($params['orderId'],'orderId').$this->kq_ck_null($params['orderTime'],'orderTime').$this->kq_ck_null($params['orderAmount'],'orderAmount').$this->kq_ck_null($params['dealId'],'dealId').$this->kq_ck_null($params['bankDealId'],'bankDealId').$this->kq_ck_null($params['dealTime'],'dealTime').$this->kq_ck_null($params['payAmount'],'payAmount').$this->kq_ck_null($params['fee'],'fee').$this->kq_ck_null($params['ext1'],'ext1').$this->kq_ck_null($params['ext2'],'ext2').$this->kq_ck_null($params['payResult'],'payResult').$this->kq_ck_null($params['errCode'],'errCode');
        
        $signPars=substr($signPars,0,strlen($signPars)-1);
		$MAC=base64_decode($params['signMsg']);
		
		$fp = fopen(ROOT_PATH . "/99bill_pki/99bill.cert.rsa.20140728.cer", "r");
		$cert = fread($fp, 8192);
		fclose($fp);
		$pubkeyid = openssl_get_publickey($cert);
		
		if (openssl_verify($signPars, $MAC, $pubkeyid) == 1) {
			return true;
		} else {
			return false;
		}
    }
    
	public function kq_ck_null( $kq_va, $kq_na ){
		if ($kq_va == "") {
			return $kq_va = "";
		} else {
			return $kq_va = $kq_na.'='.$kq_va.'&';
		}
	}
}
?>
<?php
class CmPayCenter {
	
	private $objPayOrderFront ;
	
	public function __construct(){
		$this->objPayOrderFront= new PayOrderFront ( );
	}
	/**
	 * CmPayHTTP请求参数
	 * @var string
	 */
	public $payForms;
	
	/**
	 * CmPayHTTPHTTP错误信息
	 * @var string
	 */
	public $payFormsError;
	
	
	
	
	/**
	 * 获取支付表单数组信息
	 * 这些信息返回给调用方，供生成提交表单
	 * @param array $params
	 * @return InternalResultTransfer 失败：返回String型错误描述；成功：返回数组，格式：array(
     *     'action'    => (string)//作为html form元素的action属性值
     *     'params'      => (array)//处理后的支付有关的参数集
     * );
	 */
	public function getPayFormArray(array $params) {
		
		if ($params && is_array ( $params )) {
			$payCenterConfig = include (ROOT_PATH . '/include/provider_config.php'); #加载接入方的配置文件
			//参数对应
			$cmPayConfig = $payCenterConfig ['cmpay'];
			$url = $cmPayConfig ['tokenReqUrl'];
			$callbackUrl = $params ['return_url'];
			$hmac = "";
			$ipAddress = $params ['user_ip'];
			$merchantId = $cmPayConfig ['merchantId'];
			$notifyUrl = $params ['notify_url'];
			$notifyEmail = $cmPayConfig ['notifyEmail'];
			$notifyMobile = $cmPayConfig ['notifyMobile'];
			$requestId = date ( "YmdHis" );
			$signType = $cmPayConfig ['signType'];
			$type = $cmPayConfig ['type'];
			$version = $cmPayConfig ['version'];
			$allowNote = $cmPayConfig ['allowNote'];
			$amount = $params ["total_fee"];
			$authorizeMode = $cmPayConfig ['authorizeMode'];
			$banks = $cmPayConfig ['banks'];
			$currency = $cmPayConfig ["currency"];
			$deliverFlag = $cmPayConfig ["deliverFlag"];
			$invoiceFlag = $cmPayConfig ["invoiceFlag"];
			$orderDate = date ( "Ymd" );
			//$orderId = date( "YmdHis" );
			$orderId = $params ['inner_out_trade_no'];
			$pageStyle = $cmPayConfig ["pageStyle"];
			$period = $cmPayConfig ["period"];
			$periodUnit = $cmPayConfig ["periodUnit"];
			
			$productDesc = u82gb($params ['body']);
			$productId = u82gb($params ['out_trade_no']);
			$productName = u82gb(cutstr($params ["subject"],60,'...'));
			$reserved = u82gb($params ["extra_common_param"]);; //保留字段
			$userToken = "";
			$signKey = $cmPayConfig ['signKey'];
			$source = $callbackUrl . $ipAddress . $merchantId . $notifyUrl . $notifyEmail . $notifyMobile . $requestId . $signType . $type . $version . $allowNote . $amount . $authorizeMode . $banks . $currency . $deliverFlag . $invoiceFlag . $orderDate . $orderId . $pageStyle . $period . $periodUnit . $productDesc . $productId . $productName . $reserved . $userToken;
			$hash = $this->hmac ( "", $source );
			$hmac = $this->hmac ( $signKey, $hash );
			$requestData = array ();
			$requestData ["callbackUrl"] = $callbackUrl;
			$requestData ["hmac"] = $hmac;
			$requestData ["ipAddress"] = $ipAddress;
			$requestData ["merchantId"] = $merchantId;
			$requestData ["notifyUrl"] = $notifyUrl;
			$requestData ["notifyEmail"] = $notifyEmail;
			$requestData ["notifyMobile"] = $notifyMobile;
			$requestData ["requestId"] = $requestId;
			$requestData ["signType"] = $signType;
			$requestData ["type"] = $type;
			$requestData ["version"] = $version;
			$requestData ["allowNote"] = $allowNote;
			$requestData ["amount"] = $amount;
			$requestData ["authorizeMode"] = $authorizeMode;
			$requestData ["banks"] = $banks;
			$requestData ["currency"] = $currency;
			$requestData ["deliverFlag"] = $deliverFlag;
			$requestData ["invoiceFlag"] = $invoiceFlag;
			$requestData ["orderDate"] = $orderDate;
			$requestData ["orderId"] = $orderId;
			$requestData ["pageStyle"] = $pageStyle;
			$requestData ["period"] = $period;
			$requestData ["periodUnit"] = $periodUnit;
			$requestData ["productDesc"] = $productDesc;
			$requestData ["productId"] = $productId;
			$requestData ["productName"] = $productName;
			$requestData ["reserved"] = $reserved;
			$requestData ["userToken"] = $userToken;
			
			$sTotalString = $this->POSTDATA ( $url, $requestData );
			if (! $sTotalString) {
				return InternalResultTransfer::fail('请求手机支付平台错误');
			}
			
			$recv = $sTotalString ["MSG"];
			$recvArray = $this->parseRecv ( $recv );
			
			//校验签名
			$r_hmac = $recvArray ["hmac"];
			$r_merchantId = $recvArray ["merchantId"];
			$r_payNo = $recvArray ["payNo"];
			$r_requestId = $recvArray ["requestId"];
			$r_returnCode = $recvArray ["returnCode"];
			$r_message = $recvArray ["message"];
			$r_signType = $recvArray ["signType"];
			$r_type = $recvArray ["type"];
			$r_version = $recvArray ["version"];
			$sessionId = $recvArray ["SESSIONID"];
			$r_source = $r_merchantId . $r_payNo . $r_requestId . $r_returnCode . $r_message . $r_signType . $r_type . $r_version . $sessionId;
			$r_hash = $this->hmac ( "", $r_source );
			$r_newhmac = $this->hmac ( $signKey, $r_hash );
			
			if ($r_hmac != $r_newhmac) {
				return InternalResultTransfer::fail("手机支付：签名校验错误。调用POSTDATA收到的值是：" . var_export($sTotalString, true));
			} else {
				$newUrl = $cmPayConfig ["tokenRedirectUrl"];
			}
			//拼接成我们统一的表单数据格式返回
			return InternalResultTransfer::success(array ('action' => $newUrl, 'params' => array ('SESSIONID' => $sessionId ) ));
		} else {
			return InternalResultTransfer::fail('手机支付获取参数缺失');
		}
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
		if (empty ( $params )) {
			return InternalResultTransfer::fail('CmPayCenter->verify_notify调用参数为空');
		}
		//报文头
		$hmac = $params ["hmac"];
		$merchantId = $params ["merchantId"];
		$payNo = $params ["payNo"];
		$requestId = $params ["requestId"];
		$returnCode = $params ["returnCode"];
		$message = $params ["message"];
		$message = $this->decodeUtf8 ( $message );
		$signType = $params ["signType"];
		$type = $params ["type"];
		$version = $params ["version"];
		//报文体
		$amount = $params ["amount"];
		$banks = $params ["banks"];
		$contractName = $params ["contractName"];
		$contractName = $this->decodeUtf8 ( $contractName );
		$invoiceTitle = $params ["invoiceTitle"];
		$invoiceTitle = $this->decodeUtf8 ( $invoiceTitle );
		$mobile = $params ["mobile"];
		$orderId = $params ["orderId"];
		$payDate = $params ["payDate"];
		$reserved = $params ["reserved"];
		$reserved = $this->decodeUtf8 ( $reserved );
		$requestId = $params ["requestId"];
		$status = $params ["status"];
		$amtItem = $params ["amtItem"];
		
		$signData = $merchantId . $payNo . $requestId . $returnCode . $message . $signType . $type . $version . $amount . $banks . $contractName . $invoiceTitle . $mobile . $orderId . $payDate . $reserved . $status;
		
		$payCenterConfig = include (ROOT_PATH . '/include/provider_config.php'); #加载接入方的配置文件
		
		if ($version == $payCenterConfig ['cmpay'] ['version']){
			 $signData = $merchantId.$payNo.$requestId.$returnCode.$message.$signType.$type.$version.$amount.$banks.$contractName.$invoiceTitle.$mobile.$orderId.$payDate.$reserved.$status.$amtItem;
		}
		
		$hash = $this->hmac ( "", $signData );
		$newhmac = $this->hmac ( $payCenterConfig ['cmpay'] ['signKey'], $hash );
		
		if ($newhmac != $hmac) {
			return InternalResultTransfer::fail("newhmac:{$newhmac} 不等于 hmac:{$hmac}");
		}
		
		#3.知道这次请求是否是失败请求
		if($params ['status'] != 'SUCCESS') {
			return InternalResultTransfer::fail("params数据的key值status不等于SUCCESS");
		}
		
		return InternalResultTransfer::success(array(
            'total_fee'     => $params ["amount"],
            'inner_out_trade_no'  => $params ["orderId"],
            'trade_status'  => $params ["status"]
        ));
	}

	 /*
	 * 输出内容
	 */
	public function response_notify_success() {
		echo 'success';
	}
	
	
	
	
	
	
	//下面是手机支付平台例子里的代码方法，为了赶时间懒的重写了。能用就行。
	public function POSTDATA($url, $data) {
		$url = parse_url ( $url );
		if (! $url) {
			return false;
		}
		if (! isset ( $url ['port'] )) {
			$url ['port'] = "";
		}
		
		if (! isset ( $url ['query'] )) {
			$url ['query'] = "";
		}
		
		$encoded = "";
		
		while ( list ( $k, $v ) = each ( $data ) ) {
			$encoded .= ($encoded ? "&" : "");
			$encoded .= rawurlencode ( $k ) . "=" . rawurlencode ( $v );
		}
		
		$urlHead = null;
		$urlPort = $url ['port'];
		if ($url [scheme] == "https") {
			$urlHead = "ssl://" . $url ['host'];
			if ($url ['port'] == null || $url ['port'] == 0) {
				$urlPort = 443;
			}
		} else {
			$urlHead = $url ['host'];
			if ($url ['port'] == null || $url ['port'] == 0) {
				$urlPort = 80;
			}
		}
		$fp = fsockopen ( $urlHead, $urlPort );
		
		if (! $fp)
			return false;
		
		$tmp = "";
		$tmp .= sprintf ( "POST %s%s%s HTTP/1.0\r\n", $url ['path'], $url ['query'] ? "?" : "", $url ['query'] );
		$tmp .= "Host: $url[host]\r\n";
		$tmp .= "Content-type: application/x-www-form-urlencoded\r\n";
		$tmp .= "Content-Length: " . strlen ( $encoded ) . "\r\n";
		$tmp .= "Connection: close\r\n\r\n";
		$tmp .= "$encoded\r\n";
		fputs ( $fp, $tmp );
		
		$line = fgets ( $fp, 1024 );
		if (! eregi ( "^HTTP/1\.. 200", $line )) {
			
			return array ("FLAG" => 0, "MSG" => $line );
		}
		
		$results = "";
		$inheader = 1;
		while ( ! feof ( $fp ) ) {
			$line = fgets ( $fp, 1024 );
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			} elseif (! $inheader) {
				$results .= $line;
			}
		}
		fclose ( $fp );
		return array ("FLAG" => 1, "MSG" => $results );
	
	}
	
	public function hmac($key, $data) {
		$key = iconv('gb2312', 'utf-8', $key);
		$data = iconv('gb2312', 'utf-8', $data);
		
		$b = 64; // byte length for md5
		if (strlen ( $key ) > $b) {
			$key = pack ( "H*", md5 ( $key ) );
		}
		$key = str_pad ( $key, $b, chr ( 0x00 ) );
		$ipad = str_pad ( '', $b, chr ( 0x36 ) );
		$opad = str_pad ( '', $b, chr ( 0x5c ) );
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;
		
		return md5 ( $k_opad . pack ( "H*", md5 ( $k_ipad . $data ) ) );
	}
	
	public function parseRecv($source) {
		$ret = array ();
		$temp = explode ( "&", $source );
		
		foreach ( $temp as $value ) {
			$tempKey = explode ( "=", $value );
			$ret [$tempKey [0]] = $tempKey [1];
		}
		return $ret;
	}
	
	public function decodeUtf8($source) {
		$temp = urldecode ( $source );
		$ret = iconv ( "UTF-8", "GB2312//IGNORE", $temp );
		return $ret;
	}
	
    /**
     * 关闭交易
     * 手机支付不支持关闭交易接口。原由：据说是纯平台，无用户支持入口，故不需提供关闭交易接口
     * @param array $params
     * @return InternalResultTransfer::fail('TRADE_NOT_EXIST')
     */
    public function closeTrade(array $params) {
        return InternalResultTransfer::fail('TRADE_NOT_EXIST');
    }
}

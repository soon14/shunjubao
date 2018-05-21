<?php
/**
 * 出票接口之华阳创美
 * 目前受理的业务
 * 1、竞彩
 * 2、11选5
 * 3、足彩
 * 4、北单
 */
class HuaYangTicketClient {
	/**
	 * 从配置里读取
	 */
	private $datakey;
	private $gateway;
	private $charset;
	private $method;
	private $version;
	private $agenterid;
	private $username;
	
	/**
	 * 根据业务获取
	 */
	private $messengerId;
	private $transactiontype;
	private $responseParams;//原生的回调结果
	
	private $errorCode;//出错信息代码
	private $errorMessage;//出错信息描述
	private $responseArray;//处理后的回调结果
	private $timestamp;//时间戳，格式 2014-10-11 20：39：10=>20141011203910
	
	/**
	 * 出错代码之：没有返回结果
	 */
	const ERROR_CODE_NOT_RETURN = 1;
	/**
	 * 出错代码之：没有返回对象
	 */
	const ERROR_CODE_NOT_OBJECT = 2;
	/**
	 * 出错代码之：没有解析出返回值
	 */
	CONST ERROR_CODE_NOT_ARRAY = 3;
	/**
	 * 投注接口最大倍数 
	 */
	CONST MAT_MULTIPLE = 99;
	
	/**
	 * 投注提前的时间，单位分
	 */
	CONST TOUZHU_EARLIER_MINIUTES = 10;
	
	public function __construct() {
		$configs = include ROOT_PATH . '/include/ticket_config.php';
		$huayang_config = $configs['huayang'];
		if (!is_array($huayang_config) || empty($huayang_config)) {
			throw new ParamsException('配置文件信息错误');
		}
		
		foreach ($huayang_config as $key => $value) {
			$this->$key = $value;
		}
//		$this->timestamp = $this->getCurrentTime();
	}
	
	/**
	 * 获取返回结果数组 
	 */
	public function getResponseArray() {
		$this->responseArray = $this->xmlToArray($this->responseParams);
		return $this->responseArray;
	}
	
	/**
	 * 获取出错信息
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}
	
	/**
	 * 获取出错信息
	 */
	public function getErrorCode() {
		return $this->errorCode;
	}

	/**
	 * 发送过程中和获取结果时出现的错误，不是第三方返回的错误
	 */
	static public function getErrorCodeDesc() {
		return array(
			self::ERROR_CODE_NOT_RETURN	=> array(
				'desc'	=> '没有返回结果',
				'code'	=> 'ERROR_CODE_NOT_RETURN',
			),
			self::ERROR_CODE_NOT_OBJECT	=> array(
				'desc'	=> '没有返回对象',
				'code'	=> 'ERROR_CODE_NOT_OBJECT',
			),
			self::ERROR_CODE_NOT_ARRAY	=> array(
				'desc'	=> '没有解析出返回值',
				'code'	=> 'ERROR_CODE_NOT_ARRAY',
			),
		);
	}
	
	/**
	 * 发送消息并保存结果
	 * @param XML $xml
	 * @return XML
	 */
	public function sent($xml) {
		$objCurl = new Curl($this->gateway);
		$method = $this->method;
		$this->setResponseParams($objCurl->$method($xml));
		return true;
	}
	
	/**
	 * 保存回调信息 
	 * @param array $params
	 */
	public function setResponseParams($params) {
		$this->responseParams = $params;
	}
	
	public function getResponseParams() {
		return $this->responseParams;
	}
	
	public function setMessengerId() {
		$this->messengerId = $this->getCurrentTime() . str_pad(rand(1, 999999), 6, 0);
	}
	
	public function getMessengerId() {
		$this->setMessengerId();
		return $this->messengerId;
	}
	
	/**
	 * 分析返回结果
	 * @return InternalResultTransfer
	 */
	private function AnalysisRes() {
		$xmlRes = $this->responseParams;
		if (!$xmlRes) {
			$this->errorCode = self::ERROR_CODE_NOT_RETURN;
			$this->errorMessage = '没有返回结果';
			return InternalResultTransfer::fail();
		}
		if (!is_string($xmlRes) && !is_object($xmlRes)) {
			$this->errorCode = self::ERROR_CODE_NOT_RETURN;
			$this->errorMessage = '没有返回对象';
			return InternalResultTransfer::fail();
		}
		$array = $this->xmlToArray($xmlRes);
		if (!is_array($array)) {
			$this->errorCode = self::ERROR_CODE_NOT_RETURN;
			$this->errorMessage = '没有解析出返回值';
			return InternalResultTransfer::fail();
		}
		$this->errorMessage = '';
		$this->errorCode = '';
		$this->responseArray = $array;
		return InternalResultTransfer::success($array);
	}
	
	/**
	 * 是否发送成功
	 * @return boolean
	 */
	public function isSendOk() {
		$analysis = $this->AnalysisRes();
		$analysis_data = $analysis->getData();
		if ($analysis->isSuccess()) {
			//发送成功
			$oelement = $analysis_data['body']['oelement'];
			if ($oelement['errorcode'] == 0) {
				//操作成功
				return true;
			} else {
				$this->errorCode = $oelement['errorcode'];
				$this->errorMessage = $oelement['errormsg'];
			}
		}
		//发送失败
		return false;
	}
	
	/**
	 * 数组转换为xml字符串:arrayToXmlString
	 * <?xml version="1.0" encoding="utf-8"?>
		<message version="1.0">
			<header>
				<messengerid>200911131015330000000001</messengerid>
				<timestamp>20091113101533</timestamp>
				<transactiontype>13007</transactiontype>
				<digest>7ec8582632678032d25866bd4bce114f</digest>
				<agenterid>10000005</agenterid>
				<username>001002001</username>
			</header>
			<body>
				<elements>
					<element>
						<lotteryname>112</lotteryname>
						<issue>2009111301</issue>
					</element>
				</elements>
			</body>
		</message>
	 * @param array $data
	 * @param string $item 键值
	 * @return obj $xml
	 */
	private function arrayToXmlString($data, $item = 'element') {
		$xml_string = '';
		foreach ($data as $key => $val){
			$item = is_string($key)?$key:$item;//解决数字键值问题
			if (is_array($val)){
				$xml_string .= "<{$item}>".$this->arrayToXmlString($val, $item)."</{$item}>";
			} else {
				$xml_string .= "<{$item}>{$val}</{$item}>";
			}
		}
		return $xml_string;
	}
		
    /**
     * 组织消息
     * <?xml version="1.0" encoding="UTF-8"?>
		<message version="1.0">
			<header>
			...
			</header>
			<body>
				<elements>
					<element>
					</element>
					<element>
					</element>
					...
				</elements>
			...
			</body>
		</message>
     * @param array $data
     * @param array $header_needle 需要添加到公共头部的信息，只能是一维数组
     * @return string $message
     */
	public function formMessage($data = array(), $header_needle = array()) {
		
		$body = $this->arrayToXmlString($data);
		if ($body) {
			$body = '<elements>'.$body.'</elements>';
		} else {
			//处理body为空的情况
		}
		$body = '<body>'.$body.'</body>';
		$commmon_header = $this->getCommonHeader($body, $header_needle);
		
		$message = '<?xml version="1.0" encoding="UTF-8"?><message version="1.0"><header>';
		$message .= $this->arrayToXmlString($commmon_header). '</header>'.$body.'</message>';
		return $message;
	}
	
	/**
	 * 获取公共头部
	 * @param string $body 需要加密的消息体
	 * @param array $needle 需要添加的字段集合
	 * @return array $header
	 */
	public function getCommonHeader($body, $needle = array()) {
		$header = array();
		$header['messengerid'] 		= $this->getMessengerId();
		$header['timestamp'] 		= $this->getCurrentTime();
		$header['digest']			= $this->getDigest($body, $header['timestamp']);
		$header['agenterid']		= $this->agenterid;
		$header['username']			= $this->username;
		
		if (is_array($needle) && $needle) {
			return $header + $needle;
		}
		return $header;
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param mixed string | obj $xml
	 * @param string $item 特殊处理的下标，遇到此key时，值为key从0开始的数组
	 */
	private function xmlToArray($xml, $item = 'element') {
		if (is_string($xml)) {
    	$tmpResult = simplexml_load_string($xml);
    	if (!is_object($tmpResult)) {
    		return array();
    	}
        $tmpArray = (array) $tmpResult; 
	    } elseif (is_object($xml)) {
	        $tmpArray = (array) $xml;
	    } else if (is_array($xml)) {
	    	 $tmpArray = $xml;
	    }else {//凡正常调用时，都不可能出现这个异常
	        throw new Exception('xml转换成数组失败');
	    }
	    foreach ($tmpArray as $tmpK => $tmpV) { 
	        if (count($tmpV) == 0) {
	            $tmpArray[$tmpK] = '';
	        } else if (count($tmpV) == 1) {
	            if (is_object($tmpV)) {
	                $tmpArray[$tmpK] = $this->xmlToArray($tmpV); 
	            } else if (is_string($tmpV)) {
	                $tmpArray[$tmpK] = (string) $tmpV; 
	            } else if (is_array($tmpV)) {
	            	
	            	$tmpArray[$tmpK] =  $tmpV;
	            } else {
	            	throw new Exception('xml转换成数组失败');
	            }
	        } else {
	            $tmpArray[$tmpK] = $this->xmlToArray($tmpV); 
	        }
	    }
	    return $tmpArray;
	}
	
	/**
	 * 摘要编码加密方式
	 * 摘要算法为md5，摘要内容为（时间戳+代理密码+消息体）
	 * 消息包中body元素部分，包含<body>与</body>
	 * @param string $body
	 * @param string $timestamp
	 * @return string
	 */
	private function getDigest($body, $timestamp) {
		return md5($timestamp. $this->datakey . $body);
	}
	
	/**
	 * 验证回传信息
	 * @param xml $xml 回传来的xml
	 * @return InternalResultTransfer
	 */
	public function verifyDigest($xml) {
//		return InternalResultTransfer::success();
		$xml_array = $this->xmlToArray($xml);//转换为数组
		
		$header_array = $xml_array['header'];//公共头部
		$digest_string = $header_array['digest'];//加密部分
		
		$body_array = $xml_array['body'];//消息体
		$body_string = $this->arrayToXmlString($body_array);//消息体转换为字符串
		
		$this_timestamp = $header_array['timestamp'];//时间戳
		
		if ($digest_string != $this->getDigest($body_string, $this_timestamp)) {
			return InternalResultTransfer::fail('未通过验证');
		}
		return InternalResultTransfer::success();
	}
	
	/**
	 * 获取当前时间，格式：yyyymmddhh24miss 
	 */
	public function getCurrentTime() {
		return date('YmdHis', time());
	}
	
	private function encrypt($data) {
		$td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
		mcrypt_generic_init($td, $this->datakey, $this->iv);

		$data = $this->paddingPKCS7($data);

		$encrypted_data = mcrypt_generic($td, $data);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return trim(chop(base64_encode($encrypted_data)));
	}
	
	private function decrypt($data) {
		$td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
		mcrypt_generic_init($td, $this->datakey, $this->iv);
		$ret = trim(mdecrypt_generic($td, base64_decode($data)));
		$ret = $this->unpaddingPKCS7($ret);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $ret;
	}
	
	private function paddingPKCS7($data) {
		$block_size = mcrypt_get_block_size('des', 'cbc');
		$padding_char = $block_size - (strlen($data) % $block_size);
		$data .= str_repeat(chr($padding_char), $padding_char);

		return $data;
	}

	private function unpaddingPKCS7($data) {
		$pad = ord($data{strlen($data) - 1});
		if ($pad > strlen($data)) {
			return false;
		}
		if (strspn($data, chr($pad), strlen($data) - $pad) != $pad) {
			return false;
		}
		return substr($data, 0, - 1 * $pad);
	}
	
	/**
	 * 余额查询
	 * @return array(
	 * 				'actmoney'=>投注金账户金额,
	 * 				'bonusmoney'=>奖金账户金额
	 * 			);
	 * or array()
	 */
	public function getSumMoney() {
		$data = array();
		$header = array('transactiontype'=>13002);
		$xml = $this->formMessage($data, $header);
		$this->sent($xml);
		if ($this->isSendOk()) {
			$return_array = $this->responseArray;
			return $return_array['body']['oelement'];
		}
		return  array();
	}
	
	/**
	 * 
	 */
}
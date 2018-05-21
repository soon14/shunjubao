<?php
/**
 * 第三方出票客户端
 * 老足彩业务：14场和任9
 */
class FeiYuSheClient {
	
	public $responseParams;//原生的回调结果
	public $errorCode;//出错信息代码
	public $errorMsg;//出错代码描述
	public $responseArray;//处理后的回调结果
	
	/**
	 * @desc 错误代码
	 * 没有返回结果，原因可能是请求超时，或网络问题
	 */
	CONST ERROR_CODE_NORESULT = 9;
	
	public function __construct() {
		$configs = include ROOT_PATH . '/include/ticket_config.php';
		$config = $configs['feiyushe'];
		if (!is_array($config) || empty($config)) {
			throw new ParamsException('配置文件信息错误');
		}
	
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
		$this->timestamp = date('YmdHis');
	}
	
	/**
	 * 获取xml体
	 * @param array $head
	 * @param array $body = array('')
	 * @return string $xml
	 */
	public function formXml($head, $body) {
		$xml = '<?xml version="'.$this->version.'" encoding="'.$this->charset.'"?>';
		$xml .= '<msg>';
		
		//head
		//自动填充部分信息partnerid="6" version="1.0" time="20110628175541"
		$head['partnerid'] = $this->partnerid;
		$head['version'] = $this->version;
		$head['time'] = $this->getTimeStamp();
		
		$xml .= $this->arrayToXmlStringSingle($head);
		
		//按不同的transcode分别重组body
		$transcode = $head['transcode'];
		
		
		$body_string = '<body>';
	
		switch ($transcode) {
			case self::TRANSCODE_QUERY_ISSUE:
				$body_string .= $this->queryIssue($body['lotteryId'], $body['issueNumber']);
				break;
			case self::TRANSCODE_QUERY_GAMES_BEIDAN:
				$body_string .= $this->queryGamesBeiDan($body['lotteryId'], $body['issueNumber']);
				break;
			case self::TRANSCODE_QUERY_SP_BEIDAN:
				$body_string .= $this->querySpValueBeiDan($body['lotteryId'], $body['issueNumber']);
				break;
			case self::TRANSCODE_QUERY_GAMES_RESULT:
				$body_string .= $this->queryGameResult($body['lotteryId'], $body['issueNumber']);
				break;
			case self::TRANSCODE_QUERY_TICKET:
				$body_string .= $this->querylotteryTickets($body);
				break;
			case self::TRANSCODE_QUERY_PARTNER_ACCOUNT:
				$body_string .= $this->queryPartnerAccount();
				break;
			case self::TRANSCODE_QUERY_TRADE:
				$body_string .= $this->queryTicket($body);
				break;
			case self::TRANSCODE_QUERY_PRIZE:
				$body_string .= $this->queryPrize($body);
				break;
			case self::TRANSCODE_AUTO_GET_TRADE_RESPONE:
				$body_string .= $this->responeAutoTrade($body);
				break;
			case self::TRANSCODE_AUTO_GET_PRIZE_RESPONE:
				$body_string .= $this->responeAutoPrize($body);
				break;
			default:
				$body_string .= '';
				break;
		}
		
		$body_string .= '</body>';
		
		$xml .= $body_string;
		$xml .= '</msg>';
		return  $xml;
	}
	
	/**
	 * 发送并保存原始回调结果，返回值为true时只代表发送成功并成功收到返回结果
	 * @param int $cmd
	 * @param array $body
	 * @return boolean
	 */
	public function sent($cmd, $body) {
		$objCurl = new Curl($this->gateway);
//		$objCurl->setOptions(array('httpHeaders'=>array($this->header)));
		$method = $this->method;
		
		$body = $this->getBody($cmd, $body);//xml string
		$head = $this->getHead($cmd, $body);
		
		$xml = 'cmd=' . $cmd . '&msg=' . $this->getMsg($head, $body);
		
		$res = $objCurl->$method($xml);
		if (!$res) {
			$this->errorCode = self::ERROR_CODE_NORESULT;
			$this->errorMsg = '没有返回结果';
			return false;
		} else {
			$this->setResponseParams($res);
			return true;
		}
	}
	
	/**
	 * 获取header
	 */
	public function getHead($cmd, $body) {
		return '<head>
				<agentid>'.$this->agentid.'</agentid>
    			<cmd>'.$this->cmd.'</cmd>
		   		<timestamp>'.$this->timestamp.'</timestamp>
		    	<cipher>'.$this->getCipher($body).'</cipher>
		 		</head>';
	}
	
	/**
	 * 获取body体
	 * @param array $body = array()
	 * @return string
	 */
	public function getBody($cmd, array $body) {
		$body_string = '<body>';
		$method = 'getCmdBody_'.$cmd;
		
		if (!method_exists($this, $method)) {
			fail_exit('method not exists');
		}
		
		$body_string .= $this->$method($body);
		$body_string .= '</body>';
		return $body_string;
	}
	
	/**
	 * @param string $head
	 * @param string $body
	 * @return string $xml
	 */
	public function getMsg($head, $body) {
		$xml = '<?xml version="'.$this->version.'" encoding="'.$this->charset.'"?>';
		$xml .= '<msg v="'.$this->version.'" id="'.$this->getTicketId().'">';
		$xml .= $head;
		$xml .= $body;
		$xml .= '</msg>';
		return $xml;
	}
	
	/**
	 * 获取出错代码描述
	 */
	public function getErrorMsg() {
		return $this->errorMsg;
	}
	
	public function getTicketId() {
		return $this->getTimeStamp() . str_pad(rand(1, 999999), 6, 0);
	}
	
	/**
	 * 获取当前时间
	 * 格式：20140708125050
	 */
	public function getTimeStamp() {
		return $this->timestamp;
	}
	
	/**
	 * 商户编号+商户密钥+时间戳+请求/响应消息体即<body>和</body>之间的内容
	 * @return string $cipher
	 */
	private function getCipher($body) {
		$body = str_replace('<body>', '', $body);
		$body = str_replace('</body>', '', $body);
		return md5($this->agentid . $this->key. $this->timestamp . $body);
	}
	
	/**
	 * 获取cmd1001：数据文件查询
	 */
	private function getCmdBody_1001($body) {
		return '<file lotteryid="'.$body['lotteryid'].'" issue="'.$body['issue'].'"/>';
	}
	
}
<?php
/**
 * 出票接口之尊傲
 * 目前受理的业务
 * 1、北单
 */
class ZunAoTicketClient {
	/**
	 * 从配置里读取
	 */
	public $key;
	public $gateway;
	public $charset;
	public $method;
	public $version;
	public $header;
	public $partnerid;
	
	/**
	 * 实时获取
	 */
	public $transcode;//请求接口代码
	public $responseParams;//原生的回调结果
	public $errorCode;//出错信息代码
	public $errorMsg;//出错代码描述
	public $responseArray;//处理后的回调结果
	
	/**
	 * @desc 错误代码
	 * 没有返回结果，原因可能是请求超时，或网络问题
	 */
	CONST ERROR_CODE_NORESULT = 9;
	
	/**
	 * 期查询请求消息体 (001)
	 */
	CONST TRANSCODE_QUERY_ISSUE = '001';
	
	/**
	 * 投注请求消息体 (002)
	 * 为(非合买业务)投注接口,一次请求最多可以同时投 50 张彩票
	 */
	CONST TRANSCODE_QUERY_TICKET = '002';
	
	/**
	 * 交易结果请求消息体(003)
	 * 	003 接口为彩票交易结果的查询接口,合作商通过发送交易订单在合作商的订单号,可以获得该彩
		票订单的当前状态。查询接口为限制接口,为了避免某些合作商的程序
		问题造成大量并发查询为系统带来负担,合作商的查询接口使用查询锁机制,平台会根据合作商的
		交易量动态分配查询锁,当合作商的并发查询数量大于锁数量时,系统会返回未知状态异常。
		注意(1)
		:一次可以查询 50 张票
		注意(2)
		:只能查询 7 天之内的数据
	 */
	CONST TRANSCODE_QUERY_TRADE = '003';
	
	/**
	 * 奖金查询请求消息体(004),貌似是按彩种查询的
	 */
 	CONST TRANSCODE_QUERY_LOTTERY_PRIZE = '004';

	/**
	 * 合作商账户余额请求消息体(005)
	 */
	CONST TRANSCODE_QUERY_PARTNER_ACCOUNT = '005';
	
	/**
	 * 北单比赛列表查询接口(006)
	 * 	接口可查询某个彩种某期的北单比赛信息列表,以及定时刷新北单比赛列表避免其中北单比赛修改信
		息参数的的问题
	 */
	CONST TRANSCODE_QUERY_GAMES_BEIDAN = '006';
	
	/**
	 * 自动发送交易结果请求消息体(007)
		007接口为彩票自动交易出票结果的发送接口，合作商通过接收交易订单，返回合作商的方案LotteryId,我方发送的palmId
		注意（1）：一次自动发送50张票 高频彩发送15分钟之内的票（频率15秒） 其他彩种目前定为2天之内（频率30秒）（暂且规定，如有变动 会及时通知商户）
	 */
	CONST TRANSCODE_AUTO_GET_TRADE = '007';
	
	/**
	 * 交易自动发送出票结果响应消息体(107)
		107消息代表着是自动出票信息的商户接收以后返回的信息，
		同时当一个出票信息被商品接收成功后 根据返回的信息 更改自动发送出票的状态。
	 */
	CONST TRANSCODE_AUTO_GET_TRADE_RESPONE = '107';
	
	/**
	 * 自动推送中奖结果接口（202）
		注意：（2分钟推送一次）高频彩中奖时间在 15分钟之内的玩法 其他彩种时间在2天的
		记得要反馈 下面的212回来确认
	 */
	CONST TRANSCODE_AUTO_GET_PRIZE = '202';
	
	/**
	 * 自动发送中奖结果响应（212）
		212消息代表着是自动出票信息的商户接收以后返回的信息，
		同时当一个出票信息被商品接收成功后 根据返回的信息 更改自动发送出票的状态。
	 */
	CONST TRANSCODE_AUTO_GET_PRIZE_RESPONE = '212';
	
	/**
	 * 北单期次 SP 值查询接口(008)
	 */
	CONST TRANSCODE_QUERY_SP_BEIDAN = '008';
	
	/**
	 * 获取比赛赛果接口(009)
	 * 在竞彩不传时间时查询 当前时间的已经开奖的 前 4 天数据
	 */
	CONST TRANSCODE_QUERY_GAMES_RESULT = '009';
	
	/**
	 * 查询中奖金额接口(011)
	 * 通过商业用户自己的订单号来查询中奖情况 一次最多 20 个查询
	 */
	CONST TRANSCODE_QUERY_PRIZE = '011';
	
	/**
	 * 玩法代码之胜平负
	 */
	CONST LOTTERY_CODE_SPF = 'SPF';
	/**
	 * 玩法代码之胜负
	 */
	CONST LOTTERY_CODE_SF = 'SF';
	/**
	 * 玩法代码之上下单双
	 */
	CONST LOTTERY_CODE_SXDS = 'SXDS';
	/**
	 * 玩法代码之进球数
	 */
	CONST LOTTERY_CODE_JQS = 'JQS';
	/**
	 * 玩法代码之比分
	 */
	CONST LOTTERY_CODE_BF = 'BF';
	/**
	 * 玩法代码之半全场
	 */
	CONST LOTTERY_CODE_BQC = 'BQC';
	/**
	 * 玩法代码之奥运胜负
	 */
	CONST LOTTERY_CODE_AYSF = 'AYSF';
	
	/**
	 * 投注接口最大倍数
	 */
	CONST MAT_MULTIPLE = 99;
	
	/**
	 * 投注截止提前的时间，单位：分
	 */
	CONST TOUZHU_EARLIER_MINIUTES = 18;
	
	public function __construct() {
		$configs = include ROOT_PATH . '/include/ticket_config.php';
		$config = $configs['zunao'];
		if (!is_array($config) || empty($config)) {
			throw new ParamsException('配置文件信息错误');
		}
	
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
	}
	
	/**
	 * 获取返回结果数组，在没有出错的情况下
	 * TODO这里可以添加验证信息
	 * @return array | 0
	 */
	public function getResponseArray() {
		return $this->responseArray;
	}
	
	static public function errorCodeDesc() {
		return array(
				self::ERROR_CODE_NORESULT => array('desc'	=> '没有返回结果',),
				'901'	=> array('desc'	=> '无此用户'),
				'902'	=> array('desc'	=> '数据格式错误'),
				'903'	=> array('desc'	=> '当前没有投注期'),
				'904'	=> array('desc'	=> '数据校验失败'),
				'905'	=> array('desc'	=> '数据金额错误'),
				'906'	=> array('desc'	=> '超过倍数上限或下限'),
				'907'	=> array('desc'	=> '超过最大金额上限'),
				'908'	=> array('desc'	=> '账户余额不足'),
				'909'	=> array('desc'	=> '投注订单 ID 重复'),
				'910'	=> array('desc'	=> '下单过期'),
				'911'	=> array('desc'	=> '发单票数超过上限'),
				'912'	=> array('desc'	=> '方案编号过长'),
				'913'	=> array('desc'	=> '下单失败因含有取消的场次'),
				'914'	=> array('desc'	=> '未开售'),
				'915'	=> array('desc'	=> '无此种玩法'),
				'916'	=> array('desc'	=> 'Xml 格式错误'),
				'917'	=> array('desc'	=> '无此期号'),
				'918'	=> array('desc'	=> '发送 Post 参数错误'),
				'919'	=> array('desc'	=> '密钥匹配错误'),
				'920'	=> array('desc'	=> '无此交易号或者还未开通'),
				'921'	=> array('desc'	=> '玩法中包含不支持比赛场次'),
				'922'	=> array('desc'	=> '玩法不支持单式方案'),
				'923'	=> array('desc'	=> '含有未开售或者已截止场次'),
				'924'	=> array('desc'	=> '暂停销售'),
				'999'	=> array('desc'	=> '系统错误'),
		);
	}
	/**
	 * 全部的北单玩法，目前有6种玩法，暂时不包括奥运单双
	 */
	static public function getAllLottery() {
		return array(
				self::LOTTERY_CODE_SPF,
				self::LOTTERY_CODE_SF,
				self::LOTTERY_CODE_BQC,
				self::LOTTERY_CODE_JQS,
				self::LOTTERY_CODE_BF,
				self::LOTTERY_CODE_SXDS
		);
	}
	/**
	 * 获取出错代码
	 */
	public function getErrorCode() {
		return $this->errorCode;
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
	 * 发送并保存原始回调结果，返回值为true时只代表发送成功并成功收到返回结果
	 * @param unknown $transcode
	 * @param unknown $xmlMsg
	 * @return boolean
	 */
	public function sent($transcode, $xmlMsg) {
		$objCurl = new Curl($this->gateway);
		$objCurl->setOptions(array('httpHeaders'=>array($this->header)));
		$method = $this->method;
		$xml_array = array();
		
		$xml_array['transcode'] = $transcode;
		$xml_array['msg'] = $xmlMsg;
		$xml_array['key'] = $this->getKey($transcode, $xmlMsg);
		$xml_array['partnerid'] = $this->partnerid;
		
		$xml = '';
		
		foreach ($xml_array as $key=>$value) {
			$xml .= $key .'=' .$value .'&';
		}
		$xml = substr($xml, 0, -1);
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
	 * 保存原生回调信息，前提：有返回值
	 * @param array 
	 */
	public function setResponseParams($params) {
		$this->responseParams = $params;
	}
	
	/**
	 * 保存回调信息数组，前提：成功解析返回值
	 * @param array
	 */
	public function setResponseArray($params) {
		$this->responseArray = $params;
	}
		
	/**
	 * 分析返回值是否正确，原则：没有error标签则为正确，否则为错误
	 * 前提：已经保存返回值
	 * @return boolean
	 */
	public function analysisRes() {
		$res = $this->responseParams;
		if (!$res) {
			return false;
		}
		//$res = 'transcode=101&msg=...”&key=qa7eu8&partnerid=100031';
		$res1 = explode('&', $res);
		
		$transcode = substr($res1[0], strlen('transcode') + 1);
		$msg = substr($res1[1], strlen('msg') + 1);
		$key = substr($res1[2], strlen('key') + 1);
		$partnerid = substr($res1[3], strlen('partnerid') + 1);
		
		$res_array = array();
		$res_array['transcode'] = $transcode;
		$res_array['msg'] = $this->xmlToArray($msg);
		$res_array['key'] = $transcode;
		$res_array['partnerid'] = $transcode;
		
		if (isset($res_array['msg']['index']['ERROR'])) {
			$index = $res_array['msg']['index']['ERROR'][0];
			$this->errorCode = $res_array['msg']['vals'][$index]['attributes']['TRANSCODE'];
			$this->errorMsg =  $res_array['msg']['vals'][$index]['attributes']['MESSAGE'];
			return false;
		}
		$this->setResponseArray($res_array);
		return true;
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
	 * @desc 获取北单赛事，默认查询当前期
	 * <querygames lotteryId="SPF" issueNumber="110707" />
	 * @param $issueNumber 期数
	 * @return string
	 */
	public function queryGamesBeiDan($lottertId, $issueNumber = '') {
		return '<querygames lotteryId="'.$lottertId.'" issueNumber="'.$issueNumber.'" />';
	}
	
	/**
	 * @desc 获取北单赛事sp
	 * <querygamesp lotteryId ="SPF" issueNumber ="2208" />
	 * @param $issueNumber 期数
	 * @return string
	 */
	public function querySpValueBeiDan($lottertId, $issueNumber) {
		return '<querygamesp lotteryId="'.$lottertId.'" issueNumber="'.$issueNumber.'" />';
	}
	
	/**
	 * @desc 获取比赛赛果
	 * <querygameresult lotteryId ="bd" issueNumber ="2208" />
	 * @param $lotteryId 
		彩种 bd 是指北单
		SF 是单场胜负
		AYSF 奥运胜负
		jczq 是指竞彩足球
		jclq 是指竞彩篮球
	 * @param $issueNumber 期号:竞彩不传期号 传时间(查询到前四天数据)(竞彩使用格式为 yyyy-MM-dd)
	 * @return string
	 */
	public function queryGameResult($lotteryId, $issueNumber = '') {
		return '<querygameresult lotteryId="'.$lotteryId.'" issueNumber="'.$issueNumber.'" />';
	}
	
	/**
	 * @desc 比赛投注query
	 * @param array $body 投注信息
	 * <ticketorder lotteryId ="SPF" ticketsnum="1" totalmoney="8">
			<tickets>
				<ticket ticketId="1023620" betType="P1_1" issueNumber="2011062" betUnits="1" multiple="1" betMoney ="8" isAppend ="0">
				<betContent>1:[胜,平]/2:[胜,平]</betContent>
				</ticket>
			</tickets>
		</ticketorder>
	 * @return string 
	 */
	public function querylotteryTickets($body) {
		
		$ticketorder = $body['ticketorder'];
		$tickets = $body['tickets'];
		
		$string = '<ticketorder ';
		$string .= 'lotteryId="'.$ticketorder['lotteryId'].'" ';//彩种 
		$string .= 'ticketsnum="'.$ticketorder['ticketsnum'].'" ';//彩票订单的数量 
		$string .= 'totalmoney="'.$ticketorder['totalmoney'].'" ';//该次请求的彩票订单总额 
		$string .= '>';
		$string .= '<tickets>';
		foreach ($tickets as $key=>$ticket) {
			$string .= '<ticket ';
			$string .= 'ticketId="'.$ticket['ticketId'].'" ';//合作商的彩票交易流水号
			$string .= 'betType="'.$ticket['betType'].'" ';//投注方式(玩法代码)
			$string .= 'issueNumber="'.$ticket['issueNumber'].'" ';//期号,该张彩票的期号
			$string .= 'betUnits="'.$ticket['betUnits'].'" ';//注数
			$string .= 'multiple="'.$ticket['multiple'].'" ';//倍数
			$string .= 'betMoney="'.$ticket['betMoney'].'" ';//该张彩票的金额
			$string .= 'isAppend="0"';//是否追加
			$string .= '>';
			$string .= '<betContent>'.$ticket['betContent'].'</betContent>';//投注内容
			$string .= '</ticket>';
		}
		
		$string .= '</tickets>';
		$string .= '</ticketorder>';
		return $string;
	}
	
	/**
	 * @desc 获取比赛sp值query
	 * @param  $lotteryId
	 * @param $issueNumber
	 * @return string
	 */
	public function queryGameSp($lotteryId, $issueNumber) {
		return '<querygamesp lotteryId ="'.$lotteryId.'" issueNumber ="'.$issueNumber.'" />';
	}
	
	/**
	 * @desc 期查询请求消息体 (001)query
	 * 该接口是彩票期次信息的获取接口,该接口包含了彩种期次、交易的开始时间和结束时间,以及平台系统
接收订单的最后时间和期次状态,当前期次状态。
<queryissue lotteryId="3D" issueNumber="2011125" />
	 */
	public function queryIssue($lotteryId, $issueNumber = '') {
		return '<queryissue lotteryId ="'.$lotteryId.'" issueNumber ="'.$issueNumber.'" />';
	}
	
	/**
	 * @desc 获取查询中奖金额接口(011)query
	 *  <queryprize TicketId="3412" />
		<queryprize TicketId="3412"/ >...... 最多 20 个(由外围应用控制)
	 * @param $body
	 * @return string 
	 */
	public function queryPrize($body) {
		$string = '';
		$queryPrize = $body['queryPrize'];
		foreach ($queryPrize as $ticketId) {
			$string .= '<queryprize TicketId="'.$ticketId.'" />';
		}
		return $string;
	}
	
	/**
	 * @desc 获取账户余额query
	 * @return string
	 */
	public function queryPartnerAccount() {
		return '<partneraccount partnerid="'.$this->partnerid.'" />';
	}
	
	/**
	 * @desc 获取交易结果(003)query
	 * <queryticket ticketId="123132" />
	 * @return string
	 */
	public function queryTicket($body) {
		$string = '';
		$queryTicket = $body['queryTicket'];
		foreach ($queryTicket as $ticketId) {
			$string .= '<queryticket ticketId="'.$ticketId.'" />';
		}
		return $string;
	}
	
	/**
	 * 自动交易返回接口
	 * <returnticketresults> 
	 * <returnticketresult lotteryId ="该商户订单Id及(ticketId)" palmId ="2208"/>
	 * </returnwontickets>
	 * @param unknown $array
	 * @param string $head
	 * @return boolean|string
	 */
	public function responeAutoTrade($body) {
		$string = '<returnticketresults>';
		$returnticketresults = $body['returnticketresults'];
		foreach ($returnticketresults as $value) {
			$string .= '<returnticketresult lotteryId='.$value['lotteryId'] . ' palmId='.$value['palmId'].'/>';
		}
		$string = '</returnticketresults>';
		return $string;
	}
	
	/**
	 * 自动返奖返回接口
	 * <returnwontickets >
	 * <returnwonticket lotteryId ="该商户订单Id及(ticketId)" palmId ="2208"/>
	 * </returnwontickets>
	 * @param unknown $array
	 * @param string $head
	 * @return boolean|string
	 */
	public function responeAutoPrize($body) {
		$string = '<returnwontickets>';
		$returnwontickets = $body['returnwontickets'];
		foreach ($returnwontickets as $value) {
			$string .= '<returnwonticket lotteryId='.$value['lotteryId'] . ' palmId='.$value['palmId'].'/>';
		}
		$string = '</returnwontickets>';
		return $string;
	}
	
	public function arrayToXmlStringSingle($array = array(), $head = 'head'){
		if (!$array || !is_array($array)) {
			return false;
		}
		
		$xml_string = "<{$head} ";
		foreach ($array as $key	=> $value) {
			$xml_string .= " {$key}=\"{$value}\" ";
		}
		$xml_string .= "/>";
		return $xml_string;
	}
	
	/**
	 * 解析xml到数组
	 * @param string $xml_string
	 * @return array('vals'=>...,'index'=>...) | 0
	 */
	 static public function xmlToArray($xml_string) {
		$xml=xml_parser_create();
		$result = xml_parse_into_struct($xml, $xml_string, $vals, $index);
		xml_parser_free($xml);
		if ($result) {
			$return = array(
				'vals'	=> $vals,
				'index'	=> $index,
			);
			return $return;
		} else {
			return $result;
		}
	}
	
	/**
	 * 获取公共头部
	 * @param string $transcode 001
	 * @return array
	 */
	public function getCommonHead($transcode) {
		$return = array();
		$return['transcode'] 	= $transcode;
		$return['partnerid'] 	= $this->partnerid;
		$return['version'] 		= $this->version;
		$return['time'] 		= $this->getTimeStamp();
		return $return;
	}
	
	/**
	 * 获取某玩法的当前期数
	 * @param int $num 返回几个期数，从当前期算起，再往前算$num-1个期数
	 * @return string | false  
	 */
	public function getBDIssueNumber($lotteryId) {
		
		$transcode = ZunAoTicketClient::TRANSCODE_QUERY_ISSUE;
		
		$head = array('transcode'	=> $transcode);
		$body = array('issueNumber' => '','lotteryId'=>$lotteryId);
		
		$xml = $this->formXml($head, $body);
		$isSendOk = $this->sent($transcode, $xml);
		
		if (!$isSendOk) {
// 			echo 'send is not ok';
			return false;
		}
		
		//发送成功，检验是否有错误
		$tmpResult = $this->analysisRes();
		if (!$tmpResult) {
			//有错误出现
// 			echo 'error!!!:'.$this->getErrorCode();
			return false;
		}
		
		$resArray = $this->getResponseArray();
		$issueIndex = $resArray['msg']['index']['ISSUEINFO'];
		if (!$issueIndex) {
			return false;
		}
		return $resArray['vals'][$issueIndex]['attributes']['ISSUENUMBER'];
	}
	
	/**
	 * 获取betType，即投注方式玩法代码
	 * @param string $select 用户选项
	 */
	public function getBetType($select) {
		$betType = array(
				 '1x1' => 'P1_1',
				 '2x1' => 'P2_1','2x3' => 'P2_3',
				 '3x1' => 'P3_1','3x4' => 'P3_4','3x7' => 'P3_7',
				 '4x1' => 'P4_1','4x5' => 'P4_5','4x11' => 'P4_11','4x15' => 'P4_15',
				 '5x1' => 'P5_1','5x6' => 'P5_6','5x16' => 'P5_16','5x26' => 'P5_26','5x31' => 'P5_31',
				 '6x1' => 'P6_1','6x7' => 'P6_7','6x22' => 'P6_22','6x42' => 'P6_42','6x57' => 'P6_57','6x63' => 'P6_63',
				 '7x1' => 'P7_1',
				 '8x1' => 'P8_1',
				 '9x1' => 'P9_1',
				 '10x1' => 'P10_1',
				 '11x1' => 'P11_1',
				 '12x1' => 'P12_1',
				 '13x1' => 'P13_1',
				 '14x1' => 'P14_1',
				 '15x1' => 'P15_1',
		);
		$s = explode('x', $select);
		return 'P'.$s[0].'_'.$s[1];
	}
	
	/**
	 * 获取betContent，即投注内容
	 * @param string $combination SPF|169|a#4.74&h#1.32,SPF|170|h#4.56
	 * @return 1:[胜,平]/2:[胜,平]/3:[胜,平]
	 */
	public function getBetContent($combination) {
		$m_ids = $return = array();
		$m = explode(',', $combination);
		$objBettingBD = new BettingBD();
		foreach ($m as $m1) {
			$v = explode('|', $m1);
			$v2 = $v[2];//a#4.74&h#1.32
			$c = explode('&', $v2);
			$betContent = array();//玩法集合
			//Array ( [0] => a#4.74 [1] => h#1.32 )
			foreach ($c as $c1) {
				$b = explode('#', $c1);
				$betContent[] = $this->getBetC($b[0]);
			}
			//获取赛事信息
			$matchInfo = $objBettingBD->get($v[1]);
			$matchId = $matchInfo['matchid'];//比赛id
			$return[] = $matchId.':['.implode(',', $betContent).']';
		}
		return implode('/', $return);
	}
	
	/**
	 * 获取betContent投注内容中[]中的内容
	 * @param string 本平台代码
	 */
	public function getBetC($value) {
		$c = array(
			//胜平负和胜负
			'h' => '胜','d' => '平', 'a' => '负',
			//进球数
			's0' => '0','s1' => '1','s2' => '2','s3' => '3','s4' => '4','s5' => '5','s6' => '6','s7' => '7+',
			//上下单双
			'sd' => '上+单','ss' => '上+双','xd' => '下+单','xs' => '下+双',
			//半全场
			'hh' => '胜-胜','hd' => '胜-平','ha' => '胜-负',
			'dh' => '平-胜','dd' => '平-平','da' => '平-负',
			'ah' => '负-胜','ad' => '负-平','aa' => '负-负',
			//比分
			'0100' => '1:0','0200' => '2:0','0201' => '2:1','0300' => '3:0','0301' => '3:1','0302' => '3:2','0400' => '4:0','0401' => '4:1','0402' => '4:2','-1-h' => '胜其他',
			'0000' => '0:0','0101' => '1:1','0202' => '2:2','0303' => '3:3','-1-d' => '平其他',
			'0001' => '0:1','0002' => '0:2','0102' => '1:2','0003' => '0:3','0103' => '1:3','0203' => '2:3','0004' => '0:4','0104' => '1:4','0204' => '2:4','-1-a' => '负其他',
		);
		return $c[$value];
	}
	
	/**
	 * 获取当前时间
	 * 格式：20140708125050
	 */
	public function getTimeStamp() {
		return date('YmdHis');
	}
	
	/**
	 * 获取交易数字签名
	 * @param string $transcode
	 * @param xml $xmlMsg
	 * @return string $key
	 */
	public function getKey($transcode, $xmlMsg) {
		return md5($transcode . $xmlMsg . $this->key);
	}
}
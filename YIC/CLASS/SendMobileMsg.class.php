<?php
/**
 *
 * 发送手机短消息类
 * @author gaoxiaogang@gmail.com
 * @example
 * $objSendMsg = new SendMobileMsg(array(
 *	'sn'	=> 'SDK-BBX-010-xxxxx',
 *	'pwd'	=> 'xxxxxx',
 * ));
 * // 发送短信：$objSendMsg->send(array('18600130227'), '测试的短信内容');
 * // 获取余额：$objSendMsg->getBalance();
 *
 */
class SendMobileMsg {
	/**
	 *
	 * 序列号
	 * @var string
	 */
	protected $sn;

	/**
	 *
	 * 密码
	 * @var string
	 */
	protected $pwd;

	/**
	 *
	 * 子渠道号
	 * @var string
	 */
	protected $subcode;

	protected $domain = 'http://sdk2.entinfo.cn';

	public function __construct(array $options) {
		# TODO 校验必要的参数
		$this->sn = $options['sn'];
		$this->pwd = $options['pwd'];

		if (isset($options['subcode'])) {
			$this->subcode = $options['subcode'];
		}
	}

	/**
	 *
	 * 发送短消息
	 * @param array $mobiles 手机号
	 * @param string $content 文本内容
	 * @return InternalResultTransfer
	 */
	public function send(array $mobiles, $content) {
		# 排重处理，同样的内容，没必要收到多次。
		$mobiles = array_unique($mobiles);

		if (!is_scalar($content)) {
			InternalResultTransfer::fail("只能发送标题类型的数据");
		}
		if (empty($content)) {
			InternalResultTransfer::fail("不能发送空内容");
		}
		$content = (string) $content;

		# 处理未指定子通道时的逻辑
		if (!isset($this->subcode)) {
			if (count($mobiles) >= 10) {// 没有指定子通道，并且收信人多于10人时，走子通道 1。该通道用于群发短信。
				if (strpos($content, '【高街网】') !== false) {// 【高街网】签名使用子通道1，其他使用子通道2
					$this->subcode = 1;
				} else {
					$this->subcode = 2;
				}
			} else {
				$this->subcode = 0;// 走原始通道，即单条下发通道。
			}
		}

//		# 如果短信内容在 68 - 70个字，则不允许使用 子通道1
//		if ($this->subcode == 1) {
//			$mblen_content = mb_strlen($content, 'utf-8');
//			if ($mblen_content >= 68 && $mblen_content <= 70) {
//				$this->subcode = 0;
//			}
//		}

		$msgs = self::splitContent($content);
		$detail = array();//存放发送详情
		$has_fail = false;//是否有发送失败的短信

		$tmp_count = count($msgs);
		for ($j = 0; $j < $tmp_count; $j++) {
			$tmpSendResult = $this->_send($mobiles, $msgs[$j]);
			if ($tmpSendResult->isSuccess()) {//发送成功
				$tmp_status = true;
				$tmp_msg = null;
			} else {//发送失败
				$tmp_status = false;
				$tmp_msg = $tmpSendResult->getData();
				$has_fail = true;
			}
			$detail[$j] = array(
			    'content' => $msgs[$j],
			    'status'  => $tmp_status,
			    'msg'     => $tmp_msg,
			);
		}
		if ($has_fail) {
			return InternalResultTransfer::fail($detail);
		} else {
			return InternalResultTransfer::success($detail);
		}
	}

	/**
	 *
	 * 拆分待发送内容
	 * * 经测试，网关规则如下：
	 * 1、纯汉字时，一条短信最多允许292个。
	 * 2、纯英文时，一条短信只允许140个。
	 * 3、中英文混杂时，两个英文算一个中文，加起来总长不能超过292.5个。
	 * @param string $content 内容
	 * @return array
	 * @author gaoxiaogang@gmail.com
	 */
	static protected function splitContent($content) {
		$length = strlen($content);
		$msgs = array();//存放拆分后的内容
		$max_len_all_english = 140;//一条纯英文短信的最大长度
		$max_len_chinese_english = 585;//一条中、英混杂短信的最大长度

		$total = 0;
		$splitTimes = 0;//拆分次数
		$msgs[$splitTimes] = '';//初始化
		//$content是否由纯英文组成
		$isAllEnglish = true;

		for ($i = 0; $i < $length; ) {
			if (0x00 <= ord($content{$i}) && 0x7f >= ord($content{$i})) {//是个ascii码字符
				if ($isAllEnglish) {
					if ($total >= $max_len_all_english) {
						$splitTimes++;//拆分次数
	                    $msgs[$splitTimes] = '';//初始化
	                    $isAllEnglish = true;
	                    $total = 0;
					}
				} else {
				    if ($total >= ($max_len_chinese_english - 1)) {
	                    $splitTimes++;//拆分次数
	                    $msgs[$splitTimes] = '';//初始化
	                    $isAllEnglish = true;
	                    $total = 0;
	                }
				}
				$msgs[$splitTimes] .= $content{$i};
				$i++;
				$total++;
			} else {//默认认为是中文字符。
			    if ($isAllEnglish) {
	                if ($total >= $max_len_all_english) {
	                    $splitTimes++;//拆分次数
	                    $msgs[$splitTimes] = '';//初始化
	                    $total = 0;
	                }
	            } else {
	                if ($total >= ($max_len_chinese_english - 2)) {
	                    $splitTimes++;//拆分次数
	                    $msgs[$splitTimes] = '';//初始化
	                    $total = 0;
	                }
	            }

	            # 中文字符在unicode中使用三个字节，所以跳过三个字节。
				$msgs[$splitTimes] .= $content{$i};
				$msgs[$splitTimes] .= $content{($i+1)};
				$msgs[$splitTimes] .= $content{($i+2)};
				$i += 3;

				# 按网关规则，一个中文抵两个英文
				$total += 2;

				$isAllEnglish = false;
			}
		}

		return $msgs;
	}

	/**
	 *
	 * 发送短消息
	 * @param array $mobiles 手机号
	 * @param string $content 文本内容
	 * @return InternalResultTransfer
	 */
	protected function _send(array $mobiles, $content) {
		switch ($this->subcode) {
			case 0:// 原始通道，用于单条下发。
				return $this->_singleSendWithDown($mobiles, $content);
				break;
			case 1:// 通道 1，用于群发。
				return $this->_batchSendWithDown($mobiles, $content);
				break;
			default:
				# 其它情况，走群发通道。目的在于保障原始通道的高效性。
				return $this->_batchSendWithDown($mobiles, $content);
		}
	}

	/**
	 *
	 * 该接口，目前用于单条下发。只用于下行，不考虑上行。比如 下发校验码、发货通知等。
	 * @param array $mobiles 手机号
	 * @param string $content 文本内容
	 * @return InternalResultTransfer
	 */
	private function _singleSendWithDown(array $mobiles, $content) {
		$url = $this->domain . '/webservice.asmx/SendSMS';
		$objCurl = new Curl($url);
		$params = array(
			'sn'	=> $this->sn,
			'pwd'	=> $this->pwd,
			'mobile'	=> join(',', $mobiles),
			'content'	=> ConvertData::u82gb($content),
		);
		$tmpResult = $objCurl->post($params);
		if (empty($tmpResult)) {
			return InternalResultTransfer::fail("curl返回值为空");
		}
		$content = $tmpResult;
		$objXml = simplexml_load_string($content);
		if (!is_object($objXml)) {
			return InternalResultTransfer::fail("返回值不是xml");
		}
		$tmpArr = (array) $objXml;
		$result = trim($tmpArr[0]);
		if ($result == '0 成功') {
			return InternalResultTransfer::success();
		} else {
			return InternalResultTransfer::fail($result);
		}
	}

	/**
	 *
	 * 该接口，目前用于批量下发，即群发。只用于群发，比如营销短信等。
	 * @param array $mobiles 手机号
	 * @param string $content 文本内容
	 * @return InternalResultTransfer
	 */
	private function _batchSendWithDown(array $mobiles, $content) {
		$url = $this->domain . '/webservice.asmx/SendSMSEx';
		$objCurl = new Curl($url);
		$params = array(
			'sn'	=> $this->sn,
			'pwd'	=> $this->pwd,
			'mobile'	=> join(',', $mobiles),
			'content'	=> ConvertData::u82gb($content),
			'subcode'	=> $this->subcode,
		);
		$tmpResult = $objCurl->post($params);
		if (empty($tmpResult)) {
			return InternalResultTransfer::fail("curl返回值为空");
		}
		$content = $tmpResult;
		$objXml = simplexml_load_string($content);
		if (!is_object($objXml)) {
			return InternalResultTransfer::fail("返回值不是xml");
		}
		$tmpArr = (array) $objXml;
		$result = trim($tmpArr[0]);
		if ($result == '0 成功') {
			return InternalResultTransfer::success();
		} else {
			return InternalResultTransfer::fail($result);
		}
	}

	/**
	 *
	 * 获取余额（其实就是剩余条数）
	 * @return InternalResultTransfer
	 */
	public function getBalance() {
		$url = $this->domain . '/webservice.asmx/GetBalance';
		$objCurl = new Curl($url);
		$params = array(
			'sn'	=> $this->sn,
			'pwd'	=> $this->pwd,
		);
		$tmpResult = $objCurl->post($params);
		if (empty($tmpResult)) {
			return InternalResultTransfer::fail("curl返回值为空");
		}
		$content = $tmpResult;
		$objXml = simplexml_load_string($content);
		if (!is_object($objXml)) {
			return InternalResultTransfer::fail("返回值不是xml");
		}
		$tmpArr = (array) $objXml;
		$money = trim($tmpArr[0]);
		return InternalResultTransfer::success($money);
	}
}
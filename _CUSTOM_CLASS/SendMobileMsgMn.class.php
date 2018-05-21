<?php
/**
 * 发送手机短信类
 */
class SendMobileMsgMn {
	/**
	 *
	 * 序列号
	 * @var string
	 */
	protected $user_name;

	/**
	 *
	 * 密码
	 * @var string
	 */
	protected $password;
	
	/**
	 * 
	 * 端口号
	 * @var string
	 */
	protected $pszSubPort = '*';
	
	/**
	 * webservice客户端
	 * @var object
	 */
	protected $soap;
	
	/**
	 * 往外发送的内容的编码
	 * @var string
	 */
	protected $outgoingEncoding = "UTF-8";
	
	/**
	 * 默认命名空间
	 */
	protected $namespace = 'http://tempuri.org/';
	
	protected $server_url = 'http://112.91.147.37:9002/MWGate/wmgw.asmx';
	
	public function __construct(array $options) {
		# TODO 校验必要的参数
		$this->user_name = $options['sn'];
		$this->password = $options['pwd'];
		
		$this->Client($this->server_url);
	}
	
	/**
	 * 初始化 webservice 客户端
	 * @param string $server_url 接口地址
	 * @param string $serialNumber 用户名
	 * @param string $password 密码
	 * @param string $timeout 连接超时时间，默认0，为不超时
	 * @param string $response_timeou 信息返回超时时间，默认30
	 */
	function Client($server_url, $timeout = 0, $response_timeout = 30) {
		$this->soap = new nusoap_client($server_url, true, false, false, false, false, $timeout, $response_timeout);
		$this->soap->soap_defencoding = $this->outgoingEncoding;
		$this->soap->decode_utf8 = false;
	}
	
	/**
	 *
	 * 发送短消息
	 * @param array $mobiles 手机号
	 * @param string $content 文本内容
	 * @return InternalResultTransfer
	 */
	public function send(array $mobiles, $content) {
		$mobiles = self::splitMobile($mobiles);
		if (empty($mobiles)) {
			return InternalResultTransfer::fail("手机号不能为空");
		}
		if (!is_scalar($content)) {
			return InternalResultTransfer::fail("只能发送标题类型的数据");
		}
		if (empty($content)) {
			return InternalResultTransfer::fail("不能发送空内容");
		}
		$content = (string) $content;

		$msgs = self::splitContent($content);
		$detail = array();//存放发送详情
		$has_fail = false;//是否有发送失败的短信

		$tmp_count = count($msgs);
		foreach ($mobiles as $tmp_mobiles) {
			for ($j = 0; $j < $tmp_count; $j++) {
				$tmpSendResult = $this->_send($tmp_mobiles, $msgs[$j]);
				if ($tmpSendResult->isSuccess()) {//发送成功
					$tmp_status = true;
					$tmp_msg = null;
				} else {//发送失败
					$tmp_status = false;
					$tmp_msg = $tmpSendResult->getData();
					$has_fail = true;
				}
				$detail[] = array(
				    'content' => $msgs[$j],
					'total'   => count($tmp_mobiles),
				    'status'  => $tmp_status,
				    'msg'     => $tmp_msg,
				);
			}
		}
		
		if ($has_fail) {
			return InternalResultTransfer::fail($detail);
		} else {
			return InternalResultTransfer::success($detail);
		}
	}
	
	/**
	 * 
	 * 拆分待发送的手机号
	 * *一次最大发送号码100个
	 * @param array $mobile 手机号
	 * @return array
	 */
	static protected function splitMobile(array $mobile) {
		if (empty($mobile)) {
			return array();
		}
		
		$max_len = 100; //一次最大发送号码100个
		return array_chunk(array_unique($mobile), $max_len);
	}
	
	/**
	 *
	 * 拆分待发送内容
	 * * 经测试，网关规则如下：
	 * 1、一个英文等于一个中文
	 * 2、文字长度不能超过350个
	 * @param string $content 内容
	 * @return array
	 * @author gaoxiaogang@gmail.com
	 */
	static protected function splitContent($content) {
		$length = strlen($content);
		$msgs = array();//存放拆分后的内容
		$max_len_all_english = 350;//一条纯英文短信的最大长度
		$max_len_chinese_english = 350;//一条中、英混杂短信的最大长度

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
				    if ($total >= $max_len_chinese_english) {
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
	                if ($total >= $max_len_chinese_english) {
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
				$total += 1;

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
		if (empty($this->pszSubPort)){
			$this->pszSubPort = '*';
		}
		
		$params = array(
			'userId'	=> $this->user_name,
			'password'	=> $this->password,
			'pszMobis'	=> implode(",",$mobiles),
			'pszMsg'	=> $content,
			'iMobiCount'=> count($mobiles),
			'pszSubPort'=> $this->pszSubPort,
		);
		
		$response = $this->soap->call("MongateCsSpSendSmsNew", $params, $this->namespace);
		$statusCode = $response['MongateCsSpSendSmsNewResult'];
		if(isset($this->status[$statusCode])) {
			return InternalResultTransfer::fail($this->status[$statusCode]);
		} else if (strlen($statusCode) >= 20 && abs(intval($statusCode)) > 999) {
			return InternalResultTransfer::success();
		}
		
		return InternalResultTransfer::fail('发送失败，返回信息：'.$statusCode);
		
	}
	
	/**
	 *
	 * 获取余额（其实就是剩余条数）
	 * @return InternalResultTransfer
	 */
	function getBalance() {
		$params = array(
			'userId'	=> $this->user_name,
			'password'	=> $this->password,
		);
		$response = $this->soap->call("MongateQueryBalance", $params, $this->namespace);
		$statusCode = $response['MongateQueryBalanceResult'];
		if(isset($this->status[$statusCode])) {
			return InternalResultTransfer::fail($this->status[$statusCode]);
		}
		
		return InternalResultTransfer::success($statusCode);
	}
	
	/**
	 * 错误状态描述
	 * @var array
	 */
	protected $status = array(
		"-1" => "参数为空。信息、电话号码等有空指针，登陆失败",
		"-2" => "电话号码个数超过100",
		"-10" => "申请缓存空间失败",
		"-11" => "电话号码中有非数字字符",
		"-12" => "有异常电话号码",
		"-13" => "电话号码个数与实际个数不相等",
		"-14" => "实际号码个数超过100",
		"-101" => "发送消息等待超时",
		"-102" => "发送或接收消息失败",
		"-103" => "接收消息超时",
		"-200" => "其他错误",
		"-999" => "web服务器内部错误",
		"-10001" => "用户登陆不成功",
		"-10002" => "提交格式不正确",
		"-10003" => "用户余额不足",
		"-10004" => "手机号码不正确",
		"-10005" => "计费用户帐号错误",
		"-10006" => "计费用户密码错",
		"-10007" => "账号已经被停用",
		"-10008" => "账号类型不支持该功能",
		"-10009" => "其它错误",
		"-10010" => "企业代码不正确",
		"-10011" => "信息内容超长",
		"-10012" => "不能发送联通号码",
		"-10013" => "操作员权限不够",
		"-10014" => "费率代码不正确",
		"-10015" => "服务器繁忙",
		"-10016" => "企业权限不够",
		"-10017" => "此时间段不允许发送",
		"-10018" => "经销商用户名或密码错",
		"-10019" => "手机列表或规则错误",
		"-10021" => "没有开停户权限",
		"-10022" => "没有转换用户类型的权限",
		"-10023" => "没有修改用户所属经销商的权限",
		"-10024" => "经销商用户名或密码错",
		"-10025" => "操作员登陆名或密码错误",
		"-10026" => "操作员所充值的用户不存在",
		"-10027" => "操作员没有充值商务版的权限",
		"-10028" => "该用户没有转正不能充值",
		"-10029" => "此用户没有权限从此通道发送信息",
		"-10030" => "不能发送移动号码",
		"-10031" => "手机号码(段)非法",
		"-10032" => "用户使用的费率代码错误",
		"-10033" => "非法关键词"
	);
	
}
<?php
/**
 * 支付宝用户快捷登录类
 */

class AlipayOauth
{
	protected $partner = '2088311949386932';//合作身份者id，以2088开头的16位纯数字

	protected $key = '34o0c4ydqw9crrf1au2rn3gjun92pa7j';//安全检验码，以数字和字母组成的32位字符

	protected $input_charset = 'utf-8';//字符编码格式 目前支持 gbk 或 utf-8

	protected $transport = 'http';//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

	protected $sign_type = 'MD5';//签名方式 不需修改

	protected $aliapy_config;

	protected $token;

	protected $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';//支付宝网关地址（新）

	/**
     * HTTPS形式消息验证地址
     */
	var $https_verify_url = 'https://www.alipay.com/cooperate/gateway.do?service=notify_verify&';

	/**
     * HTTP形式消息验证地址
     */
	var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';

	public function __construct(){

		$aliapy_config = array();

		$aliapy_config['partner']      = $this->partner;

		$aliapy_config['key']          = $this->key;

		$aliapy_config['return_url']   = ROOT_DOMAIN . '/connect/alipay_connect.php';//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
	//return_url的域名应写成http://127.0.0.1/alipay.auth.authorize_php_utf8/return_url.php ，否则会导致return_url执行无效

		$aliapy_config['sign_type']    = $this->sign_type;

		$aliapy_config['input_charset']= $this->input_charset;

		$aliapy_config['transport']    = $this->transport;

		$this->aliapy_config = $aliapy_config;
	}

	public   function  getAliapyConfig(){
		return $this->aliapy_config;
	}

	/**
     * 构造快捷登录接口
     * @param $para_temp 请求参数数组
     * @return 通知给支付宝的url
     */
	public function alipay_auth_authorize($para_temp) {

		$aliapy_config = $this->aliapy_config;
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp, $aliapy_config);

		$paras = $this->alipay_gateway_new;

		foreach ($para as $key=>$val) {
			$paras.= $key.'='.$val.'&';
		}
		$url = substr($paras, 0, -1);//去掉最后一个&

		return $url;

	}

	/**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
	 */
	public function query_timestamp() {
		$url = $this->alipay_gateway_new."service=query_timestamp&partner=".trim($this->aliapy_config['partner']);
		$encrypt_key = "";

		$doc = new DOMDocument();
		$doc->load($url);
		$itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
		$encrypt_key = $itemEncrypt_key->item(0)->nodeValue;

		return $encrypt_key;
	}

	/**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @param $aliapy_config 基本配置信息数组
     * @return 要请求的参数数组
     */
	public function buildRequestPara($para_temp,$aliapy_config) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = self::paraFilter($para_temp);
		//对待签名参数数组排序
		$para_sort = self::argSort($para_filter);
		//生成签名结果
		$mysign = self::buildMysign($para_sort, trim($aliapy_config['key']), strtoupper(trim($aliapy_config['sign_type'])));
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['sign_type'] = strtoupper(trim($aliapy_config['sign_type']));

		return $para_sort;
	}

	/**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
	 * @param $aliapy_config 基本配置信息数组
     * @return 要请求的参数数组字符串
     */
	public function buildRequestParaToString($para_temp,$aliapy_config) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp,$aliapy_config);

		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$request_data = self::createLinkstring($para);

		return $request_data;
	}

	/**
     * 构造模拟远程HTTP的POST请求，获取支付宝的返回XML处理结果
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * @param $para_temp 请求参数数组
     * @param $gateway 网关地址
	 * @param $aliapy_config 基本配置信息数组
     * @return 支付宝返回XML处理结果
     */
	public function sendPostInfo($para_temp, $gateway, $aliapy_config) {
		$xml_str = '';

		//待请求参数数组字符串
		$request_data = $this->buildRequestParaToString($para_temp,$aliapy_config);
		//请求的url完整链接
		$url = $gateway . $request_data;
		//远程获取数据
		$xml_data = self::getHttpResponse($url,trim(strtolower($aliapy_config['input_charset'])));
		//解析XML
		$doc = new DOMDocument();
		$doc->loadXML($xml_data);

		return $doc;
	}

	public function buildMysign($sort_para,$key,$sign_type = "MD5") {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = self::createLinkstring($sort_para);
		//把拼接后的字符串再与安全校验码直接连接起来
		$prestr = $prestr.$key;
		//把最终的字符串签名，获得签名结果
		$mysgin = self::alipaysign($prestr,$sign_type);
		return $mysgin;
	}
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public function createLinkstring(array $para) {
		$arg  = "";
		foreach ($para as $key=>$val) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);

		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

		return $arg;
	}

	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	public function paraFilter($para) {
		$para_filter = array();
		foreach ($para as $key=>$val) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}

	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	public function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	/**
	 * 签名字符串
	 * @param $prestr 需要签名的字符串
	 * @param $sign_type 签名类型 默认值：MD5
	 * return 签名结果
	 */
	public function alipaysign($prestr,$sign_type='MD5') {
		$sign='';
		if($sign_type == 'MD5') {
			$sign = md5($prestr);
		}elseif($sign_type =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$sign_type."类型的签名方式");
		}
		return $sign;
	}

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
	function getResponse($notify_id) {
		$transport = strtolower(trim($this->aliapy_config['transport']));
		$partner = trim($this->aliapy_config['partner']);
		$veryfy_url = '';
		if($transport == 'https') {
			$veryfy_url = $this->https_verify_url;
		}
		else {
			$veryfy_url = $this->http_verify_url;
		}
		$veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
		$responseTxt = $this->getHttpResponse($veryfy_url);

		return $responseTxt;
	}

	/**
	 * 远程获取数据
	 * 注意：该函数的功能可以用curl来实现和代替。curl需自行编写。
	 * $url 指定URL完整路径地址
	 * @param $input_charset 编码格式。默认值：空值
	 * @param $time_out 超时时间。默认值：60
	 * return 远程输出的数据
	 */
	public function getHttpResponse($url, $input_charset = '', $time_out = "60") {
		$urlarr     = parse_url($url);
		$errno      = "";
		$errstr     = "";
		$transports = "";
		$responseText = "";
		if($urlarr["scheme"] == "https") {
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else {
			$transports = "tcp://";
			$urlarr["port"] = "80";
		}
		$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
		if(!$fp) {
			die("ERROR: $errno - $errstr<br />\n");
		} else {
			if (trim($input_charset) == '') {
				fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
			}
			else {
				fputs($fp, "POST ".$urlarr["path"].'?_input_charset='.$input_charset." HTTP/1.1\r\n");
			}
			fputs($fp, "Host: ".$urlarr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlarr["query"] . "\r\n\r\n");
			while(!feof($fp)) {
				$responseText .= @fgets($fp, 1024);
			}
			fclose($fp);
			$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");

			return $responseText;
		}
	}

    /**
     * 根据反馈回来的信息，生成签名结果
     * @param $para_temp 通知返回来的参数数组
     * @return 生成的签名结果
     */
	function getMysign($para_temp) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = self::paraFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = self::argSort($para_filter);

		//生成签名结果
		$mysign = self::buildMysign($para_sort, trim($this->aliapy_config['key']), strtoupper(trim($this->aliapy_config['sign_type'])));

		return $mysign;
	}

}
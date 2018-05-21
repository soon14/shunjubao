<?php
/**
 * 支付宝 Connect
 */
class AlipayConnect
{
	const ALIPAY_CONNECT_COOKIE_NAME = 'AlipayConnectReferer';

	var $objAlipayOauth;

	function __construct(){
		$this->objAlipayOauth = new AlipayOauth();
	}

	/**
	 * 构造支付宝快捷登陆url
	 */
	public function getAuthorizeURL($callback = null) {

		//组装alipay请求参数

		$aliapy_config = $this->objAlipayOauth->getAliapyConfig();
		$para_temp = array(
				"service"			=> "alipay.auth.authorize",
				"target_service"	=> 'user.auth.quick.login',

				"partner"			=> $aliapy_config['partner'],
				"_input_charset"	=> strtolower($aliapy_config['input_charset']),
		        "return_url"		=> $aliapy_config['return_url'],

		        "anti_phishing_key"	=> '',//反钓鱼的，暂时用不上
				"exter_invoke_ip"	=> '',
		);
		$url = $this->objAlipayOauth->alipay_auth_authorize($para_temp);
// 		if (!is_null($callback)) $url = $callback;
		return $url;
	}

	/**
	 * 从支付宝回调url中获取用户信息
	 * Enter description here ...
	 */
	public function getInfo(array $info_callback) {
		if (!$info_callback || $info_callback['is_success'] != 'T') return false;
		$userinfo['user_id'] = $info_callback['user_id'];
		$userinfo['email'] = $info_callback['email'];
		$userinfo['real_name'] = $info_callback['real_name'];
		$userinfo['token'] = $info_callback['token'];
		return $userinfo;
	}

    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
	function verifyReturn(){
		if(empty($_GET)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$mysign = $this->objAlipayOauth->getMysign($_GET);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
			$responseTxt = 'true';
			if (! empty($_GET["notify_id"])) {$responseTxt = $this->objAlipayOauth->getResponse($_GET["notify_id"]);}

			//写日志记录
			//$log_text = "responseTxt=".$responseTxt."\n notify_url_log:sign=".$_GET["sign"]."&mysign=".$mysign.",";
			//$log_text = $log_text.createLinkString($_GET);
			//logResult($log_text);

			//验证
			//$responseTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			if (preg_match("/true$/i",$responseTxt)) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * 构造获取支付宝用户收获地址的url
	 * Enter description here ...
	 */

	function getAlipayConsigneeInfoUrl($token = '') {

		if (!$token) return false;

		//组装alipay请求参数

		$aliapy_config = $this->objAlipayOauth->getAliapyConfig();
		$para_temp = array(
				"service"			=> "user.logistics.address.query",

				"partner"			=> $aliapy_config['partner'],
				"_input_charset"	=> $aliapy_config['input_charset'],
        		"return_url"		=> ROOT_DOMAIN.'/connect/alipay_consignee_info.php',

       			"token"				=> $token

		);
		$url = $this->objAlipayOauth->alipay_auth_authorize($para_temp);
		return $url;

	}

	 /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
	function verifyNotify($params){
		if(empty($params)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$mysign = $this->objAlipayOauth->getMysign($params);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
			$responseTxt = 'true';
			if (! empty($params["notify_id"])) {
				$responseTxt = $this->objAlipayOauth->getResponse($params["notify_id"]);
			}

			//验证
			//$responseTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			if (preg_match("/true$/i",$responseTxt) && $mysign == $params["sign"]) {
				return true;
			} else {
				return false;
			}
		}
	}

}
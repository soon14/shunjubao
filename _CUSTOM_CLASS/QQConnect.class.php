<?php
/**
 *
 * QQ connect 登录
 * @author gxg
 *
 */
class QQConnect {
	private $apiKey = '101179991';

    private $secretKey = '9811cbfedfa8a5ffe60e4aae43e0fa61';

    const COOKIE_KEY_RAND_SECRET = 'qq_RandSecret';
    const COOKIE_KEY			 = 'qq_Weibo_Misc';

	/**
     * 获取QQ Connect 登录URL
     * @param $callback
     */
	public function getAuthorizeURL() {
		
		$callback =	ROOT_DOMAIN . '/connect/qq_connect.php';

		# 授权范围
		$scope = "get_user_info,add_share,add_weibo";

		$state = md5(uniqid(rand(), true)); //CSRF protection
		# 存起来，后续的login方法会用到
// 		setcookie(self::COOKIE_KEY_RAND_SECRET, $state, 0, '/', DOMAIN);

		$login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id={$this->apiKey}&redirect_uri="
					. urlencode($callback)."&state={$state}&scope={$scope}";
		return $login_url;
	}

	/**
	 *
	 * 使用OAuth登录流程返回的$code去获取 access_token 和 openid 信息
	 * @param string $code
	 * @return InternalResultTransfer
	 * 成功时返回的结构：array(
	 * 		'access_token'	=> $access_token,
	 * 		'openid'		=> $openid,
	 * );
	 */
	public function getAccessTokenByCode($code) {
		$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
		. "client_id=" . $this->apiKey . "&redirect_uri=" . urlencode(ROOT_DOMAIN.'/connect/qq_connect.php')
		. "&client_secret=" . $this->secretKey . "&code=" . $code;

		$objCurl = new Curl($token_url);
		$response = $objCurl->get();
		
		if (strpos($response, "callback") !== false) {
			$lpos = strpos($response, "(");
			$rpos = strrpos($response, ")");
			$response = substr($response, $lpos + 1, $rpos - $lpos -1);

			$params = json_decode($response, true);
		} else {
			$params = array();
			parse_str($response, $params);
		}

		if (!isset($params["access_token"])) {
			if (isset($params['error'])) {
				return InternalResultTransfer::fail("{$params['error']}::{$params['error_description']}");
			} else {
				return InternalResultTransfer::fail("error unknow");
			}
		}

		$access_token = $params["access_token"];
		$tmpResult = $this->getOpenid($params["access_token"]);
		if (!$tmpResult->isSuccess()) {
			return $tmpResult;
		}
		$openid = $tmpResult->getData();

		return InternalResultTransfer::success(array(
			'access_token'	=> $access_token,
			'openid'		=> $openid,
		));
	}

	/**
	 *
	 * 判断 $access_token 值是否有效
	 * @param string $access_token
	 * @return Boolean
	 */
	public function isValidAccessToken($access_token) {
		$tmpResult = $this->getOpenid($access_token);
		return $tmpResult->isSuccess();
	}

	/**
	 *
	 * 获取用户的openid，该值严格与用户的qq号一一对应，即唯一（注：不是qq号本身）
	 * @param string $access_token
	 * @return InternalResultTransfer
	 */
	protected function getOpenid($access_token) {
		$graph_url = "https://graph.qq.com/oauth2.0/me?access_token={$access_token}";
		$objCurl = new Curl($graph_url);
		$response = $objCurl->get();

	    if (strpos($response, "callback") !== false) {
	        $lpos = strpos($response, "(");
	        $rpos = strrpos($response, ")");
	        $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
	    }

	    $user = json_decode($response, true);
	    if (!is_array($user) || isset($user['error'])) {
	    	return InternalResultTransfer::fail("{$user['error']}::{$user['error_description']}");
	    }

	    $openid = $user['openid'];
	    $tmpInfo = array(
	    	'access_token'	=> $access_token,
	    	'openid'		=> $openid,
	    );
// 	    setcookie(self::COOKIE_KEY, json_encode($tmpInfo), 0, '/', DOMAIN);

	    return InternalResultTransfer::success($openid);
	}

	/**
	 *
	 * 获取用户信息
	 * @param array $token_info 口令信息，结构如下：array(
	 * 		'access_token'	=> (string),
	 * 		'openid'		=> (string),
	 * );
	 * @return InternalResultTransfer
	 * 成功时返回值格式：Array
	 * (
	 *  [ret] => 0 //返回码
	 *  [msg] =>//如果ret<0，会有相应的错误信息提示，返回数据全部用UTF-8编码。
	 *  [nickname] => 且听风吟//用户在QQ空间的昵称。
	 *  [figureurl] => http://qzapp.qlogo.cn/qzapp/100228433/4457136A31EE7A66F4229D0B7D8A9C1A/30//大小为30×30像素的QQ空间头像URL。
	 *  [figureurl_1] => http://qzapp.qlogo.cn/qzapp/100228433/4457136A31EE7A66F4229D0B7D8A9C1A/50//大小为50×50像素的QQ空间头像URL。
	 *  [figureurl_2] => http://qzapp.qlogo.cn/qzapp/100228433/4457136A31EE7A66F4229D0B7D8A9C1A/100//大小为100×100像素的QQ空间头像URL。
	 *  [gender] => 男	//性别。 如果获取不到则默认返回"男"
		[figureurl_qq_1] => 	大小为40×40像素的QQ头像URL。
		[figureurl_qq_2] => 	大小为100×100像素的QQ头像URL。需要注意，不是所有的用户都拥有QQ的100x100的头像，但40x40像素则是一定会有。
		[is_yellow_vip ] =>	标识用户是否为黄钻用户（0：不是；1：是）。
		[vip] => 	标识用户是否为黄钻用户（0：不是；1：是）
		[yellow_vip_level] => 	黄钻等级
		[level] => 	黄钻等级
		[is_yellow_year_vip] => 	标识是否为年费黄钻用户（0：不是； 1：是） 
	 * )
	 */
	public function getUserInfo(array $token_info) {
		$access_token = $token_info['access_token'];
		$openid = $token_info['openid'];

		$get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $access_token
        . "&oauth_consumer_key=" . $this->apiKey
        . "&openid=" . $openid
        . "&format=json";

		$objCurl = new Curl($get_user_info);
		$response = $objCurl->get();

		$arr = json_decode($response, true);
		if (!is_array($arr)) {
			return InternalResultTransfer::fail();
		}
		if ($arr['ret'] != 0) {
			return InternalResultTransfer::fail($arr);
		}
		return InternalResultTransfer::success($arr);
	}
}
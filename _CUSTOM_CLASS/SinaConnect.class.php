<?php
/**
 * Sina微博 Connect
 * @date 2012-04-28
 * @author gen
 */
class SinaConnect
{
    private $apiKey = '3430318831';
    private $secretKey = '178cbf0f282bea916620a94b08828c5f';

    const COOKIE_KEY = 'SinaWeibo_Misc';
    const COOKIE_KEY_RAND_SECRET = 'SinaWeibo_RandSecret';
    const COOKIE_KEY_FIRST_LOGIN = 'SinaWeibo_FirstLogin';//新浪微博第一次登录发feed

    private $oauth;
    private $weibo;

    public function __construct($access_token = NULL) {
    	$this->oauth = new SaeTOAuthV2($this->apiKey, $this->secretKey, $access_token);
	    $this->weibo = new SaeTClientV2($this->apiKey, $this->secretKey, $access_token, NULL);
    	//$this->login();	// 读 cookie 中存在的登录， 更新变量 $this->weibo ， 这样发微博，关注用户等方法才能使用
    }

    /**
     * 获取Sina Connect 登录URL
     * @param $callback
     * @param $islogged
     */
	public function getAuthorizeURL() {
		
		$callback =	ROOT_DOMAIN . '/connect/weibo_connect.php';
		
		$oauth = new SaeTOAuthV2($this->apiKey, $this->secretKey);
		
		$response_type = 'code'; $state = NULL; $display = 'default';
		
		return $oauth->getAuthorizeURL($callback,$response_type, $state, $display);
		
	}
	
	/**
	 * 获取token
	 * @param string $type
	 * @param array $keys array('code'=>..., 'redirect_uri'=>...)
	 * @return boolean|Ambigous <multitype:, boolean, mixed>
	 */
	function getAccessToken($code, $type = 'code') {
		$oauth = new SaeTOAuthV2($this->apiKey, $this->secretKey);
		$keys = array('code'=>$code,'redirect_uri'=>ROOT_DOMAIN.'/connect/weibo_connect.php');
		$token = $oauth->getAccessToken($type, $keys);
		if (!$this->verifyToken($token)) {
			return false;
		}
		return $token;
	}

	/**
	 *
	 * 记录下connect的登录状态，使当前类可以调用 发微博 等接口
	 * @param string $access_token
	 * @return InternalResultTransfer
	 */
	public function login() {
		$token = json_decode(TMCookie::get(SinaConnect::COOKIE_KEY, array()), true);
		
		// 如果 cookie 中不存在(不合法), 或者用户换了账户。 都重新登录
		//if (!$this->verifyToken($token)) {
			if (!empty($token)) {
				$rand_secret = TMCookie::get(SinaConnect::COOKIE_KEY_RAND_SECRET,array());
				if (!$this->verifyToken($token) || $rand_secret != md5($token['access_token'])) {
					$tmpErrMsg = '获取校验标识失败。<xmp style="display:none">' . print_r($token, true) . '</xmp>';
					return InternalResultTransfer::fail($tmpErrMsg);
				}
				
				// token 存 Cookie , 相当于登录标识，发微博(等)用
				//setcookie(SinaConnect::COOKIE_KEY, json_encode($token), time()+60*60*24*7, '/', DOMAIN);
				
			} else {
				$tmpErrMsg = 'Connect登录后，跳转URL中缺少参数。';
				return InternalResultTransfer::fail($tmpErrMsg);
			}
		//}
		
		$this->oauth = new SaeTOAuthV2($this->apiKey, $this->secretKey, $token['access_token']);
		$this->weibo = new SaeTClientV2($this->apiKey, $this->secretKey, $token['access_token']);
		return InternalResultTransfer::success();
	}

	private function verifyToken($token) {
		return is_array($token) && $token['access_token'] && $token['remind_in'] && $token['uid'] && $token['expires_in'];
	}
	

	/**
	 * 获取登录的用户 信息
	 * 回调回来时，调用此函数
	 * @param string $oauth_token		URL 中 get 获取
	 * @param string $oauth_verifier    同上
	 * @return array | false
	 */
	public function getInfo($access_token, $uid) {
		$c = new SaeTClientV2($this->apiKey, $this->secretKey, $access_token);
// 		$uid_get = $c->get_uid();
// 		$uid = $uid_get['uid'];
		$sinaInfo = $c->show_user_by_id($uid);
		return $sinaInfo;
		if (!Verify::unsignedInt($sinaInfo['id'])) {
			// 获取失败, token 失效
			$expiration = time() - 60*60*24*365;
			TMCookie::set(SinaConnect::COOKIE_KEY, '', $expiration, DOMAIN, '/');
			return false;
		}

		return $sinaInfo;
	}

	/**
	 * 发微博
	 * @param string $text		内容
	 * @param string $pic_path  图片地址
	 */
	public function update($text, $pic_path = null) {
		$token = json_decode(TMCookie::get(SinaConnect::COOKIE_KEY, array()), true);
		$c = new SaeTClientV2($this->apiKey, $this->secretKey, $token['access_token']);
		$path2 = preg_replace('#https?://#', '', $pic_path);
		if(empty($path2))
		{
			return $c->update($text);
		}
		return $c->upload($text, $pic_path);
	}

	 /**
     * 关注一个用户
     *
     * @access public
     * @param mixed $uid_or_name 要关注的用户UID或微博昵称
     * @return array
     */
    public function follow( $screen_name ) {
    	$token = json_decode(TMCookie::get(SinaConnect::COOKIE_KEY, array()), true);
    	$c = new SaeTClientV2($this->apiKey, $this->secretKey, $token['access_token']);
    	return $c->follow_by_name($screen_name);
    }
    
    /** 
     * 返回两个用户关系的详细情况 
     *  
     * @access public 
     * @param mixed $uid_or_name 要判断的用户UID 
     * @return array 
     */ 
    public function is_followed($uid_or_name) { 
    	$token = json_decode(TMCookie::get(SinaConnect::COOKIE_KEY, array()), true);
    	$c = new SaeTClientV2($this->apiKey, $this->secretKey, $token['access_token']);
        return $c->is_followed_by_name($uid_or_name); 
    } 
}

?>
<?php
/**
 * 微信connect类
 * access_token 默认2小时有效
 * refresh_token 默认30天有效
 * 调用频率限制
			接口名 	频率限制
			通过code换取access_token 	1万/分钟
			刷新access_token 	5万/分钟
			获取用户基本信息 	5万/分钟
 * @date 2015-1-4
 */
class WeiXinConnect {
	
	private $AppId = 'wxc1b1ad8efd2af8eb';
	private $AppSecret = '71902ec371b39323d9a69bf750b1347f';
	
	/**
	 * 微信登录接口中的state参数，用来校验
	 * @var string
	 */
	private $state;
	
	/**
	 * 登录成功后返回的code值
	 * @var string
	 */
	private $code;
	
	/**
	 * curl接口返回数据
	 */
	protected $respons;
	
	public function __construct() {
		
	}
	
	/**
	 * http链接类，构造curl类并发送数据
	 * @param string $url curl
	 * @param string $method
	 * @param array $data
	 */
	private function _http_get($url) {
		$objCurl = new Curl($url);
		return $objCurl->get();
	}
	
	/**
	 * 获取联合登录url
	 * @param string $redirect_uri 登录后跳转到主站的地址
	 * @return string
	 */
	public function getLoginUrl() {
		$redirect_uri = urlencode(ROOT_DOMAIN.'/connect/weixin_connect.php');
		return "https://open.weixin.qq.com/connect/qrconnect?appid={$this->AppId}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_login&state={$this->_signState()}#wechat_redirect";
	}
	
	/**
	 * 获取联合登录AccessToken信息
	 * @param string $code 登录成功后返回的code
	 * @return string
	 * 正确的返回：{
				"access_token":"ACCESS_TOKEN",
				"expires_in":7200,
				"refresh_token":"REFRESH_TOKEN",
				"openid":"OPENID",
				"scope":"SCOPE"
				} 
		错误返回：{"errcode":40029,"errmsg":"invalid code"} 		
	 */
	public function getAccessTokenByCode($code) {
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->AppId}&secret={$this->AppSecret}&code={$code}&grant_type=authorization_code";
		return json_decode($this->_http_get($url));
	}
	
	/**
	 * 获取联合登录AccessToken信息
	 * @param string $refresh_token 登录成功后返回的refresh_token
	 * @return string
	 * 正确的返回：{
				 "access_token":"ACCESS_TOKEN",
				 "expires_in":7200,
				 "refresh_token":"REFRESH_TOKEN",
				 "openid":"OPENID",
				 "scope":"SCOPE"
				 }
	 错误返回：{"errcode":40029,"errmsg":"invalid code"}
	 */
	public function getAccessTokenByRefreshToken($refresh_token) {
		$url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->AppId}&refresh_token={$refresh_token}&grant_type=refresh_token";
		return json_decode($this->_http_get($url));
	}
	
	/**
	 * 检验授权凭证（access_token）是否有效
	 * @param string $access_token
	 * @return array
	 * 正确的Json返回结果：
		{
		"errcode":0,"errmsg":"ok"
		}
		
		错误的Json返回示例:
		{
		"errcode":40003,"errmsg":"invalid openid"
		} 
	 */
	public function verifyAccessToken($access_token, $openid) {
		$url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$openid}";
		return json_decode($this->_http_get($url));
	}
	
	/**
	 * 获取用户个人信息（UnionID机制）
		接口说明
		此接口用于获取用户个人信息。
		开发者可通过OpenID来获取用户基本信息。
		特别需要注意的是，如果开发者拥有多个移动应用、网站应用和公众帐号，可通过获取用户基本信息中的unionid来区分用户的唯一性，
		因为只要是同一个微信开放平台帐号下的移动应用、网站应用和公众帐号，用户的unionid是唯一的。
		换句话说，同一用户，对同一个微信开放平台下的不同应用，unionid是相同的。
	 * @return
	 * 返回说明
			正确的Json返回结果：
			{
			"openid":"OPENID",
			"nickname":"NICKNAME",
			"sex":1,
			"province":"PROVINCE",
			"city":"CITY",
			"country":"COUNTRY",
			"headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
			"privilege":[
			"PRIVILEGE1",
			"PRIVILEGE2"
			],
			"unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
			}
			参数 	说明
			openid 	普通用户的标识，对当前开发者帐号唯一
			nickname 	普通用户昵称
			sex 	普通用户性别，1为男性，2为女性
			province 	普通用户个人资料填写的省份
			city 	普通用户个人资料填写的城市
			country 	国家，如中国为CN
			headimgurl 	用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空
			privilege 	用户特权信息，json数组，如微信沃卡用户为（chinaunicom）
			unionid 	用户统一标识。针对一个微信开放平台帐号下的应用，同一用户的unionid是唯一的。
			错误的Json返回示例:
			{
			"errcode":40003,"errmsg":"invalid openid"
			}
	 * @return array
	 */
	public function getUserInfo($access_token, $openid) {
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}";
		return json_decode($this->_http_get($url));
	}
	
	/**
	 * 获取加密后的state
	 */
	private function _signState() {
		return $this->state = md5($this->scope.$this->AppSecret.$this->AppId.rand(1, 100));
	}
	
	/**
	 * 验证state
	 * @param string $state
	 * @return boolean
	 */
	public function verifySign($state) {
		return $this->state == $state;
	}
	
	/**
	 * 用户信息对象到数组的转化
	 */
	public function objUserInfoTOArray($obj_user_info) {
		$user_info = array();
		$user_info['openid'] 	= $obj_user_info->openid;
		$user_info['nickname'] 	= $obj_user_info->nickname;
		$user_info['sex'] 		= $obj_user_info->sex;
		$user_info['province'] 	= $obj_user_info->province;
		$user_info['city'] 		= $obj_user_info->city;
		$user_info['country'] 	= $obj_user_info->country;
		$user_info['headimgurl']= $obj_user_info->headimgurl;
		$user_info['unionid'] 	= $obj_user_info->unionid;
		$user_info['privilege'] = $obj_user_info->privilege;
		return $user_info;
	}
}
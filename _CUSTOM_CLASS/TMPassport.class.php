<?php
/**
 * 用户通行证系统
 *
 */
class TMPassport {
	/**
	 * 安全key
	 *
	 * @var string
	 */
	private $securityKey;

	private $login_cookie_name = 'TM_PASSPORT_MEMBER';
	
	/**
	 * 验证登录用户的cookiename
	 * @var string
	 */
	private $login_sign_cookie_name = 'ZY_PASSPORT_MEMBER';
	
	/**
	 * 
	 * 登录用的键名
	 * @var array
	 */
	private $login_need_keys = array(
		'u_id',
		'u_name',
		'cash',
		'expire',
		'ZY_PASSPORT_MEMBER',
		'u_img'
	);

	public function __construct() {
		if (!defined('PASSPORT_SIGN_KEY')) {
			throw new ParamsException('请指定securityKey');
		}
        $this->securityKey = PASSPORT_SIGN_KEY;
	}

	/**
	 * 获取登录用户信息
	 * 包括：1、用户id；2、用户名；3、账户余额
	 * @return InternalResultTransfer 成功：存在登录cookie里的信息作为数组返回；失败：失败原因
	 */
	public function getLoginInfo() {
		//由于session不能跨域读取，因此改用cookie
		if (!isset($_SESSION['u_id']) || !Verify::int($_SESSION['u_id'])) {
// 			return InternalResultTransfer::fail('没有登录');
		}

        $loginInfo = array();
        
        foreach ($this->login_need_keys as $key) {
        	$value = TMCookie::Get($key);
        	if ($value) {
        		$loginInfo[$key] = $value;
        	}
        }
        
        if (!$this->verifySign($loginInfo)) {
        	return InternalResultTransfer::fail('校验不通过');
        }
        
        if ($loginInfo['expire'] < time()) {
        	return InternalResultTransfer::fail('登录超时');
        }
        
        return InternalResultTransfer::success($loginInfo);
	}

	/**
     * 登录
     * # 得仔细考虑下如何处理 expire 值，这涉及到安全性问题。
     * @param string $name  用户名
     * @param string $password  密码
     * @param int | null $expire 登录有效期 值为null时：表示该cookie为当前会话期有效
     * @param string $login_type 登录类型。默认为主站用户
     * @return InternalResultTransfer
     */
	public function login($name, $password, $expire = null) {
		$objUserMemberFront = new UserMemberFront();
		$tmpResult = $objUserMemberFront->getByNameAndPassword($name, $password);
		if (!$tmpResult->isSuccess()) {			
			return $tmpResult;
		}

		$user = $tmpResult->getData();
		return $this->loginByUserInfo($user);
	}
	
	/**
	 * 为某个用户登录
	 * @param array $userInfo
	 */
	public function loginByUserInfo($user) {
		
		//获取账户余额
		if (in_array('cash', $this->login_need_keys)) {
			$objUserAccountFront = new UserAccountFront();
			$userAccountInfo = $objUserAccountFront->get($user['u_id']);
			$user['cash'] = $userAccountInfo['cash'];
		}
		
		$loginInfo = array();
		foreach ($this->login_need_keys as $key) {
			if (isset($user[$key])) {
				$loginInfo[$key] 		= $user[$key];
			}
		}
		
		$loginInfo['expire'] = time() + SESSION_EXPIRE_TIME + 7*86400;
		//加入密码信息，解决更改密码后扔能登录的bug
		$loginInfo['u_pwd'] = $user['u_pwd'];
		//用户时间加长到7天
// 		$currentSource = UserMember::getUserSource();
// 		if ($currentSource == UserMember::REGISTER_TYPE_APP || $currentSource == UserMember::REGISTER_TYPE_IOS) {
// 			$loginInfo['expire'] += $loginInfo['expire'] + 7*86400;
// 		}
		
		$loginInfo[$this->login_sign_cookie_name] = $this->sign($loginInfo);
		
		$this->writeLoginCookie($loginInfo);
		
		//更新登录时间
		$user['u_logintime'] = getCurrentDate();
		$objUserMemberFront = new UserMemberFront();
		$tmpResult = $objUserMemberFront->modify($user);
		return $tmpResult;
	}
	
	/**
	 * 
	 * 登出
	 */
	public function logout() {
		foreach ($this->login_need_keys as $key) {
			if (isset($_SESSION[$key])) {
				unset($_SESSION[$key]);
			}
			if (isset($_COOKIE[$key])) {
				TMCookie::set($key, '');
			}
        }
	}

	/**
	 * 注册一个用户
	 * 1、添加会员信息
	 * 2、添加账户扩展信息
	 * 3、添加余额信息
	 * 4、成功后登录
	 * @param array $info = array(
	 * 		'u_name'	=>		string,
	 * 		'u_pwd'		=>		string,
	 * )
	 * @return InternalResultTransfer
	 */
	public function register(array $info) {
					
		$objUserMemberFront = new UserMemberFront();
		#添加会员信息
        $tmpResult = $objUserMemberFront->add($info);
        if (!$tmpResult->isSuccess()) {
        	return $tmpResult;
        }
        
        $userInfo = $tmpResult->getData();
        
        #添加账户扩展信息
        $objUserRealInfoFront = new UserRealInfoFront();
        $tmpResult = $objUserRealInfoFront->add($info);
		if (!$tmpResult->isSuccess()) {
        	return $tmpResult;
        }
        
		#添加余额信息
		$objUserAccountFront = new UserAccountFront();
        $tmpResult = $objUserAccountFront->add($info);
		if (!$tmpResult->isSuccess()) {
        	return $tmpResult;
        }
        
		#登录
        $tmpResult = $this->login($info['u_name'], $info['u_pwd']);
        if (!$tmpResult->isSuccess()) {
        	return $tmpResult;
        }
        
        return InternalResultTransfer::success($userInfo);
	}

	/**
	 * 写登录信息到cookie
	 * @param array $info
	 * @return InternalResultTransfer
	 */
	public function writeLoginCookie(array $info) {
		foreach ($info as $key=>$value) {
			TMCookie::set($key, $value, $info['expire']-time());
		}
		return InternalResultTransfer::success();
		if (is_null($info['expire'])) {// 说明这是个当前会话期有效的登录用户
			$info['expire']      = time() + 4 * 60 * 60;//登录cookie签名的有效性，设为4小时
			$cookie_expire       = null;//让登录cookie在当前会话期有效
		} else {
			# 让登录cookie的存在期比 登录cookie签名有效性多1天。避免用户电脑时间与服务器时间不一致，导致签名在有效期，但cookie却已失效的情况。
			$cookie_expire       = $info['expire'] + 24 * 60 * 60;
		}

		if (is_null($info['timestamp'])) {//
			$info['timestamp'] = time();
		}

		# 版本号，为以后安全性升级做准备
		$info['version'] = '0.1';

        $tmpResult = $this->sign($info);
        if (!$tmpResult->isSuccess()) {//签名失败
        	return $tmpResult;
        }

        $info['sign'] = $tmpResult->getData();

        setcookie($this->login_cookie_name, http_build_query($info), $cookie_expire, '/', DOMAIN);

        return InternalResultTransfer::success();
	}
	
	/**
	 * 登录信息记录到session
	 * @return InternalResultTransfer 
	 */
	public function writeLoginSession($userInfo) {
		if (!Verify::unsignedInt($userInfo['u_id'])) {
			return InternalResultTransfer::fail('无效用户信息id');
		}
		
		foreach ($this->login_need_keys as $key) {
			if (isset($userInfo[$key])) {
				Session::Set($key, $userInfo[$key]);
			}
        }
        
		return InternalResultTransfer::success($userInfo);
	}

	/**
	 * 对 $info 做签名
	 *
	 * @param array $info 格式：array
	 * (
	 *     // 这些是必要字段
	 *     'uid'       => (int),//用户id
	 *     'uname'     => (string),//用户名
	 *     'expire'    => (int),//签名有效期，过了这个有效期，即使签名正确，也不认。
	 *     'register_type' => (int),//用户注册类型
	 * )
	 *
	 * @return InternalResultTransfer  成功：返回签名$sign；失败：返回失败原因
	 */
    public function sign(array $info) {

    	$sign_info = array();
    	$sign_info['u_id'] 		= $info['u_id'];
    	$sign_info['u_name'] 	= $info['u_name'];
    	$sign_info['expire'] 	= $info['expire'];
    	$sign_info['u_pwd']		= $info['u_pwd'];
    	
    	ksort($sign_info);
        $tmpStr = '';
        foreach ($sign_info as $k => $v) {
        	$tmpStr .= "{$k}={$v}&";
        }
        $tmpStr .= "securityKey={$this->securityKey}";
        $sign = strtolower(sha1($tmpStr));

        return $sign;
    }

    /**
     * 验证 $info 的有效性
     *
     * @param array $info
     * @return boolean
     */
    public function verifySign(array $info) {
    	//加入密码验证
    	if ($info['u_id']) {
    		$objUserMemberFront = new UserMemberFront();
    		$user = $objUserMemberFront->get($info['u_id']);
    		$info['u_pwd'] = $user['u_pwd'];
    	}
        return $this->sign($info) == $info[$this->login_sign_cookie_name];
    }

}
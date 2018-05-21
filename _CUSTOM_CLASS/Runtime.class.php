<?php
/**
 * 运行时类
 * @author gaoxiaogang@gmail.com
 *
 */
class Runtime {

	/**
	 * 是否登录
	 *
	 * @return boolean
	 */
	public function isLogin() {
        return (boolean) self::getUser();
	}

	/**
	 * 要求未登录用户去登录
	 * # TODO 该方法有待进一步填充
	 * @param boolean $isHalt 不满足登录要求时，是否停机。默认停机跳转到登录页
	 * @return boolean or redirect
	 */
	public function requireLogin($isHalt = true) {
        if (!self::isLogin()) {
        	if (!$isHalt) {
        		return false;
        	}
        	$tmpParams = array(
        		'from'	=> Request::getCurUrl(),
        	);
        	
        	$url = jointUrl(PASSPORT_ROOT_DOMAIN . '/passport/login.php', $tmpParams);
        	
        	redirect($url);
            exit;
        }

        return true;
	}

	/**
	 *
	 * 获取用户所属的角色列表
	 * @return array
	 */
	public function getsRoles() {
		$uname = self::getUname();
		if (!$uname) {
			return array();
		}

		static $user_role_config = null;
		if (is_null($user_role_config)) {
			$user_role_config = include ROOT_PATH . '/include/user_role_config.php';
		}

		$roles = array();
		foreach ($user_role_config as $role	=> $unames) {
			if (in_array($uname, $unames)) {
				$roles[] = $role;
			}
		}
		return $roles;
	}

	/**
	 *
	 * 要求指定角色
	 * @param mixed $raw_role 可以是单个角色，传递角色名；也可以是多个角色，传递数组。
	 * 					如 Role::ADMIN　或　array(Role::EDITOR, Role::CUSTOMER_SERVICE)
	 * @param boolean $isHalt 不满足角色要求时，是否停机。默认停机报错。这样可以由调用者指定报错信息
	 * @param Boolean $isExactCompare 是否精确比较，非精确比较时，admin或super具有完全权限。默认为不精确比较。
	 * @throws ParamsException "role参数要求是string或array"
	 * @return true
	 */
	public function requireRole($raw_role, $isHalt = true, $isExactCompare = false) {
		self::requireLogin($isHalt);// 必须是先登录的，才有角色可言

		$uname = self::getUname();

		if (is_null($isHalt)) {
			$isHalt = true;
		}
		if (is_null($isExactCompare)) {
			$isExactCompare = false;
		}

		if (!is_string($raw_role) && !is_array($raw_role)) {
			throw new ParamsException("role参数要求是string或array");
		}
		if (is_string($raw_role)) {
			$roles = array($raw_role);
		} else {
			$roles = $raw_role;
		}

		static $user_role_config = null;
		if (is_null($user_role_config)) {
			$user_role_config = include ROOT_PATH . '/include/user_role_config.php';
		}

		if (!$isExactCompare) {// 如果不要求精确比较，则管理员或super有权限
			if (!in_array(Role::SUPER, $roles)) {
				if (!in_array(Role::ADMIN, $roles)) {
					array_unshift($roles, Role::ADMIN);// 插入队列头
				}

				array_unshift($roles, Role::SUPER);
			}
		}


		$havePermission = false;
		foreach ($roles as $role) {
			if (array_key_exists($role, $user_role_config)
				&& in_array($uname, $user_role_config[$role])
			) {
				$havePermission = true;
				break;
			}
		}
		if ($havePermission) {
			return true;
		}

		if (!$isHalt) {// 不停机，即由上层去处理报错
			return false;
		}

		# 权限不足
		$roleDesc = Role::getRoleDesc();
		$tmpArr = array();
		foreach ($roles as $tmpRole) {
			$tmpArr[] = $roleDesc[$tmpRole]['desc'];
		}
		$descs = join($tmpArr, " 或 ");
		$title = '您的权限不足';
		$desc = "本页面需要 {$descs} 的权限";

		$tmpParams = array(
        	'from'	=> Request::getCurUrl(),
        );
        $reLoginUrl = jointUrl(PASSPORT_ROOT_DOMAIN . '/passport/relogin.php', $tmpParams);

		fail_exit_g($title, $desc, array(
			array(
				"title"	=> "重新登录",
				"href"	=> $reLoginUrl,
			),
		));

		return false;
	}

	/**
     * 获取用户id
     *
     * @return false | int
     */
	public function getUid() {
        $user = self::getUser();
        if (!$user) {
        	return false;
        }

        return $user['u_id'];
	}

	/**
	 * 获取用户名
	 *
	 * @return false | string
	 */
	public function getUname() {
        $user = self::getUser();
        if (!$user) {
            return false;
        }

        return $user['u_name'];
	}

	/**
	 * 获取用户信息不仅仅是登录信息
	 * @return false | array
	 */
	static public function getUser() {
		
		//赠送积分逻辑，从点击登录处转移至此；3月1日起赠送1个积分
		$score = 10;
		if (getCurrentDate() >= '2015-03-01 00:00:00') {
			$score = 1;
		}
		
		static $user = null;
		if (!is_null($user)) {
			//addScoreByLogin($user['u_id'], $score);
			return $user;
		}
		
		$objTMPassport = new TMPassport();
        $tmpResult = $objTMPassport->getLoginInfo();
        if (!$tmpResult->isSuccess()) {
            return false;
        }
        $userInfo = $tmpResult->getData();
        $objUserMemberFront = new UserMemberFront();
        $user = $objUserMemberFront->get($userInfo['u_id']);
       // addScoreByLogin($user['u_id'], $score);
        return $user;
	}

	/**
	 *
	 * 获取全局用户id。该值与用户是否登录无关，是日志统计的基础
	 * 通过该字段，可以关联出更多的用户的其他行为。
	 * @return false | string
	 */
	static public function getUUID() {
		$uuid = Request::c('uuid');
		if (!$uuid) {
			return false;
		}
		$uuid = nginx_uuid_decode($uuid);
		if (strlen($uuid) != 32) {
			return false;
		}
		return $uuid;
	}

	/**
	 * 获取注册来源
	 * 如 主站用户、新浪微博connecte用户、开心网connect用户
	 *
	 * @return false | string
	 */
	public function getLoginType() {
        $user = self::getUser();
        if (!$user) {
            return false;
        }

        return $user['u_source'];
	}

    /**
     * 是否处于命令行下
     * @return Boolean
     */
    static public function isCLI() {
        if (php_sapi_name() == "cli"//PHP 4 >= 4.0.1, PHP 5 support php_sapi_name function
            || empty($_SERVER['PHP_SELF'])//If PHP is running as a command-line processor this variable contains the script name since PHP 4.3.0. Previously it was not available.
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否类unix系统
     * @return Boolean
     */
    static public function isUnixLike() {
        $os = strtolower(PHP_OS);
        if (in_array($os, array('linux', 'freebsd', 'unix', 'netbsd'))) {
            return true;
        }
        return false;
    }
    
    public function getServerNameId() {
    	return 1;
    }
}

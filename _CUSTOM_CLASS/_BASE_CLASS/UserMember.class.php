<?php 
class UserMember extends DBSpeedyPattern {
	protected $tableName = 'user_member';

	protected $primaryKey = 'u_id';

    /**
     * 
     * 数据库真实字段
     * @var array
     */
    protected $real_field = array(
    		'u_id',
    		'u_name',
    		'u_pwd',//明文20位md5
	    	'u_nick',//昵称，不超过20个字符
	    	'u_address',
	    	'u_birthday',
	    	'u_img',
	    	'u_email',
	    	'u_jointime',//注册时间
	    	'u_logintime',//登录时间
	    	'u_loginip',//用户注册ip地址，字符
	    	'u_source',//来源
    		'u_expert',//是否可以晒单
			'u_paipang',//是否可参加排行
			'u_lock',//是否锁定
			'intro',//介绍
    );
    
	/**
	 * 主站-注册来源
	 * @var int
	 */
	const REGISTER_TYPE_MAINSITE   = 1;
	
	/**
	 * 支付宝
	 * @var int
	 */
	const REGISTER_TYPE_ALIPAY   = 2;
	
	/**
	 * QQ登录
	 * @var int
	 */
	const REGISTER_TYPE_QQ   = 3;
	
	/**
	 * 腾讯微博
	 * @var int
	 */
	const REGISTER_TYPE_WEIBO_T   = 4;
	
	/**
	 * 新浪微博
	 * @var int
	 */
	const REGISTER_TYPE_WEIBO_SINA   = 5;
	
	/**
	 * 手机端注册m版
	 * @var int
	 */
	CONST REGISTER_TYPE_MOBILE = 10;
	
	/**
	 * 安卓版
	 */
	CONST REGISTER_TYPE_APP = 11;
	
	/**
	 * ios版
	 */
	CONST REGISTER_TYPE_IOS = 12;
	
	/**
	 * 微信版
	 */
	CONST REGISTER_TYPE_MP = 13;
///////////////////外站////////////////////
	/**
	 * 外站统一cookie的key 
	 * 外站是广义的概念，包括特定的网站或个人
	 * @var string
	 */
	const OTHER_SITES_FROM_COOKIE_KEY = 'ZYsiteFrom';
	
	/**
	 * 足球装备论坛:bbs.enjoyz.com
	 * @var int
	 */
	const REGISTER_TYPE_BBS_ENJOYZ   = 20;
	
	/**
	 * ip注册时间间隔，10分钟 
	 */
	const IP_REGISTER_TIME_MIN = 600;
	
    static private $registerDesc = array(
    	self::REGISTER_TYPE_MAINSITE => array(
    		'desc'	=> '主站',
    		'kw'		=> 'REGISTER_TYPE_MAINSITE',
    	),
    	self::REGISTER_TYPE_ALIPAY => array(
    		'desc'	=> '支付宝',
    		'kw'		=> 'REGISTER_TYPE_ALIPAY',
    	),
    	self::REGISTER_TYPE_QQ => array(
    		'desc'	=> 'QQ用户',
    		'kw'		=> 'REGISTER_TYPE_QQ',
    	),
    	self::REGISTER_TYPE_WEIBO_T => array(
    		'desc'	=> '腾讯微博',
    		'kw'		=> 'REGISTER_TYPE_WEIBO_T',
    	),
    	self::REGISTER_TYPE_WEIBO_SINA => array(
    		'desc'	=> '新浪微博',
    		'kw'		=> 'REGISTER_TYPE_WEIBO_SINA',
    	),
    	self::REGISTER_TYPE_MOBILE => array(
    		'desc'	=> '手机端注册',
    		'kw'	=> 'REGISTER_TYPE_MOBILE',
    	),
    	self::REGISTER_TYPE_IOS => array(
    		'desc'	=> 'ios注册',
    		'kw'	=> 'REGISTER_TYPE_IOS',
    	),
    	self::REGISTER_TYPE_APP => array(
    		'desc'	=> '安卓注册',
    		'kw'	=> 'REGISTER_TYPE_APP',
    	),
    	self::REGISTER_TYPE_MP => array(
    		'desc'	=> '微信注册',
    		'kw'	=> 'REGISTER_TYPE_MP',
    	),
    	self::REGISTER_TYPE_BBS_ENJOYZ => array(
    		'desc'	=> '足球装备论坛:enjoyz',
    		'kw'	=> 'REGISTER_TYPE_BBS_ENJOYZ',
    	),
    	    	
    );

    /**
     * 返回所有的用户注册类型
     * @return array
     */
    static public function getRegisterDesc() {
    	return self::$registerDesc;
    }
    
    /**
     * 这个部分的数据将来需要改为数据库的形式，目前外站较少，可以写到类里
     */
	static private $otherSitesDesc = array(
    	self::REGISTER_TYPE_BBS_ENJOYZ => array(
    		'desc'	=> '足球装备论坛:.enjoyz',
    		'kw'		=> 'REGISTER_TYPE_BBS_ENJOYZ',
    	),
    );

    /**
     * 返回所有外站的用户注册类型
     * @return array
     */
    static public function getOtherSitesDesc() {
    	return self::$otherSitesDesc;
    }
    
    /**
     * 验证来源是否是合作的网站，若是返回sourceID，若不是返回false
     * @param string $from
     * @return false | ID
     */
    static public function verifySiteFrom($from) {
    	$ID = ConvertData::decryptStr2Id($from);
    	if (Verify::int($ID)) {
    		return $ID;
    	}
    	return FALSE;
    }
    
    static public function getSourceDesc() {
    	return array(
    		self::REGISTER_TYPE_MAINSITE => array(
    			'desc' => '主站',
    		),
    		self::REGISTER_TYPE_MOBILE => array(
    			'desc' => '手机端注册',
    		),
    		self::REGISTER_TYPE_IOS => array(
    			'desc' => 'ios注册',
    		),
    		self::REGISTER_TYPE_APP => array(
    			'desc' => '安卓注册',
    		),
    		self::REGISTER_TYPE_MP => array(
    			'desc' => '微信注册',
    		),
    	);
    }
    
    /**
     * 获取站点信息，主站或手机端
     * 函数名命名不准确，应该叫SiteSource,而不是getUserSource
     * @return int $source
     */
    static public function getUserSource() {
    	if(preg_match(WAP_DOMAIN_MATCH, ROOT_DOMAIN)) {
    		return self::REGISTER_TYPE_MOBILE;
    	} elseif (preg_match(APP_DOMAIN_MATCH, ROOT_DOMAIN)){
    		return self::REGISTER_TYPE_APP;
    	} elseif (preg_match(IOS_DOMAIN_MATCH, ROOT_DOMAIN)){
    		return self::REGISTER_TYPE_IOS;
    	} elseif (preg_match(MP_DOMAIN_MATCH, ROOT_DOMAIN)){
    		return self::REGISTER_TYPE_MP;
    	} else {
    		return self::REGISTER_TYPE_MAINSITE;
    	}
    }
    
    /**
     * 创建一个用户
     *
     * @param array $info 要求的字段 array(
     *     'u_name'       => (string),//用户名
     *     'u_pwd'   	=> (string),//用户密码
     *			......
     * )
     * @return InternalResultTransfer 成功：返回用户记录，包括用户id；失败：返回失败原因
     */
    public function add(array $info) {
    	$name = $info['u_name'];
    	
    	$verifyNameResult = UserMemberFront::verifyName($name);
    	if (!$verifyNameResult->isSuccess()) {
    		return $verifyNameResult;
    	}

    	$password = $info['u_pwd'];
        if (empty($password)) {
            return InternalResultTransfer::fail('password字段不能为空');
        }
        
        $password = self::getPWD($password);
        
        $u_source      		= isset($info['u_source'])?$info['u_source']:self::REGISTER_TYPE_MAINSITE;
        $register_ip     	= Request::getIpAddress();
        $date 				= getCurrentDate();

        $tableInfo =  array(
            'u_name'            => $name,
            'u_pwd'          	=> $password,
            'u_source'     		=> $u_source,
            'u_jointime'     	=> $date,
            'u_loginip'       	=> $register_ip,
        	'u_logintime'		=> $date,
        	'u_nick'			=> $name,
        );

        $uid = parent::add($tableInfo);
        if (!$uid) {
        	return InternalResultTransfer::fail('插入会员信息失败');
        }

        $user = $tableInfo;
        $user[$this->primaryKey] = $uid;

        return InternalResultTransfer::success($user);
    }
    
    /**
     * 获取指定用户名 $name 的用户id
     *
     * @param string $name
     * @return false | int
     */
    public function getIdByName($name) {
        if (empty($name)) {
        	return false;
        }
        $condition = array(
            'u_name'   => trim($name),
        );
        
        $result = $this->fetchOne($condition, $this->primaryKey);
        if (!$result) {
        	return false;
        }
        return array_pop($result);
    }

    /**
     *
     * 更新会员信息(除密码)
     * @param int $id 用户u_id
     * @param array $info 待更新的会员信息
     * @return boolean
     */
    public function updateMember ($id, $info = array()) {
    	if (!Verify::int($id)) {
			return FALSE;
		}
		
        $condition = array(
            'u_id'   => $id,
        );
        
        $tableInfo  = $info;
        //不从这里更新密码
        if (isset($tableInfo['u_pwd'])) {
        	unset($tableInfo['u_pwd']);
        }
        
    	return $this->update($tableInfo, $condition);
    }
    
    /**
     *
     * 根据用户名修改密码
     * @param string $name 用户密码
     * @param string $password 用户名
     * @return boolean
     */
    public function updatePasByName ($name, $password) {
    	if (empty($name) || empty($password)) {
			return FALSE;
		}
        $condition = array(
            'u_name'   => trim($name),
        );
    	$tableInfo['u_pwd'] = self::getPWD($password);
    	return $this->update($tableInfo, $condition);
    }
    
    /**
     * 批量获取账户信息
     */
    public function getsAccountById($ids) {
    	return $this->gets($ids);
    }
    
    /**
     * 密码加密方式
     * @param string $pwd
     * @return string 
     */
    public function getPWD($pwd) {
//    	return md5_20($pwd);//2014-07-01密码区分大小写
    	return md5_20(strtolower($pwd));
    }
    
}
?>
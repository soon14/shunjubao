<?php
/**
 *
 * 连接用户绑定表 的后端操作类
 * @author gaoxiaogang@gmail.com
 *
 */
class UserConnect extends DBSpeedyPattern {
	protected $tableName = 'user_connect';
	protected $primaryKey = 'id';
	
	/**
	 * 用户来源地址，即登录成功后跳转的地址cookie key
	 */
	CONST REDIRECT_URI_COOKIE_KEY = 'ZY_REDIRECT_URI';
	
	/**
	 * 类型，用来区别从哪来的用户
	 */
	
	/**
	 * 支付宝
	 * @var int
	 */
	const TYPE_ALIPAY 		= 1;

	/**
	 * QQ
	 * @var int
	 */
	const TYPE_QQ 			= 2;

	/**
	 * 微信
	 * @var int
	 */
	const TYPE_WEIXIN 		= 3;
	
	/**
	 * 新浪微博
	 * @var int
	 */
	const TYPE_WEIBO_SINA 	= 4;
	
	protected $real_field = array(
		'id',// int(10) NOT NULL AUTO_INCREMENT,
  		'u_id',// int(10) NOT NULL COMMENT '我方uid',
	  	'u_name',// varchar(40) COLLATE latin1_general_ci NOT NULL COMMENT '我方uname',
	  	'c_uid',// varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT '登录方uid',
		'c_name',// varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT '登录方uname',
		'token',// text COLLATE latin1_general_ci NOT NULL COMMENT '登录方密钥',
		'extend',// text COLLATE latin1_general_ci NOT NULL,
		'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
		'modify_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
		'type',//`type` TINYINT(3) NOT NULL COMMENT '登录方类型qq微信微博等';
		'status',// TINYINT(3) NOT NULL COMMENT '绑定状态0未绑定；1已绑定' AFTER `type`;
	);

	/**
	 * 绑定状态之：已绑定
	 */
	CONST CONNECT_STATUS_BIND = 1;
	/**
	 * 绑定状态之：未绑定
	 */
	CONST CONNECT_STATUS_NOT_BIND = 2;
	
    static private $typeDesc = array(
		self::TYPE_ALIPAY	=> array(
			'id'	=> self::TYPE_ALIPAY,
			'desc'	=> '支付宝',
		),
		
		self::TYPE_QQ	=> array(
			'id'	=> self::TYPE_QQ,
			'desc'	=> '腾讯',
		),
		self::TYPE_WEIXIN	=> array(
			'id'	=> self::TYPE_WEIXIN,
			'desc'	=> '微信',
		),
		
		self::TYPE_WEIBO_SINA	=> array(
			'id'	=> self::TYPE_WEIBO_SINA,
			'desc'	=> '新浪微博',
		),
    );
    

	/**
     *
     * 是否有效的站点id
     * @param int $siteId
     * return Boolean
     */
    static public function isValidSite($siteId) {
		return array_key_exists($siteId, self::$typeDesc);
    }

	/**
	 * 按条件获取信息
	 * @param array $condition
	 * @return array | false
	 */
	public function getsByCondition($condition, $limit  = null, $order = 'create_time asc') {
		$ids = $this->findIdsBy($condition, $limit, $order);
		return $this->gets($ids);
	}
	
	public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}
	
		return array_pop($tmpResult);
	}
	
	public function gets($ids) {
		$result = parent::gets($ids);
		foreach ($result as & $tmpV) {
			$tmpV = $this->UnparseExtend($tmpV);
		}
		return $result;
	}
	
	public function modify($info, $condition = null) {
		$info = parent::parseExtend($info);
		$info['modify_time'] = getCurrentDate();
		return parent::modify($info, $condition);
	}
    
	/**
	 *
	 * 是否绑定，没有绑定过返回false，绑定过则返回connect信息
	 * @param string $connect_uid
	 * @param int $u_source
	 * @return false | array
	 */
    public function hasBind($connect_uid, $type) {
		$condition = array(
			'c_uid'	=> $connect_uid,
			'type'	=> $type,
			'status'=> self::CONNECT_STATUS_BIND,
		);
		$ids = $this->findIdsBy($condition);
		if (!$ids) {
			return false;
		}
		$id = array_pop($ids);
		return $this->get($id);
    }

    /**
     * 不存在时添加信息；存在时转为更新
     * @param array $info 要保存的信息
     * @param array $onDuplicate 如果重复时，需要更新的信息。如果不指定，则使用$info的值，即认为要全部更新
     * @return int | Boolean
     * 		   int：只要存在，无论之前记录是否存在，都会返回记录的id；
     * 		   true：执行成功，但获取记录id时失败；
     * 		   false：执行失败
     */
    public function add(array $info) {
    	
    	$curDate = getCurrentDate();
    	$info['create_time'] = $curDate;
    	$info['modify_time'] = $curDate;
    	$info = $this->parseExtend($info);
    	
    	return parent::add($info);
    }


    /**
     * 绑定某个帐号
     * 1、必须是未绑定的信息
     * 2、同一用户名同一类型下只能有一个绑定信息
     * @param int $connect_id
     * @param array $userInfo 本站用户
     * @return InternalResultTransfer
     */
    public function bindUser($connect_id, $userInfo) {
    	
    	if (!Verify::int($connect_id)) {
    		return InternalResultTransfer::fail('connect_id wrong');
    	}
    	
    	$connect_info = $this->get($connect_id);
    	if (!$connect_info) {
    		return InternalResultTransfer::fail('connect_info wrong');
    	}
    	
    	if ($connect_info['status'] != self::CONNECT_STATUS_NOT_BIND) {
    		return InternalResultTransfer::fail('has bind');
    	}
    	
    	//是否绑定过该登录类型
    	$condition = array();
    	$condition['u_id'] 		= $userInfo['u_id'];
    	$condition['type'] 		= $connect_info['type'];
    	$condition['status']	= UserConnect::CONNECT_STATUS_BIND;
    	$c_info = $this->getsByCondition($condition,1);
    	if ($c_info) {
    		return InternalResultTransfer::fail('only can bind once');
    	}
    	
    	$connect_info['u_name'] = $userInfo['u_name'];
    	$connect_info['u_id'] 	= $userInfo['u_id'];
    	$connect_info['status'] = self::CONNECT_STATUS_BIND;
    	
    	return $this->modify($connect_info);
    }
    
    /**
     * 解绑某个帐号：直接删除这个绑定信息
     * @param int $connect_id
     * @return InternalResultTransfer
     */
    public function unbind($connect_id){
    	if (!Verify::int($connect_id)) {
    		return InternalResultTransfer::fail('connect_id wrong');
    	}
    	 
    	$connect_info = $this->get($connect_id);
    	if (!$connect_info) {
    		return InternalResultTransfer::fail('connect_info wrong');
    	}
    	 
    	if ($connect_info['status'] != self::CONNECT_STATUS_BIND) {
    		return InternalResultTransfer::fail('has not bind');
    	}
    	$result = $this->delete(array('id'=>$connect_id));
    	return $result?InternalResultTransfer::success():InternalResultTransfer::fail('delete fail');
    }
    
    /**
     * 获取登录url，不填类型时返回全部url
     * @return array(1=>支付宝url,2=>qq,3=>微信,4=>微博)
     */
    public function getLoginUrl($type = false) {
    	$return = array();
    	do{
    		
    		$objAlipayConnect = new AlipayConnect();
    		$return[self::TYPE_ALIPAY] = $objAlipayConnect->getAuthorizeURL();
    		if ($type == self::TYPE_ALIPAY) {
    			break;
    		} 
    		
    		$objQQConnect = new QQConnect();
    		$return[self::TYPE_QQ] = $objQQConnect->getAuthorizeURL();
    		if ($type == self::TYPE_QQ) {
    			break;
    		}
    		
    		$objWeiXinConnect = new WeiXinConnect();
    		$return[self::TYPE_WEIXIN] = $objWeiXinConnect->getLoginUrl();
    		if ($type == self::TYPE_WEIXIN) {
    			break;
    		}
    		
    		$objSinaConnect = new SinaConnect();
    		$return[self::TYPE_WEIBO_SINA] = $objSinaConnect->getAuthorizeURL();
    		
    	}while (false);
    	
    	return $return;
    }
    
    static public function getTypesDesc(){
    	return self::$typeDesc;
    }

    /**
     * 每个新关联的帐号在本站的默认随机密码
     * @return string
     */
    static public function getConnectUserPW() {
    	return getUniqueOrderId();
    }
}
<?php
/**
 * 验证码基础类
 */
class UserCode extends DBSpeedyPattern {
	protected $tableName = 'user_code';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
			'id',
			'u_id',
			'mobile',
			'code',
			'create_time',
			'dip',
	);
	
	/**
	 * 验证码过期时间5分钟，单位秒
	 */
	CONST CODE_OUT_TIME = 300;
	
	/**
	 * 验证码发送间隔，单位秒
	 */
	CONST CODE_INTERVAL_TIME = 60;
	
// 	CONST CODE_STATUS_1 = 1;
// 	CONST CODE_STATUS_2 = 2;
// 	CONST CODE_STATUS_3 = 3;

	public function add($info) {
		$info['create_time'] = time();
		$info['dip'] = getClientIp();
		return parent::add($info);
	}
	
	/**
	 * 是否具备给某个手机号发短信的条件
	 * @return InternalResultTransfer fail：原因
	 */
	public function verify() {
		$mobile = Request::r('mobile');
		
		//1、手机号是否可以重置密码
		$res = $this->isMobileCanReset($mobile);
		if (!$res->isSuccess()) {
			return $res;
		}
		//2、发送频率是否频繁
		$results = $this->getsByCondition(array('mobile'=>$mobile), 1);
		if ($results) {
			$code_info = array_pop($results);
			if ((time() - $code_info['create_time']) < self::CODE_INTERVAL_TIME ) {
				$msg = "发送频率过快";
				return InternalResultTransfer::fail($msg);
			}
		}
		return InternalResultTransfer::success();
	}
	
	/**
	 * 某个手机号是否可以重置密码
	 * @param string $mobile
	 * @return InternalResultTransfer
	 */
	public function isMobileCanReset($mobile) {
		
		do{
			if (empty ( $mobile )) {
				$msg = "手机号为空";
				break;
			}
			
			if (!Verify::mobile($mobile)) {
				$msg = "手机号格式不正确";
				break;
			}
			
			$objUserRealInfoFront = new UserRealInfoFront();
			$result = $objUserRealInfoFront->getsByCondition(array('mobile'=>$mobile));
			
			if (!$result) {
				$msg = "未找到该手机号对应的用户";
				break;
			}
			
			if (count($result) >= 2) {
				$msg = "该手机号对应的用户不止一个，请联系客服进行修改！";
				break;
			}
			
			return InternalResultTransfer::success();
			
		}while (false);
		
		return InternalResultTransfer::fail($msg);
	}
	
	/**
	 * 手机号和验证码是否匹配
	 * @return InternalResultTransfer
	 */
	public function verifyMobileAndCode($mobile, $code) {
		
			if (!$code || !is_scalar($code)) {
				return InternalResultTransfer::fail('验证码不正确');
			}
			
			if (!Verify::mobile($mobile)) {
				return InternalResultTransfer::fail('手机号格式不正确');
			}
			
			$result = $this->getsByCondition(array('mobile'=>$mobile), 1 ,'id desc');
			
			if (!$result) {
				return InternalResultTransfer::fail('发送结果未找到');
			}
			
			$res = array_pop($result);
			
			if ($res['code'] != $code) {
				return InternalResultTransfer::fail('验证码不匹配');
			}
			
			if ((time() - $res['create_time']) > self::CODE_OUT_TIME) {
				return InternalResultTransfer::fail('验证码已过期');
			}
			
			return InternalResultTransfer::success();
	}
}
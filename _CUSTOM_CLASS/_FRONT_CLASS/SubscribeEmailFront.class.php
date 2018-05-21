<?php
/**
 *
 * 邮件订阅前端类
 * @author gaoxiaogang@gmail.com
 *
 */
class SubscribeEmailFront{
	/**
	 *
	 * Enter description here ...
	 * @var SubscribeEmail
	 */
	private $objSubscribeEmail;

	public function __construct() {
		$this->objSubscribeEmail = new SubscribeEmail();
	}

	/**
	 *
	 * 添加一条订阅
	 * @param array $info
	 * @return InternalResultTransfer
	 */
	public function add(array $info) {
		if (!isset($info['email']) || empty($info['email'])) {
			return InternalResultTransfer::fail('email不能为空');
		}
		if (!Verify::email($info['email'])) {
			return InternalResultTransfer::fail('email格式不正确');
		}

    	$tmpResult = $this->objSubscribeEmail->add($info);
    	if (!Verify::unsignedInt($tmpResult)) {
			return InternalResultTransfer::fail(DBException::INSERT_FAIL);
    	} else {
    		return InternalResultTransfer::success();
    	}
    }

    /**
     * 编辑订阅信息
     * @param array $info
     */
 	public function modify(array $info, $cas_token = null) {
    	return $this->objSubscribeEmail->modify($info, null, $cas_token);
    }
    
    /**
     * 按邮件地址获取订阅信息
     * @param string $email
     * @param string $limit
     * @param string $order
     * @return array | false
     */
	public function findIdsByEmail($email, $limit = null, $order = 'end_time desc') {
		return $this->objSubscribeEmail->findIdsBy(array('email'=>$email), $limit, $order);
	}
	
	public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}

		return array_pop($tmpResult);
	}

	/**
	 * 批量获取
	 * @param array $ids
	 * @return array 无结果时返回空数组
	 */
	public function gets(array $ids) {
		$userInfo = array();

		if (empty($ids)) {
			return $userInfo;
		}

		return $this->objSubscribeEmail->gets($ids);
	}
	
}
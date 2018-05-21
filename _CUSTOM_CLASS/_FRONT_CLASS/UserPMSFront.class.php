<?php
/*
 * 站内用户短消息前段类
 */
class UserPMSFront {

	public function __construct() {
		$this->objUserPMS = new UserPMS();
	}

	/**
     * 返回所有状态和状态描述
     * @return array
     */
    public function getStatusDesc() {
    	return $this->objUserPMS->getStatusDesc();
    }

	/**
	 * 添加一条短消息
	 * @param int $msgtoid 接收人用户ID
	 * @param int $msgfromid 发送人用户ID
	 * @param string $subject 消息主题
	 * @param string $url  消息链接
	 * @return int | false
	 */
	public function addOnePMS($tableInfo){
		
		$receive_uid = $tableInfo['receive_uid'];
		$subject = $tableInfo['subject'];
		
		if(!Verify::int($receive_uid) || !$subject) return false;
		
		$create_time = getCurrentDate();
		$Info = array(
			'send_uid' 			=> $tableInfo['send_uid']?$tableInfo['send_uid']:0,//0指的是系统发送
			'receive_uid' 		=> $receive_uid,
			'status' 			=> UserPMS::STATUS_NOT_RECEIVING,
			'subject' 			=> $subject,
			'body' 				=> $tableInfo['body'],
			'start_time' 		=> $tableInfo['start_time']?$tableInfo['start_time']:$create_time,
			'end_time' 			=> $tableInfo['end_time']?$tableInfo['end_time']:$create_time,
			'create_time' 		=> getCurrentDate(),
		);

		return $this->objUserPMS->add($Info);
	}

	/**
	 * 批量修短消息为以读消息
	 * @param array $ids
	 * @return InternalResultTransfer
	 */
	public function updatePMSsToReceive(array $ids){
		$tableInfo = array(
			'status' => UserPMS::STATUS_RECEIVING,
		);
		$condition = array(
			'id' => $ids,
		);
		return $this->objUserPMS->update($tableInfo, $condition);
	}

	/**
	 * 删除一条站内短信
	 * @return InternalResultTransfer
	 */
	public function delOnePMS($id){
		return $this->updatePMSsToDelete(array('id' => $id));
	}
	
	/**
	 * 批量修短消息为以读消息-这里只用于后台管理前端请勿调用此功能
	 * @param array $ids
	 * @return InternalResultTransfer
	 */
	public function updatePMSsToDelete(array $ids){
		$tableInfo = array(
			'status' => UserPMS::STATUS_DELETE,
		);
		$condition = array(
			'id' => $ids,
		);
		return $this->objUserPMS->update($tableInfo, $condition);
	}

	/**
	 * 通过条件获取当前用户的消息
	 */
	public function findIdsByPMS(array $condition = null, $limit = null, $order = 'create_time desc'){
		return $this->objUserPMS->findIdsBy($condition, $limit, $order);
	}
	
	/**
	 * 通过条件获取当前用户的消息
	 */
	public function getsByCondition(array $condition = null, $limit = null, $order = 'create_time desc'){
		$ids = $this->objUserPMS->findIdsBy($condition, $limit, $order);
		if ($ids) {
			return $this->getPMSs($ids);
		}
		return array();
	}
	
	public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition =  array(), $limit = null, $order = 'create_time desc') {
    	return $this->objUserPMS->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
    /**
     * 获取未读的短消息
     * @param int $u_id
     */
    public function getUnRecieviSum($u_id) {
    	return $this->objUserPMS->getUnRecieviSum($u_id);
    }
    
	/**
	 * 通过IDs批量获取消息
	 */
	public function getPMSs($ids){
		return $this->objUserPMS->gets($ids);
	}

	/**
	 * 通过ID获取一条消息
	 */
	public function getOnePMS($id){
	  return $this->objUserPMS->get($id);

	}
    
	
}
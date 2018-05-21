<?php
/*
 * 站内用户提醒前段类
 */
class UserRemindFront {
	
	public function __construct() {
		$this->objUserRemind = new UserRemind();
	}
	
	/**
	 * 通过ID获取一条提醒
	 */
	public function getOneRemind($id){
	  return $this->objUserRemind->getOneRemind($id);
	}
	
	/**
	 * 清空用户提醒[站内信]
	 */
	public function clearRemind_Pms($uid){
		$tableInfo = array(
			'pms_ids' => serialize(array()),
		);
		$condition = array(
			'id' => $uid,
		);
		return $this->objUserRemind->modifiedRemind($tableInfo, $condition);
	}
	
	/**
	 * 添加或修改一条提醒[站内信]
	 */
	public function replaceOneRemind_Pms($uid,$Pms_id){
		$remindData = $this->objUserRemind->getOneRemind($uid);
		if(isset($remindData['pms_ids'])){
			$pms_ids = unserialize($remindData['pms_ids']);
			if(count($pms_ids) >= 3){
				array_shift($pms_ids);
			}
			array_push($pms_ids,$Pms_id);
			
			$tableInfo = array(
			'id' => $uid,
			'pms_ids' => serialize($pms_ids)
			);
		}else{
			$tableInfo = array(
			'id' => $uid,
			'pms_ids' => serialize(array($Pms_id))
			);
		}
		return $this->objUserRemind -> replaceOneRemind($tableInfo);
	}
	
	/**
	 * 删除一条提醒[站内信]
	 */
	public function delRemind_Pms($uid,$Pms_id){
		$remindData = $this->objUserRemind->getOneRemind($uid);
		if(!isset($remindData['pms_ids'])) return false;
		$pms_ids = unserialize($remindData['pms_ids']);
		$i = 0;
		while ($i < 3){
			if($pms_ids[$i] == $Pms_id){
        		unset($pms_ids[$i]);
        		break;
        	}
        	$i++;
		}
		$tableInfo = array(
			pms_ids => serialize($pms_ids)
		);
		return $this->objUserRemind->modifiedRemind($tableInfo, array('id' => $uid));
	}
	
	
	
}
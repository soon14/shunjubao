<?php
/*
 * 站内用户提醒后端类
 */
class UserRemind extends DBAbstract{
	protected $tableName = 'user_remind';
	protected $primaryKey = 'id';
	
	
	/*
	 * 添加或修改一条[提醒]
	 */
	public function replaceOneRemind(array $tableInfo){
		return $this->replace($tableInfo);
	}
	
	/*
	 * 获取用户的[提醒]
	 */
	public function getOneRemind($id){
		if(!isInt($id)) return false;
		return $this->get($id);
	}
	
	/*
	 * 修改
	 */
	public function modifiedRemind( array $tableInfo, array $condition){
		return $this->update($tableInfo, $condition);
	}
		
}
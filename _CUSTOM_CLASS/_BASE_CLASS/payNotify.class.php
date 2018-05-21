<?php
/**
 * 支付平台流水日志后端类
 * @author lihuanchun
 */
class payNotify extends DaoAbstract {
	protected $tableName = 'pay_notify';

	/**
	 * 添加一条日志
	 *
	 * @param array $tableInfo
	 * @return boolean
	 */
	public function add(array $tableInfo) {
		if (empty($tableInfo)) return false;
		return $this->create($tableInfo, false);
	}

}
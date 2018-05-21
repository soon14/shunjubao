<?php
/**
 *
 * 后台操作日志前端类
 * @author lishuming@gaojie100.com
 *
 */
class OperateRecordFront {
	/**
	 *
	 * @var OperateRecord
	 */
	protected $objOperateRecord;

	public function __construct() {
		$this->objOperateRecord = new OperateRecord();
	}

	/**
	 * 创建
	 * @param array $info
	 * @return int or false
	 */
	public function add($info) {
		$info['create_time'] = getCurrentDate();
		$info['o_uid'] = Runtime::getUid();
		$info['o_uname'] = Runtime::getUname();
		return $this->objOperateRecord->add($info);
	}
	
	/**
	 * 按条件获取信息
	 * @param array $condition
	 * @return array | false
	 */
	public function getsByCondition($condition, $limit  = null, $order = 'create_time asc') {
		$ids = $this->objOperateRecord->findIdsBy($condition, $limit, $order);
		return $this->gets($ids);
	}
	
	public function getsByCondtionWithField($start, $end, $field = 'create_time', $condition = null, $limit = null, $order = 'create_time desc') {
		$infos = $this->objOperateRecord->getsByCondtionWithField($start, $end, $field,$condition,$limit, $order);
		foreach ($infos as $key=>&$value) {
			$value = $this->objOperateRecord->UnparseExtend($value);
		}
		return $infos;
	}
	
	public function getNum($start, $end, $type) {
		return $this->objOperateRecord->getNum($start, $end, $type);
	}
	
	public function get($id) {
		return $this->objOperateRecord->get($id);
	}
	
	public function gets($ids) {
		return $this->objOperateRecord->gets($ids);
	}
	
	public function modify($info, $condition = null) {
		return $this->objOperateRecord->modify($info, $condition);
	}	
}
<?php
class UserPayTypeFront {
	protected $objUserPayType;


	public function __construct() {
		$this->objUserPayType = new UserPayType();
	}

	/**
	 * 添加记录
	 */
	public function add($info)
	{
		return $this->objUserPayType->add($info);
	}

	/**
	 * 根据uid查询信息
	 */
	public function getByUid($uid)
	{
		return $this->objUserPayType->getByUid($uid);
	}
}
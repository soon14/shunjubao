<?php
abstract class AbstractFront {
	/**
	 * @var DBSpeedyPattern
	 */
    protected $objMain;

    public function __construct() {
    	$this->setMainObject();
    }

    /**
     * 每一个该类的子类，都要实现该方法
     */
    abstract public function setMainObject();

    public function totals() {
        return $this->objMain->totals();
    }

    public function get($id) {
        $result = $this->gets(array($id));
        if (!$result) {
            return false;
        }
        return array_pop($result);
    }

    public function gets(array $ids) {
        $result = $this->objMain->gets($ids);
        return $result;
    }

    public function getsAll($limit = null, $order = null) {
        $ids = $this->objMain->getsAllIds($order, $limit);
        return $this->gets($ids);
    }
}
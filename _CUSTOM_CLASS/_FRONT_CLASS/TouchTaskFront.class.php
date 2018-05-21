<?php
/**
 * 接触任务 前端类
 * @author gaoxiaogang@gmail.com
 *
 */
class TouchTaskFront {
	/**
	 *
	 * Enter description here ...
	 * @var TouchTask
	 */
	private $objTouchTask;

	public function __construct() {
		$this->objTouchTask = new TouchTask();
	}

	public function get($id) {
        $result = $this->gets(array($id));
        if (!$result) {
            return false;
        }

        return array_pop($result);
    }

    /**
     * 批量获取
     * @param array $ids
     * @return array 无结果时返回空数组
     */
    public function gets(array $ids) {
        $return = array();

        if (empty($ids)) {
            return $return;
        }

        $return = $this->objTouchTask->gets($ids);
        return $return;
    }

	public function add(array $info) {
		if (!isset($info['status'])) {
			$info['status'] = TouchTask::STATUS_WAIT_PROCESS;
		}
		return $this->objTouchTask->add($info);
	}


	/**
     *
     * 获取指定状态的促销信息集
     * @param mixed $status 状态。默认为null，即不限
     * @param mixed $type 类型。默认为null，即不限
     * @param mixed | string $orderBy 排序。默认按开始时间升序
     * @param mixed $limit 分页。默认为null
     * @return array
     */
    public function getsByCond(array $cond, $orderBy = 'start_time asc', $limit = null) {
		$ids = $this->objTouchTask->findIdsBy($cond, $limit, $orderBy);
		return $this->gets($ids);
    }
}

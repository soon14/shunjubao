<?php
/**
 *
 * 消息队列前端抽象类
 * @author gxg
 *
 */
abstract class AbstractMessageQueueFront {
	/**
	 *
	 * Enter description here ...
	 * @var MessageQueue
	 */
	protected  $objMessageQueue;

	/**
	 *
	 * 由继承类设置
	 * @var string
	 */
	protected $namespace;

	public function __construct() {
		$this->objMessageQueue = new MessageQueue();
	}

	/**
     * 删除一条消息
     * @see DBAbstract::delete()
     * @return Boolean
     */
    public function delete($id) {
		return $this->objMessageQueue->delete($id);
    }

    /**
     * 添加一条消息
     * @see DBSpeedyPattern::add()
     * @return InternalResultTransfer
     */
    public function add(array $info) {
    	$info['ns'] = $this->namespace;
    	return $this->objMessageQueue->add($info);
    }

    /**
     *
     * 延迟指定消息$id在原waiting_time基础上再推后$ts秒处理
     * @param int $id 消息id
     * @param int $ts 要延迟的秒数
     * @param string $reason 延迟原因。默认为空
     * @return InternalResultTransfer
     */
    public function delay($id, $ts, $reason = null) {
    	return $this->objMessageQueue->delay($id, $ts, $reason);
    }

	/**
	 *
	 * 获取最早的$limit条消息
	 * @param mixed $limit
	 * @return array
	 */
	public function getsFirst($limit = 20) {
		return $this->objMessageQueue->getsByNS($this->namespace, $limit);
	}
}
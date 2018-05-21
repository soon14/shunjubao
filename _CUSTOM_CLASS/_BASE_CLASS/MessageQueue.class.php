<?php
/**
 *
 * 通用的消息队列
 * @author gxg
 *
 */
class MessageQueue extends DBSpeedyPattern {
	protected $tableName = 'message_queue';

	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $other_field = array(
        'ns',// 命名空间
    	'waiting_time',// 等待处理的时间
        'try_times',// 因处理失败而重复尝试次数
    );

    /**
     *
     * 获取指定命名空间的$limit条消息队列
     * @param string $ns 命名空间
     * @param mixed $limit
     * @return array
     */
    public function getsByNS($ns, $limit = 20) {
		$cond = array(
			'waiting_time'	=> SqlHelper::addCompareOperator('<=', time()),
			'ns'	=> $ns,
		);
		$order = "waiting_time ASC";
		$ids = $this->findIdsBy($cond, $limit, $order);
		return $this->gets($ids);
    }

    /**
     * 删除一条消息
     * @see DBAbstract::delete()
     * @return Boolean
     */
    public function delete($id) {
    	$cond = array(
    		$this->primaryKey => $id,
    	);
    	return parent::delete($cond);
    }

    /**
     * 添加一条消息
     * @see DBSpeedyPattern::add()
     * @return InternalResultTransfer
     */
    public function add(array $info) {
		if (!isset($info['ns'])) {
			return InternalResultTransfer::fail("请指定命名空间ns");
		}

		if (!isset($info['waiting_time']) || !Verify::int(isset($info['waiting_time']))) {
			$info['waiting_time'] = time();
    	}

    	$tmpResult = parent::add($info);
    	if ($tmpResult && Verify::int($tmpResult)) {
    		$id = $tmpResult;
    		return InternalResultTransfer::success($id);
    	}

    	return InternalResultTransfer::fail();
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
    	if (!Verify::int($id)) {
    		return InternalResultTransfer::fail(ParamsException::INVALID_ID);
    	}
    	if (!Verify::int($ts)) {
    		return InternalResultTransfer::fail(ParamsException::INVALID_INT);
    	}

    	$modify_info = array(
    		$this->primaryKey	=> $id,
    		'try_times'			=> SqlHelper::wrapperNoQuote("`try_times` + 1"),
    		'waiting_time'		=> SqlHelper::wrapperNoQuote("`waiting_time` + {$ts}"),
    	);
    	if (isset($reason)) {
    		$modify_info['delay_reason'] = $reason;
    	}
    	return $this->modify($modify_info);
    }
}

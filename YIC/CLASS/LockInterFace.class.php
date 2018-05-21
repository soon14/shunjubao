<?php
interface LockInterFace {
	/**
	 * 获取指定标志的锁
	 *
	 * @param string $lockId 锁标志
	 * @param int $lockTime 锁定时间，以秒为单位
	 */
    public function getLock($lockId, $lockTime);

    /**
     * 释放指定标志的锁
     *
     * @param string $lockId 锁标志
     */
    public function releaseLock($lockId);
}
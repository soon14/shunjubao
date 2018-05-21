<?php
class MemcacheLock implements LockInterFace {
	/**
	 * 缓存操作的实例
	 *
	 * @var CacheInterface
	 */
	protected $objCache;
	public function __construct(CacheInterface $objCache) {
        $this->objCache = $objCache;
	}

	/**
	 * 获取锁，基于Memcached的方法add提供的原子操作达到独占锁的目的。
	 *
	 * @param string $lockId 锁标志
	 * @param int $lock_timeout 锁超时，单位秒;该值千万不要设零，否则该锁将一直被占用！
	 * @return Boolean
	 */
    public function getLock($lockId, $lock_timeout) {
    	if($lock_timeout <=0 ) {
    		$lock_timeout = 60;
    	}
    	$lockFlag = 1;//随便什么值，只是为了能存储
        return $this->objCache->add($lockId, $lockFlag, $lock_timeout);
    }

    /**
     * 释放锁
     *
     * @param string 锁标志 $lockId
     */
    public function releaseLock($lockId) {
        $this->objCache->clear($lockId);
    }
}
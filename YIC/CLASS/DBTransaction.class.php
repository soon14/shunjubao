<?php
/**
 * 数据库事务类
 * 主要是包装 MySQLite 的事务方法。供前端类、前端php响应页面调用。
 * @author gaoxiaogang@gmail.com
 *
 */
class DBTransaction {

    /**
     * 数据库实例
     *
     * @var MySQLite
     */
    protected $db;

    public function __construct($master_flag = 'default') {
        global $CACHE;
        if (!isset($CACHE['db']) || !is_array($CACHE['db'])) {
            throw new ParamsException('依赖的$CACHE[\'db\']数据结构无效');
        }

        if (!isset($CACHE['db'][$master_flag]) || !is_string($CACHE['db'][$master_flag])) {
            throw new ParamsException("传递进来的主库标志对应的dsn不存在：{$master_flag}");
        }
        $dsn = $CACHE['db'][$master_flag];
        $this->db = new MySQLite($dsn);
    }

    /**
     * 开始事务
     * @return false | string false：失败；string：成功返回事务标志
     */
    public function start() {
    	return $this->db->startTransaction();
    }

    /**
     * 提交事务
     * @param string $strTransactionId
     * @return Boolean
     */
    public function commit($strTransactionId) {
    	return $this->db->commit($strTransactionId);
    }

    /**
     * 回滚事务
     * @param string $strTransactionId
     * @return Boolean
     */
    public function rollback($strTransactionId) {
        return $this->db->rollback($strTransactionId);
    }

    /**
     *
     * 开始使用主库。后续的所有读查询，都会被强制到主库
     *
     * @return String 返回一串标志，供$this->restore 方法使用，用于恢复上一个状态
     */
    public function beginUseMaster() {
    	return $this->db->beginUseMaster();
    }

    /**
     * 恢复采用 $strMasterStatusId 为句柄保存的上次的状态
     *
     * @param String $strMasterStatusId
     * @return Boolean
     *
     */
    public function restore($strMasterStatusId) {
    	return $this->db->restore($strMasterStatusId);
    }
}
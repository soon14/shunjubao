<?php
/**
 * 统计表的公共抽象类
 * ps:统计表是为性能优化而出现的。有相似特点
 * @author gaoxiaogang@gmail.com
 *
 */
abstract class TotalAbstract extends DaoAbstract {
	/**
	 * 存放统计数的字段名
	 * @var string
	 */
	protected $totalKey = 'total';

    public function __construct() {
        if(!isset($this->primary_key)) {
        	throw new Exception('请先指定统计表的主键名');
        }
        parent::__construct();
    }

    /**
     * 批量递增
     * @param array $primaryValues
     * @param int $value
     * @return boolean
     */
    public function batchIncr(array $primaryValues, $value = 1) {
        if(!isInt($value) || $value < 1) return false;

        if (empty($primaryValues)) {
            return false;
        }

        $sql = "INSERT INTO {$this->tableName} (`{$this->primary_key}`, `{$this->totalKey}`) VALUES ";

        $sqlSegment = array();
        foreach ($primaryValues as $primaryValue) {
            if(!isInt($primaryValue) || $primaryValue < 1) {
                continue;
            }
            $sqlSegment[] = "({$primaryValue}, {$value})";
        }
        if (empty($sqlSegment)) {
            return false;
        }
        $sql .= implode(',', $sqlSegment);

        $sql .= "
            ON DUPLICATE KEY UPDATE
            `{$this->totalKey}` = `{$this->totalKey}` + VALUES({$this->totalKey})
            ;
        ";
        return $this->db->query($sql);
    }

    /**
     * 统计数加1
     * @param int $primaryValue
     * @param int $value 递增的步长
     * @throws '无效的主键值'
     * @throws '无效的递增值'
     * @return false：失败；>0的int：成功，返回递增后的值；
     */
    public function incr($primaryValue, $value = 1) {
        if(!isInt($primaryValue) || $primaryValue < 1) {
        	throw new Exception('无效的主键值');
        }
        if(!isInt($value) || $value < 1) {
        	throw new Exception('无效的递增值');
        }

        $sql = "INSERT INTO {$this->tableName} (`{$this->primary_key}`, `{$this->totalKey}`)
            VALUES (
                {$primaryValue}
                , {$value}
            )
            ON DUPLICATE KEY UPDATE
            `{$this->totalKey}` = last_insert_id(`{$this->totalKey}` + {$value})
            ;
        ";
        $result = $this->db->query($sql);
        $affectedRows = $this->mdb->affectedRows();
        if (!isInt($affectedRows)) {
        	return false;
        }

        if ($affectedRows == 1) {
        	return (int) $value;
        } else {
        	$sql = "SELECT LAST_INSERT_ID();";
            $curr_total = $this->mdb->fetchSclare($sql);
            return (int) $curr_total;
        }
    }

    /**
     * 统计数减1
     * ps:`{$this->totalKey}` > 0 只有大于0的才允许减1，否则会产生一个一个能存储的最大整数。
     * @param int $primaryValue
     * @param int $value 递减的步长
     * @return false：失败；int(可能为0)：成功操作后的当前值；
     */
    public function decr($primaryValue, $value = 1) {
    	if(!self::isValidPK($primaryValue)) {
    		throw new Exception('无效的主键值');
    	}
    	if(!isInt($value) || $value < 1) {
    		throw new Exception('无效的递减值');
    	}

        $sql = "UPDATE {$this->tableName} SET `{$this->totalKey}` = last_insert_id(`{$this->totalKey}` - {$value})
            WHERE `{$this->primary_key}` = '{$primaryValue}'
            && `{$this->totalKey}` >= {$value}
            ;
        ";
        $result = $this->mdb->query($sql);
        $affectedRows = $this->mdb->affectedRows();
        if (!isInt($affectedRows) || $affectedRows < 1) {
            return false;
        }

        $sql = "SELECT LAST_INSERT_ID();";
        $curr_total = $this->mdb->fetchSclare($sql);
        return (int) $curr_total;
    }

    /**
     * 获取前$limit个热门
     * @param int $limit
     * @return false | array
     */
    public function getHots($limit) {
    	$condition = array();
        $result = $this->findBy($condition, $this->primary_key, $limit, null, "{$this->totalKey} desc");
        if(empty($result)) return false;
        return $result;
    }

    /**
     * 获取指定主键的总数
     * @param $primaryValue
     * @return int | false
     */
    public function getTotal($primaryValue) {
    	if(!isInt($primaryValue) || $primaryValue < 1) return false;

        $condition = array(
            $this->primary_key => $primaryValue,
        );
        $result = $this->findBy($condition, null, null, " {$this->totalKey} ");
        if(empty($result)) return 0;

        return (int) $result[0][$this->totalKey];
    }
}

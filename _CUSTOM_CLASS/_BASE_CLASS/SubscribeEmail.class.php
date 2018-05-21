<?php
/**
 *
 * 邮件订阅后端类
 * @author gaoxiaogang@gmail.com
 *
 */
class SubscribeEmail extends DBSpeedyPattern {
	protected $tableName = 'subscribe_email ';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'email',
    	'batch',
    	'extend',
    	'create_time',
    	'start_time',
    	'end_time',
        'type',
    );

 	/**
 	 * 创建
 	 * @param array $info
 	 * @return int or false
 	 */
    public function add($info) {
    	$info = parent::parseExtend($info);
    	if (!$info) {
    		return false;
    	}
    	return parent::add($info);
    }
    
    /**
     * 
     * 按条件获取信息
     * @param array $condition
     * @return array | false
     */
    public function getsByCondition($condition, $limit  = null, $order = 'create_time asc') {
    	$ids = $this->findIdsBy($condition);
    	return $this->gets($ids);
    }
    
    public function get($id) {
		$tmpResult = $this->gets(array($id));
		if (!$tmpResult) {
			return false;
		}

		return array_pop($tmpResult);
    }
    
    public function gets($ids) {
    	$result = parent::gets($ids);
    	foreach ($result as & $tmpV) {
            $tmpExtend = array();
            $tmpExtend = unserialize($tmpV['extend']);
            unset($tmpV['extend']);

            # 将存在扩展字段里的信息提出来
            if (is_array($tmpExtend)) foreach ($tmpExtend as $tmpKK => $tmpVV) {
            	if (!in_array($tmpKK, $this->real_field)) {
                    $tmpV[$tmpKK] = $tmpVV;
                }
            }
        }
        return $result;
    }

}
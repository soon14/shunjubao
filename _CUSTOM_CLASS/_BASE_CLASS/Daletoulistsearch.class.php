<?php 
class Daletoulistsearch extends DBSpeedyPattern {
	protected $tableName = 'daletou_detail';

	protected $primaryKey = 'l_id';

    /**
     * 
     * 数据库真实字段
     * @var array
     */
    protected $real_field = array(
    	  'l_id',
		  'd_id',
		  'qishu',
		  'u_id',
		  'titlename',
		  'title',
		  'beishu',
		  'zhushu',
		  'dingqian',
		  'qianqu',
		  'dinghou',
		  'houqu',
		  'price',
		  'buytime',
		  'ischupiao',
		  'buyip',
    );
    
    
    /**
     * 插入一条记录
     * )
     * @return InternalResultTransfer 成功：返回记录，包括用户id；失败：返回失败原因
     */
    public function add(array $info) {
        $info['buyip']=Request::getIpAddress();
        $info['dstates']=0;
        $info['buytime']=time();
        $did = parent::add($info);
        if (!$did) {
        	return InternalResultTransfer::fail('插入信息失败');
        }

        $user = $info;
        $user[$this->primaryKey] = $did;
      	return $did;
    }
    
    public function get_daletou_list($id) {
    	if (empty($id)) {
    		return false;
    	}
    	$condition = array(
    		'u_id'   => trim($id),
    	);
    	$result = $this->findBy($condition, '*','d_id desc');
    	if (!$result) {
    		return false;
    	}
    	return $result;
    }
    public function searchByCondtionWithField($start, $end, $field, $condition = null, $limit = null, $order = null) {
    	$sql = 'select * from '. $this->tableName;
    	$where = '';
    
    	if ($condition) {
    		$where = $this->parseCondition($condition);
    		$where .= ' && ';
    	} else {
    		$where = ' WHERE ';
    	}
    
    	$where .= " {$field} >= '{$start}' && {$field} <= '{$end}' ";
    
    	if ($order) {
    		$where .= " ORDER BY {$order} ";
    	}
    
    	if ($limit) {
    		$where .= " LIMIT {$limit} ";
    	}
    	$sql .= $where;
    	return $this->db->fetchAll($sql);
    }
 
}
?>
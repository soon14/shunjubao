<?php 
class Daletouset extends DBSpeedyPattern {
	protected $tableName = 'daletou_set';

	protected $primaryKey = 'd_id';

    /**
     * 
     * 数据库真实字段
     * @var array
     */
    protected $real_field = array(
    	  'd_id',
		  'qishu',
		  'qianqu',
		  'houqu',
		  'j1',
    	  'j2',
    	  'j3',
    	  'j4',
    	  'j5',
    	  'j6',
    	  'now',
		  'addtime',
    );
    
    
    /**
     * 插入一条记录
     * )
     * @return InternalResultTransfer 成功：返回记录，包括用户id；失败：返回失败原因
     */
    public function add(array $info) {
        $info['addtime']=date("Y-m-d H:i:s",time());
        $did = parent::add($info);
        if (!$did) {
        	return InternalResultTransfer::fail('插入信息失败');
        }

        $user = $info;
        $user[$this->primaryKey] = $did;
      	return $did;
    }
    public function updateset(){
    	$sql="update daletou_set set now=0";
    	return $this->db->query($sql);
    }
    public function get_set_one($condition) {
    	if (empty($condition)) {
    		return false;
    	}
    	
    	$result = $this->findBy($condition, '*','d_id desc');
    	if (!$result) {
    		return false;
    	}
    	return $result;
    }
    public function del_daletou($condition){
    	if (empty($condition)) {
    		return false;
    	}
    	$result = $this->delete($condition);
    	if (!$result) {
    		return false;
    	}else{
			return 1;
    	}
    }
    public function searchByCondtionWithField($start, $end, $field, $condition = null, $limit = null, $order = null) {
    	$sql = 'select * from '. $this->tableName;
    	$where = '';
    
    	if ($condition) {
    		$where = $this->parseCondition($condition);
    		$where .= ' && ';
    	}
    
    	//$where .= " {$field} >= '{$start}' && {$field} <= '{$end}' ";
    
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
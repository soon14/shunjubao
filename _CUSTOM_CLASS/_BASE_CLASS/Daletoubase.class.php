<?php 
class Daletoubase extends DBSpeedyPattern {
	protected $tableName = 'daletou_list';

	protected $primaryKey = 'd_id';

    /**
     * 
     * 数据库真实字段
     * @var array
     */
    protected $real_field = array(
    		'd_id',
    		'u_id',
    		'multinum',
    		'wagercount',
	    	'wagertype',
	    	'wagerstore',
	    	'manner',
	    	'totalmoney',
	    	'lotteryno',
	    	'lotterytype',
	    	'together',
	    	'buytime',
	    	'states',
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
    
    public function success_order_list($condition) {
    	$result = $this->findBy($condition,null,null,'*','d_id asc');
    	if (!$result) {
    		return false;
    	}
    	return $result;
    }
    public function query_dlt($sql) {
    	$result = $this->db->query($sql);
    	return $result;
    }
    public function get_list_operation($qs){
    	$returnAssociateKey=null;
    	$sql="select b.l_id,b.u_id,b.qianqu,b.houqu,b.beishu,b.zhushu,b.price,b.d_id from daletou_list a left join daletou_detail b on a.d_id=b.d_id where a.dstates=1 and b.ischupiao=1 and b.prize_state=0 and b.qishu='$qs'";
    	$result = $this->db->fetchAll($sql, $returnAssociateKey);
    	return $result;
    }
 
}
?>
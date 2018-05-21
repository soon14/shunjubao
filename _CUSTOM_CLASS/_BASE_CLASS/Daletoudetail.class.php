<?php 
class Daletoudetail extends DBSpeedyPattern {
	protected $tableName = 'daletou_detail';

	protected $primaryKey = 'l_id';

    /**
     * 
     * 数据库真实字段
     * @var array
     */
    protected $real_field = array(
    		'd_id',
    		'u_id',
    		'title', // 方式
    		'beishu', // 倍数
    		'zhushu',//注数
	    	'qianqu',//昵称，不超过20个字符
	    	'houqu',
	    	'price',
	    	'buytime',//用户注册ip地址，字符
	    	'ischupiao',// 是否出票 
	    	'buyip',//ip地址
	    	'prize_state',//ip地址
	    	'company_id',//ip地址
	    	'source'
    );
    
    
    /**
     * 创建一个用户
     * )
     * @return InternalResultTransfer 成功：返回用户记录，包括用户id；失败：返回失败原因
     */
    public function add(array $info) {
//     	$name = $info['u_name'];
//         if (empty($password)) {
//             return InternalResultTransfer::fail('password字段不能为空');
//         }
    	$data_list = json_decode(urldecode($info['wagerstore']),true);
    	$totalprice=0;
		foreach($data_list as $key=>$val){
			
			foreach($val as $sonkey=>$sonval){
				$daletou_data_li['titlename'] = trim($sonkey);
				$daletou_data = explode('|',$sonval['wager']);
				
				$daletou_data_li['qianqu'] = trim($daletou_data[1]);
				$daletou_data_li['houqu'] = trim($daletou_data[2]);
				$dingqianqu='';
				$dinghouqu='';
				if(strpos($daletou_data[1],'[')>0){
					$dingqianqu = $this->zhongkuohao($daletou_data[1]);
					$daletou_data_li['qianqu']=$this->guolv($daletou_data[1]);
				}
				if(strpos($daletou_data[2],'[')>0){
					$dinghouqu=$this->zhongkuohao($daletou_data[2]);
					$daletou_data_li['houqu'] = $this->guolv($daletou_data[2]);
				}
				if(empty($dingqianqu) && empty($dinghouqu)){
					$daletou_data_li['title']=1; // 普通
				}else{
					$daletou_data_li['title']=2; // 定胆
				}
				$daletou_data_li['dingqian']=$dingqianqu;
				$daletou_data_li['dinghou']=$dinghouqu;
				
				$daletou_data_li['zhushu'] = $sonval['wc']; // 注数
				$daletou_data_li['beishu']=$info['multinum']; // 倍数
				$daletou_data_li['price'] = $sonval['wc']*2*$info['multinum'];
				$daletou_data_li['u_id']=$info['u_id'];
				$daletou_data_li['d_id']=$info['d_id'];
				$daletou_data_li['qishu']=$info['lotteryno']; // 期数
				$daletou_data_li['buytime']=time();
				$daletou_data_li['ischupiao']=0;
				$daletou_data_li['buyip']=Request::getIpAddress();
				$totalprice +=$daletou_data_li['price'];
			}
			$datali[] = $daletou_data_li;
		}
		$str = array();
		foreach($datali as $key => $val) {
		 	$str[]="('".$val['titlename']."','".$val['title']."','".$val['qianqu']."','".$val['houqu']."','".$val['zhushu']."','".$val['beishu']."','".$val['price']."','".$val['u_id']."','".$val['d_id']."','".$val['buytime']."','".$val['ischupiao']."','".$val['buyip']."','".$val['qishu']."','".$val['dingqian']."','".$val['dinghou']."')";
        }
        $sqlfield="(`titlename`,`title`,`qianqu`,`houqu`,`zhushu`,`beishu`,`price`,`u_id`,`d_id`,`buytime`,`ischupiao`,`buyip`,`qishu`,`dingqian`,`dinghou`)";
        $values=implode(',',$str);
        $sql="INSERT INTO daletou_detail $sqlfield VALUES $values";
        
        //$this->db->query("set names charset utf8");
        if (!$this->db->query($sql)) {
        	return InternalResultTransfer::fail('插入信息失败');
        }
        $re = $this->fumoney($totalprice, $info['u_id']);
        if($re['ok']==1){
        	$updatestatus="update daletou_list set dstates=1 where d_id=".$info['d_id'];
        	$this->db->query($updatestatus);
        	return 1;
        }else{
        	if($re['msg']['error_code']=='9004'){
        		return -1; // 余额不足
        	}else{
        		return -2; // 支付失败
        	}
        }
    }
    
    
    public function get_daletou_list($condition) {
    	$result = $this->findBy($condition,null,null,'*','l_id asc');
    	if (!$result) {
    		return false;
    	}
    	return $result;
    }
    
    public function get_daletou_list_my($uid) {
    	$condition=array('u_id'=>trim($uid));
    	$result = $this->findBy($condition,null,null,'*','l_id asc');
    	if (!$result) {
    		return false;
    	}
    	return $result;
    }
    
    public function chupiao($ren,$idlist){
    	$sql=" update daletou_detail set company_id=1,operate_uname=$ren,ischupiao=1 where l_id in($idlist) and company_id=0 and operate_uname=0 and ischupiao=0";
    	if ($this->db->query($sql)) {
    		return '1'; // success
    	}else{
    		return '-1'; //die
    	}
    }
    public function tuipiao($id){
    	$sql=" update daletou_detail set ischupiao=2 where l_id in($id) and company_id=0 and ischupiao=0";
    	$condition['l_id']=$id;
    	$condition['company_id']=0;
    	$condition['ischupiao']=0;
    	$result = $this->findBy($condition,null,null,'*','l_id asc');
    	$count = count($result);
    	if($count>0){
	    	if ($this->db->query($sql)) {
	    		$condition2['l_id']=$id;
	    		$result = $this->fetchOne($condition2,$selectCols = '*', $order = null);
	    		$money = $result['price'];
	    		$u_id = $result['u_id'];
	    		$re=$this->tuimoney($money,$u_id);
		    	if($re['ok']==1){
		        	return 1;
		        }else{
		        	$sql=" update daletou_detail set ischupiao=0 where l_id in($id) and company_id=0 and ischupiao=0";
		        	$this->db->query($sql);
		        	if($re['msg']['error_code']=='9004'){
		        		return -1; // 余额不足
		        	}else{
		        		return -2; // 支付失败
		        	}
		        }	    		
	    	}else{
	    		return '-1';//die
	    	}
    	}else{
    		return '-2';//die
    	}
    }
    public function update_list($idlist) {
    	$condition =array();
    
    	$result = $this->findBy($condition, '*','l_id asc');
    	if (!$result) {
    		return false;
    	}
    	return $result;
    }
    
    public function tuimoney($money,$u_id){
    	$dtime=time();
    	$php_handle = 'daletou_cash_refund.php';
    	$total = $money*100;
    	 
    	$params=array("time"=>$dtime,
    			"u_id"=>$u_id,
    			"total"=>$total,
    			"appId"=>'3',);
    	 
    	$token = $this->getToken($params);
    	$url = 'http://news.shunjubao.com/api/'.$php_handle.'?token='.$token.'&time='.$dtime.'&u_id='.$u_id.'&total='.$total.'&appId=3';
    	$json = file_get_contents($url);
    	$result = json_decode($json, true);
    	return $result;
    }
    
    public function get($id){
    	$result = $this->gets($id);
    	return $result;
    	
    }
    public function fumoney($money,$u_id){
    	$dtime=time();
    	$php_handle = 'daletou_cash.php';
    	$total = $money*100;
    	
    	$params=array("time"=>$dtime,
    			"u_id"=>$u_id,
    			"total"=>$total,
    			"appId"=>'3',);
    	
    	$token = $this->getToken($params);
    	$url = 'http://news.shunjubao.com/api/'.$php_handle.'?token='.$token.'&time='.$dtime.'&u_id='.$u_id.'&total='.$total.'&appId=3';
    	$json = file_get_contents($url);
    	$result = json_decode($json, true);
		return $result;
    }
	public function getToken($params) {
		
		if (!is_array($params)) return '';
		
		ksort($params);
		
		$string = '';
		
		foreach ($params as $key=>$value) {
			if ($key == 'token') {
				continue;
			}
			$string .= $key . $value;
		}
		//应用id必须有
		$appId = $params['appId'];
		//为你分配的appkey
		$appKey = '9cb6bc11c960e0c7';
		//传输的内容
		$string .= $appKey;
		return substr(md5($string), 8, 16);
}
 
}
?>
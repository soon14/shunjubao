<?php

class DaletouFront {
	
	private  $DaletouBase;
	/**
	 * 大乐透
	 */
	public function __construct() {
    	$this->DaletouBase = new Daletoubase();
    	$this->Daletoudetail = new Daletoudetail();
    	
    }

    

    public function add(array $info) {
    	$did= $this->DaletouBase->add($info);
    	$info['d_id']=$did;
    	$result = $this->Daletoudetail->add($info);    	
    	return $result;
    }
    
    public function get_daletou_list($id) {
    	return $this->DaletouBase->get_daletou_list($id);
    }
    
    public function getsByCondtionWithField($start, $end, $field, $condition = null, $limit = null, $order = 'buytime desc') {
    	return $this->DaletouBase->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
    }
    
   
}
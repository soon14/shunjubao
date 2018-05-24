<?php
/**
 * 支付接口调测例子
 * ================================================================
 * index 进入口，方法中转
 * submitOrderInfo 提交订单信息
 * queryOrder 查询订单
 * 
 * ================================================================
 */
header("Content-type:text/html;charset=utf-8");
require('Utils.class.php');
require('config/config.php');
require('class/RequestHandler.class.php');
require('class/ClientResponseHandler.class.php');
require('class/PayHttpClient.class.php');

Class Request{
    //$url = 'http://192.168.1.185:9000/pay/gateway';

    private $resHandler = null;
    private $reqHandler = null;
    private $pay = null;
    private $cfg = null;
    
    public function __construct(){
        $this->Request();
    }

    public function Request(){
        $this->resHandler = new ClientResponseHandler();
        $this->reqHandler = new RequestHandler();
        $this->pay = new PayHttpClient();
        $this->cfg = new Config();

        $this->reqHandler->setGateUrl($this->cfg->C('url'));
        $this->reqHandler->setKey($this->cfg->C('key'));
    }
    
    public function index(){
        $method = isset($_REQUEST['method'])?$_REQUEST['method']:'submitOrderInfo';
        switch($method){
            case 'submitOrderInfo'://提交订单
		
                $this->submitOrderInfo();
            break;
            case 'queryOrder'://查询订单
                $this->queryOrder();
            break;
            case 'submitRefund'://提交退款
                $this->submitRefund();
            break;
            case 'queryRefund'://查询退款
                $this->queryRefund();
            break;
            case 'callback':
                $this->callback();
            break;
        }
    }
    
    /**
     * 提交订单信息
     */
    public function submitOrderInfo(){
        $this->reqHandler->setReqParams($_GET,array('method'));
        $this->reqHandler->setParameter('service','pay.alipay.native');//接口类型
        $this->reqHandler->setParameter('mch_id',$this->cfg->C('mchId'));//必填项，商户号，由平台分配
        $this->reqHandler->setParameter('notify_url',$this->cfg->C('notify_url'));
        $this->reqHandler->setParameter('version',$this->cfg->C('version'));
        $this->reqHandler->setParameter('nonce_str',mt_rand(time(),time()+rand()));//随机字符串，必填项，不长于 32 位
        $this->reqHandler->createSign();//创建签名
		

		 
        $data = Utils::toXml($this->reqHandler->getAllParameters());
		
		$temp_array =$this->reqHandler->getAllParameters();
		$will_mchId =$this->cfg->C('mchId');
		$will_out_trade_no =$temp_array["out_trade_no"];
		
		
		 
		$keyw = "zy3658786787676";
		$dtime = time();
		$sign = md5($will_out_trade_no.$will_mchId.$keyw.$dtime);
		$turl='http://www.shunjubao.xyz/services/mppay_update.php?will_out_trade_no='.$will_out_trade_no.'&will_mchId='.$will_mchId.'&dtime='.$dtime.'&sign='.$sign; 
		
		$result = file_get_contents($turl);
		//var_dump($result);exit();
		
		
		log_result("ali_sub_log03.txt",$turl); 
		log_result("ali_sub_log02.txt",$will_mchId."_".$will_out_trade_no); 
		 
        //var_dump($data);
       // log_result("ali_sub_log.txt",$data);
        $this->pay->setReqContent($this->reqHandler->getGateURL(),$data);
        if($this->pay->call()){
            $this->resHandler->setContent($this->pay->getResContent());
            $this->resHandler->setKey($this->reqHandler->getKey());
            if($this->resHandler->isTenpaySign()){
				
			//	var_dump($this->resHandler->getParameter('status'));exit();
				
				//log_result("ali_sub_log01.txt",$this->resHandler->getParameter('out_trade_no'));
                //当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
                if($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0){
					
					$code_url = $this->resHandler->getParameter('code_url');
					echo $code_url;
					exit();
					
					$code_img_url = $this->resHandler->getParameter('code_img_url');
					echo '<img src="'.$code_img_url.'" />';
					
                   /* echo json_encode(array('code_img_url'=>$this->resHandler->getParameter('code_img_url'),
                                           'code_url'=>$this->resHandler->getParameter('code_url')));*/
                    exit();
                }else{
                    echo json_encode(array('status'=>500,'msg'=>'Error Code:'.$this->resHandler->getParameter('err_code').' Error Message:'.$this->resHandler->getParameter('err_msg')));
                    exit();
                }
            }
            echo json_encode(array('status'=>500,'msg'=>'Error Code:'.$this->resHandler->getParameter('status').' Error Message:'.$this->resHandler->getParameter('message')));
        }else{
            echo json_encode(array('status'=>500,'msg'=>'Response Code:'.$this->pay->getResponseCode().' Error Info:'.$this->pay->getErrInfo()));
        }
    }

    

    /**
     * 界面显示
     */
    public function queryRefund(){
       
        
    }
    
    /**
     * 异步通知方法，demo中将参数显示在result.txt文件中
     */
    public function callback(){
		
		log_result("ali_callback_log.txt","callback");
		
        $xml = file_get_contents('php://input');
        //$res = Utils::parseXML($xml);
        $this->resHandler->setContent($xml);
		log_result("ali_callback_xml.txt",$xml);
		//var_dump($this->resHandler->setContent($xml));
        $this->resHandler->setKey($this->cfg->C('key'));
        if($this->resHandler->isTenpaySign()){
            if($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0){
				
				log_result("ali_error_log.txt","success_01");
				//echo $this->resHandler->getParameter('status');
				//此处可以在添加相关处理业务，校验通知参数中的商户订单号out_trade_no和金额total_fee是否和商户业务系统的单号和金额是否一致，一致后方可更新数据库表中的记录。
				 echo 'success';
				//更改订单状态
				$out_trade_no = $this->resHandler->getParameter('out_trade_no');
				
				log_result("ali_error_log.txt",$out_trade_no);
				
				$total_fee = $this->resHandler->getParameter('total_fee');
				$total_fee = $total_fee/100;
				$trade_status = $this->resHandler->getParameter('out_trade_no');
				$keyw = "zy3658786787676";
				$dtime = time();
				$sign = md5($out_trade_no.$keyw.$dtime);
				$turl='http://www.shunjubao.xyz/services/mppay_return.php?out_trade_no='.$out_trade_no.'&total_fee='.$total_fee.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$this->cfg->C('mchId');
				log_result("ali_error_log.txt",$turl);
				$result = file_get_contents($turl);
				
				
                Utils::dataRecodes('接口回调,返回通知参数',$this->resHandler->getAllParameters());
                exit();
            }else{
				log_result("ali_error_log.txt","failure_02");
                echo 'failure_02';
                exit();
            }
        }else{
			log_result("ali_error_log.txt","failure_03");
            echo 'failure_03';
        }
    }
}

$req = new Request();
$req->index();


function  log_result($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}


?>
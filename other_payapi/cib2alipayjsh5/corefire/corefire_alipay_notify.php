<?php
/**
 * Created on 2017/03/03
 * @author: xiaobing
 */
require_once "CorefireAliPay.Config.php";
require_once("CorefireAliPay.Api.php");
require_once("CorefireAliPay.Notify.php");

class CorefireAliPayNotifyCallBack extends CorefireAliPayNotify
{
	private $channel = null;
	//查询订单
	public function Queryorder($out_trade_no,$time_end)
	{
		
		//生产时使用真实的商户号、商户appid和商户key代替
		$input = new CorefireAliPayOrderQuery(CorefireAliPayConfig::TEST_MCH_KEY);
		$input->SetAppid(CorefireAliPayConfig::TEST_MCH_APPID);
		$input->SetMch_id(CorefireAliPayConfig::TEST_MCH_ID);
		$input->SetOut_trade_no($out_trade_no);
		$input->SetMethod("mbupay.alipay.query");
		$result = CorefireAliPayApi::orderQuery($input);
		
		if($result['return_code']=='SUCCESS'&&$result['result_code']=='SUCCESS')
		{
            return true;
		}else{
		    return false;
		}
	}
	

	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
// 		Log::DEGUG("aliorder NotifyProcess:".$data);
		
		$this->log_result("corefire_alipay_notify.txt",json_encode($data)); 
		$notfiyOutput = array();
		
		if(!array_key_exists("out_trade_no", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		
		if($data["return_code"]=="SUCCESS"){
			$mchId = $data["mch_id"];	
			$out_trade_no =  $data["out_trade_no"];
			$total_fee =  $data["total_fee"];
			$total_fee = $total_fee/100;
			$trade_status =$data["return_code"];
			
			
			$keyw = "zy3658786787676";
			$dtime = time();
			$sign = md5($out_trade_no.$mchId.$keyw.$dtime);
			$turl2='http://www.zhiying365.com/services/mppay_update.php?will_out_trade_no='.$out_trade_no.'&will_mchId='.$mchId.'&dtime='.$dtime.'&sign='.$sign;
			$result = file_get_contents($turl2);
			$this->log_result("corefire_alipay_notify_url2.txt",$turl2); 	

			$sign = md5($out_trade_no.$keyw.$dtime);
			$turl='http://www.zhiying365.com/services/mppay_return.php?out_trade_no='.$out_trade_no.'&total_fee='.$total_fee.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$mchId;
			$result = file_get_contents($turl);
			$this->log_result("corefire_alipay_notify_url.txt",$turl); 
			
			$turl2='http://www.zhiying365.com/services/mppay_update.php?will_out_trade_no='.$out_trade_no.'&will_mchId='.$mchId.'&dtime='.$dtime.'&sign='.$sign;
			
		
		}
		
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["out_trade_no"],$data["time_end"])){
			$msg = "订单查询失败";
			return false;
		}
		
		$this->log_result("corefire_alipay_notify_url.txt","bbbb"); 
		return true;
	}
	
	public function  log_result($file,$word){
		$fp = fopen($file,"a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	
	
	
	
}
$notify = new CorefireAliPayNotifyCallBack();
$notify->Handle(false);

?>
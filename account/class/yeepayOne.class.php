<?php
/*
*�ױ�֧��
*date 2016-07-19
*/
class yeepayOne{
	public $callbackurl='';
	public $fcallbackurl='';
	
	function __construct(){
		;
	}
	function sendPay($orderid,$money,$userArr){
	   global $_CFG;
	   include("module/yeepayMPay.php");
       $yeepay = new yeepayMPay($_CFG['merchantaccount'],$_CFG['merchantPublicKey'],$_CFG['merchantPrivateKey'],$_CFG['yeepayPublicKey']);
        
		$order_id        =  $orderid;
		$cardno          =  trim($userArr['cardno']);//
		$idcardtype      =  trim($userArr['idcardtype']);//
		$idcard          =  trim($userArr['idcard']);//
		$owner           =  trim($userArr['owner']);//
		$transtime       =  time(); //У��ʱ��
		$amount          =  intval($money*100);  //��ֵ��� ����
		$currency        =  156;
		$product_catalog =  '1';
		$product_name    =  'ticket';
		$product_desc    =  'ticket';
		$identity_type   =  2;  //����
		$identity_id     =  $userArr['userid']; //�û���ʶ  �������û���
		$user_ip         =  $userArr['userip'];  //����
		$user_ua         =  'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36';   //trim($_POST['userua']); //����
		$terminaltype    =  1;  //intval($_POST['terminaltype']);  //����
		$terminalid      =  $userArr['terminalid'];   //trim($_POST['terminalid']); //����
		$callbackurl     =  $this->callbackurl;
		$fcallbackurl     =  $this->fcallbackurl;
		$orderexp_date    =  60;
		$paytypes        = '';
		$version         = '';
       
        $url = $yeepay->webPay($order_id,$transtime,$amount,$cardno,$idcardtype,$idcard,$owner,$product_catalog,$identity_id,$identity_type,$user_ip,$user_ua,
	     $callbackurl,$fcallbackurl,$currency,$product_name,$product_desc,$terminaltype,$terminalid,$orderexp_date,$paytypes,$version);

        if( array_key_exists('error_code', $url))	{
			return;
	    }else{
			$arr = explode("&",$url);
			$encrypt = explode("=",$arr[1]);
			$data = explode("=",$arr[2]); 
			return $url;
		}
	}
	
	function resp(){
		;
	}
	
}
?>

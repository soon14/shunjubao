<?php
/*
 * @Description �ױ�֧����Ʒͨ�ýӿڷ��� 
 * @V3.0
 * @Author xin.li
 */
#ʱ������
date_default_timezone_set('prc');
$_CFG=array();
$_CFG['reqURL_onLine'] = "https://www.yeepay.com/app-merchant-proxy/node";
$_CFG['p1_MerId'] = "10013629852";
$_CFG['merchantKey'] = "dE1202Q77g7WPQTW7NL5h95P7r6t6F734q64Pa27F11to1g4441Y9HS18wL5"; #����ʹ��
$_CFG['logName'] = "YeePay_HTML.log";

// �̻����
$_CFG['merchantaccount'] = '10000418926';
// �̻�˽Կ
$_CFG['merchantPrivateKey'] = 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALD0Tou2w7EHbP3q5wi5PG5xrvC0CBawXxSI1PlZAGo2iFYhaBK6SsB5UiYT64fSR3YemQGS2vSqQii5vYdOfrffvvDprrr7Vo7BziS6sJQ9B0/DzwN2zY7jJBCz55CLMBsZCtuqDNVxTcsOcZnrgSSMqnhk+usuR4hPoV9qABeHAgMBAAECgYAfnth2UOdxN/F7AkHcpjUtSzVGn/UeENA8vCLKl+PiFvKP6ZJOXmnDMSrD0SVydNn+OoN+634i4FXIL0C18Anmh4IlQM9hj+rFTg1bMSUHvSPKoZpoEfjR0R+3TQF8PycBbaIWgLV/5NA8dMld0DvF5d8bbqpgH6FzEXZPvF8OgQJBANwHRhCu+o/JoCoH0coVhNFuobVYZU0pQRlfDaE4ph0+daiJ4HlT630JrBFb728Ga7E81dsfGMSi1N6QSipJMEECQQDN4kb+O/ecDNQrEsjA0LqDXkaKsRP6iU/HVNyr4Z/7ojHws0F5Vypj1euCII+V6U7StMKRbSaB1GI8Bs34llXHAkEAnIc0KiRBLk+S+LOtZGVgoplgwyEKmBUUMdd0W9BwJHfNvkOwBMBV1BMwbP0JXeOkc2dDAGqj9Sed5mOhz2lXwQJAVeA0TIcm2Ohg9zZ2ljZ6FaGVOvRxqObtZ+91vBv4ZzVYL1YV0U8SV2I7QaPjQFx4jFrpbU9h6HV2JCOSdkX+sQJBAJ+PfNA0b25HuY9n4cTk/hLc2TCWVDsPnONuhNpuRpXqxu9L0p2aHX5JLf1kTUoYxqmlEjx6IYcObcB9Snw0Tf0=';
// �̻���Կ
$_CFG['merchantPublicKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCw9E6LtsOxB2z96ucIuTxuca7wtAgWsF8UiNT5WQBqNohWIWgSukrAeVImE+uH0kd2HpkBktr0qkIoub2HTn63377w6a66+1aOwc4kurCUPQdPw88Dds2O4yQQs+eQizAbGQrbqgzVcU3LDnGZ64EkjKp4ZPrrLkeIT6FfagAXhwIDAQAB';
// �ױ���Կ
$_CFG['yeepayPublicKey'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCKcSa7wS6OMUL4oTzJLCBsE5KTkPz9OTSiOU6356BsR6gzQ9kf/xa+Wi1ZANTeNuTYFyhlCI7ZCLW7QNzwAYSFStKzP3UlUzsfrV7zge8gTgJSwC/avsZPCWMDrniC3HiZ70l1mMBK5pL0H6NbBFJ6XgDIw160aO9AxFZa5pfCcwIDAQAB';

	
#ǩ����������ǩ����
function getReqHmacString($p0_Cmd,$p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$p9_SAF,$pa_MP,$pd_FrpId,$pm_Period,$pn_Unit,$pr_NeedResponse)
{
	include 'merchantProperties.php';
	
	#����ǩ������һ�������ĵ��б�����ǩ��˳�����
  $sbOld = "";
  #����ҵ������
  $sbOld = $sbOld.$p0_Cmd;
  #�����̻����
  $sbOld = $sbOld.$p1_MerId;
  #�����̻�������
  $sbOld = $sbOld.$p2_Order;     
  #����֧�����
  $sbOld = $sbOld.$p3_Amt;
  #���뽻�ױ���
  $sbOld = $sbOld.$p4_Cur;
  #������Ʒ����
  $sbOld = $sbOld.$p5_Pid;
  #������Ʒ����
  $sbOld = $sbOld.$p6_Pcat;
  #������Ʒ����
  $sbOld = $sbOld.$p7_Pdesc;
  #�����̻�����֧���ɹ����ݵĵ�ַ
  $sbOld = $sbOld.$p8_Url;
  #�����ͻ���ַ��ʶ
  $sbOld = $sbOld.$p9_SAF;
  #�����̻���չ��Ϣ
  $sbOld = $sbOld.$pa_MP;
  #����֧��ͨ������
  $sbOld = $sbOld.$pd_FrpId;
  #���붩����Ч��
  $sbOld = $sbOld.$pm_Period;
  #���붩����Ч�ڵ�λ
  $sbOld = $sbOld.$pn_Unit;
  #�����Ƿ���ҪӦ�����
  $sbOld = $sbOld.$pr_NeedResponse;
//  echo $sbOld;
	logstr($p2_Order,$sbOld,HmacMd5($sbOld,$merchantKey));
  return HmacMd5($sbOld,$merchantKey);
  
} 

function getCallbackHmacString($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType)
{
  
	include 'merchantProperties.php';
  
	#ȡ�ü���ǰ���ַ���
	$sbOld = "";
	#�����̼�ID
	$sbOld = $sbOld.$p1_MerId;
	#������Ϣ����
	$sbOld = $sbOld.$r0_Cmd;
	#����ҵ�񷵻���
	$sbOld = $sbOld.$r1_Code;
	#���뽻��ID
	$sbOld = $sbOld.$r2_TrxId;
	#���뽻�׽��
	$sbOld = $sbOld.$r3_Amt;
	#������ҵ�λ
	$sbOld = $sbOld.$r4_Cur;
	#�����ƷId
	$sbOld = $sbOld.$r5_Pid;
	#���붩��ID
	$sbOld = $sbOld.$r6_Order;
	#�����û�ID
	$sbOld = $sbOld.$r7_Uid;
	#�����̼���չ��Ϣ
	$sbOld = $sbOld.$r8_MP;
	#���뽻�׽����������
	$sbOld = $sbOld.$r9_BType;

	logstr($r6_Order,$sbOld,HmacMd5($sbOld,$merchantKey));
	return HmacMd5($sbOld,$merchantKey);

}


#	ȡ�÷��ش��е����в���
function getCallBackValue(&$r0_Cmd,&$r1_Code,&$r2_TrxId,&$r3_Amt,&$r4_Cur,&$r5_Pid,&$r6_Order,&$r7_Uid,&$r8_MP,&$r9_BType,&$hmac)
{  
	$r0_Cmd		= $_REQUEST['r0_Cmd'];
	$r1_Code	= $_REQUEST['r1_Code'];
	$r2_TrxId	= $_REQUEST['r2_TrxId'];
	$r3_Amt		= $_REQUEST['r3_Amt'];
	$r4_Cur		= $_REQUEST['r4_Cur'];
	$r5_Pid		= $_REQUEST['r5_Pid'];
	$r6_Order	= $_REQUEST['r6_Order'];
	$r7_Uid		= $_REQUEST['r7_Uid'];
	$r8_MP		= $_REQUEST['r8_MP'];
	$r9_BType	= $_REQUEST['r9_BType']; 
	$hmac			= $_REQUEST['hmac'];
	
	return null;
}

function CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac)
{
	if($hmac==getCallbackHmacString($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType))
		return true;
	else
		return false;
}
		
function getCzHmacString($p0_Cmd,$p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pa_Ext,$pb_Oper,$pd_FrpId,$pd_BankBranch,$pt_ActId,$pv_Ver)
{
	include 'merchantProperties.php';
		
	#����ǩ������һ�������ĵ��б�����ǩ��˳�����
  $sbOld = "";
  #����ҵ������
  $sbOld = $sbOld.$p0_Cmd;
  #�����̻����
  $sbOld = $sbOld.$p1_MerId;
  #�����̻�������
  $sbOld = $sbOld.$p2_Order;     
  #����֧�����
  $sbOld = $sbOld.$p3_Amt;
  #���뽻�ױ���
  $sbOld = $sbOld.$p4_Cur;
  #������Ʒ����
  $sbOld = $sbOld.$p5_Pid;
  #������Ʒ����
  $sbOld = $sbOld.$p6_Pcat;
  #������Ʒ����
  $sbOld = $sbOld.$p7_Pdesc;
  #�����̻�����֧���ɹ����ݵĵ�ַ
  $sbOld = $sbOld.$p8_Url;
  #�����̻���չ��Ϣ
  $sbOld = $sbOld.$pa_MP;
  #	��չ����
  $sbOld	= $sbOld.$pa_Ext;
  #	����Ա
  $sbOld	= $sbOld.$pb_Oper;
  #	֧��ͨ������
  $sbOld  = $sbOld.$pd_FrpId;
  #	���з���
  $sbOld  = $sbOld.$pd_BankBranch;
  #	��ֵĿ���˺�
  $sbOld  = $sbOld.$pt_ActId;
  #	�汾��
  $sbOld  = $sbOld.$pv_Ver;
  
	logstr($p2_Order,$sbOld,HmacMd5($sbOld,$merchantKey));
  return HmacMd5($sbOld,$merchantKey); 
}   


function HmacMd5($data,$key)
{
// RFC 2104 HMAC implementation for php.
// Creates an md5 HMAC.
// Eliminates the need to install mhash to compute a HMAC
// Hacked by Lance Rushing(NOTE: Hacked means written)

//��Ҫ���û���֧��iconv���������Ĳ���������������
$key = iconv("GBK","UTF-8",$key);
$data = iconv("GBK","UTF-8",$data);
$b = 64; // byte length for md5
if (strlen($key) > $b) {
$key = pack("H*",md5($key));
}
$key = str_pad($key, $b, chr(0x00));
$ipad = str_pad('', $b, chr(0x36));
$opad = str_pad('', $b, chr(0x5c));
$k_ipad = $key ^ $ipad ;
$k_opad = $key ^ $opad;

return md5($k_opad . pack("H*",md5($k_ipad . $data)));
}

function logstr($orderid,$str,$hmac)
{
include 'merchantProperties.php';
$james=fopen($logName,"a+");
fwrite($james,"\r\n".date("Y-m-d H:i:s")."|orderid[".$orderid."]|str[".$str."]|hmac[".$hmac."]");
fclose($james);
}

?> 

<?php
/*
*易宝支付
*date 2016-07-19
*/
class yeepay{
	public $p0_Cmd = "Buy";
	##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
	public $p2_Order = '';
	public $p3_Amt	= 0; //支付金额,必填.以“分”为单位
	public $p4_Cur = "CNY";
	##用于支付时显示在易宝支付网关左侧的订单产品信息.
	public $p5_Pid = '';
	public $p6_Pcat = '';
	public $p7_Pdesc = '';
	public $p8_Url = 'http://www.zhiying365365.com/services/yeepay_return.php'; //通知地址 发送2次	
	//商户可以任意填写1K 的字符串,支付成功时将原样返回.												
	public $pa_MP = '';
	//扩展属性
	public $pa_Ext = '';
	//操作员
	public $pb_Oper = 'admin';
	//	支付通道编码
	//默认为""，到易宝支付网关.若不需显示易宝支付的页面，直接跳转到各银行支付页面，该字段可依照附录:银行列表设置参数值.			
	public $pd_FrpId = "";
	//银行分行
	public $pd_BankBranch	= "";
	//充值目标账号
	public $pt_ActId  = "0";
	public $p9_SAF="0"; //送货地址
	//版本号
	public $pv_Ver	=  "2.0";
	public $pm_Period="7";
	public $pn_Unit="day";
	public $pr_NeedResponse="1";
	function __construct(){
		;
	}
	function sendPay($orderid,$money,$pd_FrpId){
		global $_CFG;
		$this->p2_Order=$orderid;
		$this->p3_Amt=$money;
		$this->pd_FrpId=$pd_FrpId;
		$hmac=getReqHmacString($this->p0_Cmd,$this->p2_Order,$this->p3_Amt,$this->p4_Cur,$this->p5_Pid,$this->p6_Pcat,$this->p7_Pdesc,$this->p8_Url,
		$this->p9_SAF,$this->pa_MP,$this->pd_FrpId,$this->pm_Period,$this->pn_Unit,$this->pr_NeedResponse);
		$str="112";
		$formstr='';
	    $formstr.='<body onload="document.yeepay.submit();">';
		$formstr.='<form name="yeepay" action="'.$_CFG['reqURL_onLine'].'" method="post">';
        $formstr.='<input type="hidden" name="p0_Cmd" value="'.$this->p0_Cmd.'">';
		$formstr.='<input type="hidden" name="p1_MerId" value="'.$_CFG['p1_MerId'].'">';
		$formstr.='<input type="hidden" name="p2_Order" value="'.$this->p2_Order.'">';
		$formstr.='<input type="hidden" name="p3_Amt" value="'.$this->p3_Amt.'">';
		$formstr.='<input type="hidden" name="p4_Cur" value="'.$this->p4_Cur.'">';
		$formstr.='<input type="hidden" name="p5_Pid" value="'.$this->p5_Pid.'">';
		$formstr.='<input type="hidden" name="p6_Pcat" value="'.$this->p6_Pcat.'">';
		$formstr.='<input type="hidden" name="p7_Pdesc" value="'.$this->p7_Pdesc.'">';
		$formstr.='<input type="hidden" name="p8_Url" value="'.$this->p8_Url.'">';
		$formstr.='<input type="hidden" name="p9_SAF" value="'.$this->p9_SAF.'">';
		$formstr.='<input type="hidden" name="pa_MP" value="'.$this->pa_MP.'">';
		$formstr.='<input type="hidden" name="pd_FrpId" value="'.$this->pd_FrpId.'">';
		$formstr.='<input type="hidden" name="pm_Period" value="'.$this->pm_Period.'">';
		$formstr.='<input type="hidden" name="pn_Unit" value="'.$this->pn_Unit.'">';
		$formstr.='<input type="hidden" name="pr_NeedResponse" value="'.$this->pr_NeedResponse.'">';
		$formstr.='<input type="hidden" name="hmac" value="'.$hmac.'">';
		$formstr.='</form></body>';
		
        return $formstr;
	}
	
	function resp(){
		;
	}
	
}
?>

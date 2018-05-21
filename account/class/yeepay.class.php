<?php
/*
*�ױ�֧��
*date 2016-07-19
*/
class yeepay{
	public $p0_Cmd = "Buy";
	##����Ϊ""���ύ�Ķ����ű����������˻�������Ψһ;Ϊ""ʱ���ױ�֧�����Զ�����������̻�������.
	public $p2_Order = '';
	public $p3_Amt	= 0; //֧�����,����.�ԡ��֡�Ϊ��λ
	public $p4_Cur = "CNY";
	##����֧��ʱ��ʾ���ױ�֧���������Ķ�����Ʒ��Ϣ.
	public $p5_Pid = '';
	public $p6_Pcat = '';
	public $p7_Pdesc = '';
	public $p8_Url = 'http://news.shunjubao.com/services/yeepay_return.php'; //֪ͨ��ַ ����2��
	//�̻�����������д1K ���ַ���,֧���ɹ�ʱ��ԭ������.												
	public $pa_MP = '';
	//��չ����
	public $pa_Ext = '';
	//����Ա
	public $pb_Oper = 'admin';
	//	֧��ͨ������
	//Ĭ��Ϊ""�����ױ�֧������.��������ʾ�ױ�֧����ҳ�棬ֱ����ת��������֧��ҳ�棬���ֶο����ո�¼:�����б����ò���ֵ.			
	public $pd_FrpId = "";
	//���з���
	public $pd_BankBranch	= "";
	//��ֵĿ���˺�
	public $pt_ActId  = "0";
	public $p9_SAF="0"; //�ͻ���ַ
	//�汾��
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

TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	var bank_type = '';
	var payment = 0;
//	var provider;   
	var provider = 'alipay';//目前只有支付宝
	$(".charge_cash").click(function(){
		$(".charge_cash").removeClass("active");
		$(this).addClass("active");
		payment = $(this).attr("payment");
		return false;
	});
	$("#inputc1").focus(function(){
		$(".charge_cash").removeClass("active");
		if($(this).val() == '其他金额') $(this).val('');
	});
	$("#inputc1").blur(function(){
		payment = $(this).val();
	});
	$(".pay_bank").click(function(){
		$(".pay_bank").removeClass("active");
		$(this).addClass("active");
		bank_type = $(this).attr("pay_bank");
		return false;
	})
	
    $("#payment").click(function(){
    	
    	var uid = $("#u_id").val();
    	var batch_pay_params = {};
		
		if(payment == 0) {
			alert('请输入支付金额');
			return false;
		}
		
		if(!$.common.Verify.isMoney(payment)) {
			alert('请输入正确金额');
			return false;
		}
		
		if(bank_type=="twjALIPAY"){
			provider = 'twjalipay';
		}
		//alert(provider);
		batch_pay_params.uid = uid;
		batch_pay_params.provider = provider;
		batch_pay_params.payment = payment;
		
		if (typeof(bank_type) == "undefined" || bank_type == '') {
			alert('请选择支付方式');
			return false;
    	} else {
    		batch_pay_params.bank_type = bank_type;
    	}
		
		var url = tmpDomain + "/purchase_process/batch_pay2.php?"+$.param(batch_pay_params);
		$(this).attr("href", url);
		return true;
	});
});
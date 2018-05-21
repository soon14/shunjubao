TMJF(function($) {
	$("#replenish").bind("click", replenish);
	
	$(".replenishRemind").click(function () {
		var SSProdId = $(this).attr('SSProdId');
		var productName = $(this).attr('productName');
		$("#replenishSSProdId").val(SSProdId);
		$("#replenishProdName").html(productName);
		replenish();
	});

	function replenish() {
		var html = $(".modalDialog_body_notice_2").html();
		html = html.replace('replenishMobile', 'reallyReplenishMobile');
		var options = {};
		$.common.MessageBox.show(html, '补货通知', options);
	}
});
function confirmReplenish() {
	var replenishMobile   = TMJF.trim(TMJF("#reallyReplenishMobile").val());
	var replenishSSProdId = TMJF.trim(TMJF("#replenishSSProdId").val());
	var replenishSSProdName = TMJF.trim(TMJF("#replenishProdName").html());

	// 验证手机号
	re= /^(((13|15)|18)[0-9]{9})$/;
	if(!re.test(replenishMobile)){
		alert('请输入合法的手机号码!');
		return false;
    }

	var requestUri = TMJF.conf.domain+"/replenish.php?no-cache=" + Math.random(); 
    TMJF.getJSON(requestUri, {mobile: replenishMobile, ssProdId:replenishSSProdId, ssProdName: replenishSSProdName}, function(ret){
		if (ret.ok)
		{
			var html = TMJF(".modalDialog_body_notice_1").html();
			var options = {};
			TMJF.common.MessageBox.show(html, '补货通知', options);
		}
		else
		{	
			alert(ret.msg.msg);
		}
		
	});   
}

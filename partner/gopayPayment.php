<?php
/**
 * 国付宝post请求支付
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$params = getRequestParams();
$action = $params['action'];
$from = $params['params'];
?>
<form name="gopayForm" action="<?php echo $action; ?>" method="POST">
	<input type="hidden" id="version" name="version" value="<?php echo $from['version'];?>"/>
	<input type="hidden" id="charset" name="charset" value="<?php echo $from['charset'];?>"/>
	<input type="hidden" id="language" name="language" value="<?php echo $from['language'];?>"/>
	<input type="hidden" id="signType" name="signType" value="<?php echo $from['signType'];?>"/>
	<input type="hidden" id="tranCode" name="tranCode" value="<?php echo $from['tranCode'];?>"/>
	<input type="hidden" id="merchantID" name="merchantID" value="<?php echo $from['merchantID'];?>"/>
	<input type="hidden" id="merOrderNum" name="merOrderNum" value="<?php echo $from['merOrderNum'];?>" />
	<input type="hidden" id="tranAmt" name="tranAmt" value="<?php echo $from['tranAmt'];?>"/>
	<input type="hidden" id="feeAmt" name="feeAmt" value="<?php echo $from['feeAmt'];?>"/>
	<input type="hidden" id="currencyType" name="currencyType" value="<?php echo $from['currencyType'];?>"/>
	<input type="hidden"  id="frontMerUrl" name="frontMerUrl" value="<?php echo $from['frontMerUrl'];?>"/>
	<input type="hidden"  id="backgroundMerUrl" name="backgroundMerUrl" value="<?php echo $from['backgroundMerUrl'];?>"/>
	<input type="hidden"  id="tranDateTime" name="tranDateTime" value="<?php echo $from['tranDateTime'];?>"/>
	<input type="hidden"  id="virCardNoIn" name="virCardNoIn" value="<?php echo $from['virCardNoIn'];?>"/>
	<input type="hidden"  id="tranIP" name="tranIP" value="<?php echo $from['tranIP'];?>"/>
	<input type="hidden"  id="isRepeatSubmit" name="isRepeatSubmit" value="<?php echo $from['isRepeatSubmit'];?>"/>
	<input type="hidden"  id="goodsName" name="goodsName" value="<?php echo $from['goodsName'];?>"/>
	<input type="hidden"  id="goodsDetail" name="goodsDetail" value="<?php echo $from['goodsDetail'];?>"/>
	<input type="hidden"  id="buyerName" name="buyerName" value="<?php echo $from['buyerName'];?>"/>
	<input type="hidden"  id="buyerContact" name="buyerContact" value="<?php echo $from['buyerContact'];?>"/>
	<input type="hidden"  id="merRemark1" name="merRemark1" value="<?php echo $from['merRemark1'];?>"/>
	<input type="hidden"  id="merRemark2" name="merRemark2" value="<?php echo $from['merRemark2'];?>"/>
	<input type="hidden"  id="signValue" name="signValue" value="<?php echo $from['signValue'];?>"/>
	<input type="hidden"  id="bankCode" name="bankCode" value="<?php echo $from['bankCode'];?>"/>
	<input type="hidden"  id="userType" name="userType" value="<?php echo $from['userType'];?>"/>
	<input type="hidden"  id="gopayServerTime" name="gopayServerTime" value="<?php echo $from['gopayServerTime'];?>"/>
	<input type="submit" style="display:none;"/>
</form>
<script type="text/javascript">
<!--
window.onload=function(){
	document.gopayForm.submit();
};
//-->
</script>

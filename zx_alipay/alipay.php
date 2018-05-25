<?php
//out_trade_no商户订单号长度32
//body 商品描述
//attach  附加信息
//total_fee
//mch_create_ip
$out_trade_no = trim($_GET["out_trade_no"]);

$body = "聚宝支付宝在线安全支付";
$attach = "聚宝支付宝支付";
$total_fee = trim($_GET["total_fee"]);
$mch_create_ip = $_SERVER["REMOTE_ADDR"];
//根据提交的参数，生成微信支付二维码
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>聚宝支付宝支付</title>
<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="js/pay.js"></script>
<link href="css/pay.css" rel="stylesheet" type="text/css"/>
<link href="css/sprite.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<script>
$(window).load(function() {
	$('#btn').click();
});
</script>

<div id="pay_platform" style="display:none">
	
	<div class="content">
    
	<div class="auto_center" id="auto_center"><div id="orderInfo">
    <div class="ico_title">聚宝支付宝支付</div>
    <div class="form_wrap account">
        <div class="form_list">
            <span class="list_title">商户订单号：</span>
            <span class="list_val">
                <input name="out_trade_no" value="<?=$out_trade_no?>" maxlength="32" size="32" placeholder="长度32">
            </span>
            <i>*</i><em>长度32</em>
        </div>
        <div class="form_list">
            <span class="list_title">商品描述：</span>
            <span class="list_val">
                <input name="body" value="聚宝支付宝支付" maxlength="64" size="32" placeholder="长度127">
            </span>
            <i>*</i><em>长度64</em>
        </div>
        <div class="form_list">
            <span class="list_title">附加信息：</span>
            <span class="list_val">
                <input name="attach" value="聚宝支付宝支付" maxlength="128" size="32" placeholder="长度128">
            </span>
            <em>长度128</em>
        </div>
        <div class="form_list">
            <span class="list_title">总金额：</span>
            <span class="list_val">
                <input name="total_fee" value="<?=$total_fee?>" placeholder="单位：分">
            </span>
            <i>*</i><em>单位：分 整型</em>
        </div>
        <div class="form_list">
            <span class="list_title">终端IP：</span>
            <span class="list_val">
                <input name="mch_create_ip" vtype="ip" value="<?=$mch_create_ip?>" maxlength="16" placeholder="长度16">
            </span>
            <i>*</i><em>长度16</em>
        </div>
        
        <div class="form_list">
            <span class="list_title"></span>
            <span id="btn" class="list_val submit btn btn_blue">确定</span>
        </div>
    </div>
</div></div>
	</div><!-- content end -->
	
	
	
</div>
</body></html>
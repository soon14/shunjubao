<?php
    header("Content-type:text/html;charset=utf-8");
    include_once("config.php");
    include_once("corefire/CorefireAliPay.Data.php");
    include_once("corefire/CorefireAliPay.Api.php");

    $url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $notify_url = 'http://'.str_replace("do.php","",$url).'corefire/corefire_alipay_notify.php';
    $return_url = 'http://'.str_replace("do.php","",$url).'result.php';
    
	
	
    //$body=$_POST['body'];
    //$total_fee=$_POST['total_fee']*100;
    $user_ip = "";
	 // $out_trade_no=time();
	$total_fee = intval(trim($_GET["total_fee"]));
	$out_trade_no = trim($_GET["out_trade_no"]);
	$body = trim($_GET["body"]);
	
	
    if(isset($_SERVER['HTTP_CLIENT_IP']))
    {
        $user_ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else
    {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    }

  
    
    $input = new CorefireAliPayWapOrder($mch_config['mch_key']);
    
    $input->SetAppid($mch_config['mch_appid']);
    $input->SetMch_id($mch_config['mch_id']);
    $input->SetMethod("mbupay.alipay.jswap");
    $input->SetBody($body);
    $input->SetVersion('2.0.0');
    $input->SetOut_trade_no($out_trade_no);
    $input->SetTotal_fee($total_fee);
    $input->SetNotify_url($notify_url);
    $input->SetReturn_url($return_url);
    $order = CorefireAliPayApi::jswap($input);
if(isset($order['return_code'])&&isset($order['result_code'])&&$order['return_code'] == 'SUCCESS'
        && $order['result_code'] == 'SUCCESS'
        )
{
    $url=urlencode($order['code_url']);
    

?>
<html>
<head> 
<meta charset="UTF-8"> 
<title>聚宝商城在线支付</title>
<meta name="apple-mobile-web-app-capable" content="yes"> 
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no"> 
<meta name="format-detection" content="email=no"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"> 
<script type="text/javascript" charset="utf-8" src="static/alipayjswap.js"></script>
<script type="text/javascript">
function alijspaywap()
{
	alijswap('<?php echo $url ?>');
}
alijspaywap();
</script>
</head> 
<body> 
<!-- 
<div style="margin:0 auto;width:300px;line-height:50px;text-align:center;font-size;14px;" onclick="alijspaywap();">
支付
</div>-->
</body>
</html>
<?php
}
else
{
    if(isset($order['return_msg'])&&$order['return_msg']!="")
    {
        $err_code_des = $order['return_msg'];
    }else{
        $err_code = empty($order['err_code']) ? "":$order['err_code'];
        $err_code_des = empty($order['err_code_des']) ? (empty($order['return_msg'])?"":$order['return_msg']) : $order['err_code_des'];
    }
    echo $err_code_des;
    exit();
}
?>
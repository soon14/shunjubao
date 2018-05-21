<?php
$logs = fopen("pay.log", "a+");
fwrite($logs, "\r\n" . date("Y-m-d H:i:s") . "  回调信息：" . json_encode($_REQUEST) . " \r\n");
fclose($logs);

$token = "d334cb030f2935c306ed47454a8c18dd";

$p_id = $_REQUEST["ordno"];
$orderid = $_REQUEST["orderid"];
$price = $_REQUEST["price"];
$realprice = $_REQUEST["realprice"];
$orderuid = $_REQUEST["orderuid"];
$key = $_REQUEST["key"];

//orderid + orderuid + p_id + price + realprice + token
//{"uid":"57752125","ordno":"A190332952686266","orderid":"1514267882500","price":"0.01","realprice":"0.01","orderuid":"1514267882500","key":"0ed56c489638b7ef18db22bddb054130"} 
//15142678825001514267882500A1903329526862660.010.01d334cb030f2935c306ed47454a8c18dd
$check = md5($orderid . $orderuid . $p_id . $price . $realprice . $token);

if($key == $check){
    //如果key验证成功，并且金额验证成功，只返回success【小写】字符串；
    //业务处理代码..........
    $true = true;
    $logs = fopen($orderid . ".lock", "a+");
    fwrite($logs, $orderid);
    fclose($logs);
}else{
    $true = false;
}

if($true){
    exit("success");
}else{
    exit("fail");
}


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="stylesheet" href="static/style.css">
<title>支付结果</title>
</head>

<body>
<?php 
if(isset($_GET['r']))
{
    $result=$_GET['r'];   
}else{
    $result='ok';
}

?>
<div class="pay_su">
	<div class="tipDiv">
<?php 
if($result=='ok')
{
?>
    	<img width="70px" src="static/suc.png">
        <p class="t">支付成功</p>
<?php
}else{
?>
    	<img width="70px" src="static/fail.png">
        <p class="t">支付失败</p>
<?php 
}
?>	

        <a href="javascript:void(0);" id="finished">关闭</a>
       
    </div>
</div>

<script src="static/jquery.min.js"></script>
<script>

    $(document).ready(function(){	
        $("#finished").click(function(){
        	AlipayJSBridge.call('closeWebview');
        });
    });

</script>
</body>
</html>

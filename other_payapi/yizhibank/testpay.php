<?php    
    //发起订单
    function createOrder()
    {        
        $key = 'wuhLhyqW4kB4Q4yOrwH80HuVnXNSehOr';
        $data['merid'] = '100001';
        $data['merchantOutOrderNo'] = time().rand(100000,999999);
        $data['notifyUrl'] = 'http://jhpay.yizhibank.com/api/callback';
        $data['noncestr'] = '12345678910';
        $data['orderMoney'] = 1.00;
        $data['orderTime'] = date('YmdHis');
        $signstr = 'merchantOutOrderNo='.$data['merchantOutOrderNo'].'&merid='.$data['merid'].'&noncestr='.$data['noncestr'].'&notifyUrl='.$data['notifyUrl'].'&orderMoney='.$data['orderMoney'].'&orderTime='.$data['orderTime'];
        $signstr.= '&key='.$key;
        $data['sign'] = md5($signstr);
        $url = 'http://jhpay.yizhibank.com/api/createOrder';
        $str =  "<form id='pay_form' method='POST' action=".$url.">";

        foreach($data as $key=>$value){
          $str.="<input type='hidden' id='".$key."' name='".$key."' value='".$value."' />";
        }
        $str.="</form><script>function submit() {
            document.getElementById('pay_form').submit();
          }window.onload = submit;</script>";
        echo $str;
    }
    //发起pc订单
    function createPcOrder()
    {        
        $key = 'wuhLhyqW4kB4Q4yOrwH80HuVnXNSehOr';
        $data['merid'] = '100001';
        $data['merchantOutOrderNo'] = time().rand(100000,999999);
        $data['notifyUrl'] = 'http://jhpay.yizhibank.com/api/callback';
        $data['noncestr'] = '12345678910';
        $data['orderMoney'] = 1.00;
        $data['orderTime'] = date('YmdHis');
        $signstr = 'merchantOutOrderNo='.$data['merchantOutOrderNo'].'&merid='.$data['merid'].'&noncestr='.$data['noncestr'].'&notifyUrl='.$data['notifyUrl'].'&orderMoney='.$data['orderMoney'].'&orderTime='.$data['orderTime'];
        $signstr.= '&key='.$key;
        $data['sign'] = md5($signstr);
        $url = 'http://jhpay.yizhibank.com/api/createPcOrder';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $temp = json_decode(curl_exec($ch));        
        curl_close($ch);
        $imgurl = $temp->url;
        $str = '<img src="http://qr.liantu.com/api.php?text='.$imgurl.'"/>';
        echo $str;
    }
    //接收通知
    function callback()
    {
        if(IS_POST){
            $content = $_POST;
            $key = '';
            $signstr = 'merchantOutOrderNo='.$content['merchantOutOrderNo'].'&merid='.$content['merid'].'&msg='.$content['msg'].'&noncestr='.$content['noncestr'].'&orderNo='.$content['orderNo'].'&payResult='.$content['payResult'];
            $signstr.= '&key='.$key;
            $sign = md5($signstr);
            if($sign==$content['sign']){
                echo 'SUCCESS';
            }
        }
    }
    //查询订单
    function queryOrder()
    {
        $key = '';
        $data['merid'] = '';
        $data['merchantOutOrderNo'] = '';
        $data['noncestr'] = '12345678910';
        $signstr = 'merchantOutOrderNo='.$data['merchantOutOrderNo'].'&merid='.$data['merid'].'&noncestr='.$data['noncestr'];
        $signstr.= '&key='.$key;
        $data['sign'] = md5($signstr);

        $url = 'http://jhpay.yizhibank.com/api/queryOrder';

        $ch = curl_init();//打开
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        var_dump($result);
    }
    createPcOrder();
    // createOrder();


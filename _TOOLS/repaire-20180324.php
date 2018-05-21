<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$s = 1583033;
$e = 1583057;
$objUserTicketAllFront = new UserTicketAllFront();
for ($ticket_id=$s;$ticket_id<=$e;$ticket_id++) {
    $ticket_info = $objUserTicketAllFront->get($ticket_id);
    $uid =$ticket_info['u_id'];
    $select = $ticket_info['select'];
    $c = $ticket_info['combination'];
    $s = $ticket_info['sport'];
    $p = $ticket_info['pool'];
    $datetime = $ticket_info['datetime'];
    $return_time = $ticket_info['return_time'];
    $user_select = $ticket_info['user_select'];
// 定义串关方式
// 定义可能组合 
$MAX_F[-1] = array("HH","HD","DA","AA");
$MAX_F[+1] = array("HH","DH","AD","AA");

$C = explode(",", $c);
$strs = $M = array();
$match_index = 0;    
    
    foreach($C as $k => $v){
        $match=explode("|",$v);
        $M[$match_index]["id"]=$match[1];
        $M[$match_index]["pool"]=$match[0];
        if ($select == '1x1') {
            $p = $match[0];
        }
        if(stripos($match[2],"&")){
            $keys=explode("&",$match[2]);
            $M[$match_index]["key"]["count"]=count($keys);
            foreach($keys as $k1 => $v1){
                $key=explode("#",$v1);
                $M[$match_index]["key"][$k1+1]["value"]=$key[0];
                $M[$match_index]["key"][$k1+1]["odds"]=$key[1];
                $M2[$match[1]][$match[0]][$key[0]]=$key[1];
                if($match[0]=="HHAD"){
                    $M2[$match[1]][$match[0]]["goalline"]=$match[3];
                }
            }
        }else{
            $key=explode("#",$match[2]);
            $M[$match_index]["key"]["count"]=1;
            $M[$match_index]["key"][1]["value"]=$key[0];
            $M[$match_index]["key"][1]["odds"]=$key[1];
            $M2[$match[1]][$match[0]][$key[0]]=$key[1];
            if($match[0]=="HHAD"){
                $M2[$match[1]][$match[0]]["goalline"]=$match[3];
            }
        }
        $match_index++;
    }
    
    $M = make_c($select,$C);
	$multiple = $ticket_info['multiple'];
//记录系统票
$objUserTicketLog = new UserTicketLog($uid);
$max_multiple = HuaYangTicketClient::MAT_MULTIPLE;
//保证倍数每注最多为99（出票接口限制）
while ($multiple>0) {
    foreach($M as $k => $v){

        if ($multiple >= $max_multiple) {
            $this_multiple = $max_multiple;
        } else {
            $this_multiple = $multiple;
        }

        $select = explode(",",$v);

        $info = array();
        $info['u_id'] 		= $uid;
        $info['sport'] 		= $s;
        $info['pool'] 		= $p;
        $info['select'] 	= count($select) . 'x1';
        $info['multiple'] 	= $this_multiple;
        $info['money'] 		= $this_multiple * 2;
        $info['datetime'] 	= $datetime;
        $info['combination'] = $v;
        $info['return_time'] = $return_time;
        $info['ticket_id'] 	= $ticket_id;
        $info['print_state'] = $ticket_info['print_state'];
        $info['return_id'] = 0;$info['return_str']='';$info['rerurn_code'] = '';$info['odds'] = '';$info['prize'] 		= '0.00';
        $info['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
        $info['company_id'] 	= $ticket_info['company_id'];
        // 		$info['results'] = $goalline;
        $user_ticket_log_id = $objUserTicketLog->add($info);
        if (!$user_ticket_log_id) {
            $args = array('type' => 'fail', 'from' => $from, 'msg' => '记录系统票失败');
            redirect(jointUrl($url, $args));
        }
    }
    $multiple -= $max_multiple;
}
echo $ticket_id.PHP_EOL;
}

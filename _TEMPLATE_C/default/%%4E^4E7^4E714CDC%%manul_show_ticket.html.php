<?php /* Smarty version 2.6.17, created on 2017-12-04 20:19:31
         compiled from manul_show_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTheoreticalBonus', 'manul_show_ticket.html', 355, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
.gdtype {
	text-align: left;
	position: relative;
	padding: 0 0 0 5px;
}
.gdtype span {
	font-size: 12px;
	color: #dc0000;
	background: url(<?php echo @STATICS_BASE_URL; ?>
/i/gBj.gif) no-repeat;
	width: 17px;
	height: 19px;
	line-height: 19px;
	color: #fff;
	text-align: center;
	display: inline-table;
	display: inline-block;
	zoom: 1;
*display:inline;
}
.gdtype strong {
	background: url(<?php echo @STATICS_BASE_URL; ?>
/i/shai.gif) no-repeat;
	position: absolute;
	right: 10px;
	top: 3px;
	width: 17px;
	height: 19px;
	line-height: 19px;
	text-indent: -5000px;
	cursor: pointer;
}
</style>
<body>
<script type="text/javascript">
function reload() {
													
	window.location.href = '<?php echo @ROOT_DOMAIN; ?>
/zy_rqxv1x7p9PI4A/manul_show_ticket.php?select=<?php echo $this->_tpl_vars['select']; ?>
&company_zhiying=<?php echo $this->_tpl_vars['is_company_zhiying']; ?>
';
	//alert('测试自动刷新');
	
	var dateTime=new Date();  
	var hh=dateTime.getHours();  
	var mm=dateTime.getMinutes();  
	var ss=dateTime.getSeconds(); 
	
	document.title=hh+":"+mm+":"+ss;  
	window.location.reload(true);
}
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var reload_second = '<?php echo $this->_tpl_vars['reload_second']; ?>
';
TMJF(function($) {
	
	var ticket_num = '<?php echo $this->_tpl_vars['ticket_num']; ?>
';
	if(ticket_num==0) {
		setTimeout(reload,reload_second*1000);
	}

	var refund_money_ing = false;
	$(".refund_money").click(function(){
		if (refund_money_ing) return false;
		if (!confirm("本单的本金将全部退还到用户的账户，确定为: ID "+$(this).attr('userTicketId')+"   执行"+$(this).text()+"操作吗？")) return false; 
		refund_money_ing = true;
		$.post(Domain + '/admin/admin_operate.php'
                , {userTicketId: $(this).attr('userTicketId'),
					type:'refund_money'
                  }
                , function(data) {
                	alert(data.msg);
                	if (data.ok) {
                		reload();
                	}
                	refund_money_ing = false;
                }
                , 'json'
            );
	});
	var batch_manul_ticket_ing = false;
	$("#batch_manul_ticket").click(function(){
		if (batch_manul_ticket_ing) return false;
		if(!ticket_person_checked()) {
			alert('没有选择出票人');
			return false;
		}
		
		var ids = '';
		$(".batch_manul_ticket").each(function(){
			if ($(this).attr('checked')) ids += $(this).val()+',';
		});
		
		if(!confirm('ID:'+ids+'确定全部出票吗？')) return false;
		batch_manul_ticket_ing = true;
		
		$.post(Domain + '/admin/admin_operate.php'
                , {ids: ids,
					type: 'batch_manul_ticket',
					operate_uid: $('input:radio[name="ticket_person"]:checked').attr('operate_uid'),
					operate_uname: $('input:radio[name="ticket_person"]:checked').attr('operate_uname')
                  }
                , function(data) {
                	alert(data.msg);
                	if (data.ok) {
                		//隐藏某行
                		//window.location.reload(true);
                		remove_tr();
                	}
                	batch_manul_ticket_ing = false;
                }
                , 'json'
            );
	});
	
	$("#batch_manul_ticket_zhiying").click(function(){
		if(batch_manul_ticket_ing) return false;
		if(!confirm('确定全部置为智赢出票吗？')) return false;
		$(".batch_manul_ticket").each(function(){
			var id = $(this).val();
			if ($(this).attr('checked')) {
				batch_manul_ticket_ing = true;
				$.post(Domain + '/admin/admin_operate.php'
		                , {userTicketId: id,
							type: 'company_to_zhiying',
		                  }
		                , function(data) {
		                	if (data.ok) {
		                		remove_tr();
		                	} else {
		                		alert('ID:' + id +'操作失败，原因：' +data.msg);
		                	}
		                	batch_manul_ticket_ing = false;
		                }
		                , 'json'
		            );
			}
		});
	});
	$("#select_all").click(function(){
		if($(this).attr('checked')) {
			$(".batch_manul_ticket").attr('checked', true);
		} else {
			$(".batch_manul_ticket").attr('checked', false);
		}
	});
		$(".detail_tr").each(function(){
			var id = $(this).attr('ticketId');
			var detail_tr = this;
			var org_details_html = $(detail_tr).html();
      var last_pool = '';
      var current_pool = '';
      var is_same_pool = true;
		$.post(Domain + '/getUserTicketInfo.php'
                , {id: id
                  }
                , function(data) {
                    if (data.ok) {
                    	var ticketInfo = data.msg;
                    	var html = '';
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                         
                        if (i == 0) {
                          last_pool = ticketInfo[i].pool;
                          current_pool = ticketInfo[i].pool;
                        } else {
                          last_pool = current_pool;
                          current_pool = ticketInfo[i].pool;
                        }

                        if (last_pool != current_pool) {

                        }

                    		html += '<tr>';
                    		html += '<td valign="middle" class="x1">'+ k +'</td>';
                    		html += '<td valign="middle" class="x2">'+ ticketInfo[i].show_num +'</td>';
                    		html += '<td valign="middle" class="x3">'+ ticketInfo[i].l_code+'</td>';
                    		html += '<td valign="middle" class="x4"><div class="XinagQingL"><b>';
                    		if (ticketInfo[i].sport == 'bk') {
                    			html += ticketInfo[i].a_cn +'</b><span>VS</span><b>'+ ticketInfo[i].h_cn;
                    		} else {
                    			html += ticketInfo[i].h_cn +'</b><span>VS</span><b>'+ ticketInfo[i].a_cn;
                    		}                   		
                    		html += '</b></div></td>';
                    		var option = ticketInfo[i].option;
                    		var option_html = '';
							var prize_html = '<div class="zhuangTai"><b class="">未开奖</b></div>';
                    		
                    		var isPrize = false;//是否有中奖
                			var isNotPirze = true;//是否全不中
                			
                    		var red = option['red'];//中奖
                    		var black = option['black'];//未中奖
                    		var empty = option['empty'];//无赛果
                    		
                    		if (red) {
                    			isPrize = true;
                    			isNotPirze = false;
                    			for(var key in red) {
                        				option_html += '&nbsp;<em style="font-style:normal;color:#dc0000;">'+red[key] +'</em>&nbsp;';
                        		}
                    		}
                    		if (black) {
                    			for(var key in black) {
                        				option_html += '&nbsp;' + black[key] + '&nbsp;';
                        		}
                    		}
                    		if (empty) {
                    			isNotPirze = false;
                    			for(var key in empty) {
                        				option_html += '&nbsp;' + empty[key] + '&nbsp;';
                        		}
                    		}
                    		html += '<td valign="middle" class="x5"><div>'+ option_html +'</div></td>';
                    		
                    		html += '</tr>'
                        }
                    	$(detail_tr).html(org_details_html + html);
                    } 
                }

                , 'json'
            );
		});
		//出票人选项是否已经选中
		function ticket_person_checked() {
			return $('input:radio[name="ticket_person"]:checked').val() != null;
		}
		//隐藏制定的行
		function remove_tr() {
			$(".batch_manul_ticket").each(function(){
				if ($(this).attr('checked')) $(this).closest('tr').remove();
			});
			//所有行都删除时提示是否需要刷新页面
			if ($("#ticket_table tr").length==1) {
				if(confirm('所有订单都已处理完毕，是否需要刷新？')) reload();
			}
		}
	});
</script> 
<!--投注记录 start-->
<style>
.chupiao{ height:40px; width:100%;}
.chupiao h2{height:30px; line-height:30px; background:#66CCFF;olor:#000; font-size:14px; font-weight:300; font-family:'微软雅黑'; padding:0; margin:0;}
.chupiao dl{ display:inline-table;display:inline-block;zoom:1;*display:inline;}
.chupiao dl dt{display:inline-table;display:inline-block;zoom:1;*display:inline;}
.chupiao dl dt dd{display:inline-table;display:inline-block;zoom:1;*display:inline;}
</style>
<div>
  <form method="post">
    <div class="chupiao">
      <h2>订单信息总数：(<span style="color:red;"><?php echo $this->_tpl_vars['ticket_num']; ?>
</span>)&nbsp;&nbsp;|&nbsp;&nbsp;说明：每<?php echo $this->_tpl_vars['reload_second']; ?>
秒钟自动刷新页面，直到出现订单为止</h2>
      <dl>
        <dt>串关数：
          <select name='select' id='select' >
            <option value="all" selected>全部玩法</option>
            <option value="1x1" <?php if ($this->_tpl_vars['select'] == '1x1'): ?>selected<?php endif; ?>>单关
            </option>
            <option value="2x1" <?php if ($this->_tpl_vars['select'] == '2x1'): ?>selected<?php endif; ?>>2x1
            </option>
            <option value="234" <?php if ($this->_tpl_vars['select'] == '234'): ?>selected<?php endif; ?>>2x1,3x1,4x1
            </option>
            <option value="other" <?php if ($this->_tpl_vars['select'] == 'other'): ?>selected<?php endif; ?>>其他
            </option>
          </select>
        </dt>
        <dt>每页显示数量(只支持整数)</dt>
        <dt>
          <input name='limit' id='limit' value='<?php echo $this->_tpl_vars['limit']; ?>
' style='width:50px;'>
        </dt>
        <dt>
          <input type="submit" name="" value="查询">
        </dt>
      </dl>
      <div class="clear"></div>
    </div>
  </form>
  <div style="position:relative;top:-1px;left:450px; width:600px; font-size:18px">
    <ul>
      <li> <?php if ($this->_tpl_vars['is_company_zhiying']): ?>
        <input type="button" id="batch_manul_ticket_zhiying" value='智赢出票'  style="font-size:18px"/>
        <?php endif; ?> 
        <!--<input type='radio' name='ticket_person' class='manul_ticket' operate_uid="6780" operate_uname="安徽赵凯" value='安徽赵凯'/>安徽赵凯
  <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="6781" operate_uname="安徽老杨" value='安徽老杨'/>安徽老杨
  <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="6782" operate_uname="福州大砖" value='福州大砖'/>福州大砖
  <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="6783" operate_uname="福州晓飞" value='福州晓飞'/>福州晓飞
  <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="6784" operate_uname="唐山荆豪" value='唐山荆豪'/>唐山荆豪
  -->
  <!--      <input type='radio' name='ticket_person' class='manul_ticket'   operate_uid="8162" operate_uname="唐山" value='唐山'/>
        唐山
        <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="8163" operate_uname="秦皇岛" value='秦皇岛'/>
        秦皇岛
        <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="8634" operate_uname="苏州出票" value='苏州出票'/>
        苏州出票
        <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="8635" operate_uname="安徽出票" value='安徽出票'/>
        安徽出票
        <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="13152" operate_uname="河北保定" value='河北保定'/>
        河北保定
        <input type='radio' name='ticket_person' class='manul_ticket' operate_uid="15160" operate_uname="山东" value='山东'/>
        山东-->
 
        <?php echo $this->_tpl_vars['str_person']; ?>
  
        <input type="button" id="batch_manul_ticket" value='批量出票'  style="font-size:18px"/>
      </li>
    </ul>
    <div class="clear"></div>
  </div>
  <br/>
  <div>
    <div class="tabpading">
      <table id='ticket_table' class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5" style="overflow:hidden;">
        <tbody>
          <tr>
            <td>序号</td>
            <td>ID
              <input type="checkbox" id='select_all'></td>
            <td>彩种</td>
            <td>赛事信息</td>
            <td>串关方式</td>
            <td>总金额</td>
            <td>倍数</td>
            <td>出票方</td>
            <td>理论奖金最大值</td>
                        <td>认购时间</td>
            <td>操作</td>
          </tr>
        <?php $this->assign('num', 0); ?>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
        <?php $this->assign('num', $this->_tpl_vars['num']+1); ?>
          <tr 
          <?php if ($this->_tpl_vars['userTicket']['yellow'] == 1): ?>style='background-color:#FFFF99'<?php else: ?>
        <?php if ($this->_foreach['ticket']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?><?php endif; ?>>
        
          <td><?php echo $this->_tpl_vars['num']; ?>
</td>
          <td><input type='checkbox' value='<?php echo $this->_tpl_vars['userTicket']['id']; ?>
' class='batch_manul_ticket'>
            <span  <?php if ($this->_tpl_vars['userTicket']['u_id'] == '9664'): ?>style='color:red'<?php endif; ?> <?php echo $this->_tpl_vars['userTicket']['u_id']; ?>
> <?php echo $this->_tpl_vars['userTicket']['id']; ?>
</span></td>
           <td <?php if ($this->_tpl_vars['userTicket']['sport'] == 'bk'): ?>style="color:green;"<?php endif; ?>><?php echo $this->_tpl_vars['userTicket']['pool_desc']; ?>
</td>
          <td><table width="100%"  <?php if ($this->_tpl_vars['userTicket']['sport'] == 'bk'): ?>style="color:green;"<?php endif; ?>  >
                <tbody class="detail_tr" 
              <?php if ($this->_tpl_vars['userTicket']['money'] >= 5000): ?>style=""<?php endif; ?> ticketId='<?php echo $this->_tpl_vars['userTicket']['id']; ?>
'>
              <tr>
                <th>序号</th>
                <th>场次</th>
                <th>赛事</th>
                <th><?php if ($this->_tpl_vars['userTicket']['sport'] == 'bk'): ?>客队VS主队<?php else: ?>主队VS客队<?php endif; ?></th>
                <th>我的选择</th>
              </tr>
                </tbody>
              
            </table></td>
          <td><?php echo $this->_tpl_vars['userTicket']['user_select']; ?>
</td>
          <td>￥<span <?php if ($this->_tpl_vars['userTicket']['money'] >= 5000): ?>style=""<?php endif; ?>><?php echo $this->_tpl_vars['userTicket']['money']; ?>
</span>元</td>
          <td><span <?php if ($this->_tpl_vars['userTicket']['money'] >= 5000): ?>style=""<?php endif; ?>><?php echo $this->_tpl_vars['userTicket']['multiple']; ?>
</span>倍</td>
          <?php $this->assign('bonus', ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getTheoreticalBonus', true, $_tmp, $this->_tpl_vars['userTicket']['combination'], $this->_tpl_vars['userTicket']['multiple'], $this->_tpl_vars['userTicket']['money'], $this->_tpl_vars['userTicket']['select']) : getTheoreticalBonus($_tmp, $this->_tpl_vars['userTicket']['combination'], $this->_tpl_vars['userTicket']['multiple'], $this->_tpl_vars['userTicket']['money'], $this->_tpl_vars['userTicket']['select']))); ?>
          <td><?php echo $this->_tpl_vars['getTicketCompany'][$this->_tpl_vars['userTicket']['company_id']]['desc']; ?>
</td>
          <td>￥<?php if ($this->_tpl_vars['bonus']['detail'][$this->_tpl_vars['userTicket']['num']]['max_money'] >= 100000): ?><span style="color:#F00; font-size:16px;"><?php echo $this->_tpl_vars['bonus']['detail'][$this->_tpl_vars['userTicket']['num']]['max_money']; ?>
 </span><?php else: ?><?php echo $this->_tpl_vars['bonus']['detail'][$this->_tpl_vars['userTicket']['num']]['max_money']; ?>
<?php endif; ?>元</td>
                    <td><?php echo $this->_tpl_vars['userTicket']['datetime']; ?>
</td>
          <td><a href="javascript:void(0);" target="_blank" class="refund_money" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">退票</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
          </tbody>
        
      </table>
      <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pageC">
        <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
          <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> <?php endif; ?> </div>
      </div>
      <?php endif; ?> </div>
  </div>
</div>
<div style="color:#FFF"><?php echo $this->_tpl_vars['sql']; ?>
</div>
<!--投注记录 end-->
</body>
</html>
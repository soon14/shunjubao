<?php /* Smarty version 2.6.17, created on 2017-10-15 13:00:08
         compiled from zhuanjia/recommend_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zhuanjia/recommend_list.html', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='zj.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript">
$(function(){

$("#hacker tr:odd").addClass('listtd');});</script>
<body>
<div id="fade" class="black_overlay"></div>
<!--专家中心center-->
<div class="center">
  <div class="tipsters">
    <div class="NewsNav">
      <h1><b>智赢专家</b><em>停止盲目猜测...<br/>
        <span>跟随智赢网专业分析师的建议</span></em> </h1>
    </div>
  </div>
  <div class="haochu">
    <dl>
      <dt>1</dt>
      <dd>智赢网的专家都是实战派</dd>
      <dt>2</dt>
      <dd>跟随专家推荐</dd>
      <dt>3</dt>
      <dd>提高您的收益率、命中率。</dd>
      <dt>4</dt>
      <dd>让您的利润蒸蒸日上 !</dd>
      <dd class="link"><a href="zhuanjiashenqing.php">专家<br/>
        申请</a></dd>
    </dl>
    <div class="clear"></div>
  </div>
  <div class="zjfengyunbang">
    <h1><b>今日单场推荐</b></h1>
    <div class="hacker">
      <table border="0" cellpadding="0" cellspacing="0" id="hacker">
        <tr>
          <th>&nbsp;</th>
          <th>推荐专家</th>
          <th>胜率</th>
          <th>赛事</th>
          <th>主队&nbsp;VS&nbsp;客队</th>
          <th>比赛日期</th>
          <th>订阅截止日期</th>
          <th>订阅金额</th>
          <th>操作</th>
        </tr>
        <?php unset($this->_sections['b']);
$this->_sections['b']['name'] = 'b';
$this->_sections['b']['loop'] = is_array($_loop=$this->_tpl_vars['datalist2']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['b']['show'] = true;
$this->_sections['b']['max'] = $this->_sections['b']['loop'];
$this->_sections['b']['step'] = 1;
$this->_sections['b']['start'] = $this->_sections['b']['step'] > 0 ? 0 : $this->_sections['b']['loop']-1;
if ($this->_sections['b']['show']) {
    $this->_sections['b']['total'] = $this->_sections['b']['loop'];
    if ($this->_sections['b']['total'] == 0)
        $this->_sections['b']['show'] = false;
} else
    $this->_sections['b']['total'] = 0;
if ($this->_sections['b']['show']):

            for ($this->_sections['b']['index'] = $this->_sections['b']['start'], $this->_sections['b']['iteration'] = 1;
                 $this->_sections['b']['iteration'] <= $this->_sections['b']['total'];
                 $this->_sections['b']['index'] += $this->_sections['b']['step'], $this->_sections['b']['iteration']++):
$this->_sections['b']['rownum'] = $this->_sections['b']['iteration'];
$this->_sections['b']['index_prev'] = $this->_sections['b']['index'] - $this->_sections['b']['step'];
$this->_sections['b']['index_next'] = $this->_sections['b']['index'] + $this->_sections['b']['step'];
$this->_sections['b']['first']      = ($this->_sections['b']['iteration'] == 1);
$this->_sections['b']['last']       = ($this->_sections['b']['iteration'] == $this->_sections['b']['total']);
?>
        <tr>
          <td><div class="pic"><img src="<?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['u_img']; ?>
"></div></td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['u_name']; ?>
</td>
          <td class="shenglv"><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['lv']; ?>
</td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['macth']; ?>
</td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['duiwu']; ?>
</td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pubdate']; ?>
</td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['out_time']; ?>
</td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pmoney']; ?>
元</td>
          <td><div class="hdingyue"> <?php if ($this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['isout'] == 1): ?>已截止<?php else: ?><a href="javascript:void(0)" onClick="booking_sigle('<?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['sysid']; ?>
')">订阅</a><?php endif; ?> </div></td>
        </tr>
        <?php endfor; endif; ?>
      </table>
      <div class="clear"></div>
      <div class="sharepages">
        <div align="center"><?php echo $this->_tpl_vars['multi']; ?>
</div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<!--专家中心end-->
<!--弹出订阅 start-->
<div id="light1" class="white_content">
  <div class="dyCenter">
    <h1>订阅智赢专家<a href="">服务细则</a><span><a href="javascript:void(0)" onClick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="tips">
      <p>在订阅智赢专家之前，请您确保您在智赢网里的账户余额够支付此次订阅的费用!
      <p> 
    </div>
    <form action="booking_action.php" method="post">
      <div class="dyother">
        <dl>
          <dt>您的用户名：</dt>
          <dd><b><span id="yname"></span></b></dd>
        </dl>
        <dl>
          <dt>您订阅的专家：</dt>
          <dd><b><span id="ename"></span></b></dd>
        </dl>
        <dl>
          <dt>订阅内容：</dt>
          <dd>
            <ul>
              <li>
                <input type="radio" name='booktype' value="1"  id="ifzj" >
              </li>
              <li>单场推荐(<span id="single"></span>元)</li>
              <li>
                <input type="radio"  name='booktype' value="2" checked="checked">
              </li>
               <li>订阅一周(<span id="week_money">50</span>元/周)</li>
              <li>
                <input type="radio"  name='booktype' value="3" >
              </li>
             <li>订阅一个月(<span id="month_money">188</span>元/月)</li>
            </ul>
          </dd>
        </dl>
        <dl class="dy">
          <dt>
            <input type="submit"  value="确认订阅" class="dingyuesub" name='' id="">
            <input name="action"  id="action" type="hidden" value="add_action">
            <input name="bookid"  id="bookid" type="hidden" value="">
            <input name="t"  id="t" type="hidden" value="">
          </dt>
        </dl>
        <div class="clear"></div>
        <div class="feiyong"><span>*</span>包周的专家一周至少推荐场次不低于7场；<em>包月的专家一月至少推荐场次不低于30场。</em></div>
      </div>
    </form>
    <h2>停止盲目猜测...跟随智赢网专业分析师的建议。</h2>
  </div>
</div>
<!--弹出订阅 end-->
<div style="width:960px; margin:0 auto;">
 <script type="text/javascript">
    /*通栏图片960*60 创建于 2014-12-04*/
    var cpro_id = "u1844009";
</script>
<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
</div>
<!--智赢页面底部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--智赢页面底部 end-->
<script>

function booking_expert(id){ 

		$("#ifzj").attr("disabled", true);



		$.ajax({

			type: "post",

			url : "http://www.zhiying365.com/zhuanjia/booking_expert.php",

			dataType:'json',

			data: 'id='+id, 

			success: function(json){

				//alert(json.error);

				if(json.error=="no_login"){

					alert('请先登录!');	

					window.location.href="http://www.zhiying365.com/passport/login.php";

					return false;

				}else if(json.error=="err_value"){

					alert('订阅数据出错!');	

					return false;

				}else if(json.error=="err_id"){

					alert('订阅ID出错!');	

					return false;

				}else{

					

				   $("#yname").text(json.yname);

				    $("#ename").text(json.ename);

				    $("#single").text(json.single);
					$("#week_money").text(json.week_money);
				    $("#month_money").text(json.month_money);

					 $("#bookid").val(id);

					 $("#t").val('2');

					$("#light1").css("display","block");

					$("#fade").css("display","block");

					return true;

				}

				

			 }   

		});

}



function booking_sigle(id){ 

		$("#ifzj").attr("disabled", false);

		$.ajax({

			type: "get",

			url : "http://www.zhiying365.com/zhuanjia/booking.php",

			dataType:'json',

			data: 't=1&id='+id, 

			success: function(json){

				//alert(json.error);

				if(json.error=="no_login"){

					alert('请先登录!');	

					window.location.href="http://www.zhiying365.com/passport/login.php";

					return false;

				}else if(json.error=="err_value"){

					alert('订阅数据出错!');	

					return false;

				}else if(json.error=="err_id"){

					alert('订阅ID出错!');	

					return false;

				}else{

					

				   $("#yname").text(json.yname);

				    $("#ename").text(json.ename);

				    $("#single").text(json.single);
					$("#week_money").text(json.week_money);
				    $("#month_money").text(json.month_money);

					 $("#bookid").val(id);

					  $("#t").val('1');

					$("#light1").css("display","block");

					$("#fade").css("display","block");

					return true;

				}

				

			 }   

		});

}

</script>
</body>
</html>
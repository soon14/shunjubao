<?php /* Smarty version 2.6.17, created on 2018-03-05 18:47:21
         compiled from zhuanjia/zhuanjia.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zhuanjia/zhuanjia.html', 4, false),)), $this); ?>
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
      <h1><b>聚宝专家</b><em>停止盲目猜测...<br/>
        <span>跟随聚宝网专业分析师的建议</span></em>
        <ul>
          <li class="active"><a href="zhuanjia_list.php">浏览订阅分析师</a></li>
        </ul>
      </h1>
    </div>
  </div>
  <div class="haochu">
    <dl>
      <dt>1</dt>
      <dd>聚宝网的专家都是实战派</dd>
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
    <h1><b>今日单场推荐<em><a href="recommend_list.php">查看更多&gt;&gt;</a></em></b></h1>
    <div class="hacker">
      <table border="0" cellpadding="0" cellspacing="0" id="hacker">
        <tr>
          <th>&nbsp;</th>
          <th>推荐专家</th>
          <th>胜率</th>
          <th>赛事</th>
          <th>主队&nbsp;VS&nbsp;客队</th>
          <th>截止时间</th>
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
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['out_time']; ?>
</td>
          <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pmoney']; ?>
元</td>
          <td><div class="hdingyue"> <?php if ($this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['isout'] == 1): ?>已截止<?php else: ?><a href="javascript:void(0)" onClick="booking_sigle('<?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['sysid']; ?>
')">订阅</a><?php endif; ?> </div></td>
        </tr>
        <?php endfor; endif; ?>
      </table>
    </div>
  </div>
  <div class="clear"></div>
  <div class="zjfengyunbang">
    <h1><b>本周专家榜</b></h1>
    <dl>
      <?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['datalist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
      <dt>
        <p><img src="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_img']; ?>
"><b><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_name']; ?>
</b><strong>胜率：<em><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['lv']; ?>
</em>&nbsp;&nbsp;战绩：<u><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['zj']; ?>
赢<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['wzj']; ?>
输</u></strong><a href='zhuanjia_show.php?id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['eid']; ?>
'>查看详细</a><span><a href="javascript:void(0)" onClick="booking_expert('<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['eid']; ?>
')">订阅</a></span></p>
      </dt>
      <?php endfor; endif; ?>
      <dd>
        <h2>最优秀专家</h2>
        <h3>最好的服务</h3>
        <h4>谁是下一个</h4>
        <h5><img src="http://www.shunjubao.xyz/www/statics/i/sbgs.png"></h5>
      </dd>
    </dl>
  </div>
  <div class="clear"></div>
</div>
<!--专家中心end--> 
<!--弹出订阅 start-->
<div id="light1" class="white_content">
  <div class="dyCenter">
    <h1>订阅聚宝专家<a href="">服务细则</a><span><a href="javascript:void(0)" onClick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="tips">
      <p>在订阅聚宝专家之前，请您确保您在聚宝网里的账户余额够支付此次订阅的费用!
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
              <li>单场推荐(<span id="single">1</span>元)</li>
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
    <h2>停止盲目猜测...跟随聚宝网专业分析师的建议。</h2>
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
<!--聚宝页面底部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<!--聚宝页面底部 end-->
<script>

function booking_expert(id){ 

		$("#ifzj").attr("disabled", true);



		$.ajax({

			type: "post",

			url : "http://www.shunjubao.xyz/zhuanjia/booking_expert.php",

			dataType:'json',

			data: 'id='+id, 

			success: function(json){

				//alert(json.error);

				if(json.error=="no_login"){

					alert('请先登录!');	

					window.location.href="http://www.shunjubao.xyz/passport/login.php";

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
					$("#week_money").text(json.week_money);
				    $("#month_money").text(json.month_money);
					
   					$("#single").text(json.single);
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

			url : "http://www.shunjubao.xyz/zhuanjia/booking.php",

			dataType:'json',

			data: 't=1&id='+id, 

			success: function(json){

				//alert(json.error);

				if(json.error=="no_login"){

					alert('请先登录!');	

					window.location.href="http://www.shunjubao.xyz/passport/login.php";

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
<?php /* Smarty version 2.6.17, created on 2017-10-14 18:32:56
         compiled from zhuanjia/zhuanjia_show.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zhuanjia/zhuanjia_show.html', 4, false),)), $this); ?>
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
<script type="text/javascript">

// 收缩展开效果

$(document).ready(function(){

	$("div.text").hide();//默认隐藏div，或者在样式表中添加.text{display:none}，推荐使用后者

	$(".box h1").click(function(){

		$(this).next(".text").slideToggle("slow");

	})

});

</script>
<body>
<!--专家中心center-->
<div class="center">
  <div class="zjshow">
    <div class="zjtop">
      <div class="showTop">
        <div style="width:1000px; margin:auto;">
          <h1><?php echo $this->_tpl_vars['value']['u_nick']; ?>
<span><em>*</em>包周的专家一周至少推荐场次不低于7场；包月的专家一月至少推荐场次不低于30场。</span></h1>
          <form action="booking_action.php" method="post">
            <dl>
              <dt><img src="<?php echo $this->_tpl_vars['value']['u_img']; ?>
"></dt>
              <dd>
                <h2><?php echo $this->_tpl_vars['value']['u_nick']; ?>
：<?php echo $this->_tpl_vars['value']['ddesc']; ?>
</h2>
                <!--   <p>

              <input type="radio" name='' id="">

              单场推荐</p>-->
                <p>
                  <input type="radio"  name='booktype' value="2" checked="checked">
                  订阅一周(<?php echo $this->_tpl_vars['value']['week_money']; ?>
元/周)</p>
                <p>
                  <input type="radio"  name='booktype' value="3" >
                  订阅一个月<?php echo $this->_tpl_vars['value']['month_money']; ?>
元/月)</p>
                <ul>
                  <li>
                    <input type="submit"  value="确认订阅" class="dingyuesub" name='' id="">
                    <input name="action"  id="action" type="hidden" value="add_action">
                    <input name="bookid"  id="bookid" type="hidden" value="<?php echo $this->_tpl_vars['value']['eid']; ?>
">
                  </li>
                </ul>
              </dd>
            </dl>
          </form>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <script>

    	function showmy(id){

			

			for(var i=1; i<4;i++){

				$("#show"+i).removeClass("active");	

				$("#showc"+i).hide();	

			}

			$("#show"+id).addClass("active");	

			$("#showc"+id).show();		

		}

    

    </script>
    <div class="showCur">
      <div class="zjtab">
        <ul>
          <li><a href="javascript:void()" onClick="showmy('1')" class="active" id="show1">最新推荐</a></li>
          <li><a href="javascript:void()"  onClick="showmy('2')" id="show2">推荐新闻</a></li>
          <li><a href="javascript:void()" onClick="showmy('3')" id="show3">服务说明</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <div class="zjinfor">
        <div class="" id="showc1">
          <div class="hacker" style="width:960px;">
            <table border="0" cellpadding="0" cellspacing="0" id="hacker">
              <tr>
                <th>日期</th>
                <th>赛事</th>
                <th>主队&nbsp;VS&nbsp;客队</th>
                <th>推荐</th>
                <th>彩果</th>
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
                <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pubdate']; ?>
</td>
                <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['macth']; ?>
</td>
                <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['duiwu']; ?>
</td>
                <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['recommond']; ?>
</td>
                <td><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['islottey_status']; ?>
</td>
              </tr>
              <?php endfor; endif; ?>
            </table>
          </div>
        </div>
        <div class="news" id="showc2" style="display:none">
          <div class="box"> <?php if ($this->_tpl_vars['dinyue_not'] == 1): ?>
            
            <?php if ($this->_tpl_vars['dinyue_out'] == 1): ?>
            <h1>你订阅的内容已过期，请先订阅。 <?php else: ?> 你还没订阅，如果查看，请先订阅。</h1>
            <?php endif; ?>
            
            <?php else: ?>
            
            
            
            
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
            <h1><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pname']; ?>
<span><?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pubdate']; ?>
</span></h1>
            <div class="text"> <?php if ($this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['ishow'] != 2): ?>
              <?php echo $this->_tpl_vars['datalist2'][$this->_sections['b']['index']]['pcontent']; ?>

              <?php else: ?>
              请先订阅
              <?php endif; ?> </div>
            <?php endfor; endif; ?>
            
            
            
            <?php endif; ?> </div>
        </div>
        <div class="service" id="showc3" style="display:none">智赢网保证每位分析师一周至少推荐场次不低于7场；包月的专家一月至少推荐场次不低于30场。 无论出于任何原因，如果您收到的推荐没有达到我们承诺的数目，那么，您的订阅将会免费延长，直到您收到补还的推荐为止。</div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>
<!--专家中心end-->
<!--智赢页面底部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--智赢页面底部 end-->
</body>
</html>
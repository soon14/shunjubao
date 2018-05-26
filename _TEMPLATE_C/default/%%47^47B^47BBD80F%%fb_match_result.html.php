<?php /* Smarty version 2.6.17, created on 2018-03-04 23:35:38
         compiled from livescore/fb_match_result.html */ ?>
<!DOCTYPE>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>竞彩足球赛果开奖-智赢竞彩智赢网数据中心！</title>
<meta name="keywords" content="足球比分直播,足彩直播,足球即时比分,足彩即时比分,足球彩票比分,比分直播网,足球数据中心" />
<meta name="description" content="竞彩足球赛果开奖，智赢竞彩智赢网数据中心。" />
</head>
<body>
<link type="text/css" rel="stylesheet" href="http://www.zhiying365365.com/www/statics/c/header.css" />
<link type="text/css" rel="stylesheet" href="http://www.zhiying365365.com/www/statics/c/bifen.css" />
<link type="text/css" rel="stylesheet" href="http://www.zhiying365365.com/www/statics/c/footer.css" />
<script type="text/javascript" src="http://www.zhiying365365.com/www/statics/j/jquery.js"></script>
<script type="text/javascript" src="http://www.zhiying365365.com/www/statics/j/jquery-1.9.1.min.js"></script>
<script src="http://www.zhiying365365.com/www/statics/j/float.js" type="text/javascript"></script>
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

<!--caipiao location start-->
<div class="Cailocation">
  <div class="location_center">
    <h1><a href="fb_match_result.php" class="active">竞彩足球</a><a href="bk_match_result.php">竞彩篮球</a><!--<a href="fb_livescore.php" style="color:#dc0000;">即时比分</a>--></h1>
    <span style="float:right;">非赛事取消或者延迟下，比赛结束后，入库赛果无误下程序在30分钟内自动派发奖金。</span></div>
</div>
<!--caipiao location end-->
<!--center start-->
<div class="center">
  <div style="margin:15px auto;width:1000px;">
    <div>
      <div class="Kjnav">
        <div class="zubifenNav">
          <dl class="one">
            <dt>赛事编号</dt>
          </dl>
          <dl class="two">
            <dt>赛事</dt>
          </dl>
          <dl class="three">
            <dt>比赛时间</dt>
          </dl>
          <dl class="four"  style="width:263px;">
            <dt>主队&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;客队</dt>
          </dl>
          <dl class="five" style="border-right:1px solid #fff;">
            <dt>半场比分</dt>
          </dl>
          <dl class="five" style="border-right:1px solid #fff;">
            <dt>全场比分</dt>
          </dl>
          <dl class="one" style="border:none;">
            <dt>派奖情况</dt>
          </dl>
          <div class="clear"></div>
        </div>
      </div>
      <div>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="stripe">
          <?php $_from = $this->_tpl_vars['show_betting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
          <tr>
            <td width="79"><?php echo $this->_tpl_vars['item']['num']; ?>
</td>
            <td width="68" style="background-color:#<?php echo $this->_tpl_vars['item']['color']; ?>
;color:#fff;"><?php echo $this->_tpl_vars['item']['l_cn']; ?>
</td>
            <td width="155"><div class="time"><?php echo $this->_tpl_vars['item']['date']; ?>
&nbsp;<?php echo $this->_tpl_vars['item']['time']; ?>
</div></td>
            <td width="263"><div class="saidui" style="width:263px">
                <dl>
                  <dd style="text-align:right; width:110px;"><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</dd>
                  <dd style="width:32px;overflow:hidden;">VS</dd>
                  <dd style="text-align:left;width:110px;"><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</dd>
                </dl>
              </div></td>
            <td width="172"><div class="banchang"><b style="color:#0066CC; font-size:12px;" id='livescore_half_<?php echo $this->_tpl_vars['item']['m_id']; ?>
'><?php echo $this->_tpl_vars['item']['half']; ?>
</b></div></td>
            <td width="172"><div class="banchang"><b style="font-size:12px;" id="livescore_<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['full']; ?>
</b></div></td>
            <td width="">已完成
              <!--<span style="color:#dc0000; display:none;">进行中</span>--></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
      <div class="gonggao">注 ：请注意“让球”只适用于让球胜平负（和其他玩法不同）。</div>
    </div>
  </div>
</div>
</div>
<!--center end-->
<!--智赢页面底部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--智赢页面底部 end-->
</body>
</html>
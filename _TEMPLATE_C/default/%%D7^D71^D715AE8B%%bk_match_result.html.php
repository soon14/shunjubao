<?php /* Smarty version 2.6.17, created on 2018-03-26 17:53:58
         compiled from livescore/bk_match_result.html */ ?>
<!DOCTYPE>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>竞彩篮球赛果派奖-智赢网智赢竞彩智赢彩票数据中心！</title>
<meta name="keywords" content="篮球比分直播,篮球直播,篮球即时比分,足彩即时比分,篮球彩票比分,比分直播网,篮球数据中心。" />
<meta name="description" content="竞彩篮球赛果派奖，智赢网智赢竞彩智赢彩票数据中心" />
</head>
<body>
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/header.css" />
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/bifen.css" />
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/footer.css" />
<script type="text/javascript" src="http://www.shunjubao.xyz/www/statics/j/jquery.js"></script>
<script type="text/javascript" src="http://www.shunjubao.xyz/www/statics/j/jquery-1.9.1.min.js"></script>
<script src="http://www.shunjubao.xyz/www/statics/j/float.js" type="text/javascript"></script>
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
    <h1><a class="active" href="bk_match_result.php">竞彩篮球</a><a href="fb_match_result.php" >竞彩足球</a><!--<a href="fb_livescore.php" style="color:#dc0000;">即时比分</a>--></h1>
    <span style="float:right;">说明：篮球比赛客队在上主队在下。</span> </div>
</div>
<!--caipiao location end-->
<!--center start-->
<div class="center">
  <div style="margin:15px auto; width:1000px;">
    <div>
      <div class="Kjnav">
        <div class="bkbifenNav">
          <dl class="one">
            <dt>赛事编号</dt>
          </dl>
          <dl class="two">
            <dt>赛事</dt>
          </dl>
          <dl class="three">
            <dt>比赛时间</dt>
          </dl>
          <dl class="four">
            <dt>客/主</dt>
          </dl>
          <dl class="five">
            <dt>一节</dt>
          </dl>
          <dl class="five">
            <dt>二节</dt>
          </dl>
          <dl class="five">
            <dt>三节</dt>
          </dl>
          <dl class="five">
            <dt>四节</dt>
          </dl>
          <dl class="five">
            <dt>加时</dt>
          </dl>
          <dl class="five">
            <dt>全场</dt>
          </dl>
          <dl class="five" style="border:none;">
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
            <td style=" line-height:60px; height:60px;"><div class="bksaishi">
                <dl>
                  <dt class="one"><?php echo $this->_tpl_vars['item']['num']; ?>
</dt>
                  <dt class="two" ><?php echo $this->_tpl_vars['item']['l_cn']; ?>
</dt>
                  <dt class="three"><?php echo $this->_tpl_vars['item']['date']; ?>
&nbsp;<?php echo $this->_tpl_vars['item']['time']; ?>
</dt>
                  <dt class="four">
                    <p><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</p>
                    <p><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</p>
                  </dt>
                  <dt class="five">
                    <p ><b><?php echo $this->_tpl_vars['item']['s1']['1']; ?>
</b></p>
                    <p><b><?php echo $this->_tpl_vars['item']['s1']['0']; ?>
</b></p>
                  </dt>
                  <dt class="five">
                    <p><b><?php echo $this->_tpl_vars['item']['s2']['1']; ?>
</b></p>
                    <p><b><?php echo $this->_tpl_vars['item']['s3']['0']; ?>
</b></p>
                  </dt>
                  <dt class="five">
                    <p><b><?php echo $this->_tpl_vars['item']['s3']['1']; ?>
</b></p>
                    <p><b><?php echo $this->_tpl_vars['item']['s3']['0']; ?>
</b></p>
                  </dt>
                  <dt class="five">
                    <p><b><?php echo $this->_tpl_vars['item']['s4']['1']; ?>
</b></p>
                    <p><b><?php echo $this->_tpl_vars['item']['s4']['0']; ?>
</b></p>
                  </dt>
                  <dt class="five">
                    <p><b>&nbsp;<?php echo $this->_tpl_vars['item']['s5']['1']; ?>
</b></p>
                    <p><b>&nbsp;<?php echo $this->_tpl_vars['item']['s5']['0']; ?>
</b></p>
                  </dt>
                  <dt class="five">
                    <p><b><?php echo $this->_tpl_vars['item']['final']['1']; ?>
</b></p>
                    <p><b><?php echo $this->_tpl_vars['item']['final']['0']; ?>
</b></p>
                  </dt>
                  <dt class="five" style="border:none;"> <b>已完结</b> </dt>
                </dl>
              </div></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
    </div>
    <div class="gonggao">声明：即时比分有待核实，请以【赛果开奖】→内容为准！暂停、取消、推迟：因场地或天气等原因比赛被迫暂停、取消或推迟开赛时间。详情请查看<a href="http://new.shunjubao.xyz/saishi/index.php">销售公告</a>。</div>
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

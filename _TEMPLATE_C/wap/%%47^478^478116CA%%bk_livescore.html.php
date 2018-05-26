<?php /* Smarty version 2.6.17, created on 2017-10-18 21:54:46
         compiled from livescore/bk_livescore.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'livescore/bk_livescore.html', 11, false),)), $this); ?>
<!DOCTYPE>
<head>
<title>竞彩篮球即时比分-智赢网智赢竞彩智赢彩票触屏版！</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1' name='viewport' />
<meta content='yes' name='apple-mobile-web-app-capable' />
<meta content='black' name='apple-mobile-web-app-status-bar-style' />
<meta content='telephone=no' name='format-detection' />
<meta name="keywords" content="篮球比分直播,篮球比分直播,篮球即时比分,篮球即时比分,篮球彩票比分,比分直播网,篮球数据中心" />
<meta name="description" content="竞彩篮球即时比分，智赢网智赢竞彩智赢彩票触屏版" />
<link href="<?php echo ((is_array($_tmp='wap_header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='wap_footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='bifen.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="wapBftags">
  <ul>
    <li><a href="http://m.zhiying365.com/livescore/bk_livescore.php" class="active">竞彩篮球</a></li>
    <li><a href="http://m.zhiying365.com/livescore/fb_livescore.php">竞彩足球</a></li>
    <li class="right"><a href="http://m.zhiying365.com/livescore/bk_match_result.php" style="display:none;">赛果开奖</a></li>
  </ul>
</div>
<!--center start-->
<div class="center">
  <div>
    <div>
      <div class="wapbifenBk"> <?php $_from = $this->_tpl_vars['show_betting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <div style="padding:0 0 10px 0;">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <th>赛事</th>
              <th>赛队</th>
              <th>一节</th>
              <th>二节</th>
              <th>三节</th>
              <th>四节</th>
              <th>加时</th>
              <th>全场</th>
            </tr>
            <tr>
              <td style="border:none;color:#777; width:50px;"><?php echo $this->_tpl_vars['item']['num_show']; ?>
</td>
              <td width="100" style="width:100px;"><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m1']['0']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m2']['0']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m2']['0']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m3']['0']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m3']['0']; ?>
</td>
              <td style="color:#dc0000;"><?php echo $this->_tpl_vars['item']['score']['0']; ?>
</td>
            </tr>
            <tr>
              <td style="color:#777;width:50px;"><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</td>
              <td width="100" style="width:100px;"><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m1']['1']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m2']['1']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m2']['1']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m3']['1']; ?>
</td>
              <td><?php echo $this->_tpl_vars['item']['m3']['1']; ?>
</td>
              <td style="color:#dc0000;"><?php echo $this->_tpl_vars['item']['score']['1']; ?>
</td>
            </tr>
          </table>
        </div>
        <?php endforeach; endif; unset($_from); ?> </div>
    </div>
    <div class="gonggao">声明：即时比分有待核实，请以<a href="http://m.zhiying365.com/livescore/fb_match_result.php">赛果开奖</a>为准！暂停、取消、推迟：因场地或天气等原因比赛被迫暂停、取消或推迟开赛时间。详情请查看<a href="http://news.zhiying365.com/saishi/wap.php">销售公告</a>。</div>
  </div>
</div>
</div>
</div>
<!--center end-->
<!--智赢页面底部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--智赢页面底部 end-->
</body>
</html>
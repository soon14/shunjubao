<?php /* Smarty version 2.6.17, created on 2018-03-05 04:43:18
         compiled from livescore/bk_match_result.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'livescore/bk_match_result.html', 11, false),)), $this); ?>
<!DOCTYPE>
<head>
<title>竞彩篮球赛果派奖-智赢网智赢竞彩智赢彩票触屏版！</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1' name='viewport' />
<meta content='yes' name='apple-mobile-web-app-capable' />
<meta content='black' name='apple-mobile-web-app-status-bar-style' />
<meta content='telephone=no' name='format-detection' />
<meta name="keywords" content="篮球比分直播,篮球比分直播,篮球即时比分,篮球即时比分,篮球彩票比分,比分直播网,篮球数据中心" />
<meta name="description" content="竞彩篮球赛果派奖，智赢网智赢竞彩智赢彩票触屏版" />
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
<style>
.NavphTab{ }
.NavphTab table{ position:relative;top:1px;}
.NavphTab table tr{}
.NavphTab table tr td{background:#fff; text-align:center;}
.NavphTab table tr td a{color:#000;font-weight:300;font-size:14px;border-bottom:2px solid #f1f1f1;height:40px;line-height:40px;display:block;}
.NavphTab table tr td a:hover{}
.NavphTab table tr td a.active{display:block;width:100%;color:#000;border-bottom:2px solid #dc0000; font-weight:900;}
</style>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="NavphTab">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="http://m.shunjubao.xyz/livescore/fb_match_result.php">竞彩足球</a></td>
      <td><a href="http://m.shunjubao.xyz/livescore/bk_match_result.php" class="active">竞彩篮球</a></td>
    </tr>
  </table>
</div>
<!--center start-->
<div class="center">
  <div style="padding:20px 0 0 0;">
    <div>
      <div class="wapbifen"> <?php $_from = $this->_tpl_vars['show_betting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <div style="padding:0 0 10px 0;">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left">&nbsp;&nbsp;<i><?php echo $this->_tpl_vars['item']['num']; ?>
</i><?php echo $this->_tpl_vars['item']['l_cn']; ?>
</td>
              <td align="center"><?php echo $this->_tpl_vars['item']['date']; ?>
</td>
              <td align="right"><em>已完成</em>&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td align="right" width="120"><b>&nbsp;<?php echo $this->_tpl_vars['item']['a_cn']; ?>
</b></td>
              <td align="center" style="width:120"><b style="color:#dc0000; font-size:20px;"><?php echo $this->_tpl_vars['item']['final']['1']; ?>
:<?php echo $this->_tpl_vars['item']['final']['0']; ?>
</b></td>
              <td align="left" width="120"><b><?php echo $this->_tpl_vars['item']['h_cn']; ?>
&nbsp;</b></td>
            </tr>
          </table>
        </div>
        <?php endforeach; endif; unset($_from); ?> </div>
    </div>
    <div class="gonggao">声明：即时比分有待核实，请以<a href="http://m.shunjubao.xyz/livescore/fb_match_result.php">赛果开奖</a>为准！暂停、取消、推迟：因场地或天气等原因比赛被迫暂停、取消或推迟开赛时间。详情请查看<a href="http://new.shunjubao.xyz/saishi/wap.php">销售公告</a>。</div>
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
<?php /* Smarty version 2.6.17, created on 2018-03-05 04:10:07
         compiled from livescore/fb_match_result.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'livescore/fb_match_result.html', 11, false),)), $this); ?>
<!DOCTYPE html>
<head>
<title>竞彩足球赛果开奖-智赢网智赢竞彩智赢彩票触屏版！</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1' name='viewport' />
<meta content='yes' name='apple-mobile-web-app-capable' />
<meta content='black' name='apple-mobile-web-app-status-bar-style' />
<meta content='telephone=no' name='format-detection' />
<meta name="keywords" content="智赢竞彩,智赢彩票,足球比分,手机足球比分,竞彩足球,手机买竞彩,手机投注竞彩,手机玩球,手机买足彩,手机彩票,手机竞彩,wap竞彩,wap竞彩投注,智赢手机版,智赢触屏版买彩。" />
<meta name="description" content="竞彩足球赛果开奖，智赢网智赢竞彩智赢彩票触屏版！" />
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
<!--智赢页面头部-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--center start-->
<div class="NavphTab">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="http://m.shunjubao.xyz/livescore/fb_match_result.php" class="active">竞彩足球</a></td>
      <td><a href="http://m.shunjubao.xyz/livescore/bk_match_result.php">竞彩篮球</a></td>
    </tr>
  </table>
</div>
<div class="center">
  <div>
    <div>
      <div class="wapbifen"> <?php $_from = $this->_tpl_vars['show_betting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left">&nbsp;&nbsp;<i><?php echo $this->_tpl_vars['item']['num']; ?>
&nbsp;<?php echo $this->_tpl_vars['item']['l_cn']; ?>
</i></td>
            <td align="center" width="65"><div class="wapbiFentime"><?php echo $this->_tpl_vars['item']['date']; ?>
</div></td>
            <td align="right"><em>已完成</em>&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td align="right" width="140"><b>&nbsp;<?php echo $this->_tpl_vars['item']['h_cn']; ?>
</b></td>
            <td align="center" width="65" style="padding:0; margin:0;width:65px;"><div class="wapbiFentime"><strong ><?php echo $this->_tpl_vars['item']['full']; ?>
</strong></div></td>
            <td align="left" width="140"><b><?php echo $this->_tpl_vars['item']['a_cn']; ?>
&nbsp;</b></td>
          </tr>
        </table>
        <?php endforeach; endif; unset($_from); ?> </div>
      <div class="gonggao">非赛事取消或者延迟下，比赛结束后，入库赛果无误下程序在30分钟内自动派发奖金。
        <p>注 ：请注意“让球”只适用于让球胜平负（和其他玩法不同）。</p>
      </div>
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
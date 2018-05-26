<?php /* Smarty version 2.6.17, created on 2018-03-05 00:11:04
         compiled from total_prize_rank.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'total_prize_rank.html', 5, false),)), $this); ?>
<!DOCTYPE html>
<head>
<title>中奖排行-智赢网-彩票赢家首选人气最旺的网站！</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"/>
<style>
.paihangC{border:1px solid #e1e1e1;margin:0 auto;width:242px;height:378px;}
.paihangC h1{ font-size:14px;font-weight:900;height:32px;line-height:32px;border-bottom:1px solid #e1e1e1;padding:0 10px;background:#f9f9f9;position:relative;}
.paihangC h1 b{display:inline-table;display:inline-block;zoom:1;*display:inline;height:33px;line-height:33px;width:120px;background:#fff;position:absolute;left:0;text-align:center;border-right:1px solid #e1e1e1;font-size:14px;font-weight:900;font-family:'';}
.paihangC h1 span{ position:absolute;right:10px;}
.paihangC h1 span a{text-decoration:none;color:#dc0000;}
.paihangC h1 span a:hover{text-decoration:underline;color:#999;}
.paihang{position:relative;padding:8px 0 5px 0;}
.paihang h3{position:absolute;bottom:5px;background:#fff;height:2px;width:242px;overflow:hidden;line-height:1%;text-indent:-5000px;}
.paihang ul{float:left;padding:15px 10px 10px 10px;display:none;}
.paihang ul li{float:left;height:26px;line-height:26px;width:95px;text-align:center;overflow:hidden;}
.paihang ul li.first{text-align:left;width:30px;}
.paihang ol{float:left;padding:0 10px;}
.paihang ol li{float:left;height:32px;line-height:32px;width:95px;text-align:center;overflow:hidden;border-bottom:1px solid #e9e9e9;}
.paihang ol li.name{text-align:left;}
.paihang ol li.first{text-align:left;width:30px;}
.paihang ol li.first b{width:20px;height:20px;line-height:20px;background:#BC1E1F;color:#fff;display:inline-table;display:inline-block;zoom:1;*display:inline;text-align:center;font-size:12px;font-weight:300;vertical-align:middle;-moz-border-radius:20px;-webkit-border-radius:20px;border-radius:20px;position:relative;top:-1px;}
.paihang ol li.first strong{width:20px;height:20px;line-height:20px;background:#6f6f6f;color:#fff;display:inline-table;display:inline-block;zoom:1;*display:inline;text-align:center;font-size:12px;font-weight:300;vertical-align:middle;-moz-border-radius:20px;-webkit-border-radius:20px;border-radius:20px;position:relative;top:-1px;}
</style>
</head>
<body>
<div class="paihangC">
  <h1><b>中奖排行</b><span><a href="http://www.shunjubao.xyz/ticket/paihang.php" target="_blank">总排行</a></span></h1>
  <div class="paihang">
    <ul>
      <li class="first">排名</li>
      <li>用户名</li>
      <li>累积中奖</li>
    </ul>
    <div class="clear"></div>
    <?php $_from = $this->_tpl_vars['rank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <ol>
      <?php if ($this->_tpl_vars['key'] <= 3): ?>
      <li class="first"><b><?php echo $this->_tpl_vars['key']; ?>
</b></li>
      <?php else: ?>
      <li class="first"><strong><?php echo $this->_tpl_vars['key']; ?>
</strong></li>
      <?php endif; ?>
      <li class="name"><?php echo $this->_tpl_vars['item']['u_name']; ?>
</li>
      <li><span><?php echo $this->_tpl_vars['item']['prize']; ?>
元</span></li>
    </ol>
    <?php endforeach; endif; unset($_from); ?>
    <div class="clear"></div>
    <h3>&nbsp;</h3>
  </div>
</div>
</body>
</html>
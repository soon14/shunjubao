<?php /* Smarty version 2.6.17, created on 2017-10-18 20:31:43
         compiled from zhuanjia/zhuanjiashenqing.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zhuanjia/zhuanjiashenqing.html', 4, false),)), $this); ?>
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
<body>
<!--专家中心center-->
<div class="center">
  <div class="tipsters">
    <div class="NewsNav">
      <h1><b>智赢专家</b><em>专业人士干专业事情<br/>
        <span>为用户购彩提供专业服务</span></em> </h1>
    </div>
  </div>
  <div class="zjlist">
    <h1><b>申请智赢专家</b></h1>
    <div class="shenqingC">
      <ol>
        <li>
          <form action="zhuanjiashenqing.php" method="post">
            <div class="sqbiaodan">
              <p class="name"><b>申请人：</b>
                <input type="text" class="input" name="u_name" id="u_name" value="">
                <span style="color:#F00"><em>*</em><?php if ($this->_tpl_vars['msg']['u_name']): ?><?php echo $this->_tpl_vars['msg']['u_name']; ?>
<?php else: ?>您智赢网的用户名<?php endif; ?></span> </p>
              <p><b>手机号：</b>
                <input type="text" class="input" name="mobile" id="mobile" value="">
                <span style=" color:#F00"><?php echo $this->_tpl_vars['msg']['mobile']; ?>
</span> </p>
              <p><b>QQ号：</b>
                <input type="text" class="input" name="sqqq" id="sqqq" value="">
              </p>
              <p><b>擅长赛事：</b>
                <input type="text" class="input" name="sqsc" id="sqsc" value="">
              </p>
              <p><b>自我介绍：</b>
                <input name="ddesc" class="input" type="text" id="ddesc" value="">
                <span><em>*</em>可输入300内字！</span> </p>
              <p class="sub">
                <input type="submit" class="submit" name="submit" id="submit" value="提交申请">
              </p>
            </div>
          </form>
        </li>
        <li>
          <div class="sqxg">
            <h2>专家订阅提供的内容</h2>
            <p>1、亚盘盘口：非竞彩/北单玩法</p>
            <p>2、竞彩：竞彩所有玩法皆可推荐</p>
            <p>3、北单：北单所有玩法皆可推荐</p>
            <p>4、传统足彩：胜负14、任9、六半全、四场进球</p>
          </div>
        </li>
      </ol>
      <div class="clear"></div>
    </div>
  </div>
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
<?php /* Smarty version 2.6.17, created on 2017-12-03 15:00:15
         compiled from zhuanjia/user_recommend_add.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zhuanjia/user_recommend_add.html', 3, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<!--center start-->
<div class="UserRight" style=" height:300px;"><?php if ($this->_tpl_vars['error_tips']): ?>
  <h2><?php echo $this->_tpl_vars['error_tips']; ?>
</h2>
  <?php else: ?>
  <h3>推荐方案<span>(请详细的填写以下信息)</span></h3>
  <div class="URcenter">
    <div class="userinforadd">
      <form action="user_recommend.php" method="post">
        <p><span>方案名称：</span><b>
          <input type='text' class="ustext" value="" name="pname" id="pname">
          </b></p>
        <p><span>比赛日期：</span><b>
          <input type="text" class="ustext" name="pubdate" id="pubdate"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
          </b></p>
        <p><span>订阅截止时间：</span><b>
          <input type="text" class="ustext" name="out_time" id="out_time"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
          </b><u style="text-decoration:none;color:#dc0000;">*</u>截止时间务必在比赛开始时间的前15分钟！</p>
        <p><span>赛事：</span>
          <input id="macth" type='text' class="ustext" value="" name="macth">
        </p>
        <p><span>主队VS客队：</span><u class="">
          <input type='text' class="ustext"  value="" name="duiwu" id="duiwu">
          </u>如：西汉姆联<u>VS</u>赫尔城</p>
        <p><span>推荐：</span>
          <input type='text' class="ustext" value="" name="recommond" id="recommond">
          如：西汉姆联 +0</p>
        <p><span>订阅金额：</span>
          <input type='text' class="ustext" value="" name="pmoney" id="pmoney">
          订阅的额度</p>
        <p><span>方案介绍：</span>
          <textarea name="pcontent" cols="60" id="pcontent"></textarea>
          (500字以内)....</p>
        <p class="sub">
          <input type="submit" value="保&nbsp;&nbsp;&nbsp;存" />
          <input name="action" type="hidden" id="action" value="add_action">
          <br>
          &nbsp;&nbsp; </p>
      </form>
    </div>
  </div>
  <?php endif; ?> </div>
</body>
</html>
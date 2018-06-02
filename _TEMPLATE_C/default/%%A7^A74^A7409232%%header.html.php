<?php /* Smarty version 2.6.17, created on 2017-10-14 18:06:18
         compiled from ../default/confirm/header.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../default/confirm/header.html', 7, false),)), $this); ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['TEMPLATE']['title']; ?>
-聚宝网|聚宝竞彩|彩票赢家首选人气最旺的网站！</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['TEMPLATE']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['TEMPLATE']['description']; ?>
" />
<link href="<?php echo ((is_array($_tmp='header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='touzhu.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jQselect.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='float.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript">
  $(document).ready(function(){
      $("#jjyh").click(function(){
	      $("#lotterycode").val(getCombination());
		  $("#childtype").val(getSelect());
		  $("#TotalMoney").val(getMoney());
          $("#jjyh_form").submit();
      })
  });
</script>
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
</script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='pms.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<link rel="shortcut icon" href="<?php echo @STATICS_BASE_URL; ?>
/i/zy.ico" type="image/x-icon" />           	
</head>
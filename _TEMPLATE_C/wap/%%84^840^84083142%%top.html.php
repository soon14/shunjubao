<?php /* Smarty version 2.6.17, created on 2017-10-18 11:53:27
         compiled from ../admin/top.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/top.html', 26, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
.STYLE1 {
    font-size: 12px;
    color: #000000;
}
.STYLE5 {font-size: 12}
.STYLE7 {font-size: 12px; color: #FFFFFF; }
.STYLE7 a{font-size: 12px; color: #FFFFFF; }
a img {
    border:none;
}
-->
</style>
<script src="<?php echo ((is_array($_tmp='jquery-1.7.1.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
    <script language="javascript">
	    var TMJF = jQuery.noConflict(true);
	    // 存放网站的一些配置信息
	    TMJF.conf = {
	        cdn_i: "<?php echo @STATICS_BASE_URL; ?>
/i"
	        , domain: "<?php echo @ROOT_DOMAIN; ?>
"
	        , www_root_domain: "<?php echo @WWW_ROOT_DOMAIN; ?>
"
	        , passport_root_domain: "<?php echo @PASSPORT_ROOT_DOMAIN; ?>
"
	        , tuan_root_domain: "<?php echo @TUAN_ROOT_DOMAIN; ?>
"
	        , purchase_root_domain: "<?php echo @PURCHASE_ROOT_DOMAIN; ?>
"
	    };
	    
	    if (typeof(console) == "undefined") {
	        var console = {
	            'log': function (msg) {
	
	            }
	        };
	    }
        
        // 校验类
        TMJF.Verify = {};
        
        // 判断是否有效的金额
        TMJF.Verify.isMoney = function (price) {
        	var numStyle = /^[0-9]\d*(\.\d{1,2})?$/; 
            if (!numStyle.test(price)) {
                return false;
            } else {
                return true;
            }
        };
    </script>
    <script src="<?php echo ((is_array($_tmp='common.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="57" background="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_03.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="378" height="57" background=""><h2 style="font-size:20px; font-family:'微软雅黑';color:#fff;">&nbsp;&nbsp;&nbsp;后台管理系统<span style="font-size:12px; font-weight:300;">system</span></h2></td>
        <td>&nbsp;</td>
        <td width="281" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="33" height="27"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_05.gif" width="33" height="27" /></td>
            <td width="248" background="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_06.gif"><table width="225" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                              <td><div align="right"><a href="<?php echo @ROOT_DOMAIN; ?>
/passport/logout.php" target="_parent"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/admin/quit.gif" alt=" " width="69" height="17" /></a></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="40" background="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_10.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="194" height="40" background="">&nbsp;</td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30" background="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_31.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" height="30"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_28.gif" width="8" height="30" /></td>
        <td width="147" background="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_29.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24%">&nbsp;</td>
            <td width="43%" height="20" valign="bottom" class="STYLE1">管理菜单</td>
            <td width="33%">&nbsp;</td>
          </tr>
        </table></td>
        <td width="39"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_30.gif" width="39" height="30" /></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="20" valign="bottom"><span class="STYLE1">当前登录用户：<?php echo $this->_tpl_vars['uname']; ?>
 &nbsp;用户角色：<?php echo $this->_tpl_vars['roleDesc'][$this->_tpl_vars['roleType']]['desc']; ?>
</span>
            <?php if ($this->_tpl_vars['show_message']): ?>
            	<span id='waiting_num' class='STYLE1' ></span><span class='STYLE1' >&nbsp;|&nbsp;刷新频率：</span><input type='text' id='refresh_frequency' value='30' style='width:25px;'/><span class='STYLE1'>分/次</span>
            <?php endif; ?>
            </td>
            <td valign="bottom" class="STYLE1"><div align="right"></div></td>
          </tr>
        </table></td>
        <td width="17"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_32.gif" width="17" height="30" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
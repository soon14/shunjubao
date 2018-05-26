<?php /* Smarty version 2.6.17, created on 2018-03-24 09:30:17
         compiled from ../admin/header.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/header.html', 8, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['TEMPLATE']['title']; ?>
</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
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
        var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
    </script>
<script src="<?php echo ((is_array($_tmp='common.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript">
TMJF(function($) {
      /* 当鼠标在表格上移动时，离开的那一行背景恢复 */
      $(document).ready(function(){ 
            $(".admintable tr td").mouseout(function(){
                var bgc = $(this).parent().attr("bg");
                $(this).parent().find("td").css("background-color",bgc);
            });
      })
      
      $(document).ready(function(){ 
            var color="#f1f1f1"
            $(".admintable tr:odd td").css("background-color",color);  //改变偶数行背景色
            /* 把背景色保存到属性中 */
            $(".admintable tr:odd").attr("bg",color);
            $(".admintable tr:even").attr("bg","#fff");
      });
});
      </script>
<style type="text/css">
<!--
body{font:12px arial;background:#fff}
body,p,form,ul{margin:0;padding:0}
table{text-align:center;border-bottom-width:0;border-collapse:collapse; font-size:12px;}
table tr th{font-size:12px; font-weight:300;}
.big-table {text-align:center;border-width:0px 0px 0px 1px;border-color:#666;border-style:solid;}
.td-head th {background-color:#eeeeee;padding:3px;font-size:14px;font-weight: bold;border-width:1px 1px 1px 0px;border-color:#666;border-style:solid;}
.td-body td {padding:3px;border-width:0px 1px 1px 0px;border-color:black;border-style:solid; font-size:12px;}
.nav {margin:4px 0 8px 0}
.td-no-border td {border-width:0px;}
/* 定义图片的长和宽 */
.img24 {width:40px; height:42px;}

.blackwindow{
background:#000;
filter:alpha(opacity=70);
-moz-opacity:0.7;
opacity:0.7;
position:absolute;
width:100%;
top:0;
left:0;
z-index:2000;
}

.paywindow{
position:absolute;
top:270px;
width:466px;
height:287px;
background:#fff;
border:12px solid #97B600;
z-index:3000;
left:50%;
margin-left:-233px;
}

.paywindow b{
width:55px;
height:55px;
display:block;
background:url(../i/note.jpg) 63px 0 no-repeat;
float:left;
padding-left:63px;
margin-top:23px;
}

.paytxt{
float:left;
margin-top:28px;
margin-left:10px;
width:300px;
}

.pay-note{
color:#666;
line-height:25px;
padding-left:5px;
}

.paytxt .cwbtn{
float:left;
margin-right:10px;
}

.paytxt .cwotherbtn{
padding-right:0px;
font-weight:bold;
}
.cartclose{
float:right;
cursor:pointer;
}
-->
.URcenter h2{ font-size:16px; font-family:'微软雅黑';}
</style>
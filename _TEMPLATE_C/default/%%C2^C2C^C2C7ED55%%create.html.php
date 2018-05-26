<?php /* Smarty version 2.6.17, created on 2017-10-14 20:33:47
         compiled from ../admin/cms/create.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/cms/create.html', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/add_single_img.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='jquery.suggest.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script src="<?php echo ((is_array($_tmp='jquery.suggest.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<style type="text/css">
<!--
body {
    margin-left: 3px;
    margin-top: 0px;
    margin-right: 3px;
    margin-bottom: 0px;
}
.STYLE1 {
    color: #e1e2e3;
    font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
    color: #344b50;
    font-size: 12px;
}
.STYLE21 {
    font-size: 12px;
    color: #3b6375;
}
.STYLE22 {
    font-size: 12px;
    color: #295568;
}

form .form_valid_err {
	border-style: solid;
	border-width: 2px;
    border-color: red;
}
table td{ margin:5px 0;}
-->
</style>
<?php if ($this->_tpl_vars['sunday'] && $this->_tpl_vars['saturday']): ?>
<script type="text/javascript">
TMJF(function ($) {
var sunday = <?php echo $this->_tpl_vars['sunday']; ?>
;
	var saturday = <?php echo $this->_tpl_vars['saturday']; ?>
;
	$("#start_time").val(sunday);
	$("#end_time").val(saturday);
});
</script>
<?php endif; ?>
<script type="text/javascript">
KE.show({
	id : 'desc'
    , imageUploadJson : '<?php echo @ROOT_DOMAIN; ?>
/kindeditor/upload_json.php'
    , fileManagerJson : '<?php echo @ROOT_DOMAIN; ?>
/kindeditor/file_manager_json.php'
    , allowFileManager : true
    //cssPath : './index.css',
    , afterCreate : function(id) {
        KE.event.ctrl(document, 13, function() {
            KE.util.setData(id);
            document.forms['example'].submit();
        });
        KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
            KE.util.setData(id);
            document.forms['example'].submit();
        });
    }
});
TMJF(function ($) {
	
	var passChecked;
	var err = function (id, msg) {
		passChecked = false;
		$("#"+id).addClass("form_valid_err");
		if ($("font[errmsgid='"+id+"']").size() == 0) {
			$("#"+id).after('&nbsp;<font errmsgid="'+id+'" color="red" >*&nbsp;'+msg+'</font>');
		}
	};
	var unerr = function (id) {
		$("#"+id).removeClass("form_valid_err");
		$("font[errmsgid='"+id+"']").remove();
	}
	$("#sub").click(function () {
		passChecked = true;
		
		var name = $("#name").val();
		name = $.trim(name);
		if (!name) {
			err("name", "请输入特卖名称");
		} else {
			unerr("name");
		}		
		
		var start_time = $("#start_time").val();
		if (start_time == '') {
            err("start_time", "请设置开始时间");
        } else if (start_time.length != 19) {
        	err("start_time", "开始时间格式不正确");
        } else {
        	unerr("start_time");
        }
		
	
		
		var end_time = $("#end_time").val();
        if (end_time == '') {
            err("end_time", "请设置结束时间");
        } else if (end_time.length != 19) {
        	err("end_time", "结束时间格式不正确");
        } else {
        	unerr("end_time");
        }
		
        
		if (KE.isEmpty("desc")) {
			err("desc", "请添加描述");
		} else {
			unerr("desc");
		}						
		
        if (!passChecked) {
            return false;
        }
	});

	$("#start_time").blur(function(){
        var time_val = $.trim($("#start_time").val());
        if (time_val.length == 10) {          
        	$("#start_time").val(time_val+' 00:00:00');//加上默认时间12:00:00
        	unerr("start_time");
        	return true;
        }	
    });
	
    $("#end_time").blur(function(){
        var time_val = $.trim($("#end_time").val());
        if (time_val.length == 10) {
            $("#end_time").val(time_val+' 23:59:59'); 
            unerr("end_time");
            return true;
        }
   });
    
    $("#start_time").focus(function(){
		if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		}
    });
	
	$("#end_time").focus(function(){
        if (!$("#end_time").val()) {
        showCalendar('end_time', 'y-mm-dd');
        }
    });	
	$("#batch_show").click(function(){
		$("#batch_info").show();
		return false;
	})
});
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/nav.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div style="text-align:left;">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td><?php if ($this->_tpl_vars['tableInfo']): ?>
      <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/edit.php">
      <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['tableInfo']['id']; ?>
" />
      <?php else: ?>
      <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/create.php">
        <?php endif; ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td width="210" align="right">标题：</td>
            <td align="left"><input id="name" name="name" value="<?php echo $this->_tpl_vars['tableInfo']['name']; ?>
" type="text" /></td>
          </tr>
          <tr>
            <td width="210" align="right">CMS分类：</td>
            <td align="left"><select name="type">
                <?php $_from = $this->_tpl_vars['cmsTypeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmsTypeDesc']):
?>
                <option  value="<?php echo $this->_tpl_vars['cmsTypeDesc']['type']; ?>
" />
                <?php echo $this->_tpl_vars['cmsTypeDesc']['desc']; ?>
 <?php endforeach; endif; unset($_from); ?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="210" align="right">推荐期数(以星期为单位自动生成)：</td>
            <td align="left"><font size=6>
              <input name="batch" value="<?php echo $this->_tpl_vars['batch']; ?>
">
              </font><a href="" id="batch_show">查看本期推荐</a></td>
          </tr>
          <tr>
            <td width="210" align="right">开始时间    (统一格式：2012-01-01 12:00:00)：</td>
            <td align="left"><input id="start_time" name="start_time" value="<?php echo $this->_tpl_vars['tableInfo']['start_time']; ?>
" type="text" /></td>
          </tr>
          <tr>
            <td width="210" align="right">结束时间：</td>
            <td align="left"><input id="end_time" name="end_time" value="<?php echo $this->_tpl_vars['tableInfo']['end_time']; ?>
" type="text"/></td>
          </tr>
          <tr>
            <td width="210" align="right">描述：<br/></td>
            <td align="left"><textarea name="desc" id="desc" cols="80" rows="10"><?php echo $this->_tpl_vars['tableInfo']['desc']; ?>
</textarea></td>
          </tr>
          <tr>
		  	<td width="210" align="right"></td>
            <td align="left"><input id="sub" type="submit" value="提交" name="submit"/>
              <input id="create_uname" name="create_uname" value="<?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
" type="hidden" /></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<div id="batch_info" style="display:none;margin:10px;"> <?php if ($this->_tpl_vars['batchInfos']): ?>
  <table width="30%" border="0" align="left" cellpadding="0" cellspacing="0">
    <thead>
      <tr class="td-head">
        <th>序号</th>
        <th>创建时间</th>
        <th>标题</th>
        <th>创建人</th>
      </tr>
    </thead>
    <?php $_from = $this->_tpl_vars['batchInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['batchInfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['batchInfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['batchInfo']):
        $this->_foreach['batchInfo']['iteration']++;
?>
    <tr class="td-body" 
    <?php if ($this->_foreach['batchInfo']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
    <td><?php echo $this->_tpl_vars['batchInfo']['id']; ?>
</td>
      <td><?php echo $this->_tpl_vars['batchInfo']['create_time']; ?>
</td>
      <td><?php echo $this->_tpl_vars['batchInfo']['name']; ?>
|<a href="<?php echo @ROOT_DOMAIN; ?>
/admin/show_recommend.php?code=<?php echo $this->_tpl_vars['code']; ?>
&&id=<?php echo $this->_tpl_vars['batchInfo']['id']; ?>
" target="_blank" >查看</a>| <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/edit.php?code=<?php echo $this->_tpl_vars['code']; ?>
&&id=<?php echo $this->_tpl_vars['batchInfo']['id']; ?>
" target="_blank" >编辑</a></td>
      <td><?php echo $this->_tpl_vars['batchInfo']['create_uname']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
  <?php endif; ?> </div>
</div>
</body></html>
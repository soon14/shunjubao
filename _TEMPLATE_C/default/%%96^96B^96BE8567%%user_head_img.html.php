<?php /* Smarty version 2.6.17, created on 2017-10-16 11:07:56
         compiled from user_head_img.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
.TouxiangUp{padding:50px 0;}
.upfile-box{position:relative;}
.upbtn{background-color:#FFF;border:1px solid #CDCDCD;height:30px;width:70px;cursor:pointer;}
.upfile{position:absolute;top:0;right:80px;height:30px;filter:alpha(opacity:0);opacity:0;width:260px cursor:pointer;}
.shangzhuan{  margin:0 auto; text-align:left; padding:40px 0 0 ;}
.shangzhuan h1{ font-size:16px; font-family:'微软雅黑';}
.tabuser ul{display:inline-table;display:inline-block;zoom:1;*display:inline;height:40px;line-height:40px;border-bottom:1px solid #ddd;width:100%;}
.tabuser ul li{display:inline-table;display:inline-block;zoom:1;*display:inline;margin:0 0 0 5px;}
.tabuser ul li a{display:inline-table;display:inline-block;zoom:1;*display:inline;padding:0 15px;color:#000;font-size:14px;}
.tabuser ul li a.active{border:1px solid #ddd;border-bottom:1px solid #fff;position:relative;top:-1px;font-weight:300; font-family:'';}
.tabuser ul li.active{border:1px solid #ddd;border-bottom:1px solid #fff;position:relative;top:-2px;font-weight:300;}
</style>
<body>
<!--用户中心上传头像 start-->
<div class="shangzhuan">
  <h1><span>▌</span>个人信息-上传头像</h1>
  <div style="text-align:left;padding:40px 0 0 0;">
  <div class="tabuser">
    <ul>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php">基本信息</a></li>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php" class="active">上传头像</a></li>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_modify_pwd.php">修改密码</a></li>
    </ul>
  </div>
  </div>
  <div class="TouxiangUp">
    <div class="">
      <form action="" method="post" enctype="multipart/form-data">
        <input type='text' name='textfield' d='textfield' />
        <input type='button' value='浏览...'/>
        <input type="file" name="fileField"id="fileField" size="28" onChange="document.getElementById('textfield').value=this.value" />
        <input type="submit" name="submit" value="上传" />
      </form>
    </div>
    <div style="padding:40px 0;color:red;"><?php if ($this->_tpl_vars['img_error']): ?><?php echo $this->_tpl_vars['img_error']; ?>
<?php endif; ?></div>
    <div class="imgtips" style="padding:30px 0 0 0;"><b>温馨提示：</b><span>支持JPG、GIF、PNG的图片上传，上传的头像文件大小不能超过40KB，不超过300*300像素的大小。</span></div>
  </div>
</div>
<!--用户中心上传头像 end-->
</body>
</html>
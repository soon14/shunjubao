<?php /* Smarty version 2.6.17, created on 2017-10-14 20:52:33
         compiled from show_iframe.html */ ?>
<!DOCTYPE html>
<head>
<title>智赢晒单中心-智赢用户最新晒单</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.newshaidan{ height:363px;clear:both;width:240px;border:1px solid #ddd; overflow:hidden;}
.newshaidan h2{ font-size:14px;font-weight:900;height:32px;line-height:32px;border-bottom:1px solid #e1e1e1;padding:0 10px;background:#f9f9f9;position:relative;}
.newshaidan h2 b{display:inline-table;display:inline-block;zoom:1;*display:inline;height:33px;line-height:33px;width:120px;color:#fff;background:#BC1E1F;position:absolute;left:0;text-align:center;border-right:1px solid #e1e1e1;font-size:14px;font-weight:900;font-family:'';}
.newshaidan h2 span{ float:right;}
.newshaidan h2 span a{color:#999;font-size:12px;font-weight:300;}
.newshaidan h2 span a:hover{color:#dc0000;text-decoration:underline;}
.newshaidan dl{ float:left;width:100px;margin:0 auto;text-align:center;margin:10px 0 0 12px;height:143px;border:1px solid #fff;cursor:pointer;padding:3px 0;}
.newshaidan dl:hover{border:1px solid #dc0000;}
.newshaidan dl dt{}
.newshaidan dl dt img{border:1px solid #ddd;width:50px;height:50px;border-radius:50px;}
.newshaidan dl dd{}
.newshaidan dl dd p{ line-height:22px;height:143px;height:22px;overflow:hidden;}
.newshaidan dl dd p em{ font-style:normal;color:#dc0000;}
.newshaidan dl dd p b{ font-size:12px;font-weight:900;}
body{background:#fff;font-size:12px;font-weight:300;font-family:Arial,"宋体",Helvetica, sans-serif;line-height:150%;margin:0;padding:0;color:#404040;text-align:center;}
div{margin:0 auto;padding:0;}
h1,h2,h3,h4,h5,h6,ul,li,dl,dt,dd,form,img,p{margin:0;padding:0;border:none;list-style-type:none;}
body>div{text-align:center;margin-right:auto;margin-left:auto;} 
div,form,ul,ol,li,span,p,dl,dt,dd{margin:0;padding:0;border:0;}
</style>
</head>
<body>
<div class="newshaidan">
  <h2><b>最新晒单</b><span><a href="http://www.zhiying365.com/ticket/show.php" target="_blank">更多</a></span></h2>
  <?php $_from = $this->_tpl_vars['show_tickets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
  <dl>
    <dt> <a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow.php?userTicketId=<?php echo $this->_tpl_vars['item']['id']; ?>
" target="_blank"><?php if ($this->_tpl_vars['show_users_info'][$this->_tpl_vars['item']['u_id']]['u_img']): ?> <img src="<?php echo $this->_tpl_vars['show_users_info'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
"> <?php else: ?> <img src="<?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg"><?php endif; ?></a></dt>
    <dd>
      <p><b><?php echo $this->_tpl_vars['show_users_info'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b></p>
      <p><?php echo $this->_tpl_vars['sportDesc'][$this->_tpl_vars['item']['sport']]['desc']; ?>
</p>
      <p><em><?php echo $this->_tpl_vars['item']['money']; ?>
元</em></p>
      <p>已有<span><?php echo $this->_tpl_vars['item']['follow_num']; ?>
</span>人跟单</p>
    </dd>
  </dl>
  <?php endforeach; endif; unset($_from); ?> </div>
</body>
</html>
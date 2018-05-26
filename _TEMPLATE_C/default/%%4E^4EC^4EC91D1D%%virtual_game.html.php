<?php /* Smarty version 2.6.17, created on 2018-03-29 21:02:26
         compiled from ../admin/game/virtual_game.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/game/virtual_game.html', 3, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="http://www.shunjubao.xyz/www/statics/j/jquery-1.9.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<body>
<script type="text/javascript">
TMJF(function($) {
	$(".start_time").focus(function(){
		showCalendar($(this).attr('itemId')+'start_time', 'y-mm-dd');
	});
	$(".end_time").focus(function(){
		showCalendar($(this).attr('itemId')+'end_time', 'y-mm-dd');
	});
	$(".del").click(function(){
		if(!confirm('确定删除这条记录吗？')) return false;
		return true;
	});
	
	$(".h").blur(function(){
		var a = $(this).closest('tr').find('.a');
// 		a.val(getHA($(this).val()));
	});
	$(".a").blur(function(){
		var h = $(this).closest('tr').find('.h');
// 		h.val(getHA($(this).val()));
	});
	function getHA(num) {
		return 2-Number(num);
	}
});
</script>
<script type="text/javascript">
      /* 当鼠标在表格上移动时，离开的那一行背景恢复 */
      $(document).ready(function(){ 
            $(".admintable tr td").mouseout(function(){
                var bgc = $(this).parent().attr("bg");
                $(this).parent().find("td").css("background-color",bgc);
            });
      })
      
      $(document).ready(function(){ 
            var color="#DCF2FC"
            $(".admintable tr:odd td").css("background-color",color);  //改变偶数行背景色
            /* 把背景色保存到属性中 */
            $(".admintable tr:odd").attr("bg",color);
            $(".admintable tr:even").attr("bg","#fff");
      })
</script>
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li> 开始时间：
          <input type="text" id="0start_time" name="start_time" itemId="0" class="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
          结束时间：
          <input type="text" id="0end_time" name="end_time" itemId="0" class="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
          &nbsp;&nbsp;|&nbsp;&nbsp;
          <input type="submit" name="" value="查询">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
</div>
<div>
  <h2> <b>●</b>运营赛事信息修改</h2>
  <br/>
  <h3 style="font-size:12px; font-weight:300;">说明：1、查询条件的开始和结束时间是创建运营比赛的时间；2、只需填写上盘或下盘赔率，然后点击空白处，另一个赔率自动计算；3、比赛的开始和结束时间需要填写完整格式,例如：2015-02-14 08:00:00</h3>
  <style>
  .admintable input{ width:50px; text-align:center;}
  </style>
  <div class="admintable">
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <th width="30">赛事id</th>
          <th>玩法</th>
          <th>场次<p>第一场比赛</p><p>101</p></th>
          <th>主VS客</th>
          <th>比赛开始时间</th>
          <th>比赛结束时间</th>
          <th>上盘赔率</th>
          <th>让球数<p>(+1,0,-1)</p></th>
          <th>下盘赔率</th>
          <th>赛果</th>
          <th>彩果</th>
          <th>比分</th>
          <th>操作</th>
        </tr>
            <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/virtual_game.php">
        <tr>
          <input name="operate" type="hidden" value="edit"/>
          <input name="id"  type="hidden" value="<?php echo $this->_tpl_vars['item']['id']; ?>
"/>
          <td width="30"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
          <td><select name="sport">
              <?php $_from = $this->_tpl_vars['sportDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?> <option value="<?php echo $this->_tpl_vars['key1']; ?>
" <?php if ($this->_tpl_vars['item']['sport'] == $this->_tpl_vars['key1']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item1']['desc']; ?>

              </option>
              <?php endforeach; endif; unset($_from); ?>
            </select>
          </td>
          <td><input type="text" name="num" value="<?php echo $this->_tpl_vars['item']['num']; ?>
"/></td>
          <td><input type="text" name="host_team" style=" width:70px;" value="<?php echo $this->_tpl_vars['item']['host_team']; ?>
"/>
            VS
            <input type="text" name="guest_team" style=" width:70px;"  value="<?php echo $this->_tpl_vars['item']['guest_team']; ?>
"/></td>
          <td><input id="<?php echo $this->_tpl_vars['item']['id']; ?>
start_time" type="text" name="start_time" itemId="<?php echo $this->_tpl_vars['item']['id']; ?>
" class="start_time" style=" width:130px;" value="<?php echo $this->_tpl_vars['item']['start_time']; ?>
"></td>
          <td><input id="<?php echo $this->_tpl_vars['item']['id']; ?>
end_time" type="text" name="end_time" itemId="<?php echo $this->_tpl_vars['item']['id']; ?>
" style=" width:130px;" class="end_time" value="<?php echo $this->_tpl_vars['item']['end_time']; ?>
"></td>
          <td><input class="h" type="text" name="h" value="<?php echo $this->_tpl_vars['item']['h']; ?>
"></td>
          <td><input type="text" name="remark" value="<?php echo $this->_tpl_vars['item']['remark']; ?>
"></td>
          <td><input class="a" type="text" name="a" value="<?php echo $this->_tpl_vars['item']['a']; ?>
"></td>
          <td><select name="result">
              <?php $_from = $this->_tpl_vars['resultDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?> <option value="<?php echo $this->_tpl_vars['key1']; ?>
" <?php if ($this->_tpl_vars['item']['result'] == $this->_tpl_vars['key1']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item1']['desc']; ?>

              </option>
              <?php endforeach; endif; unset($_from); ?>
            </select></td>
          <td><select name="lottery_result">
              <?php $_from = $this->_tpl_vars['resultDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?> <option value="<?php echo $this->_tpl_vars['key1']; ?>
" <?php if ($this->_tpl_vars['item']['lottery_result'] == $this->_tpl_vars['key1']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item1']['desc']; ?>

              </option>
              <?php endforeach; endif; unset($_from); ?>
            </select></td>
          <td><input type="text" name="score" value="<?php echo $this->_tpl_vars['item']['score']; ?>
"></td>
          <td><input type='submit' value="修改" style="width:40px;">
            <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/game/virtual_game.php?operate=del&id=<?php echo $this->_tpl_vars['item']['id']; ?>
" class="del">删除</a> </td>
        </tr>
      </form>
      <?php endforeach; endif; unset($_from); ?>
      <form method="post" action="">
        <tr>           <td>生成</td>
          <td><select name="sport">
              <?php $_from = $this->_tpl_vars['sportDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
              <option value="<?php echo $this->_tpl_vars['key1']; ?>
"><?php echo $this->_tpl_vars['item1']['desc']; ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>
          </td>
          <td><input type="text" name="num" value=""/></td>
          <td><input type="text" name="host_team" value=""/>
            VS
            <input type="text" name="guest_team" value=""/></td>
          <td><input id="newstart_time" type="text" name="start_time" itemId="new" class="start_time" value=""></td>
          <td><input id="newend_time" type="text" name="end_time" itemId="new" class="end_time" value=""></td>
          <td><input class="h" type="text" name="h" value=""></td>
          <td><input type="text" name="remark" value="0"></td>
          <td><input class="a" type="text" name="a" value=""></td>
          <td><select name="result">
              <?php $_from = $this->_tpl_vars['resultDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
              <option value="<?php echo $this->_tpl_vars['key1']; ?>
"><?php echo $this->_tpl_vars['item1']['desc']; ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select></td>
          <td><select name="lottery_result">
              <?php $_from = $this->_tpl_vars['resultDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
              <option value="<?php echo $this->_tpl_vars['key1']; ?>
"><?php echo $this->_tpl_vars['item1']['desc']; ?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select></td>
          <td><input type="text" name="score" value=""></td>
          <td><input type='submit' value="添加">
            <input type="hidden" name="operate" value="add"></td>
        </tr>
      </form>
      </tbody>
      
    </table>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>
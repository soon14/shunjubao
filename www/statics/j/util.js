var ie6 = $.browser.msie && $.browser.version < 7;
var dlgHeight = ie6 ? 490 : 450;

$(function(){
	// 表单提交选中select, POST才能收到
	$(document.frm_cate).submit(function(){
		var jselect = $('select[name=ids[]]');
		if(jselect.length==0)	return;
		var select = jselect[0];
		for(var i=0; i<select.options.length; i++)
		{
			select.options[i].selected = true;
		}
	});
	// 关键词：移除所选
	$('#remove').click(function(){
		var select = $(this).prev()[0];
		for(var i=0; i<select.options.length; i++)
		{
			if(select.options[i].selected)
			{
				select.remove(i--);
			}
		}
		if(select.options.length == 0)
		{
			alert('所选关键词已全被清空，请重新选择！');
			location = '?action=uncat';
		}
	});
	// 增加1个分类
	$('.jaddc').click(function(){
		$(this).parents('td').next().append('<div>'+
							  '      <input name="cids[]" type="hidden" />'+
							  '		 <input class="jcat_name disabled" disabled="disabled" />'+
							  '      <input type="button" value="浏览..." onclick="selectCat(this);" />'+
							  '		&nbsp;<a href="#na" class="jdelete" title="删除"><img src="' + g_statics_url + '/i/delete.gif" align="absmiddle" /></a>'+
							  '</div>');
	});
	// 移除一个分类
	$('.jdelete').live('click', function(){
		$(this).parent().remove();
	});

});

// 分类编辑：选择上级分类
function selectParentCat(ele)
{
	var jcur = $(ele).parent();
	var jfhide = jcur.find('input[name=f[parent_id]]');
	var ret = window.showModalDialog('/admin/dmoz/cat_dialog.php'
							, {sel:jfhide.val(), cur:ele.form['f[id]'].value}
							, 'dialogwidth:420px; dialogheight:' + dlgHeight + 'px; scroll:no');
	if(ret)
	{
		jfhide.val(ret.parent_id);
		jcur.find('.jcat_name').val(ret.parent_name);
	}
}
// 关键词： 选择分类
function selectCat(ele)
{
	var jcur = $(ele).parent();
	var jfhide = jcur.find('input[name="cids[]"]');
	var ret = window.showModalDialog('/admin/dmoz/cat_dialog.php?type=_kw'
							, {sel:jfhide.val(), cur:0}
							, 'dialogwidth:420px; dialogheight:' + dlgHeight + 'px; scroll:no');
	if(ret)
	{
		jfhide.val(ret.parent_id);
		jcur.find('.jcat_name').val(ret.parent_name);
	}
}

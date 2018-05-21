TMJF(function($){
	//页面载入时将表单中的值，对应到样式上
	$('.init').each(function(){
		var input_v = $(this).val();
		var _parent = $(this).parent();
		var action = _parent.next().attr('class');
		//换购商品特殊处理
		if(action == 'exchangeProd_listof' && $('#ep_json_data').val() !='') {
			epFill($('#ep_json_data').val());
			return;
		}
		if(input_v == '') {
			return;
		}
		
		var input_arr = input_v.split(',');
		$.each(input_arr, function(k, v){
			$.get(TMJF.conf.domain+"/admin/searchNameById.php"
	                , {
	                    id: v,
	                    action: action
	                  }
	                , function(data) {
	                    if (data.ok) {
	                    	tagsExt(_parent, v, data.msg, true);
	                    } else {
	                    	tagsExt(_parent, v, v, true);
	                    }
	                }
	                , 'json' 
	        );
		});
		
		// 打印总条数
		$(".total_"+action).html(input_arr.length);
	});
	
	//直接在textarea中回车输入
	$('.example').keydown(function(e){
		if(e.keyCode==13){
			var _parent = $(this).parent();
			var textarea_val = $.trim(_parent.find('textarea').val());

			if(!tagsExt(_parent, null, textarea_val)) {
				return false;
			}
			
		}
	});
	
	//通过表单提交输入
	$('.input_tagsExt').click(function(){
		var _parent = $('.' + $(this).attr('tagsObj'));
		var input = $('.' + $(this).attr('inputClass'));
		
		if($(this).attr('tagsObj') != 'tag_channelid' && input.attr('inputV') == '') { // 除了渠道id可直接输入外，其他必须搜索输入
			return false;
		}
		
		// 打印总条数
		var input_v = input.parent().find('.init').val();
		var input_arr = [];
		if (input_v) {
			input_arr = input_v.split(',');
		}
		
		$(".total_"+$(this).attr('inputClass')).html(input_arr.length + 1);
		
		//换购商品做的处理
		if($(this).attr('inputClass') == 'exchangeProd_listof') {
			epClick();
			return false;
		}
		
		if(!tagsExt(_parent, input.attr('inputV'), input.val())) {
			input.val('');
			input.attr('inputV', '');
			return false;
		}
		input.val('');
		
	});

	//删除操作
	$('.text-remove').live("click", function(){
		var tag_v = $(this).parent().find('.text-label').attr('val');
		var _tags = $(this).parents('.tags');
		var last_tag_width = $(this).parents('.text-tag').width();//获取删除元素的宽度  #??
		
		//删除当前样式
		$(this).parents('.text-tag').detach();
		
		//构造新的表单值
		var input = _tags.find('input');
		if(input.val() != '') {
			var input_arr = input.val().split(',');
			$.each(input_arr, function(i, n){
				if(input_arr[i] == tag_v) {
					input_arr.splice(i,1);
				}
			});
			
		}
		
		// 打印总条数
		var action = _tags.parent().find('.input_tagsExt').attr('inputClass');
		$(".total_"+action).html(input_arr.length);
		
		input.val(input_arr.join(','));
		
		//确定textarea指针新的位置
		var last_tag = _tags.find('.text-tag:last');
		if(last_tag.position() != null) {
			var textarea_padding_left = last_tag.position().left + last_tag_width; 
			var textarea_padding_top = last_tag.position().top;
		} else {
			var textarea_padding_left = 3; 
			var textarea_padding_top = 3;
		}
		//_tags.find('textarea').css('padding-left', textarea_padding_left);//！！删除操作时这里有点问题
		_tags.find('textarea').css('padding-top', textarea_padding_top);
	});
	
	
	/**
	 * tagsExt
	 * @param _parent 对象
	 * @param int input_val 添加到表单中的值
	 * @param string textarea_val 样式中显示的文本。！！默认使用input_val的值
	 * @param boolean isInit 是否页面初始化调用
	 * @return Boolean
	 */
	function tagsExt(_parent, input_val, textarea_val, isInit) {
		input_val = input_val ? input_val : textarea_val;
		
		var input = _parent.find('input');
		if (!input_val) {
			return false;
		}

		// 构造新的表单值
		if(input.val() != '') {
			var input_arr = input.val().split(',');
			if($.inArray(input_val, input_arr) != -1) {
				_parent.find('textarea').val('');
				
				if(!isInit) { //是初始化时继续执行样式构造
					return false;
				}
			} else {
				input_arr.push(input_val);
				input.val(input_arr.join(','));
			}
			
		} else {
			input.val(input_val);
		}
		
		// 构造新的样式
		var html = '<div class="text-tag"><div class="text-button"><span class="text-label" val="'+input_val+'">' + textarea_val + '</span><a class="text-remove"></a></div></div>'
		_parent.find('.text-tags').append(html);
		_parent.find('textarea').val('');

		//确定textarea指针新的位置
		var _parent_t = _parent;
		var last_tag = _parent_t.find('.text-tag:last');
		var textarea_padding_left = last_tag.position().left + last_tag.width(); 
		var textarea_padding_top = last_tag.position().top;
		
		_parent.find('textarea').css('padding-left', textarea_padding_left);
		_parent.find('textarea').css('padding-top', textarea_padding_top);
		if(_parent.find('textarea').height() <=  last_tag.height()) {
			_parent.find('textarea').height(textarea_padding_top + 40);
			_parent.height(textarea_padding_top + 40);
		}

		//在非IE浏览器中防止textarea指针换行
		if(!document.all) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * 换购商品输入到表单
	 * 数据构造格式：sku-价格
	 */
	function epClick() {
		//是否添加过相同的诉苦
		if(epCheckSKU($('#ep_sku').val())) {
			return false;
		}
		var _parent = $('.tag_exchangeProd_listof');
		var textarea_val = $('#ep_hidden').val() + ';换购价' + $('#ep_price').val() + '元';//表单里显示的文本
		var inputV = $('#ep_sku').val() + '-' + $('#ep_price').val() + '-' + $('#ep_ssProdAttrId').val();//表单里的值
		tagsExt(_parent, inputV, textarea_val);
		$('#ep_price').val('');
		$('#ep_sku').val('');
		$('#ep_ssProdAttrId').val()
		$('#ep_hidden').val('');//清空原内容
	}
	
	/**
	 * 检查是否添加过这个sku
	 * 同一促销不允许有相同的sku出现
	 * 返回值：boolean，存在true，不存在false
	 */
	function epCheckSKU(sku) {
		if(!sku) return false;
		var flag = false;
		var input_val = $("input[name='exchangeProd_listof']").val().split(',');
		$.each(input_val,function(k,v){
			var input_sku = v.split('-');
			if(sku == input_sku[0]) {
				alert('这个sku：'+sku+'已经添加');
				flag = true;
				return false;
			}
		});
		return flag;
	}
	
	/**
	 * 换购商品自动填充到表单
	 */
	function epFill(ep_json_data) {
		var ep_data = ep_json_data.split(',');
		$.each(ep_data, function(k, v){
			var val = v.split('-');
			var sku = val[0];
			var price = val[1];
			var ssProdAttrId = val[2];
			$.get(TMJF.conf.domain+"/admin/searchNameById.php"
	                , {
	                    id: ssProdAttrId,
	                    action: 'ssProdAttrId'
	                  }
	                , function(data) {
	                	var textarea_val = data.msg + ';换购价' + price + '元';
	                    if (data.ok) {
	                    	tagsExt($('.tag_exchangeProd_listof'), v, textarea_val,true);
	                    } else {
	                    	tagsExt($('.tag_exchangeProd_listof'), v, v, true);
	                    }
	                }
	                , 'json' 
	        );
			
		});
	}
});
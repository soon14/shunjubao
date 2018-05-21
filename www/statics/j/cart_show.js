TMJF(function($) {
	var tmpDomain = TMJF.conf.domain;
	$(".del_depot").click(function () {
		if(!confirm('您确认取消该商品吗？'))	return;
		var ssProdAttrId = $(this).attr("ssProdAttrId");
		
		$.post(tmpDomain + '/cart/delete.php'
            , {
                depotId: ssProdAttrId
              }
            , function(data) {
                if (data.ok) {
                    location.reload();
                } else {
                    alert("删除失败:" + data.msg);
                }
            }
            , 'json'
        );
	});
	$(".del_depot_ep").click(function () {
		if(!confirm('您确认取消该商品吗？'))	return;
		var ssProdAttrId = $(this).attr("ssProdAttrId");
		var salesPromotionId = $(this).attr("salesPromotionId");
		$.post(tmpDomain + '/cart/delete.php'
            , {
                depotId: ssProdAttrId,
                salesPromotionId:salesPromotionId
              }
            , function(data) {
                if (data.ok) {
                    location.reload();
                } else {
                    alert("删除失败:" + data.msg);
                }
            }
            , 'json'
        );
	});
	// 修改数量
	var jquantiry = $('.quantiry');
	jquantiry.keyup(function(){
		if (/\D/.test(this.value))	this.value = this.value.replace(/\D/g, '');
	});
	jquantiry.blur(function(){
		var q = parseInt(this.value);
		if (isNaN(q)) {
			this.value = $(this).attr('ori_value');
			return;
		}
		if (q<=0) {
			if (!confirm('您确认取消该商品吗？')) {
				this.value = $(this).attr('ori_value');
				return;
			}
		}
		ajax_edit_q($(this));
	});
	jquantiry.prev('img').click(function(){
		var q = $(this).parent().find('input');
		if (q.val() <= 1) {
			if(!confirm('您确认取消该商品吗？'))	return;
		}
		q.val(parseInt(q.val()) - 1);
		ajax_edit_q(q);
	});
	jquantiry.next('img').click(function(){
		var q = $(this).parent().find('input');
		q.val(parseInt(q.val()) + 1);
		ajax_edit_q(q);
	});
	function ajax_edit_q (j_input_q) {
		var ssProdAttrId = j_input_q.attr('ssProdAttrId');
		var quantity = j_input_q.val();
		if (quantity <= 0) {
			$.post(tmpDomain + '/cart/delete.php'
	            , {
	                depotId: ssProdAttrId
	              }
	            , function(data) {
	                if (data.ok) {
	                    location.reload();
	                } else {
	                    alert("删除失败:" + data.msg);
	                }
	            }
	            , 'json'
	        );
			return;
		}
		
		var sub_total = j_input_q.parents('td').next().find('span');
		$.getJSON(tmpDomain + '/cart/edit_quantiry.php?no-cache=' + Math.random(), {itemId: ssProdAttrId, quantity: quantity}, function(ret){
			if (ret) {
				if (ret.ok) {
					var jq_tips = $("#tips-"+ssProdAttrId);
					switch (ret.msg.type) {
						case 'UNDER_STOCK':// 库存不足
							jq_tips.html("<font color='#912823'>"+ret.msg.msg+"</font>");
							break;
						case 'OK':
							jq_tips.html("<font color='#63AB00'>"+ret.msg.msg+"</font>");
							break;
						default:// 其它情况下的操作
							alert(ret.msg.msg);
						    location.reload();
						    return;
					
					}
					var cart_info = ret.msg.cart_info;
					if (!cart_info.listof[ssProdAttrId]) {
	                    location.reload();
	                    return;
	                }
					
					jq_tips.show();
					jq_tips.fadeOut(1500);
					
					j_input_q.val(cart_info.listof[ssProdAttrId]);
	                j_input_q.attr('ori_value', cart_info.listof[ssProdAttrId]);
	                sub_total.text(cart_info.sub_total);
	                var jcb_ids = $(':checkbox[name=cb_ids]');
	                var jep_keys = $(':checkbox[name=ep_keys]');
	                var totalmoney = 0;
	                jcb_ids.each(function()
	                {
	                	if(this.checked)
	                    {           
	                        totalmoney += $('#attr_money_'+this.value).text() * 100;    
	                    }
	                });
	                jep_keys.each(function()
	    	        {
	    	            if(this.checked)
	    	            {           
	    	                 totalmoney += $('#ep_attr_money_'+this.value).text() * 100;    
	    	             }
	    	        });
	                $('.total_money').text(totalmoney/100);
	                location.reload();
				} else {
					alert(ret.msg.msg);
                    location.reload();
                    return;
				}
			} else {
				alert('修改数量失败！');
			}
		});
	}
	
	

	

	// 全选功能	
	var jcb_selectall = $(':checkbox[name=cb_selectall]');
	var jcb_ids = $(':checkbox[name=cb_ids]');
	var jep_keys = $(':checkbox[name=ep_keys]');
	jcb_selectall.click(function(){
		jcb_ids.attr('checked', this.checked);
		jep_keys.attr('checked', this.checked);
		if(this.checked)
			{    //如果全选，那么选出页面上的值相加
		        var rm_money = 0;
				jcb_ids.each(function()
				{
					rm_money = rm_money.add(Number($('#attr_money_'+this.value).text()));
		
				});
				jep_keys.each(function()
				{
					rm_money = rm_money.add(Number($('#ep_attr_money_'+this.value).text()));
				
				});
				$('.total_money').text(rm_money);
			}
		else      //如果没有选中，那么为0
			{
			$('.total_money').text('0');
			}
	});
	jcb_ids.click(function(){
		var all_checked = true;
		var ssProdAttr_id = this.value;		
		if (!this.checked) {	
			rm_money = Number($('#attr_money_'+ssProdAttr_id).text()) ;	
			money = Number($('.total_money').text()).sub(rm_money);
			$('.total_money').text(money);	
		}	
		if(this.checked)
		{			
			rm_money = Number($('#attr_money_'+ssProdAttr_id).text());				
			money = Number($('.total_money').text()).add(rm_money);
			$('.total_money').text(money);				
		}
		jcb_ids.each(function(){	
			if (!this.checked) {
				all_checked = false;
				return false;
			}	 			
		});
		jcb_selectall.attr('checked', all_checked);
	});
	jep_keys.click(function(){
		var all_checked = true;
		var ssProdAttr_id = this.value;		
		if (!this.checked) {	
			rm_money = Number($('#ep_attr_money_'+ssProdAttr_id).text()) ;	
			money = Number($('.total_money').text()).sub(rm_money);
			$('.total_money').text(money);	
		}	
		if(this.checked)
		{			
			rm_money = Number($('#ep_attr_money_'+ssProdAttr_id).text());				
			money = Number($('.total_money').text()).add(rm_money);
			$('.total_money').text(money);				
		}
		jep_keys.each(function(){	
			if (!this.checked) {
				all_checked = false;
				return false;
			}	 			
		});
		jcb_selectall.attr('checked', all_checked);
	});
	$('.js-confirm').click(function(){
		var sb = [];
		var ep_key= [];//换购商品在购物车中的key
		$(':checkbox[name=cb_ids]:checked').each(function(){
			sb.push(this.value);
		});
		$(':checkbox[name=ep_keys]:checked').each(function(){
			ep_key.push(this.value);
		});
		if (sb.length == 0) {
			alert('没有选择任何商品');
			return false;
		}
		var href = tmpDomain+'/purchase_process/confirm.php?attrIds=' + sb.join(',');
		href += '&ep_keys=' + ep_key.join(',');
		href += "&preview=1";
		this.href = href;
	});
	$('.ep_add_to_cart').click(function(){
		$.post(tmpDomain + '/cart/add_exchangeProd.php'
	            , {
					ssProdAttrId: $(this).attr('ssProdAttrId'),
	                salesPromotionId:$(this).attr('salesPromotionId')
	              }
	            , function(data) {
	                if (data.ok) {
	                	alert('添加成功');
	                    location.reload();
	                } else {
	                    alert(data.msg);
	                }
	            }
	            , 'json'
	        );
	});
	$(document).ready(function(){
		jcb_ids.attr('checked', 'checked');
		jcb_selectall.attr('checked', 'checked');
	});
});
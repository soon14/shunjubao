// 重新渲染订单确认页的模块
var _render_confirm_modules = (function ($) {
	return function (not_use_coupon) {
		var root_domain = $.conf.domain;
		var selected_salesPromotionIds = $("input[name='selected_salesPromotionIds']").val() || '';
		var attrIds = $("input[name='attrIds']").val() || '';
		var ep_keys = $("input[name='ep_keys']").val() || '';
		$.ajax({
			url: root_domain + '/purchase_process/render_confirm_modules.php'
			, data: {
				'_r': Math.random()
				, 'attrIds': attrIds
				, 'selected_salesPromotionIds': selected_salesPromotionIds
				, 'ep_keys': ep_keys
				, 'not_use_coupon': not_use_coupon
			}
			, dataType: 'json'
			, type: 'POST'
			, success: function (data) {
				if (data.ok) {
					var success_tips = data.msg.success_tips;
					delete data.msg.success_tips;
					$.each(data.msg, function (module_id, module_html) {
						$("#"+module_id).html(module_html);
					});
					if (success_tips) {
						alert(success_tips);
					}
				} else {
					alert(data.msg);
				}
			}
		});
	};
})(TMJF);
//切换促销分组时的事件
TMJF(function ($) {
	$("input[name='selected_salesPromotionIds']").live('change', _render_confirm_modules);
	//选择不同在线支付方式的处理
	// 因为下面这段代码，导致 金额确认模块一定会被渲染一次，因为一定会选择支付方式！add by gxg，所以把confirm.php里面判断是否提示可用代金券的代码去掉
	$("input[name='op_type'],input[name='pay_type']").click(function(){
		var op_type = $(this).val();
		if(op_type == 1) return true;//说明选择的是在线支付按钮
		$.common.Cookie.set("op_type", op_type, "gaojie100.com");//说明选择的是在线支付方式
		$.common.Cookie.set("op_type", op_type, "gaojie.com");
		var selected_salesPromotionIds = $("input[name='selected_salesPromotionIds']").val() || '';//其他促销
		var op_salesPromotionIds = $("input[name='op_salesPromotionIds']").val() || '';//在线支付的促销
		//同时有多个促销	
//		if($('#'+op_type+'_sp').attr('op_type') == op_type) {
//			selected_salesPromotionIds = op_salesPromotionIds;
//		} else {
			selected_salesPromotionIds = '';
//		}
		
		var attrIds = $("input[name='attrIds']").val() || '';
		var ep_keys = $("input[name='ep_keys']").val() || '';
		_render_confirm_modulesFn(attrIds, selected_salesPromotionIds, ep_keys);
	});
	//重新渲染订单确认页的模块方法
	function _render_confirm_modulesFn(attrIds, selected_salesPromotionIds, ep_keys) {
		var root_domain = $.conf.domain;
		$.ajax({
			url: root_domain + '/purchase_process/render_confirm_modules.php'
			, data: {
				'_r': Math.random()
				, 'attrIds': attrIds
				, 'selected_salesPromotionIds': selected_salesPromotionIds
				, 'ep_keys': ep_keys
			}
			, dataType: 'json'
			, type: 'POST'
			, success: function (data) {
				if (data.ok) {
					var success_tips = data.msg.success_tips;
					delete data.msg.success_tips;
					$.each(data.msg, function (module_id, module_html) {
						$("#"+module_id).html(module_html);
					});
					if (success_tips) {
						alert(success_tips);
					}
				} else {
					alert(data.msg);
				}
			}
		});
	}
});
	

var prepareCouponList = (function($) {
    var _prepareCouponListFn = function(attrIds, callback) {
        attrIds = attrIds || '';//set the default attrIds to blank
        var ep_keys = $("input[name='ep_keys']").val() || '';
        // 获取已选中的促销活动id集
        var selected_salesPromotionIds = $("input[name='selected_salesPromotionIds']").val() || '';
        
        // 暂时取消使用代金券的点击事件
        $("#prepare-coupon-list").unbind("click", _prepareCouponList);
        
        $.get($.conf.domain+"/account/prepare_coupon_list.php?_r=" + Math.random() + "&attrIds=" + attrIds + "&ep_keys=" + ep_keys + "&selected_salesPromotionIds=" + selected_salesPromotionIds,
            function(data) {
                if (data.ok) {
                    switch (data.msg.type) {
                        case 'OK':
                        	if (data.msg.is_exclusive_coupon) {
                        		if (!confirm("使用代金券后，目前享有的优惠将会取消，您确定使用代金券？")) {
                        			return false;
                        		}
                        	}
                        	
                        	options = {};
                        	$.common.MessageBox.show(data.msg.coupons, '使用代金券', options);

                            if ($.isFunction(callback)) {
                                callback();
                            }

                            break;
                        default:
                            alert(data.msg.msg);
                            location.reload();
                    }
                } else {
                    //if (typeof data.msg == 'object') {
                    //    alert("获取代金券失败：" + data.msg.msg);
                    //} else {
                    //    alert("获取代金券失败：" + data.msg);
                    //}
                    //location.reload();
                	alert(data.msg);
                	return;
                }
                // 恢复点击事件
                $("#prepare-coupon-list").bind("click", _prepareCouponList);
            }
            , 'json'
            );
    },
    _prepareCouponList = function(attrIds) {
        _prepareCouponListFn(attrIds, function() {
            
            $(".btn-close, .c_p_close").click(function(){
            	$.common.MessageBox.hide();
            	return false;
            });

            $("input[name=use]").click(function(){
                var selected = $(this).val();

                if(selected == 'use02'){
                    $(".c_p_enter").show();
                    $(".c_p_choose").hide();
                }else{
                    $(".c_p_enter").hide();
                    $(".c_p_choose").show();

                }
            });
            $('.c_p_warning').hide();
            $('.c_p_in input:text').focus(function(){
                var value = $(this).val();
                if('请输入代金券序号' == value) {
                    $(this).val('');
                }
            });
            
        });
    };
    return _prepareCouponList;
}) (TMJF);
//激活并使用代金券
var activeThenBundleCoupon = (function($) {
    var _activeThenBundleCoupon = function(attrIds) {
        var
            coupon_str = $('.c_p_enter input@[name=coupon_str]').val(),
            coupon_pwd = $('.c_p_enter input@[name=coupon_pwd]').val(),
            attrIds = attrIds || '';//set the default attrIds to blank;
        var ep_keys = $("input[name='ep_keys']").val() || '';
        $.get($.conf.domain+"/account/coupon_active_then_bundle.php?_r=" + Math.random()
            + "&coupon_str=" + coupon_str
            + "&coupon_pwd=" + coupon_pwd
            + "&attrIds=" + attrIds
            + "&ep_keys=" + ep_keys,
            function(data) {
//                window.data = data;
                if (data.ok) {
                    alert(data.msg.msg);
                    
                    _render_confirm_modules();
                    
                    $.common.MessageBox.hide();
                    window.location = '#pay_detail';
//                    location.reload();
                } else {
                    if (typeof data.msg == 'object') {
                        $('.c_p_warning').html(data.msg.msg);
                    } else {
                        $('.c_p_warning').html(data.msg);
                    }
                    $('.c_p_warning').show();
//                    location.reload();
                }
            }
            , 'json'
        );
    };
    
    return _activeThenBundleCoupon;
}) (TMJF);
//选择代金券
var validCoupon = (function($) {
    var _validCoupon = function() {
        var selectedCoupon = $('.modalDialog_window :radio:checked@[name=coupon_str]').val();
        var attrIds = $(".modalDialog_window").attr('attrIds');
        var ep_keys = $("input[name='ep_keys']").val() || '';
        if(!selectedCoupon) {
            alert('请选择代金券!');
            return;
        }
        $.get($.conf.domain+"/cart/coupon_valid.php?_r=" + Math.random() + "&coupon_str=" + selectedCoupon + "&attrIds=" + attrIds + "&ep_keys=" + ep_keys,
            function(data) {
                if (data.ok) {
                    alert(data.msg.msg);
                    
                    _render_confirm_modules();
                } else {
                    if (typeof data.msg == 'object') {
                        alert(data.msg.msg);
                    } else {
                        alert(data.msg);
                    }
//                    location.reload();
                }
                
                $.common.MessageBox.hide();
                window.location = '#pay_detail';
//                location.reload();
            }
            , 'json'
        );
    };
    return _validCoupon;
}) (TMJF);

// 选择首推的代金关
// @author gxg
var useDefaultCoupon = (function($) {
    var _useDefaultCoupon = function(attrIds, coupon_str) {
        var ep_keys = $("input[name='ep_keys']").val() || '';
        console.log('选择首推的代金关');
        $.get($.conf.domain+"/cart/coupon_valid.php?_r=" + Math.random() + "&coupon_str=" + coupon_str + "&attrIds=" + attrIds + "&ep_keys=" + ep_keys,
            function(data) {
                if (data.ok) {
                    _render_confirm_modules();
                } else {
//                    if (typeof data.msg == 'object') {
//                        alert(data.msg.msg);
//                    } else {
//                        alert(data.msg);
//                    }
                }
                //不用跳转 window.location = '#pay_detail';
            }
            , 'json'
        );
    };
    return _useDefaultCoupon;
}) (TMJF);

var cancelUseCoupon = (function ($) {
	function cancelUseCoupon() {
		$.get($.conf.domain+"/cart/cancel_use_coupon.php?_r=" + Math.random(),
            function(data) {
                if (data.ok) {
                    _render_confirm_modules(true);
                } else {
//	                    if (typeof data.msg == 'object') {
//	                        alert(data.msg.msg);
//	                    } else {
//	                        alert(data.msg);
//	                    }
                }
                //不用跳转 window.location = '#pay_detail';
            }
            , 'json'
        );
	};
	return cancelUseCoupon;
})(TMJF);

//TMJF(function($) {
//    $("#prepare-coupon-list").bind("click", function() {
//        prepareCouponList();
//    });
//})

TMJF(function ($){
	var root_domain = $.conf.domain;
	$("#sub_exchange_code").live('click', function(){
		var input_exchange_code_html = "<div class='dhcur'><p style='padding: 0px; margin: 0px; line-height: 25px;'>注：1、每个订单只能使用一张兑换券。<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、使用兑换券的商品不参与代金券等优惠活动。</p><span style='position:relative;bottom:0!important; bottom:3px;color:#000;'>商品兑换券：</span><input type='text' value='输入订单中对应的商品兑换券' name='exchange_code_str' class='dtext'><div class='htsub'><input type='submit' name='sub_exchange_code' class='bdsubmit' value=''></div></p><p style='padding:30px 0 10px 0;'><span>温馨提示：</span>点击<a href='"+root_domain+"/order/orders.php' target='_blank'>“我的账户</a>”--<a href='"+root_domain+"/account/exchange_code.php?status=1500' target='_blank'>“商品兑换券”</a>查看您的商品兑换券信息。</p></div>";
		var options = {};
		$.common.MessageBox.show(input_exchange_code_html, '使用商品兑换券', options);
	});
	
	$("input[name=sub_exchange_code]").live('click', function(){
		var attrIds = $("input[name='attrIds']").val() || '';
		var exchange_code_str = $(".dhcur input[name=exchange_code_str]").val();
		var selected_salesPromotionIds = $("input[name='selected_salesPromotionIds']").val() || '';
		
		$.post(root_domain + "/purchase_process/check_exchange_code_ajax.php"
				, {  selected_salesPromotionIds : selected_salesPromotionIds
					, attrIds : attrIds
					, exchangeCodeStr : exchange_code_str 
				 }
				, function(data) {
					if (data.ok) {
						if (!data.msg) { // 没冲突，继续使用兑换券
							applyExchangeCode(attrIds, exchange_code_str, selected_salesPromotionIds);
							$.common.MessageBox.hide();
						} else {
							var conflict_name = []; // 冲突的促销名称
							$.each(data.msg.conflict_salesPromotions, function (k, v) {
								conflict_name.push("\""+v.name+"\"");
							});
							
							var conflict_text = "使用此兑换券后，购物车内的商品将不满足";
							if (!data.msg.is_coupon_conflict) { // 冲突代金券文案
								conflict_text += "代金券使用条件，";
							}
							if (conflict_name.join("，")) { // 冲突促销文案
								conflict_text += conflict_name.join("，") + "优惠活动，";
							}
							conflict_text += "您是否要继续使用？";
							
							var tmpResult = confirm(conflict_text); // 给用户冲突提示，是否继续使用兑换券
							if (!tmpResult) {
								$.common.MessageBox.hide();
								return false;
							} else {
								applyExchangeCode(attrIds, exchange_code_str, selected_salesPromotionIds);
								$.common.MessageBox.hide();
							}
						}
					} else {
						alert(data.msg);
						return false;
					}
				}
				, 'json'
		);
	});
	
	function applyExchangeCode(attrIds, exchange_code_str, selected_salesPromotionIds) {
		$.post(root_domain + "/account/exchange_code_active.php"
				, {  attrIds :attrIds
					, exchangeCodeStr : exchange_code_str
					, selected_salesPromotionIds : selected_salesPromotionIds
				}
				, function(data) {
					if(data.ok){
						alert(data.msg);
						_render_confirm_modules();
					} else {
						alert(data.msg);
					}
				}
				, 'json'
		);
	}
});
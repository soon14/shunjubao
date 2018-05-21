TMJF(function($) {
	$("#refund_but").click(
			function() {
				var str = document.getElementsByName("box");
				var objarray = str.length;
				var chestr = "";
				for (i = 0; i < objarray; i++) {
					if (str[i].checked == true) {
						chestr += str[i].value + "|,|";
					}
				}
				if (chestr == "") {
					alert("您还没有选择要退款的商品");

					return false;
				} else {
					var show_txt = '';
					var yz_money = 0;// 退款给用户共计总价
					var zj = 0;// 退款商品总价
					var return_userName = $("#return_userName").val();
					var return_on_balance = $("#return_on_balance").val();

					if(return_on_balance.length == 0){
						alert("请输正确的金额");
						return false;
					}

					if(!return_on_balance.match(/^\d*\.?\d{1,2}$/)){
						alert("请输正确的金额");
						return false;
					}
					if(return_on_balance>parseFloat($("#userOrder_money").val())) {
						alert('退款金额大于原订单金额，不允许退款');
						return false;
					}
					var orderAttrId_amount = {};//退款的数量
					var orderAttrId_stock_type = {};//退库存类型
					var orderAttrId_money = {};//退款金额
					var expressfee = 0;//退运费

					$("input[name=box]").each(function() {
						if (!this.checked) {
							return;
						}
						//允许不选商品只退运费
						var orderAttrId = $.trim($(this).attr('orderAttrId'));
						var this_parent = $(this).parent();
						//统计待退商品数
						var this_amount = $(this_parent).find('.amount').val();
						//统计待退商品金额
						var this_money = $(this_parent).find('.money').val();
						//统计退款商品去向
						var this_stock_type = $(this_parent).find('.stock_type').val();

						orderAttrId_amount[orderAttrId] = this_amount;
						orderAttrId_money[orderAttrId] = this_money;
						orderAttrId_stock_type[orderAttrId] = this_stock_type;
					});

					if ($("#expressfee_box").attr('checked') && $.common.Verify.isMoney($("#expressfee").val())) {
						expressfee = $("#expressfee").val();
					}

					return_on_balance = return_on_balance * 1;

					var return_or_coupon = $("#return_or_coupon").val();
					var return_coupon_money = $("#return_coupon_money").val();
					var return_coupon_str = $('#return_coupon_str').val();
				    var return_part_refund_remarks = $("#return_part_refund_remarks").val();
					var return_or_coupon = '';
					var return_userOrderId = $("#return_userOrderId").val();
					var return_out_trade_no = $("#return_out_trade_no").val();
					var return_on_uid = $("#return_on_uid").val();
					var userOrder_cas_token = $.trim($("#userOrder_cas_token").val());
					var refund_reason_type = $("#refund_reason_type").val();

					$("input[name=return_or_coupon]").each(function(i) {
						if (this.checked)
							return_or_coupon = this.value;
					});
					show_txt = show_txt + '订单:' + return_out_trade_no + '\n';

					var strs = new Array();
					strs = chestr.split("|,|");

					for (i = 0; i < strs.length - 1; i++) {
						var yf = $("#expressfee").val();
						if (strs[i] == 'expressfee' && $.common.Verify.isMoney(yf)) {
							show_txt = show_txt + '退运费:' + yf + '元\n';
							zj = zj.add(parseFloat(yf));
						} else {
							var data = strs[i].split('@g@');
							show_txt = show_txt + '退商品:' + data[1] + '*'
									+ orderAttrId_amount[data[5]] + ',sku:' + data[2] + ',此商品总价:'
									+ orderAttrId_money[data[5]] + '元\n';
							zj = zj.add(parseFloat(orderAttrId_money[data[5]]));
						}
					}

					if (return_on_balance != '' && return_on_balance != 0) {
						show_txt = show_txt + '退还用户:' + return_userName
								+ '账户余额' + return_on_balance + '元\n';
						yz_money = yz_money.add(parseFloat(return_on_balance));
					}else{
						show_txt = show_txt + '退还用户:' + return_userName
						+ '账户余额' + 0 + '元\n';
					}

					if (return_or_coupon != '' && return_or_coupon != 'f') {
						show_txt = show_txt + '退还用户:' + return_userName
								+ '代金券:' + return_coupon_str + '面额:'
								+ return_coupon_money;
						//排除代金券到总价 代金券不计算到总额里面去。
						//yz_money = yz_money.add(parseFloat(return_coupon_money));
					}

					//js简单验证
//					if (zj < yz_money) {
//						alert('退款给用户的金额，不能大于所退物品金额！');
//						return false;
//					}

					if(return_coupon_str != '' && return_or_coupon == ''){
						alert('请选择是否退还代金券');
						return false;
					}


					if (yz_money == 0 && (return_or_coupon == '' || return_or_coupon == 'f')) {
						alert('没有输入要退款的金额');
						return false;
					}

					var recover_stock_orderAttrIds = {};
					$(".recover_stock").each(function () {
						if ($(this).attr("checked") == 'checked') {
							var orderAttrId = $.trim($(this).val());
							recover_stock_orderAttrIds[orderAttrId] = orderAttrId;
						}
					});

					// 获取用户订单下各促销优惠的金额（允许客服修改）
					var userOrder_salePromotion_discount_money = {};
					$(".userOrder_salePromotion_discount_money").each(function () {
						var salePromotionId = $(this).attr("salePromotionId");
						var discount_money = $(this).val();
						userOrder_salePromotion_discount_money[salePromotionId] = discount_money;
					});
					console.log(yz_money);
					
					// 判断 补贴10元代金券？ 是否选中
					var subsidy_coupon_10yuan = $("#subsidy_coupon_10yuan").attr("checked");
					if (subsidy_coupon_10yuan == "checked") {
						subsidy_coupon_10yuan = 1;
					} else {
						subsidy_coupon_10yuan = 0;
					}
					
					// 获取需要作废的代金券列表
					var will_cancel_couponStrs = {};
					$(".coupon_strs").each(function () {
						if ($(this).attr("checked") == "checked") {
							var coupon_str = $(this).attr("coupon_str");
							will_cancel_couponStrs[coupon_str] = coupon_str;
						}
					});

					// 提交提醒
					if (confirm(show_txt)) {
						// 提交
						this.disabled = true;//当前按钮不可点击
						$.ajax({
							type : "POST",
							url  : "part_refund_order.php?action=part_refund",
							dataType: "json",
							data : "&userOrderId=" + return_userOrderId
									+ "&refund_money=" + yz_money
									+ "&on_uid=" + return_on_uid
									+ "&on_couponid=" + return_or_coupon
									+ "&coupon_str=" + return_coupon_str
									+ "&products_txt=" + encodeURIComponent(chestr)
									+ "&part_refund_remarks=" + encodeURIComponent(return_part_refund_remarks)
									+ "&userOrder_cas_token=" + userOrder_cas_token
//									+ "&recover_stock_orderAttrIds=" + $.common.JSON.stringify(recover_stock_orderAttrIds)
									+ "&orderAttrId_amount=" + $.common.JSON.stringify(orderAttrId_amount)
									+ "&orderAttrId_money=" + $.common.JSON.stringify(orderAttrId_money)
									+ "&orderAttrId_stock_type=" + $.common.JSON.stringify(orderAttrId_stock_type)
									+ "&expressfee=" + expressfee
									+ "&refund_reason_type=" + refund_reason_type
									+ "&userOrder_salePromotion_discount_money=" + $.common.JSON.stringify(userOrder_salePromotion_discount_money)
									+ "&subsidy_coupon_10yuan=" + subsidy_coupon_10yuan
									+ "&will_cancel_couponStrs=" + $.common.JSON.stringify(will_cancel_couponStrs)
									+ "&userName="+ return_userName + '',

							success : function(data) {
								if(data.ok){
									alert('操作成功');
									$('input[name=box]').attr('checked', '');
									location.reload(true);
								}else{
									alert(data.msg);
								}
							}
						});
						this.disabled = false;//当前按钮可点击
					}
				}
			});


	$(".userOrder_salePromotion_discount_money").dblclick(function () {
		$(this).attr("readonly", null);
	});
    $(".money").dblclick(function () {
		$(this).attr("readonly", null);
	});
	$(".userOrder_salePromotion_discount_money").blur(function () {
        var new_money = parseFloat($.trim($(this).val()));
        if (!$.common.Verify.isMoney(new_money)) {
            alert("不是有效的金额");
            return false;
        }
        var oldMoney = $(this).attr("oldMoney");
        if (new_money > oldMoney) {
        	alert("促销金额只允许减少");
        	return false;
        }
        $(this).attr("readonly", "readonly");

        // 同时调整用户订单折扣总金额
        //userOrder_discount_money
    });

});
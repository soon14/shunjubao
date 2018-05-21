/**
 * 商品属性购买js
 */ 
var PropSelect = (function ($) {
	function PropSelect() {
		// 保留前一个选中的元素
        this.prevEle;
        this.selectClassName = 'selected';
	}
	PropSelect.prototype.isSelect = function (ele) {
		var cls = $(ele).attr('class');
		if (typeof(cls) == "undefined") {
			return false;
		}
        var index = cls.indexOf(this.selectClassName);
        return !(index == -1);
    };
	PropSelect.prototype.select = function (ele) {
		if (this.isSelect(ele)) {// 这里控制是否允许反选
//			return;// 不允许反选
            $(ele).removeClass(this.selectClassName);
        } else {// 该元素之前是未选中过，将其选中
            $(ele).addClass(this.selectClassName);
            if (this.prevEle != ele) {// 将前一个元素反选
                if (typeof(this.prevEle) != "undefined") {
                    $(this.prevEle).removeClass(this.selectClassName);
                }
            }

            this.prevEle = ele;
        }
	};

    return PropSelect;
}) (TMJF);

//alert(depotAttrs.depot_attr_define.amount);
var attr_amount = depotAttrs.attr_amount;
var ps_1 = new PropSelect();
var ps_2 = new PropSelect();

TMJF(function($) {
	var tmpDomain = TMJF.conf.domain;
	var purchase_root_domain = TMJF.conf.purchase_root_domain;
	
	// 切换左侧图片
	function changeLeftImgs(imgs, data) {
		var eleData = $("#productImageGrid").attr("data");
		if (eleData == data) {
			return ;
		}
		$("#productImageGrid").attr("data", data);
		
		var tmpHtml = '<div class="prodImage">';
		if (typeof(imgs[0]['l_2000x2000']) != "undefined" && imgs[0]['l_2000x2000'].length > 0) {
			tmpHtml += '<a href="'+imgs[0]['l_2000x2000']+'" class="MYCLASS" rel="gal1" title="MYTITLE1" ><img class="prod_img_308x400" src="'+imgs[0]['b_308x330']+'" /></a>';
		} else {
			tmpHtml += '<img class="prod_img_308x400" src="'+imgs[0]['b_308x330']+'" />';
		}
		tmpHtml += '</div><span class="blank10"></span>';
		
		tmpHtml += '<ul class="simage">';
		$.each(imgs, function (k, v) {
			tmpHtml += '<li><a href="javascript:void(0);" rel="{gallery: \'gal1\', smallimage: \''+v['b_308x330']+'\',largeimage: \''+v['l_2000x2000']+'\'}"';
			if (k == 0) {
				tmpHtml += ' class="zoomThumbActive"';
			}
			tmpHtml += ' >';
			tmpHtml += '<img src="'+v['s_47x51']+'" />';
			tmpHtml += '</a></li>';
		});
		tmpHtml += '</ul>';
		
		$("#productImageGrid").html(tmpHtml);
		
		$('.MYCLASS').jqzoom({
	        zoomType: 'standard',
	        lens:true,  
	        zoomWidth: 580,   
	        zoomHeight: 427,   
	        xOffset:41,   
	        yOffset:0,
	        title:false,
	        preloadImages: false,
	        alwaysOn:false
	    });
	}
	
	// 将数据编码成base64，并使之成为合法的url的一部分
	function base64url_encode($data) {
		$new_data = $.common.Base64.encode($data);
		$new_data = $new_data.replace(/\+/g, '-').replace(/\//g, '_');
		$new_data = $new_data.replace(/=+$/, '');// 去掉尾部=号
		return $new_data;
	}
	
	// 渲染属性
	function renderAttr(i, v) {
		var html = '<li data="' + v['attr_' + i]['value']  + '" data_base64="' + base64url_encode(v['attr_' + i]['value'])  + '"';
		if (typeof(v['attr_' + i]['small_img']) != "undefined" && v['attr_' + i]['small_img'].length > 0) {// 有图片的属性
            html += '><b></b><a style="background-image: url(' + v['attr_' + i]['small_img'] + ');" href="javascript:void(0);" title="' + v['attr_' + i]['value'] + '"><span class="text-hidden">' + v['attr_' + i]['value'] + '</span></a>';
        } else {
            var len = v['attr_' + i]['value'].length;
			if (len > 2) {
				html += 'class="nopic" ><b></b><a href="javascript:void(0);"><span>' + v['attr_' + i]['value'] + '</span></a>';
			} else {
				html += 'class="nopic" style="width:40px;"><b></b><a href="javascript:void(0);" style="width:40px;"><span>' + v['attr_' + i]['value'] + '</span></a>';
			}
        }
        html += "</li>";
        $("#attr_" + i + " ul").append(html);
	}
	// 渲染属性描述
	function renderAttrDefine(i) {
		var html = '<table class="pro-detail pro-tu" id="attr_' + i + '"><tr>';
        html += "<td class='pro-t'>";
        html += depotAttrs.depot_attr_define["attr_" + i] + "</td><td class='colon'>：";
        html += "</td>";
        if(i==2) html += "<td class='pro-c' id='attrs_2'><ul>";//添加id用来对其li标签进行排序
        else html += "<td class='pro-c'><ul>";
        if(depotAttrs.depot_attr_define["attr_" + i] == "尺码"){
            if(depotAttrs.add_sizeTable != null){
            	if(depotAttrs.sizecheck != false){
                	html += '</ul></td><td class="lvse"><a  target="_blank" href="'+ depotAttrs.add_sizeTable +'">尺码对照表</a></div></td></tr></table>';
            	}
            }
        }
        $("#prop").append(html);
	}
	
	// 初始化属性选中提示
	function initAttrSelectedTips() {
		var tmpHtml = '<span id="selected_value_desc">请选择</span><i>：</i>';
		for (var i = 1; i <= attr_amount; i++) {                  //添加了tips字段 //meng
			tmpHtml += '<b id="selected_value_attr_'+i+'"><dd style="color:red;float:left;margin-right:3px;" id="tips_'+i+'">"'+depotAttrs.depot_attr_define["attr_" + i]+'”</dd></b>';
        }
		$("#selected_value_div").html(tmpHtml);
	}
	initAttrSelectedTips();
	
	// 当选中一个属性时，提示相应的文本
	function tipWithSelectAttr(attrKey, value) {
		var nonSelectedOfAll = true;
			var tmpHtml = '<span id="selected_value_desc">您已选择</span><i>：</i>';
			$.each(selectedAttrs, function (k, v) {
				var i = k+1;
				if (!v) {				//添加了tip字段 //meng
					tmpHtml += '<b><dd style="color:red;float:left" id="tip_'+i+'">'+'请选择'+depotAttrs.depot_attr_define["attr_" + i]+'</dd></b>';
				}else{
					nonSelectedOfAll = false;
					tmpHtml += '<b><dd style="float:left;" id="selected_value_attr_'+i+'">“'+v+'”</dd></b>';
				}
			});

		if (!nonSelectedOfAll) {
			$("#selected_value_div").html(tmpHtml);
		} else {
			initAttrSelectedTips();
		}
	}
	
	// 获取指定特卖商品属性id的信息
	function getSSProdAttrById(id) {
		var ssProdAttr;
		TMJF.each(depotAttrs.ssProdAttrs, function (k, v) {
			if (v.id == id) {
				ssProdAttr = v;
			}
		});
		return ssProdAttr;
	}
	
	// 属性初始化
    var k_v_ssProdAttrs = [];// 以属性值拼成key，商品属性信息为值的数组
    var data_amount_non_zero = {};// 凡值相关的amount不为0的，都记录在这个数组里。方便初始化那些不可点击的属性
    for (var i = 1; i <= attr_amount; i++) {
    	data_amount_non_zero[i] = [];
    }
    var depot_has_img = {};
    var attrs = [];// 数组长度是 depotAttrs.depot_attr_define.amount，值为不重复的属性值
    var selectedAttrs = [];// 已选中的属性
    for (var i = 0; i < attr_amount; i++) {
    	attrs[i] = [];//初始化
    	selectedAttrs[i] = null;//初始化

    	renderAttrDefine(i+1);
    }
    TMJF.each(depotAttrs.ssProdAttrs, function (k, v) {
    	// 填充点击商品属性后切换左而图片的数据结构
    	for (var i = 1; i <= attr_amount; i++) {
    		if (typeof(depot_has_img[v['attr_' + i]['value']]) == "undefined") {
    			if (typeof(v['attr_' + i]['small_img']) != "undefined" && v['attr_' + i]['small_img'].length > 0) {// 有小图
        			depot_has_img[v['attr_' + i]['value']] = v['imgs'];
        		}
    		}
    		if (v.amount > 0) {
    			if ($.inArray(v['attr_' + i]['value'], data_amount_non_zero[i]) == -1) {
    				data_amount_non_zero[i].push(v['attr_' + i]['value']);
    			}
    		}
    	}
    	
    	
        var tmpArrKey = '';
        for (var i = 1; i <= attr_amount; i++) {
        	
            tmpArrKey += "_" + v['attr_' + i]['value'];

            if ($.inArray(v['attr_' + i]['value'], attrs[i - 1]) == -1) {
                attrs[i - 1].push(v['attr_' + i]['value']);
                renderAttr(i, v);
            }

        }
        k_v_ssProdAttrs[tmpArrKey] = {
            'id': v['id']
            , 'amount': v['amount']
        };
    });
//    sortByAttr2();
    console.log(depot_has_img);
    console.log("库存数非0的属性值");
    console.log(data_amount_non_zero);
    console.log(attrs);
    console.log(selectedAttrs);
    console.log(k_v_ssProdAttrs);
    var a = function () {

    };
    a.prototype.canBuy = function () {
    	for (var i = 0; i < attr_amount; i++) {
        	if (selectedAttrs[i] == null) {
     		    return false;
        	}
    	}

    	return true;
    };
    a.prototype.getSelectedDepot = function () {
        var key = '';
    	for (var i = 0; i < attr_amount; i++) {
            if (selectedAttrs[i] == null) {
                return false;
            }

            key += "_" + selectedAttrs[i];
        }
    	console.log(key);
    	console.log(k_v_ssProdAttrs[key]);

        return k_v_ssProdAttrs[key];
    };
    // 获取选中属性的商品属性id
    a.prototype.getDepotId = function () {
        if (!this.canBuy()) {
            return false;
        }

        return '1';
    };

    var _a = new a();
    
    // 选中属性后的操作，需要判断其它属性是否可操作
    // 以下情况不可操作：
    // 1、不存在的属性值
    // 2、存库为0
    function tt(idx, value1) {
    	var ssProdAttrs = getsSSProdAttrsBy(idx + 1, value1);
    	for (var i = 0; i < attr_amount; i++) {
    	    if (i == idx) {
        	    continue;
    	    }

    	    (function () {
 	    	    var _i = i;
  	    	    $("#attr_" + (_i+1) + " li").each(function () {
	                var objTMJF = $(this);
	                var value2 = objTMJF.attr("data");

	                if (!inSSProdAttrs(_i+1, value2, ssProdAttrs)) {//判断所选商品属性对应下的另一组属性是否存在
	                	objTMJF.addClass("notive");
	                    objTMJF.unbind("click");
	                } else {
	                	var cls = $(this).attr('class');
	            		if (typeof(cls) == "undefined") {
	            			return;
	            		}
	                	if (cls.indexOf("notive") != -1) {
		                	console.log('need remove notive');
	                		objTMJF.removeClass("notive");

	                		(function () {
	                            var __i = _i;
	                            objTMJF.bind("click", function() {
	                            	attrClickFn(__i, this);
	                            });
	                        }) ();
	                	}
	                }
	            });
    	    }) ();
    	}
    }

    function untt(idx, value1) {
    	var ssProdAttrs = getsSSProdAttrsBy(idx + 1, value1);
        for (var i = 0; i < attr_amount; i++) {
            if (i == idx) {
                continue;
            }

            (function () {
                var _i = i;
                $("#attr_" + (_i+1) + " li").each(function () {
                    var objTMJF = $(this);
                    var value2 = objTMJF.attr("data");

                    if (!inSSProdAttrs(_i+1, value2, ssProdAttrs)) {
                    	var cls = $(this).attr('class');
                		if (typeof(cls) == "undefined") {
                			return false;
                		}
                    	if (cls.indexOf("notive") != -1) {
                            console.log('need remove notive');
                            objTMJF.removeClass("notive");

                            (function () {
                                var __i = _i;
                                objTMJF.bind("click", function() {
                                    attrClickFn(__i, this);
                                });
                            }) ();
                        }
                    }
                });
            }) ();
        }
        
        var rightAwayToBuy = $('#rightAwayToBuy');
        var  addToCart = $('#addToCart');
        var  preSale_message = $("#preSale_message");       
        rightAwayToBuy.show();     
		addToCart.removeClass("btn7");
		preSale_message.hide();
		 var show_message = $("#sale_message");
		show_message.show();
		addToCart.addClass("btn2");
    }

    function attrClickFn(i, _this) {
    	console.log('gxg');
        objPropSelect[i].select(_this);

        if (objPropSelect[i].isSelect(_this)) {// 选中了一个属性
        	var val = $(_this).attr("data");
            selectedAttrs[i] = val;
            
            if (typeof(depot_has_img[val]) != "undefined") {// 选中了含图片的商品属性，切换左边的图片
            	changeLeftImgs(depot_has_img[val], val);
            	console.log(depot_has_img[val]);
            }
            tipWithSelectAttr(i+1, val);

            tt(i, selectedAttrs[i]);

            console.log(selectedAttrs);
            
            var depot = _a.getSelectedDepot();
            var rightAwayToBuy = $('#rightAwayToBuy');
            var  addToCart = $('#addToCart');
            var  preSale_message = $("#preSale_message");
            var show_message = $("#sale_message");
            if (depot) {// 选中了一件商品
            	var tmpSSProdAttr = getSSProdAttrById(depot.id);
            	if(tmpSSProdAttr.ssProdAttrId){
            		rightAwayToBuy.hide();
            		addToCart.removeClass("btn2");
            		addToCart.addClass("btn7");
            		preSale_message.show();            		
            		show_message.hide();
            	}else{
            		rightAwayToBuy.show();
            		addToCart.removeClass("btn7");
            		addToCart.addClass("btn2");
            		preSale_message.hide();
            		show_message.show();
            	}
            	$("#unit_price").text(tmpSSProdAttr.unit_price + "元");
            	$("#old_price").text(tmpSSProdAttr.old_price + "元");
            	$("#gaojie_price").text(tmpSSProdAttr.gaojie_price + "元");
            	var discount = Number(tmpSSProdAttr.unit_price).div(tmpSSProdAttr.old_price).mul(10);
            	var discountStr = discount.toString().substr(0,3).replace(".0",'');
            	$(".discount").text('(' + discountStr + '折)');
            	var vip_price = Math.floor(Number(tmpSSProdAttr.unit_price).mul(98)).div(100);
            	$("#vip_price").text(vip_price + '元');
            	var tmpSkuHtml = '<b style="color:#333333"><dd>&nbsp;&nbsp;&nbsp;&nbsp;SKU:'+tmpSSProdAttr.prodAttr.sku + '</dd></b>';
            	$("#selected_value_div").html($("#selected_value_div").html() + tmpSkuHtml);
            	
            	for (var _i = 1; _i <= attr_amount; _i++) {
            		if (tmpSSProdAttr["attr_"+_i].value == val) {
            			/*
            			if (tmpSSProdAttr["attr_"+_i].big_img.length > 0) {//当前选中商品属性有大图，执行相关操作
            				// do nothing
            			}
            			*/
            		}
            	}
            	// 进入页面实时刷新运费显示
		        setFreightmoney();
		        
		        // 选中了sku，判断剩余库存，是否要提示快买
		        if (tmpSSProdAttr.amount <= 5) {
		        	$("#just_buy_it_tips").show();
		        } else {
		        	$("#just_buy_it_tips").hide();
		        }
            }
        } else {
        	untt(i, selectedAttrs[i]);
            selectedAttrs[i] = null;
            
        	var val = $(_this).attr("data");
        	tipWithSelectAttr(i+1, val);
        	
        	// 没有选中sku，隐藏快买提示
        	$("#just_buy_it_tips").hide();
        }

        // 这处代码没啥作用，只是用于触发log输出
        _a.getSelectedDepot();
    }

    function inSSProdAttrs(idx, value, ssProdAttrs) {
        var isIn = false;
        $.each(ssProdAttrs, function (k, v) {
            if (v['attr_' + idx]['value'] == value) {
            	isIn = true;
            }
        });
        return isIn;
    }

    function getsSSProdAttrsBy(idx, value) {
     	var ssProdAttrs = [];

    	$.each(depotAttrs.ssProdAttrs, function (k, v) {
    	    if (v['attr_' + idx]['value'] == value) {
    	    	if (v['amount'] > 0) {// 库存为0的不允许再购买了
    	    		ssProdAttrs.push(v);
    	    	}
    	    } 
    	});

    	return ssProdAttrs;
    }
    
    var objPropSelect = [];// 存放属性选择对象的实例
    for (var i = 0; i < attr_amount; i++) {
    	objPropSelect[i] = new PropSelect();

    	// 让 变量i的值闭包，因为后面还会用到
    	(function () {
    		var _i = i;
    		$("#prop #attr_" + (_i+1) + " li").bind("click", function() {
    			attrClickFn(_i, this);
            });
    	}) ();
    }

    function addToCartClickFn(callback) {
        var depot = _a.getSelectedDepot();
    	if (!_a.getSelectedDepot()) {
    		
    		
          // alert('请选择颜色以及尺码型号');
        } else {
        	var jq_quantity = $("#qselected");
        	var quantity = jq_quantity.val();
        	if(!$.common.Verify.isInt(quantity) || quantity < 1){
        		alert('至少购买一件商品');
        		return;
        	}
        	
        	// 暂时取消购买按钮的点击事件
        	$("#addToCart").unbind("click", addToCart);
        	$("#rightAwayToBuy").unbind("click", rightAwayToBuy);
        	
        	$.common.CrossDomainAjax.get(purchase_root_domain+"/cart/add.php?_r="+Math.random()+"&quantity="+quantity+"&itemId=" + depot.id, function (data) {
            	if (data.ok) {
            		switch (data.msg.type) {
            			case 'UNDER_STOCK':
            				
            				jq_quantity.css({'color':'red'});
            				if (jq_quantity.next("span[class='tips']").length) {
            					jq_quantity.next("span[class='tips']").html("&nbsp;&nbsp;<font color='red'>库存不足</font>");
            				} else {
            					jq_quantity.after("<span class='tips'>&nbsp;&nbsp;<font color='red'>库存不足</font></span>");
            				}
            				
            				setTimeout(function () {
            					jq_quantity.next("span[class='tips']").html("&nbsp;&nbsp;<font color='red'>自动修改成可购买数量</font>");
            					jq_quantity.val(data.msg.real_amount);
            					jq_quantity.css({'color':'black'});
            					
            					if (jq_quantity.next("span[class='tips']")) {
            						jq_quantity.next("span[class='tips']").fadeOut(1000, function () {
            							jq_quantity.next("span[class='tips']").remove();
            						});
            					}
            					// 进入页面实时刷新运费显示
                		        setFreightmoney();
            				}, 700);
            				
                    		break;
            			case 'OK':
            				var cart_info = data.msg.cart_info;
                    		if ($.isFunction(callback)) {
                    			callback({
                    				'prod_num': cart_info.items
                    				, 'money': cart_info.money
                    			});
                    		}
                    		
                    		break;
            			default:
            				alert(data.msg.msg);
            				location.reload();
            		}
            	} else {
            		if (typeof data.msg == 'object') {
            			alert("购买失败：" + data.msg.msg);
            		} else {
            			alert("购买失败：" + data.msg);
            		}
            		location.reload();
            	}
            	// 恢复点击事件
            	$("#addToCart").bind("click", addToCart);
            	$("#rightAwayToBuy").bind("click", rightAwayToBuy);
        	}
        	, 'json'
        	);
        }
    }
    // 立即购买的动作
    function rightAwayToBuy() {
    	checkAndShow();  //判断弹出窗口；
    	addToCartClickFn(function() {
    		var depot = _a.getSelectedDepot();
    		location.href = purchase_root_domain + "/purchase_process/confirm.php?attrIds=" + depot.id;
    	});
    }
    
    // 判断并弹出窗口显示哪个属性没有选择   //meng
    function checkAndShow()
    { 	
		var tips = '';
    	for (var i = 1; i <=attr_amount; i++) {
    		if($("#tip_"+i).html() != null)
    		{
    			tips += $("#tip_"+i).html();
    		}    			
    	}    	
    	if(tips == '')
    	{
    		for (var i = 1; i <=attr_amount; i++) {
        		if($("#tips_"+i).html() != null)
        		{
        			tips += $("#tips_"+i).html();
        		}    			
        	}        		
    		if(tips != '')
    		{
    			tips = '请选择' + tips;
    			alert(tips);
    		}
        		        	
    	}
    	else
    	{
    		alert(tips);
    	}
    }
    
    // 加入购物车
    function addToCart() {      
    	checkAndShow();  //判断弹出窗口； 		//meng
		addToCartClickFn(function(params) {
			var html = $("#add_to_cart_tips").html();
			html = html.replace('#cart_prod_num#', params.prod_num);
			html = html.replace('#cart_money#', params.money);
			var options = {};
			$.common.MessageBox.show(html, '商品已成功加入购物车', options);
    	});
    }
    $("#addToCart").bind("click", addToCart);
    $("#rightAwayToBuy").bind("click", rightAwayToBuy);
    
    // 将属性值置为不可选中
    for (var i = 1; i <= attr_amount; i++) {
    	$("#attr_"+i+" li[data]").each(function () {
    		var objTMJF = $(this);
    		if ($.inArray(objTMJF.attr('data'), data_amount_non_zero[i]) == -1) {
                objTMJF.addClass("notive");// 设为不可点
                objTMJF.unbind("click"); //取消click的绑定事件
            }
    	});
    }
    
    var color = depotAttrs.color;
    var j = 1;
    if (color) {
    	if ($("#attr_1 li[data='"+color+"']").size()) {// 支持color直接是颜色值的情况(旧版本)
    		$("#attr_1 li[data='"+color+"']").click();
    	} else {// 支持地址栏里传进来的color是base64编码后值的情况
    		$("#attr_1 li[data_base64='"+color+"']").click();
    	}
    	j = 2;
    }
    	// 处理默认选中属性
        for (var i = j; i <= attr_amount; i++) {
        	var singleElesNum = 0;
        	var defaultSelectedEle;
        	$("#attr_"+i+" li[data]").each(function () {
        		var cls = $(this).attr('class');
        		if (typeof(cls) == "undefined" || cls.indexOf("notive") == -1) {// 可选中的属性
        			singleElesNum++;
        			defaultSelectedEle = this;
        		}
        	});
        	if (singleElesNum == 1) {
        		$(defaultSelectedEle).trigger("click");
        	}
        }
 
        // 根据售价和购买数量
        function setFreightmoney() {
        	var unit_price = parseFloat($("#unit_price").html());
        	var quantity = $("#qselected").val();
        	if(!$.common.Verify.isInt(quantity) || quantity < 1){
        		//alert('至少购买一件商品');
        		return;
        	}
        	if(!$.common.Verify.isMoney(unit_price) || unit_price < 0.1){
//        		alert('商品价格不合法或找不到');// 不弹出。TODO 不知为啥iphone上会弹这个，有时间查下原因。
        		return;
        	}
        	var totalMoney = unit_price * quantity;
        	if (totalMoney >= expressfeeValve) {
        		$("#freightmoney").html("0元");
        		return;
        	}
        	$("#freightmoney").html("10元");
        	return;
        }
        
        // 进入页面实时刷新运费显示
        setFreightmoney();
        // 修改购买量时添加change事件
        $("#qselected").change(function(){
        	 setFreightmoney();
        });
        // 对第二个属性进行排序
        function sortByAttr2() {
        	var color_rank = ['XS','S','M','L','XL','XXL','XXXL'];//所有可能的颜色，从大到小
        	var unit_rank = ['1g','2g','3g','4g','5g','6g','7g','8g','9g','10g'];
        	var obj_attr2_ul = $('#attrs_2 ul:first').clone();
        	var html_num_ul = [];//数字的组合
        	var html_ul = [];//字符的组合
        	var html_unit_ul = [];//单位组合
        	var html_other_ul = [];//其他字符的组合
        	$('#attrs_2 ul:first li').each(function(i, item){
        		var this_data = $(item).attr('data');
        		if($.common.Verify.isInt(this_data)) {
        			html_num_ul[this_data] = $(this).clone();
        		} else if ($.inArray(this_data, color_rank) != -1){
        			html_ul[this_data] = $(this).clone();
        		} else if ($.inArray(this_data, unit_rank) != -1){
        			html_unit_ul[this_data] = $(this).clone();
        		} else {
        			html_other_ul[this_data] = $(this).clone();
        		}
            });
        	$('#attrs_2 ul:first').html('');
        	//对数字组合优先排序
        	if(html_num_ul !=[]) {
        		var all_num = [];//全部数字
        		for(var ele in html_num_ul){
        			all_num.push(ele);
        		}
        		all_num.sort();
        		for(var ele in all_num){
            		$('#attrs_2 ul:first').append(html_num_ul[all_num[ele]]);
        		}
        	}
        	if(html_ul != []) {
        		for(var i=0;i<color_rank.length;i++){
            		if(typeof html_ul[color_rank[i]] != 'undefined') {
            			$('#attrs_2 ul:first').append(html_ul[color_rank[i]]);
            		}
            	}
        	}
        	if(html_unit_ul != []) {
        		for(var i=0;i<unit_rank.length;i++){
            		if(typeof html_unit_ul[unit_rank[i]] != 'undefined') {
            			$('#attrs_2 ul:first').append(html_unit_ul[unit_rank[i]]);
            		}
            	}
        	}
        	if(html_other_ul != []) {
        		for(var ele in html_other_ul){
            		$('#attrs_2 ul:first').append(html_other_ul[ele]);
        		}
        	}
        }
});
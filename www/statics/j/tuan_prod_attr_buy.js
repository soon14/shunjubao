/**
 * 商品属性购买js
 */ 
var PropSelect = (function ($) {
	function PropSelect() {
		// 保留前一个选中的元素
        this.prevEle;
        this.selectClassName = 'active';
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

//alert(depotAttrs.depot_attr_define.attr_1);

var attr_amount = depotAttrs.attr_amount;
var ps_1 = new PropSelect();
var ps_2 = new PropSelect();

TMJF(function($) {
	var tmpDomain = TMJF.conf.domain;
	var purchase_root_domain = TMJF.conf.purchase_root_domain;
	
	// 渲染属性
	
	function renderAttr(i, v) {	 

		var html = ' <li data="' + v['attr_' + i]['value']  + '"><div></div>';
		/* if (typeof(v['attr_' + i]['small_img']) != "undefined" && v['attr_' + i]['small_img'].length > 0)// 有图片的属性
			 {
				 html += '<a href="javascript:void(0);" style="background-image: url(' + v['attr_' + i]['small_img'] +');width:17px;height:19px; overflow:hidden; padding:0;margin:0;"> <span style="display:none;">' + v['attr_' + i]['value'] + '</span></a>';
		      }
			 else
		     {*/
				 html += '<a href="javascript:void(0);">'+ v['attr_' + i]['value'] +'</a>';
		    
		 html += '</li>';
		
        $("#attr_" + i + " ul").append(html);
	}
	
	// 渲染属性描述
	function renderAttrDefine(i) {
		var html = ' <div class="ks_gb_choose" id="attr_' + i + '">';
		html += '<span class="ks_gb_choose_title">'+ depotAttrs.depot_attr_define["attr_" + i] + '：</span>';
		html += '<ul class="floatleft ks_gb_choosesizelist">';
		html += '</ul>';
		html += '<div class="clear"></div>';
		html += '</div>';
	 
        $("#prop").append(html);
	}
	
	// 初始化属性选中提示
	function initAttrSelectedTips() {
		//style="color:red;float:left;margin-right:3px;"
		var tmpHtml = '<span class="gray">请选择：</span>';
		for (var i = 1; i <= attr_amount; i++) {                  //添加了tips字段 //meng
			tmpHtml += ' <span class="red" id="selected_value_attr_'+i+'"><em style="color:red;margin-right:3px;" id="tips_'+i+'">"'+depotAttrs.depot_attr_define["attr_" + i]+'”</em></span>';
        }
		$("#selected_value_div").html(tmpHtml);
	}
	initAttrSelectedTips();
	
	// 当选中一个属性时，提示相应的文本
	function tipWithSelectAttr(attrKey, value) {
		var nonSelectedOfAll = true;
			var tmpHtml = '<span class="gray">您已选择：</span>';
			$.each(selectedAttrs, function (k, v) {
				var i = k+1;
				if (!v) {				//添加了tip字段 //meng
					tmpHtml +='<span class="red"'+'">请选择<em style="color:red;margin-right:3px;" id="tips_'+i+'">'+depotAttrs.depot_attr_define["attr_" + i]+'</em></span>';
				}else{
					nonSelectedOfAll = false;
				    tmpHtml += '';
					tmpHtml += '<span class="green pdlr4" id="selected_value_attr_'+i+'">“'+v+'”</span>';
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
    	 	for (var i = 1; i <= attr_amount; i++) {
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
	                	objTMJF.addClass("nogoods");
	                    objTMJF.unbind("click");
	                } else {
	                	var cls = $(this).attr('class');
	            		if (typeof(cls) == "undefined") {
	            			return false;
	            		}
	                	if (cls.indexOf("nogoods") != -1) {
		                	console.log('need remove nogoods');
	                		objTMJF.removeClass("nogoods");

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
                    	if (cls.indexOf("nogoods") != -1) {
                            console.log('need remove nogoods');
                            objTMJF.removeClass("nogoods");

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

    function attrClickFn(i, _this) {
    	console.log('点击方法');
        objPropSelect[i].select(_this);

        if (objPropSelect[i].isSelect(_this)) {// 选中了一个属性
        	var val = $(_this).attr("data");
        	
            selectedAttrs[i] = val;
            
           
            tipWithSelectAttr(i+1, val);

            tt(i, selectedAttrs[i]);

            console.log(selectedAttrs);
            
            var depot = _a.getSelectedDepot();
            
        
            var addToCart = $('#addToCart');
            var rightAwayToBuy = $('#rightAwayToBuy');
          
            
            if (depot) {// 选中了一件商品
            	var tmpSSProdAttr = getSSProdAttrById(depot.id);            
            	$("#unit_price").text(tmpSSProdAttr.unit_price);
            	$("#old_price").text(tmpSSProdAttr.old_price);
            	var discount = Number(tmpSSProdAttr.unit_price).div(tmpSSProdAttr.old_price).mul(10);
            	var discountStr = discount.toString().substr(0,3).replace(".0",'');
            	$(".discount").text( discountStr + '折');
            	
            	
            	var tmpSkuHtml = 'SKU：<font color=#63AB00 >'+tmpSSProdAttr.prodAttr.sku + '</font>';
            	$(".pdsku").html(tmpSkuHtml);
            	
            	for (var _i = 1; _i <= attr_amount; _i++) {
            		if (tmpSSProdAttr["attr_"+_i].value == val) {
            			/*
            			if (tmpSSProdAttr["attr_"+_i].big_img.length > 0) {//当前选中商品属性有大图，执行相关操作
            				// do nothing
            			}
            			*/
            		}
            	}
            	
            }
        } else {
        	untt(i, selectedAttrs[i]);
            selectedAttrs[i] = null;
            
        	var val = $(_this).attr("data");
        	tipWithSelectAttr(i+1, val);
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
        	$.common.CrossDomainAjax.get($.conf.purchase_root_domain+"/cart/add.php?_r="+Math.random()+"&quantity="+quantity+"&itemId=" + depot.id, function (data) {
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
                    		/*
            				window.location.href=$.conf.domain+"/cart/show.php";            			
                    	    */
                    		
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
  
   console.log('测试走到那一步');
    for (var i = 1; i <= attr_amount; i++) {
    	$("#attr_"+i+" li[data]").each(function () {
    		var objTMJF = $(this);
    		//alert(data_amount_non_zero[i]);
    		if ($.inArray(objTMJF.attr('data'), data_amount_non_zero[i]) == -1) {
                objTMJF.addClass("nogoods");// 设为不可点
                objTMJF.unbind("click"); //取消click的绑定事件
            }
    	});
    }
   
    var color = depotAttrs.color;
    
    if (color) {
    	$("#attr_1 li[data='"+color+"']").click();
    } else {
    	// 处理默认选中属性
        for (var i = 1; i <= attr_amount; i++) {
        	var singleElesNum = 0;
        	var defaultSelectedEle;
        	$("#attr_"+i+" li[data]").each(function () {
        		var cls = $(this).attr('class');
        		if (typeof(cls) == "undefined" || cls.indexOf("nogoods") == -1) {// 可选中的属性
        			singleElesNum++;
        			defaultSelectedEle = this;
        			console.log(defaultSelectedEle);
        		}
        	});
        	if (singleElesNum == 1) {
        		$(defaultSelectedEle).trigger("click");
        	}
        }
    }
    
});
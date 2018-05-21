 /** 
  * 通过url查找商品信息，返回商品状态，对于已经售光的商品添加一个图片,并更新价格和折扣信息
  * 返回对象具体形式请参阅 activity/getssProdInfoByUrl.php
  * by hsy 2012-8-15
  */
(function($) {
	//获取url，防止返回头信息过多，每50个url查找1次
	var urls = [];
	var i = 0;
	var className = '.search_img';
	var purchase_root_domain = TMJF.conf.purchase_root_domain;
	
	$(className).each(function(){
		var _this = $(this).find('a');
		var url = _this.attr('href');
		if(typeof url != 'undefined' && url != ''){
			i++;
			urls.push(getShortUrl(url));
			if(i >= 10) {
				autoAppendHtml(urls,className);
				i = 0;
				urls = [];
			}
		}
	});
	if(urls == '') return false;
	autoAppendHtml(urls,className);
	
	function autoAppendHtml(urls,className) {
		var html = '<p class="qiang">抢光了</p>';
		//判断商品是否已卖光
		$.common.CrossDomainAjax.post($.conf.www_root_domain + '/activity/getssProdInfoByUrl.php'
	            , {urls: urls
	              }
	            , function(data) {
	                var info = data.msg;
	                console.log(info);
	              	//填充抢光了图片
	            	$(className).each(function(){
	            		var _this = $(this).find('a');
	            		var url = _this.attr('href');
	            		var obj_this = $(this).parent().find('.search_price1');
	            		if(typeof url != 'undefined' && url != ''){
	            			var this_info = info[getShortUrl(url)];
	            			if(typeof this_info == 'undefined') {
	            				return;
	            			}
	            			updatePrice(obj_this, this_info);//更新价格
	            			if(this_info.status != 4000 || this_info.ss_status != 2100){
	            				$(this).append(html);
	            				changeAddToCartNone($(this).parent());
	            			}
	            		}
	            	}); 
	            }
	            , 'json'
	  );
	}
	
	//防止数据过长，把有效的url部分返回,暂不支持团购商品
	function getShortUrl(url) {
		if(url == 'undefined') return false;
		var short_url = '';
		var reg = [];
		reg[0] = /product\/p([^\/]+)m\//;
//		reg[1] = /tuanprods\/p([^\/]+)m\//;
//		reg[2] = /tuan\/detail\/p([^\/]+)m\//;
//		for(var i=0;i<3;i++) {
			var matches = url.match(reg[0]);
			if(matches) {
				return matches[1];
			}
//		}
		return false;
	}
	//实时更新购买价格，成本价和折扣
	function updatePrice(obj, info) {
		if(typeof obj == 'undefined') return false;
		if(typeof info == 'undefined') return false;
		
		var this_b = $(obj).find('b').eq(0);//售价
		var this_strong = $(obj).find('strong').eq(0);//原价
		var this_span = $(obj).find('span').eq(0);//折扣
		
		var unit_price = info.unit_price;
		var old_price = info.old_price;
		if(!$.common.Verify.isMoney(unit_price) || !$.common.Verify.isMoney(old_price)) {
			return false;
		}
		var zhekou = Number(Number(unit_price).div(old_price)).mul(100);
		zhekou = Math.floor(zhekou).div(10);
		
		$(this_b).html(info.unit_price+'元');
		$(this_strong).html(info.old_price+'元');
		if($(this_span).text().match(/折/)) $(this_span).html('('+ zhekou +'折)');
	}
	//加入购物车按钮的控制
	function changeAddToCartNone(obj) {
		var addToCartUrl_n = 'http://wwwcdn.gaojie1oo.com/upload/2012/1227/192542_80376.png';//加入购物车的图片（不可点击）
		$(obj).find('.addToCartImg').attr('src', addToCartUrl_n);
		$(obj).find('.btn2').css('cursor','default');
	}
	// 加入购物车
    function addToCart(params) { 
			var html = $("#add_to_cart_tips").html();
			html = html.replace('#cart_prod_num#', params.items);
			html = html.replace('#cart_money#', params.money);
			var options = {};
			$.common.MessageBox.show(html, '商品已成功加入购物车', options);
    }
    function addToCartClickFn(depotId) {
        $.common.CrossDomainAjax.get(purchase_root_domain+"/cart/add.php?_r="+Math.random()+"&quantity=1&itemId=" + depotId, function (data) {
            if (data.ok) {
            	switch (data.msg.type) {
            		case 'UNDER_STOCK':
            			//alert('库存不足');
                    	break;
            		case 'OK':
            			var cart_info = data.msg.cart_info;
            			addToCart(cart_info);
                    	break;
            		default:
            			alert(data.msg.msg);
//            			location.reload();
            	}
            } else {
            	if (typeof data.msg == 'object') {
            		alert("购买失败：" + data.msg.msg);
            	} else {
            		alert("购买失败：" + data.msg);
            	}
//            	location.reload();
            }
        }
        , 'json'
        );
    }
	$(".btn2").click(function(){
		//商品非抢光时可点击
		if(!$(this).parent().parent().find('.qiang').html()) {
			addToCartClickFn($(this).attr('depotId'));
		}
		return false;
	});
})(TMJF);
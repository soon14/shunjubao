TMJF(function($){
	var www_root_domain = TMJF.conf.www_root_domain;
	var num = $(".SSProduct").attr("num");
	var site = $(".SSProduct").attr("site");
	var html = $(".SSProduct").html(); //原始html
	var replace_after_html = ''; // 替换后的html
	
	if (!num) {
		return false;
	}
	$.post(www_root_domain+'/get_random_product.php'
            , {num : num , site : site}
            , function(data) {
                if (data.ok) {
                	var SSProds_r = data.msg;
                	if (SSProds_r == '') {
                		return false;
                	}
                	
                	$(".SSProduct").empty();
                	print_html(SSProds_r);
                	$(".SSProduct").show();
                } else {
                	alert(data.msg);
                	return false;
                }
            }
            , 'json'
	);

	function print_html(SSProds) {
		for (var id in SSProds) {
			var discount = SSProds[id].unit_price / SSProds[id].old_price *10;
			discount = parseInt(discount * 10) / 10;
			var productUrl = www_root_domain+'/product/p'+SSProds[id].friendlyUrl+'m';
			replace_after_html = html.replace(/\#productName#/g, SSProds[id].productInfo.name);
			replace_after_html = replace_after_html.replace(/\#productImg_0#/g, SSProds[id].default_ssProdAttr.imgs[0].b_308x330);
			replace_after_html = replace_after_html.replace(/\#productImg_1#/g, SSProds[id].default_ssProdAttr.imgs[1].b_308x330);
			replace_after_html = replace_after_html.replace(/\#old_price#/g, SSProds[id].old_price);
			replace_after_html = replace_after_html.replace(/\#unit_price#/g, SSProds[id].unit_price);
			replace_after_html = replace_after_html.replace(/\#discount#/g, discount);
			replace_after_html = replace_after_html.replace(/\#productUrl#/g, productUrl);
			$(".SSProduct").append(replace_after_html);
		}
	}
	
});
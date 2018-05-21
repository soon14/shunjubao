// 团列表页滚动加载处理
TMJF(function ($) {
	$("[ajaxNextPageUrl]").each(function () {
		var ajaxNextPageUrl = $(this).attr('ajaxNextPageUrl');
		var pageHtml = $(".page").html();
	    if (typeof(ajaxNextPageUrl) == "undefined") {
	        return;
	    }
	    $(".page").scrollLoad(ajaxNextPageUrl, function (url) {
	        // 引用函数自身
	        var func_self = arguments.callee;
	        var jq = $(this);
	        jq.html('<img src="'+TMJF.conf.cdn_i+'/loadding.gif" />');
	        $.ajax({
	            url: url
	            , type: "GET"
	            , dataType: "json"
	            , success: function (data) {
	                if (data.ok) {
	                    $('.ks_gb_leftshowlist').append(data.msg.html);
	                    
	                    // 如果存在下一页，或者ajax调取数据失败，则继续绑定滚动加载事件
	                    if (data.msg.hasNextPage) {
	                        jq.html("");
	                        jq.scrollLoad(data.msg.nextPageUrl, func_self);
	                    } else {
	                        jq.html(pageHtml);
	                    }
	                }
	            }
	            , error: function (xhr, textStatus, errorThrown) {
	                switch (textStatus) {
	                    case 'parsererror':// 返回了非json数据
	                        jq.html("获取下一页出错，原因："+xhr.responseText);
	                        break;
	                    case 'timeout':// 超时，可以重绑滚动加载事件
	                        jq.html("获取下一页超时");
	                        jq.scrollLoad(url, func_self);
	                        break;
	                    case 'error':
	                        if (xhr.status == 504) {// 超时，可以重绑滚动加载事件
	                            jq.html("获取下一页超时");
	                            jq.scrollLoad(url, func_self);
	                            break;
	                        }
	                    default:
	                        jq.html("获取下一页出错");
	                }
	            }
	            , timeout: 5000
	        });
	    });
	});
});
// 当滚动条滚动到指定元素时，调用回调函数
(function ($) {
	/**
	 * @param mixed _config 可以是字符串的url；也可以是一个对象，目前允许的参数有：
	 * {
	 *     url: ''// url
	 *     , upperBound //元素的上边界。默认为0，即当滚动元素到窗口可见时，才加载。如果指定upperBound为正值，则当元素离窗口可见upperBound像素时，就开始提前加载。
	 *     , lowerBound //元素的下边界。如果指定，则滚动条超出元素顶部＋下边界后，不加载。用于防止用户一下把滚动条拉出元素范围，仍然加载。
	 * }
	 * 
	 * 当元素顶端与可见窗口的上边框对齐时，元素的 offset().top值与$(document).scrollTop()值相等。
	 */
	var scrollLoad = function (_config, callback) {
		if (typeof(_config) == 'string') {
			var config = {
				url: _config
			}
		} else {
			var config = _config;
		}
		config.upperBound = config.upperBound || 0;
		var _this = this;
		var jq = $(_this);
		var cb_scroll = function () {
            if (jq.size() == 0) {
                return;
            }
            var scrollTop = $(document).scrollTop();
            var canLoad = false;// 用于标识能否加载
            if (config.lowerBound) {
            	if (scrollTop >= (jq.offset().top - $(window).height() - config.upperBound)
            	    && (scrollTop < (jq.offset().top + config.lowerBound))
            	) {
            		canLoad = true;
            	}
            } else {
            	canLoad = scrollTop >= (jq.offset().top - $(window).height() - config.upperBound);
            }
            if (canLoad) {
            	// 取消滚动事件的绑定，不然会发出一系列的回调
            	$(window).unbind('scroll', cb_scroll);
                if (typeof(callback) == 'function') {
                	callback.call(_this, _config);// 把原生输入参数传递给回调函数
                }
            }
        };
        // 绑定滚动事件
		$(window).bind('scroll', cb_scroll);
    };
    // 扩展到html元素
    $.fn.extend({
    	scrollLoad: scrollLoad
    });
})(TMJF);
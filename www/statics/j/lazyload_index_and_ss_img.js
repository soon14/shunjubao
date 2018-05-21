/**
 * 延迟加载首页、特卖页图片
 */
TMJF(function ($) {
    $("[lazyLoadUrl]").each(function () {
        var img_url = $(this).attr('lazyLoadUrl');
        if (typeof(img_url) == "undefined") {
            return;
        }
        // 提前500像素开始加载(upperBound)，超出元素底部400像素后(lowerBound)，不加载
        $(this).scrollLoad({url:img_url, lowerBound:400, upperBound:500}, function (config) {
            // 引用函数自身
            $(this).attr('src', config.url);
        });
    });
    // 向下滚动1像素。确保打开页面时，停留位置的满足加载条件的元素会被加载到
    $(document).scrollTop($(document).scrollTop()+1);
});
/**
 * 效果：将图片元素往上收，然后再把新图片元素往下展示，直到全部展示完成。
 * @author gxg
 *
 */
TMJF(function ($) {
    $("[slideChange]").each(function () {
        var new_img = $(this).attr("slideChange");
        // 对新图片做个预加载
        var objImage = new Image();
        objImage.src = new_img;
        
        var this_slideChange = this;
        setTimeout(function () {
            $(this_slideChange).slideUp(2000, function () {
                var _this = this;
                $("img", this).attr("src", new_img);
                $(_this).slideDown(2000);
            });
        }, 4000);
    });
    
    // 将整块素材隐藏，再往下拉展示的效果
    $("[slideDown]").each(function () {
        var new_img = $(this).attr("slideDown");
        $(this).hide();
        var this_slideDown = this;
        $("img", this).attr("src", new_img);
        $("img", this).load(function () {
        	$(this_slideDown).slideDown(4000);
        });
    });
});
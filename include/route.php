<?php
/**
 *
 * 路由配置文件，供 Route.class.php类使用
 */

/**
 *
 * 对 create_function 函数的一个简单包装
 * @param string $statement 待执行的语句
 * @param string $params 附加的参数。默认会 传进来 $match参数，如果还需要其它参数，可以通过$params传递，格式(一定要包在单引号里)： '$param_a,$param_b'
 * @return 匿名函数
 */
if (!function_exists('wrap_create_function')) {
	function wrap_create_function($statement, $params = null) {
		if (is_null($params)) {
			$params = '$match';
		} else {
			$params = '$match,'.$params;
		}
		return create_function(
			$params,
			$statement
		);
	}
}

return array(
	'normal'	=> array(// 普通的、无需正则配置的路由
		'index.php'	=> array(// 首页
			'file'	=> 'index.php',
		),
		'partners'	=> array(// 合作方查看的统计数据页
			'file'	=> '/partners/statis.php',
		),
		'account/msgcenter'	=> array(
			'file'	=> 'account/msgcenter.php',
		),

		'about/about'	=> array(// 公司简介
			'file'	=> '/help/about.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "about";'),
		),
		'about/bd'    => array(  //诚聘英才
			'file'	=> '/help/about.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "bd";'),
		),
		'about/contact'    => array(  //联系我们
			'file'	=> '/help/about.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "contact";'),
		),
		'about/media'    => array(  //媒体报道
			'file'	=> '/help/about.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "media";'),
		),
		'about/recruitment'    => array(  //招聘信息
			'file'	=> '/help/about.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "recruitment";'),
		),
		'about/links'    => array(  //招聘信息
			'file'	=> '/help/about.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "links";'),
		),
		'help/help'	=> array( //帮助页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "help";'),
		),
		'help/buy'    => array(  //购买流程页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "buy";'),
		),
		'help/faq'    => array( //常见问题页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "faq";'),
		),
		'help/payment'	=> array( //付款页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "payment";'),
		),
		'help/shipping'    => array( //配送页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "shipping";'),
		),
		'help/service'    => array(  //售后服务页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "service";'),
		),
		'help/bulkbuy'    => array(  //大宗购物
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "bulkbuy";'),
		),
		'help/washing'    => array( // 洗涤标准页面
			'file'	=> '/help/help.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "washing";'),
		),
		'help/size'	=> array(//
			'file'	=> '/help/help.php',  //尺寸参照
				'callback'	=> wrap_create_function('
				$_GET["type"] = "size";'),
		),
		'help/agreement'    => array(
			'file'	=> '/help/help.php', //用户协议
			'callback'	=> wrap_create_function('
				$_GET["type"] = "agreement";'),
		),
		'help/vip'    => array(
			'file'	=> '/help/help.php', //用户协议
			'callback'	=> wrap_create_function('
				$_GET["type"] = "vip";'),
		),
		'help/Partner'    => array(
			'file'	=> '/help/help.php', //用户协议
			'callback'	=> wrap_create_function('
				$_GET["type"] = "Partner";'),
		),
		'promotions/promotions'	=> array(//
			'file'	=> '/help/promotions.php',  //最新活动
				'callback'	=> wrap_create_function('
				$_GET["type"] = "promotions";'),
		),
		'promotions/promotion1'    => array(
			'file'	=> '/help/promotions.php', //赠品信息
			'callback'	=> wrap_create_function('
				$_GET["type"] = "promotion1";'),
		),
		'promotions/promotion2'    => array(
			'file'	=> '/help/promotions.php', //免运费政策
			'callback'	=> wrap_create_function('
				$_GET["type"] = "promotion2";'),
		),
		'admin/tongji'	=> array(
			'file'	=> '/admin/investor/index.php' //投资方查看的宏观统计数据
		),
		'promise'	=> array(
			'file'	=> 'promise.php'//高街承诺页面
		),
		'jadecolour'=> array(
			'file'	=> 'jadecolour.php'//高街承诺页面
		),
		'activity/change'	=> array(
			'file'	=> '/activity/change.php' //投资方查看的宏观统计数据
		),

    //以下 360商城接入
		'360getproduct'    => array(
			'file'	=> '/api/mall360/index.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "GetProduct";'),
		),
		'360getprice'    => array(
			'file'	=> '/api/mall360/index.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "GetPrice";'),
		),
		'360desktop'    => array(
			'file'	=> 'index.php',
			'callback'	=> wrap_create_function('
				header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");
				setcookie("from_360desktop", 1, 0, "/", DOMAIN);
				$_GET["type"] = "360desktop";
			'),
		),
	),
	'regular'	=> array(// 需正则的路由配置
		'#^baokuan(?:/(\S+))?$#i'		=> array(
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'baokuan.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = $match[1];
			'),
		),
		'#^search/([ \S]+)/?$#i'	=> array(// 搜索
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'search.php',
			'callback'	=> wrap_create_function('
				$_GET["keyWord"] = $match[1];
			'),
		),
		'#^(apparel|shoesbags|home|taste|luxe)(?:/(\d+))?$#i'	=> array(// 特卖分类之 服饰
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'index.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^(beauty)(?:/(\d+))?$#i'	=> array(// 特卖分类之 服饰
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'beauty.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^activitys/(\S+)$#i'	=> array(// 活动页
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'activity/activity.php',
			'callback'	=> wrap_create_function('
				$_GET["rootAdd"] = $match[1];
			'),
		),
		'#^partners/(\S+)[^(.php)]$#i'	=> array(// 合作方查看的统计数据页
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'partners/statis.php',
			'callback'	=> wrap_create_function('
				$_GET["adsense_from"] = $match[1];
			'),
		),
		'#^etao/item/+(\d+)\.xml$#i'	=> array(// etao
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'etao/index.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = "item";
				$_GET["id"] = $match[1];
			'),
		),
		'#^product/p([a-z]+)m(?:/(.+))?$#i'	=> array(// 特卖商品详细页
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'specialSaleProduct.php',
			'callback'	=> wrap_create_function('
				$_GET["friendlyUrl"] = $match[1];
				$_GET["color"] = $match[2];
			'),
		),
		'#^tuanprods/[\d]+([a-z]+)/?$#i'	=> array(// 特卖商品详情页(百度团购接口使用)
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'maskToTuanFromSSProd.php',
			'callback'	=> wrap_create_function('
				$_GET["friendlyUrl"] = $match[1];
			'),
		),
		'#^product(\d+)$#i'	=> array(// 特卖商品详细页   这个维护兼容性
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'specialSaleProduct.php',
			'callback'	=> wrap_create_function('
				$_GET["id"] = $match[1];
			'),
		),
		'#^sku/p([a-z]+)m(?:/(.+))?$#i'	=> array(// 专用于显示sku的url规则
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'specialSaleProduct.php',
			'callback'	=> wrap_create_function('
				$_GET["friendlyUrl"] = $match[1];
				$_GET["color"] = $match[2];
				$_GET["show_sku"] = true;
			'),
		),
		'#^tuan/today(?:/([a-z]+)(?:/(\d+))?)?$#i'	=> array(// 团购 今日推荐
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'tuan_index.php',
			'callback'	=> wrap_create_function('
				$_GET["categoryType"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^tuan/list(?:/([a-z]+)(?:/(\d+))?)?$#i'	=> array(// 团购 今日推荐
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'tuan_list_now.php',
			'callback'	=> wrap_create_function('
				$_GET["categoryType"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^tuan/endlist(?:/([a-z]+)(?:/(\d+))?)?$#i'	=> array(// 团购 今日推荐
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'tuan_list_over.php',
			'callback'	=> wrap_create_function('
				$_GET["categoryType"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),

		'#^tuan/detail/([a-z]+)?$#i'	=> array(// 团购 今日推荐
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'tuan_detail.php',
			'callback'	=> wrap_create_function('
				$_GET["ssProdId"] = $match[1];
			'),
		),
		'#^([a-z]+)/([a-z]+)(?:/(\d+))?$#i'	=> array(// 特卖页
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'specialSale.php',
			'callback'	=> wrap_create_function('
				$_GET["type"] = $match[1];
				$_GET["friendlyUrl"] = $match[2];
				$_GET["page"] = $match[3];
			'),
		),
		'#^ver[^\-]+/([bf]=.*)$#i'	=> array(// 该路由配置只会用在线下开发环境
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'js_css_min.php',
			'callback'	=> wrap_create_function('
				$_GET["files"] = $match[1];
			'),
		),
		'#^ver[^\-/]+/(.*)$#i'	=> array(// 该路由配置只会用在线下开发环境
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'js_css_min.php',
			'callback'	=> wrap_create_function('
			echo ROOT_DOMAIN . "/statics/" . $match[1]."";
				header("Location: " . ROOT_DOMAIN . "/statics/" . $match[1]."");
				exit;
			'),
		),
		'#^category/(?:(\d+))(?:/([\d\.]+))?$#i'	=> array(// TAG系统
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'category.php',
			'callback'	=> wrap_create_function('
				$_GET["categoryId"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^sellout_category/(?:(\d+))(?:/(\d+))?$#i'	=> array(// 已售完TAG页面
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'sellout_category.php',
			'callback'	=> wrap_create_function('
				$_GET["categoryId"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^brand/(?:(\d+))(?:/([\d\.]+))?$#i'	=> array(// TAG系统
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'brand.php',
			'callback'	=> wrap_create_function('
				$_GET["brandId"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		'#^sellout_brand/(?:(\d+))(?:/(\d+))?$#i'	=> array(// 已售完TAG页面
			'type'	=> Route::PATTERN_TYPE_REGULAR,
			'file'	=> 'sellout_brand.php',
			'callback'	=> wrap_create_function('
				$_GET["brandId"] = $match[1];
				$_GET["page"] = $match[2];
			'),
		),
		),
);
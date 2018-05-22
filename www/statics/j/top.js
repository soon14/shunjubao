$(document).ready(function(){
	var u_name = '';
	var cash = 0.00;
	var arrCookie = document.cookie.split(/;\s*/); 
	//遍历cookie数组，处理每个cookie对 
	for(var i=0;i<arrCookie.length;i++){
		var arr = arrCookie[i].split("=");
		//找到名称为userId的cookie，并返回它的值
		if("u_name" == arr[0]){
			u_name = decodeURIComponent(arr[1]); 
		}
		if("cash" == arr[0]){
			cash = arr[1];
		}
	}
	
	var welcome_str = "<li>&nbsp;</li>";
	if (u_name != '') {
		welcome_str += "<li class=\"name\"><a href=\"http://www.shunjubao.com/account/user_center.php?p=ticket\">"+u_name+"</a></li>";
		welcome_str += "<li class=\"loginout\"><a href=\"http://www.shunjubao.com/passport/logout.php\">退出</a></li>"+
        "<li class=\"Navlist account\"><span><a href=\"http://www.shunjubao.com/account/user_center.php?p=basic\">我的账户<i>&nbsp;</i></a></span>"+
        "<div class=\"Navlist\">"+
          "<div class=\"connectaccount\">"+
            "<div class=\"k3\"></div>"+
            "<p><a href=\"http://www.shunjubao.com/account/user_center.php?p=basic\">基本信息</a></p>"+
            "<p><a href=\"http://www.shunjubao.com/account/user_center.php?p=account_log\">账户明细</a></p>"+
            "<p><a href=\"http://www.shunjubao.com/account/user_center.php?p=ticket\">投注记录</a></p>"+
            "<p><a href=\"http://www.shunjubao.com/account/user_center.php\">查看余额</a></p>"+
            "<dl>"+
              "<dt><a href=\"http://www.shunjubao.com/account/user_charge.php\" class=\"hover\">充值</a></dt>"+
              "<dt><a href=\"http://www.shunjubao.com/account/user_center.php?p=withdraw\">提现</a></dt>"+
            "</dl>"+
          "</div>"+
        "</div>"+
      "</li>";
	} else {
		welcome_str += "<li class=\"login\"><a href=\"http://www.shunjubao.com/passport/login.php\">登录</a></li>"+        
	        "<li class=\"reg\"><a href=\"http://www.shunjubao.com/passport/reg.php\">注册</a></li>"+
			"<li class=\"hezuo\">&nbsp;&nbsp;合作登录&nbsp<a href=\"https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101179991&redirect_uri=http%3A%2F%2Fwww.zhiying365365.com%2Fconnect%2Fqq_connect.php&state=d8fde422ac693070830df92d8b61bf11&scope=get_user_info,add_share,add_weibo\"><img src=\"http://www.shunjubao.com/www/statics/i/QQlogin.gif\"></a><a href=\"https://mapi.alipay.com/gateway.do?_input_charset=utf-8&partner=2088311949386932&return_url=http://www.shunjubao.com/connect/alipay_connect.php&service=alipay.auth.authorize&target_service=user.auth.quick.login&sign=eec67941b9a9e81899e345ed53b2873b&sign_type=MD5\"><img src=\"http://www.shunjubao.com/www/statics/i/alipaylogin.gif\"></a><a href=\"https://open.weixin.qq.com/connect/qrconnect?appid=wxc1b1ad8efd2af8eb&redirect_uri=http%3A%2F%2Fwww.zhiying365365.com%2Fconnect%2Fweixin_connect.php&response_type=code&scope=snsapi_login&state=94819a2f2176dd83da86bd10c1db699d#wechat_redirect\"><img src=\"http://www.shunjubao.com/www/statics/i/weixin2.gif\"></a><a href=\"https://api.weibo.com/oauth2/authorize?client_id=3430318831&redirect_uri=http%3A%2F%2Fwww.zhiying365365.com%2Fconnect%2Fweibo_connect.php&response_type=code&display=default\"><img src=\"http://www.shunjubao.com/www/statics/i/weibologin.gif\"></a>"+
	        "</li>";
	}
	$("#topCenter").append(welcome_str);
});
document.writeln(
"<div style=\"height:34px;line-height:34px;background:#f1f1f1;\">"+
"  <div class=\"topNav\">"+
"    <div class=\"navC\">"+
"      <ul>"+
"        <li class=\"Navlist first\" style=\"display:none;\"><span><a href=\"http://www.shunjubao.com/\" target=\"_blank\">手机版<i>&nbsp;</i></a></span>"+
"          <div class=\"Navlist\">"+
"            <div class=\"Navmobile\">"+
"              <div class=\"kl\"></div>"+
"              <dl>"+
"                <dt><b>智赢网安卓APP</b><img src=\"http://www.shunjubao.com/www/statics/i/android.png\">"+
"                  <p><a href=\"http://www.shunjubao.com/upload/zhiying365_v0.1.apk\" target=\"_blank\">点击下载</a></p>"+
"                </dt>"+
"                <dd>"+
"                  <p>IOS即将上架敬请期待!</p>"+
"                </dd>"+
"              </dl>"+
"            </div>"+
"          </div>"+
"        </li>"+
"      </ul>"+
"      <ul id=\"topCenter\">"+
"      </ul>"+
"      <ol>"+
"        <li class=\"Navlist\"><em><img src=\"http://www.shunjubao.com/www/statics/i/weixin.gif\"></em>"+
"          <div class=\"Navlist\">"+
"            <div class=\"erweima\">"+
"              <img src=\"http://www.shunjubao.com/www/statics/i/tuijianw.jpg\"><p><img src=\"http://www.shunjubao.com/www/statics/i/dalishuishou.jpg\"></p>"+
"            </div>"+
"          </div>"+
"        </li>"+
"        <li class=\"tel\">&nbsp;&nbsp;&nbsp;&nbsp;7*24TH&nbsp;010-64344882&nbsp;&nbsp;</li>"+
"        <li><a onclick=\"AddFavorite(window.location,document.title)\">加入收藏</a><span>|</span></li>"+
"        <li><a href=\"/help\" target=\"_blank\">帮助中心</a><span>|</span></li>"+
"        <li><a href=\"http://www.shunjubao.com/help/contact.html\" target=\"_blank\">客服中心</a><span>|</span></li>"+
"        <li><a href=\"http://www.shunjubao.com/ticket/paihang.php\" target=\"_blank\">中奖排行</a><span>|</span></li>"+
"        <li class=\"Navlist account\"><span> <a href='javascript:void(0);'>网站导航<i>&nbsp;</i></a></span>"+
"          <div class=\"Navlist\">"+
" <div class=\"map\">"+
"               <div class=\"k4\">&nbsp;</div>"+
"               <dl>"+
"                 <dt><b><a href=\"http://www.shunjubao.com/football/hhad_list.php\" target=\"_blank\">竞彩足球</a></b></dt>"+
"                 <dd>"+
"                   <p><a href=\"http://www.shunjubao.com/football/hhad_list.php\" target=\"_blank\">胜平负/让球</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/football/fb_crosspool.php\" target=\"_blank\">混合过关</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/football/ttg_list.php\" target=\"_blank\">总进球</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/football/hafu_list.php\" target=\"_blank\">半全场</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/football/crs_list.php\" target=\"_blank\">比分</a> </p>"+
"                 </dd>"+
"                 <dt><b><a href=\"http://www.shunjubao.com/basketball/hdc_list.php\" target=\"_blank\">竞彩篮球</a></b></dt>"+
"                 <dd>"+
"                   <p><a href=\"http://www.shunjubao.com/basketball/hdc_list.php\" target=\"_blank\">胜负\让分胜负</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/basketball/bk_crosspool.php\" target=\"_blank\">混合过关</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/basketball/wnm_list.php\" target=\"_blank\">胜分差</a> </p>"+
"                   <p><a href=\"http://www.shunjubao.com/basketball/hilo_list.php\" target=\"_blank\">大小分</a> </p>"+
"                 </dd>"+
" 			    <dt><b><a href=\"http://new.shunjubao.com/footballtj/\" target=\"_blank\">资讯中心</a></b></dt>"+
"                 <dd>"+
"                  <p><a href=\"http://www.shunjubao.com/basketball/hdc_list.php\" target=\"_blank\">足球推荐</a> </p>"+
"                  <p><a href=\"http://new.shunjubao.com/NBAtj/\" target=\"_blank\">篮球推荐</a> </p>"+
"                  <p><a href=\"http://new.shunjubao.com/footballxw/\" target=\"_blank\">足球新闻</a> </p>"+
"                  <p><a href=\"http://new.shunjubao.com/NBAxw/\" target=\"_blank\">篮球新闻</a> </p>"+
" 				  <p><a href=\"http://new.shunjubao.com/touzhujiqiao/\" target=\"_blank\">投注技巧</a> </p>"+
"  				  <p><a href=\"http://new.shunjubao.com/zhongchao/\" target=\"_blank\">论剑中超</a> </p>"+
"                </dd>"+
" 				<dt><b><a href=\"http://www.shunjubao.com/livescore/fb_livescore.php\" target=\"_blank\">即时比分</a></b></dt>"+
"             <dd>"+
"                  <p><a href=\"http://www.shunjubao.com/livescore/fb_livescore.php\" target=\"_blank\">竞彩足球</a> </p>"+
"                  <p><a href=\"http://www.shunjubao.com/livescore/bk_livescore.php\">竞彩篮球</a> </p>             </dd>"+
"				<dt><b><a href=\"http://new.shunjubao.com/footballtj/\" target=\"_blank\">赛果开奖</a></b></dt>"+
"                <dd>"+
"                  <p><a href=\"http://www.shunjubao.com/livescore/fb_match_result.php\" target=\"_blank\">竞彩足球</a> </p>"+
"                  <p><a href=\"http://www.shunjubao.com/livescore/bk_match_result.php\">竞彩篮球</a> </p>"+
"                </dd>"+
"                <dd class=\"show\">"+
"                  <p><a href=\"http://www.shunjubao.com/ticket/show.php\" target=\"_blank\">晒单中心</a> </p>"+
"                  <p><a href=\"http://www.shunjubao.com/ticket/dingzhi.php\" target=\"_blank\">跟单定制</a> </p>"+
"                  <p><a href=\"http://www.shunjubao.com/ticket/paihang.php\" target=\"_blank\">中奖排行</a> </p>"+
"                  <p><a href=\"http://www.shunjubao.com/ticket/virtual_list.php\" target=\"_blank\">积分投注</a> </p>"+
"                  <p><a href=\"http://www.shunjubao.com/help/\" target=\"_blank\">帮助中心</a> </p>"+
"                </dd>"+
"              </dl>"+"           </div>"+
"          </div>"+
"        </li>"+
"      </ol>"+
"    </div>"+
"  </div>"+
"</div>"+
"<div class=\"clear\"></div>");
$(function(){
	lanrenzhijia(".Navlist");});function lanrenzhijia(_this){
	$(_this).each(function(){
		var $this = $(this);var theMenu = $this.find(".Navlist");var tarHeight = theMenu.height();theMenu.css({height:0});$this.hover(
			function(){
				$(this).addClass("topmenu_hover");theMenu.stop().show().animate({height:tarHeight},5);},
			function(){
				$(this).removeClass("topmenu_hover");theMenu.stop().animate({height:0},5,function(){
					$(this).css({display:"none"});});}
		);});}
//屏幕比例调整
function changeWindow () {
    var win_W = window.screen.width;
    var win_Dpr = 2; //不实用window.devicePixelRatio，因为有很多奇葩分辨率手机;
    if (win_Dpr * win_W >= 2000) {
        document.querySelector('meta[name="viewport"]').setAttribute('content','width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no');
    }else if (win_Dpr * win_W >= 1200) {
        document.querySelector('meta[name="viewport"]').setAttribute('content','width=device-width, initial-scale=0.75, maximum-scale=0.75, minimum-scale=0.75, user-scalable=no');
    }else if (win_Dpr * win_W < 650) {
        document.querySelector('meta[name="viewport"]').setAttribute('content','width=device-width, initial-scale=0.45, maximum-scale=0.45, minimum-scale=0.45, user-scalable=no');
    }else{
        document.querySelector('meta[name="viewport"]').setAttribute('content','width=device-width, initial-scale=0.5, maximum-scale=0.5, minimum-scale=0.5, user-scalable=no');
    }
}

changeWindow()

window.addEventListener('resize', function() {
    changeWindow()
}, false);

//获取链点参数
function GetQueryString(str,href) {
    var Href;
    if (href != undefined && href != '') {
        Href = href;
    }else{
        Href = location.href;
    };
    var rs = new RegExp("([\?&])(" + str + ")=([^&#]*)(&|$|#)", "gi").exec(Href);
    if (rs) {
        return decodeURI(rs[3]);
    } else {
        return '';
    }
}

//获取滚动距离
function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
        yScroll = self.pageYOffset;
        xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
        yScroll = document.documentElement.scrollTop;
        xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
        yScroll = document.body.scrollTop;
        xScroll = document.body.scrollLeft;
    }
    arrayPageScroll = new Array(xScroll,yScroll);
    return arrayPageScroll;
}

//状态弹框
function Alert (type,text) { //type:loading\success\error，text为提示内容
    var AlertBox;
    if (document.getElementById('Alert') == undefined) {
        AlertBox = document.createElement('div');
        AlertBox.id = 'Alert';
        AlertBox.setAttribute('status','loading');
        AlertBox.innerHTML = '<div class="loading">-</div><div class="success">-</div><div class="error">-</div>';
        document.body.appendChild(AlertBox);
    }else{
        AlertBox = document.getElementById('Alert');
    };
    AlertBox.setAttribute('status',type);
    AlertBox.getElementsByClassName(type)[0].innerHTML = text;
    if (type != 'loading') {
        setTimeout('document.body.removeChild(document.getElementById("Alert"))',1500);
    }
}

function showError(text) {
    Alert('error', text);
}

function showSuccess(text) {
    Alert('success', text);
}

function showLoading() {
    Alert('loading', '加载中...');
}

function closeLoading () {
    document.body.removeChild(document.getElementById('Alert'));
}

//确认弹框
function confirmAlert (content, Event, title, canText, comText) { //content为提示文案，Event为确认事件
    if (document.getElementById('ComfirmBox') == undefined) {
        if (canText == undefined) {
            canText = '取消';
        }
        if (comText == undefined) {
            comText = '确认';
        }
        if (title == undefined) {
            title = "请确认";
        }
        var Box = document.createElement('div');
        Box.id = 'ComfirmBox';
        Box.innerHTML = '<div class="default"><div class="title">' + title + '</div>' +
            '<div class="comText">' + content + '</div>' +
            '<div class="btn"><button onclick="confirmAlert()">' + canText + '</button><button class="comfirm">' + comText + '</button></div>';

        Box.getElementsByTagName('button')[1].setAttribute('onclick', Event);

        document.body.appendChild(Box);
    }else{
        document.body.removeChild(document.getElementById('ComfirmBox'));
    }
}

//支付弹框
function showPayCode(merchant, goods, cost, orderNo, qrCode) {
    if (document.getElementById('payCode') == undefined) {
        var CodeDiv = document.createElement('div');
        CodeDiv.id = 'payCode';
        CodeDiv.innerHTML = '<div class="default"><div class="title">微信扫一扫付款<button onclick="document.body.removeChild(this.parentNode.parentNode.parentNode)"></button></div>' +
            '<img src="data:image/jpg;base64,' + qrCode + '">' +
            '<p class="name">' + goods + '</p>' +
            '<p class="cost">￥' + parseFloat(cost).toFixed(2) + '</p>' +
            '<p class="warm">请用<span>微信</span>扫描二维码</p></div>';
        document.body.appendChild(CodeDiv);
    } else {
        return;
    }
}

//新推荐时触发弹框
//对象例子
//Parr = [{
//  "id":123,
//  "title":"湿胸很帅",
//  "host":"皇家马德里",
//  "away":"巴塞罗那",
//  "league":"西甲",
//  "play":"大小球",
//  "time":"02-10"
//}]
function NewPush (Parr) { //直接传比赛对象数组
    var Box = document.createElement('div');
    Box.id = 'PushList';
    Box.innerHTML = '<div class="default"><div class="title">新的套餐比赛推荐</div><ul></ul>' +
        '<div class="btn"><button>- 我知道了 -</button></div></div>';
    Box.getElementsByTagName('button')[0].setAttribute('onclick',"document.body.removeChild(document.getElementById('PushList'))");

    for (var i = 0; i < Parr.length; i++) {
        var LI = document.createElement('li');
        LI.innerHTML = '<a href="recommend.html?id=' + Parr[i].id + '" class="match">' +
            '<p>' + Parr[i].title + '</p>' +
            '<dl class="match"><dd class="play">[' + Parr[i].play + ']</dd><dd class="league">' + Parr[i].league + '</dd>' +
            '<dd class="host">' + Parr[i].host + '</dd><dd class="score">vs</dd><dd class="away">' + Parr[i].away + '</dd>' +
            '<dd class="time">' + Parr[i].time + '</dd></dl></a>';

        Box.getElementsByTagName('ul')[0].appendChild(LI);
    };


    document.body.appendChild(Box);
}

function ShowMy () {
    if (document.getElementById('MY').className == 'hidden') {
        if (location.href.indexOf('?') != -1) {
            history.replaceState({}, '', location.href + '&ShowMy=1');
        }else{
            history.replaceState({}, '', location.href + '?ShowMy=1');
        }
        document.getElementById('MY').className = '';
    }else{
        if (location.href.indexOf('&ShowMy') != -1) {
            history.replaceState({}, '', location.href.split('&ShowMy')[0]);
        }else if (location.href.indexOf('?ShowMy') != -1) {
            history.replaceState({}, '', location.href.split('?ShowMy')[0]);
        }
        document.getElementById('MY').className = 'hidden';
    }
}

//加载时触发
window.onload = function () {
    if (location.href.indexOf('hotMatch') != -1 && GetQueryString('Lid') != '') { //赛事列表切换tab
        for (var i = 0; i < document.getElementById('Toptab').getElementsByTagName('dd').length; i++) {
            if (document.getElementById('Toptab').getElementsByTagName('dd')[i].getAttribute('lid') == GetQueryString('Lid')) {
                ChangeTab(document.getElementById('Toptab').getElementsByTagName('dd')[i],GetQueryString('Lid'));
                break;
            }
        }
    }
}

function setBanner (BannerArr) {
    var banner = document.getElementById('Banner');
    if (banner) {
        setInterval('bannerRun()',3500);
        document.addEventListener('scroll', function (event) {
            if (document.getElementById('Banner')) {
                var Scroll = getPageScroll()[1];
                if (Scroll > 100) {
                    DelBanner ()
                }else{
                    AddBanner ()
                }
            }
        }, false);
    }
}

function bannerRun() {
    var BannerNumber = parseInt(document.getElementById('Banner').getAttribute('type'));
    var dl = document.getElementById('bannerDl');
    var type = (BannerNumber + 1) % dl.children.length;
    document.getElementById('Banner').setAttribute('type',type);
}

function AddBanner () {
    document.getElementById('Banner').className = 'show';

    if (document.getElementById('Search') && (document.getElementById('Search').tagName == 'A' || document.getElementById('Search').tagName == 'a')) {
        document.getElementById('Search').style.top = '120px';
    }
}
function DelBanner () {
    document.getElementById('Banner').className = 'hidden';

    if (document.getElementById('Search') && (document.getElementById('Search').tagName == 'A' || document.getElementById('Search').tagName == 'a')) {
        document.getElementById('Search').style.top = '0';
    }
}

/**
 * 使用cookie保存浏览推荐文章的记录
 * @param article_id
 */
function addArticleHistory(article_id) {
    var key = "LIAOGOU_ARTICLE_HIS";
    var history = getCookie(key);
    if (history) {
        history = history.replace(",_" + article_id + "_", "");
        history = history.replace("_" + article_id + "_", "");
        if (history == "") {
            history = "_" + article_id + "_";
        } else {
            //最多保存50个浏览记录
            //判断是否有50个记录
            var h_array = history.split(",");
            if (h_array.length >= 50) {
                history = history.replace(/_\d+_,?/, '');
            }
            history += "," + "_" + article_id + "_";
        }
        setCookie(key, history);
    } else {
        setCookie(key, "_" + article_id + "_");
    }
}

function setCookie(name, value, days) {
    days = /^\d+$/.test(days) ? days : 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + encodeURIComponent(value) + ";path=/;expires=" + exp.toGMTString();
}

function getCookie(name) {
    var arr , reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if(arr = document.cookie.match(reg)) {
        return decodeURIComponent(arr[2]);
    } else {
        return null;
    }
}

function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var c_val = getCookie(name);
    if(c_val != null) {
        document.cookie = name + "=" + c_val + ";expires=" + exp.toGMTString();
    }
}

//添加代理提示
function AddAgent () {
    var Agent = document.createElement('div');
    Agent.id = 'Agent';
    Agent.innerHTML = '<p>这是你的代理分享页面，你可以将页面分享出去，用户通过分享的页面进行注册购买，你将获得相应的代理提成！</p><button onclick="DelAgent()">我知道了</button>';
    document.body.appendChild(Agent);
}
function DelAgent () {
    var NowTime = new Date();
    localStorage.setItem('delAgentTime',NowTime.getTime());
    document.body.removeChild(document.getElementById("Agent"))
}

//展开类型筛选弹层
function ShowTypeChange () {
    if (document.getElementById('typeList').className != 'hidden') {
        document.getElementById('typeList').className = 'hidden';
        document.getElementById('Navigation').getElementsByClassName('typeChoose')[0].className = 'typeChoose';
    }else{
        document.getElementById('typeList').className = '';
        document.getElementById('Navigation').getElementsByClassName('typeChoose')[0].className = 'typeChoose on';
    }
}

//翻页到页底
function scrollBottom (endFunc) {
    var ClientHeight,BodyHeight,ScrollTop;
    if(document.compatMode == "CSS1Compat"){
        ClientHeight = document.documentElement.clientHeight;
    }else{
        ClientHeight = document.body.clientHeight;
    }

    BodyHeight = document.body.offsetHeight;

    ScrollTop = getPageScroll()[1];

    if (BodyHeight - ScrollTop - ClientHeight < 20) {
        endFunc();
    }
}
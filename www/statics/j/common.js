/**
 * 公共js，该文件依赖于jQuery框架
 */
TMJF.common = function(){
    var $ = TMJF;
    var Methods = {
        Copy: function(str){
            if(str) str = str.toString();
            if(window.clipboardData) {
                return window.clipboardData.setData('Text', str);
            } else if(navigator.userAgent.indexOf('Opera') != -1) {
                window.location = str;
            } else if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
                } catch (e) {
                    //throw '您的firefox安全限制限制您进行剪贴板操作，请打开"about:config"将"signed.applets.codebase_principal_support"设置为"true"之后重试。';
                    throw '你的浏览器不支持脚本复制或你拒绝了浏览器安全确认，请尝试手动Ctrl+C复制。';
                    return false;
            }
            var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
            if (!clip)
                return;
                var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
                if (!trans)
                    return false;
                trans.addDataFlavor('text/unicode');
                var str = new Object();
                var len = new Object();
                var str = Components.classes['@mozilla.org/supports-string;1'].createInstance(Components.interfaces.nsISupportsString);
                var copytext = str;
                str.data = copytext;
                trans.setTransferData('text/unicode',str,copytext.length*2);
                var clipid = Components.interfaces.nsIClipboard;
                if (!clip)
                    return false;
                clip.setData(trans,null,clipid.kGlobalClipboard);
                return true;
            }
        }
        , CommCopy: function(txt){
            try{
                var result = Methods.Copy(txt);
                if(result)  alert('复制成功');
                else alert('你的浏览器不支持脚本复制或你拒绝了浏览器安全确认，请尝试手动Ctrl+C复制。', '未复制成功');
            }catch(e){
                alert(e,'未复制成功');
            }
        }       
    };

    /**
      JSON 编解码类
      var jsonStr = JSON.stringify(jsObject);
      var jsonObj = JSON.parse(jsonStr);
    */
    var JSON = function () {
        function f(n) {
            return n < 10 ? '0' + n : n;
        }
        Date.prototype.toJSON = function () {
            return this.getUTCFullYear() + "-" + f(this.getUTCMonth() + 1) + "-" + f(this.getUTCDate()) + "T" + f(this.getUTCHours()) + ":" + f(this.getUTCMinutes()) + ":" + f(this.getUTCSeconds()) + "Z";
        };
        var m = {
            "\b": "\\b",
            "\t": "\\t",
            "\n": "\\n",
            "\f": "\\f",
            "\r": "\\r",
            "\"": "\\\"",
            "\\": "\\\\"
        };
    
        function stringify(value, _306f) {
            var a, i, k, l, r = /["\\\x00-\x1f\x7f-\x9f]/g,
                v;
            switch (typeof(value)) {
            case "string":
                return r.test(value) ? "\"" + value.replace(r, function (a) {
                    var c = m[a];
                    if (c) {
                        return c;
                    }
                    c = a.charCodeAt();
                    return "\\u00" + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
                }) + "\"" : "\"" + value + "\"";
            case "number":
                return isFinite(value) ? String(value) : "null";
            case "boolean":
                return value ? 1 : 0;
            case "null":
                return String(value);
            case "object":
                if (!value) {
                    return "null";
                }
                a = [];
                if (typeof(value.length) === "number" && !(value.propertyIsEnumerable("length"))) {
                    l = value.length;
                    for (i = 0; i < l; i += 1) {
                        a.push(stringify(value[i], _306f) || "null");
                    }
                    return "[" + a.join(",") + "]";
                }
                if (_306f) {
                    l = _306f.length;
                    for (i = 0; i < l; i += 1) {
                        k = _306f[i];
                        if (typeof(k) === "string") {
                            v = stringify(value[k], _306f);
                            if (v) {
                                a.push(stringify(k) + ":" + v);
                            }
                        }
                    }
                } else {
                    for (k in value) {
                        if (typeof(k) === "string") {
                            v = stringify(value[k], _306f);
                            if (v) {
                                a.push(stringify(k) + ":" + v);
                            }
                        }
                    }
                }
                return "{" + a.join(",") + "}";
            }
        }
        return {
            stringify: stringify,
            parse: function (json) { return eval('(' + json + ')') }
        };
    } ();       

    /**
        Cookie 读写类
            读：Cookie.get(name)
            写：Cookie.set(name, value, domain, ttl/*是否持久* /)
            删除: Cookie.clear(name)
            绑定Cookie变化事件 Cookie.change(function(){})
    */
    var Cookie = function () {
        var prevCookie = null;
        var _user = {};
        
        $(function(){
            window.setInterval(function () {
                if (!prevCookie || prevCookie != document.cookie) {
                    prevCookie = document.cookie;
                    $(Cookie).trigger('cookie_change', prevCookie);
                }
            }, 1000);
        });
    
        return {
            change: function(fn){
                $(this).bind('cookie_change', fn);
            },
            clear: function (name) {
                var date = new Date();
                date.setTime(date.getTime() - 24 * 60 * 60 * 1000);
                var cookie = name + "=''; expires=" + date.toGMTString() + "; path=/;";
                document.cookie = cookie;
            },
            set: function (name, value, domain, ttl) {
                var value = value ? encodeURIComponent(typeof(value) == 'string' ? value : JSON.stringify(value)) : "";
                var expires = "";
                if (value === "") {
                    ttl = -1;
                }
                if (typeof(ttl) != "undefined") {
                    var date = new Date();
                    date.setTime(date.getTime() + (ttl * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                }
                try {
                    if ($.browser.msie && value !== "") {
                        var extra = 56 + (domain||'').length;
                        var cookieByteLen = 0;
                        if (document.cookie) {
                            var cookieArr = document.cookie.split(/;\s*/);
                            cookieByteLen = cookieArr.length * extra + document.cookie.length;
                        }
                        var _302e = Cookie.get(name, false);
                        var _302f = _302e ? _302e.length : 0;
                        if ((cookieByteLen + value.length - _302f) > 4096) {
                            throw ("exceeds 4096 byte limit for cookie");
                        }
                    }
                    document.cookie = name + "=" + value + expires + "; path=/;" + (domain ? (" domain=." + domain) : "");
                    return true;
                } catch(e) {
                    return false;
                }
            },
            get: function (name, parse) {
                var cookieArr = document.cookie.split(/;\s*/);
                for (var i = 0; i < cookieArr.length; ++i) {
                    var bits = cookieArr[i].split("=", 2);
                    if (bits[0] == name) {
                        if (parse) {
                            try {
                                return eval("(" + decodeURIComponent(bits[1]) + ")");
                            } catch(e) {}
                        } else {
                            return decodeURIComponent(bits[1]);
                        }
                    }
                }
                return null;
            }
        };
    } ();
    /**
        与后台交互的Cookie事件类
            使用：CookieEvent.bind(event, handler)
            当后台写入Cookie时，自动执行 handler
    */
    var CookieEvent = function(){
        var _rand = Math.random();
        return {
            bind: function(event, handler){
                $(CookieEvent).bind(event, handler);
                if (!CookieEvent.listening) {
                    Cookie.change(CookieEvent.trigger);
                    CookieEvent.listening = true;
                }
            },
            trigger: function(cookie){
                var ce = Cookie.get("e", true);
                if (!ce) {
                    return;
                }
                if (!ce.processedBy) {
                    ce.processedBy = {};
                    ce.processedBy[_rand] = 0;
                } else {
                    if (!ce.processedBy[_rand]) {
                        ce.processedBy[_rand] = 0;
                    }
                }
                ce.processedBy[_rand]++;
                if (ce.processedBy[_rand] > 20) { // 20 * cookie_change 1000毫秒 = 20 秒， 20秒内所有窗口内都能执行事件
                    Cookie.clear("e");
                } else {
                    Cookie.set("e", ce);
                    if(ce.list[0][0] == 'signin' || ce.list[0][0] == 'signout') {
                        // 登录，只通知一个窗口消息
                        Cookie.clear("e");
                    }
                    if (ce.processedBy[_rand] == 1) {
                        if(ce.list){
                            $.each(ce.list, function (i, eObj) {
                                $(CookieEvent).trigger(eObj[0], eObj[1]);
                            });
                        }
                    }
                }
            }
        }
    }();
    
    var YokaPassport = function(){
        var currentUser = {};
        var inited = false;
        function init(){
            if(inited)  return;
            inited = true;
            
            // 获取用户信息
            var passport_member = Cookie.get('TM_PASSPORT_MEMBER');
            if (!passport_member) {
            	return false;
            }
            $.each(passport_member.split("&"), function(tmpK, tmpV) {
            	var tmpKV = tmpV.split('=');
            	currentUser[tmpKV[0]] = decodeURIComponent(tmpKV[1]);
            });
        }
        var _tmgs = false;
        return {
            isLogin : function(uid){
                init(); 
                uid = uid || currentUser.uid;
                return uid != null && uid != '' && uid != '0';
            }, 
            isKaiXinLogin : function(uid){
                init(); 
                if(currentUser.login_type != 3)
                {
                	return false;
                }
                uid = uid || currentUser.uid;
                return uid != null && uid != '' && uid != '0';
            },
            getUserInfo : function(){
                init();
                return currentUser;
            },
            bind : function(event, handler){
                switch(event){
                    case 'login' : 
                        _YOKA.Passport.setLoginHandler("header_passport_login_handler", handler);
                        break;
                    case 'logout' :
                        _YOKA.Passport.setLoginHandler("header_passport_logout_handler", handler);
                        break;
                }
                if(!_tmgs){
                    _YOKA.TimerManage.startup();
                    _tmgs = true;
                }
            }
        };
    }();

    // 判断window.ie WindowMessage 不依赖jQuery时用到
    if (window.ActiveXObject) window.ie = window[window.XMLHttpRequest ? 'ie7' : 'ie6'] = true;
    //else if (document.childNodes && !document.all && !navigator.taintEnabled) window.webkit = window[window.xpath ? 'webkit420' : 'webkit419'] = true;

    /**
      监控类，WindowMessage用到
      语法：var m = new Monitor(function(){}, 2000);
    */
    function Monitor(f, interval) {
        var curr = f();
        if (!interval) {
            interval = 100;
        }
        this.check = function () {
            var now = f();
            if (now != curr) {
                curr = now;
                Event(this).trigger("monitor_change", curr);
            }
            return now;
        };
        this.timer = setInterval((function(t){
            return function(){
                try{
                    t.check.call(t)
                }catch(e){}
            }
        }).call(null, this), interval);
    };
    Monitor.prototype.stop = function () {
        clearInterval(this.timer);
    };
    /**
        自定义事件绑定、触发类，WindowMessage 不依赖jQuery时用到
        语法: Event(object).bind(event, handler)
              Event(object).unbind(event, handler)
              Event(object).trigger(event, args)
    */
    function Event(object){
        var epx = '__e_';
        return{
            bind: function(type, handler){
                if (object.addEventListener)    object.addEventListener(type, handler, false);
                else if(object.attachEvent)     object.attachEvent('on' + type, handler);

                var eventType = epx + type;
                if (object[eventType] == undefined) object[eventType] = [];
                object[eventType].push(handler);
            }
            , unbind: function(type, handler){
                var eventQueue = object[epx + type];
                if(!handler){
                    if (eventQueue != undefined){
                        for (var i=0, j=eventQueue.length; i<j; i++){
                            if (object.removeEventListener) object.removeEventListener(type, eventQueue[i], false);
                            else if(object.detachEvent)     object.detachEvent('on' + type, eventQueue[i]);
                            eventQueue.splice(i, 1); 
                        }//endfor
                    }
                    return;
                }
                if (object.removeEventListener) object.removeEventListener(type, handler, false);
                else if(object.detachEvent)     object.detachEvent('on' + type, handler);

                if (eventQueue != undefined){
                    for (var i=0, j=eventQueue.length; i<j; i++){
                        if(handler == eventQueue[i])    eventQueue.splice(i, 1); 
                    }//endfor
                }
            }
            , trigger: function(type, args){
                if(Object.prototype.toString.call(args) != '[object Array]')    args = [args];
                args.unshift({});// first param e
                var eventQueue = object[epx + type];
                if (eventQueue != undefined){
                    for (var i=0, j=eventQueue.length; i<j; i++){
                        var handler = eventQueue[i];
                        if(Object.prototype.toString.call(handler) === '[object Function]'){
                            handler.apply(object, args);
                        }
                    }//endfor
                }//endif
            }
        }
    }
    /**
        跨域 iframe 之间通信
        发送：WindowMessage.postMessage(目标窗口，基URL/*可为null* /, 'myevent', jsonData);
        接受：WindowMessage.bind('myevent', function(json){});
    */
    var WindowMessage = function(){
        var monitor;
        var ticks = 0;
        var historyLen = window.history.length - 1;
        var sb = [];
        var referrer = (document.referrer + "").split("#")[0];
        function scrollXY(tmp) {
            if (!tmp) {
                tmp = new Point(0, 0);
            }
            if (typeof(window.pageXOffset) != "undefined") {
                tmp.x = window.pageXOffset;
                tmp.y = window.pageYOffset;
            } else {
                if (document.documentElement) {
                    tmp.x = document.documentElement.scrollLeft;
                    tmp.y = document.documentElement.scrollTop;
                } else {
                    tmp.x = document.body.scrollLeft;
                    tmp.y = document.body.scrollTop;
                }
            }
            return tmp;
        };
    
        function setScroll(pos) {
            var d = document.documentElement;
            var b = document.body;
            d.scrollLeft = b.scrollLeft = pos.x;
            d.scrollTop = b.scrollTop = pos.y;
        };
    
        function Point(x, y) {
            this.x = x;
            this.y = y;
        };
        function onHashChange(hash) {
            if (!hash) {
                return;
            }
            hash = decodeURIComponent((window.location.href).split("#")[1]);
            try {
                var msg = eval("(" + hash + ")");
                if (msg && msg.seq) {
                    if (msg.t < ticks) {
                        Event(WindowMessage).trigger("back");
                        window.history.go(historyLen - window.history.length);
                    } else {
                        ticks = (new Date()).getTime();
                    }
                    if (msg.seq == 1) {
                        sb = [];
                    }
                    sb.push(msg.data);
                    if (msg.last) {
                        var data = eval("(" + sb.join("") + ")");
                        if (data.e) {
                            Event(WindowMessage).trigger(data.e, data.m);
                        }
                    } else {
                        WindowMessage.postMessage(window.parent, referrer, "_ack");
                    }
                }
                var orig = (window.location.href).split("#")[0] + "#";
                var scrollPos = scrollXY();
                try {
                    window.location.replace(orig);
                } catch(e1) {
                    window.location = orig;
                }
                setScroll(scrollPos);
            } catch(e2) {}
        };
        function postMessageChunk(tgt, base, data, seq, last) {
            var msg = encodeURIComponent(JSON.stringify({
                data: "PLACEHOLDER",
                seq: seq,
                t: (new Date()).getTime(),
                last: last
            }));
            var dataLen = data.length;
            if (data.match(/%$/)) {
                dataLen -= 1;
                data = data.substr(0, dataLen);
            } else {
                if (data.match(/%[0-9A-F]$/)) {
                    dataLen -= 2;
                    data = data.substr(0, dataLen);
                }
            }
            while (data.match(/%5C$/)) {
                dataLen -= 3;
                data = data.substr(0, dataLen);
            }
            msg = msg.replace("PLACEHOLDER", data);
            msg = base + "#" + msg;
            try {
                tgt.location.replace(msg);
            } catch(e2) {
                tgt.location = msg;
            }
            return dataLen;
        };
        function postMessageIE(tgt, base, event, args){
            tgt.name = JSON.stringify({
                e: event,
                m: args,
                t: (new Date()).getTime()
            });
        }
        function onHashChangeIE(e, hash){
            if(!hash)   return;
            try{
                var data = eval('(' + hash + ')');
                if (data.e) Event(WindowMessage).trigger(data.e, data.m);
                
            }catch(e){}
        }
        return {
            bind: function(event, handler){
                Event(WindowMessage).bind(event, handler);
                if (!monitor) {
                    monitor = new Monitor(function () {
                        if(window.ie)   return window.name;
                        return window.location.hash;
                    },
                    100);
                    Event(monitor).bind("monitor_change", window.ie? onHashChangeIE : onHashChange);
                }
            },
            unbind: function(event, handler){
                Event(WindowMessage).unbind(event, handler);
            },
            postMessage: function (tgt, base, event, args) {
                if (!tgt)   tgt = window.parent;
                if (!tgt)   return;
                if (!base)  base = (document.referrer + "").split("#")[0];
                try {
                    var tmp;
                    if ((tmp = tgt.contentWindow)) {
                        tgt = tmp;
                    }
                } catch(e1) {}
                if(window.ie){
                    postMessageIE(tgt, base, event, args);
                    return;
                }
                base = base.split("#")[0];
                var msg = encodeURIComponent(JSON.stringify(JSON.stringify({
                    e: event,
                    m: args
                })).replace(/(^"|"$)/g, ""));
                var urlMaxLen = 8000;
                if (window.ie) {
                    urlMaxLen = 1900;
                }
                var seq = 1;
                var postMsg = function () {
                    var last = (msg.length <= urlMaxLen);
                    var msgLen = last ? msg.length : urlMaxLen;
                    var chunk = msg.substr(0, msgLen);
                    msgLen = postMessageChunk(tgt, base, chunk, seq, last);
                    if (!last) {
                        msg = msg.substr(msgLen);
                    }
                    seq++;
                    return last;
                };
                if (!postMsg()) {
                    var _1a5c = WindowMessage.bind("_ack", function () {
                        if (postMsg()) {
                            //_1a5c.clean();
                        }
                    });
                }
            }
        }
    }();

    // 在页面右上角显示"数据加载中..."
    var Progress = function () {
        var jnode;
    
        function init() {
            if (!jnode) {
                jnode = $('<div id="progress"></div>');
                $(document.body).append(jnode);
            }
        }
        return {
            show: function (msg) {
                init();
                jnode.html(msg);
                jnode.css('top', $(document.documentElement).scrollTop());
                jnode.show();
            },
            hide: function () {
                init();
                jnode.hide();
            }
        };
    } ();

    // 跨域Ajax提交 
    /* 使用方法 CrossDomainAjax.post({
                                        // 表单
                                        form: jform,
                                        // 或键值对类型数据
                                        data: {JSON}
                                        action: 'http://passport.yoka.com/login.php?from=' + cb_url,
                                        busyMsg: '正在登录...',
                                        // 成功或失败回调函数
                                        onSuccess: function (json) {
                                            ModalDialog.hide();
                                            if($.isFunction(callback))  callback();
                                        },
                                        onError: function(json){
                                            jform.find('#error_msg').html(json.message[0].content);
                                        }
                                    });
    */
    var CrossDomainAjax = function() {
        var UUID = 0;
        var handles = {};
        function getUUID() {
            return ++UUID;
        }
        
        /**
         * url是否已有参数
         */
        function hasParam(url) {
        	if (url.indexOf('?') == -1) {
    			return false;
    		} else {
    			return true;
    		}
        }
        
        return {
            getUUID: function() {
                return getUUID();
            },
            post: function () {
            	var options = {};
            	options.action 	= arguments[0];
            	options.data	= arguments[1];
            	options.cb		= arguments[2];
            	
                options.method = "POST";
                CrossDomainAjax.request(options);
            },
            get: function () {
            	var url = arguments[0];
            	if (hasParam(url)) {
            		arguments[0] = arguments[0] + "&jsonp_cb=?";
            	} else {
            		arguments[0] = arguments[0] + "?jsonp_cb=?";
            	}
                $.getJSON.apply(this, arguments);
            },
            request: function (options) {
                var uuid_flag = options.uuid || getUUID();
                var jiframe = $('<iframe style="display: none;" name="CrossDomainAjax_'+uuid_flag+'" src="about:blank"></iframe>');
                var tmp_iframe = jiframe.appendTo(document.body);
                tmp_iframe = tmp_iframe[0];
                tmp_iframe._tmp = true;

                var form;
                options.data = options.data || {};
                if(options.form){
                    if(options.form.jquery)     form = options.form[0];
                    else    form = options.form;
                }else{
                    var fh = '<form style="display:none">';
                    fh += '<input type="hidden" name="cross_cb" value="' + TMJF.conf.domain + '/cross_domain.php?cb=TMJF.common.CrossDomainAjax.onSuccess&uuid='+uuid_flag + '" />';
                    
                    $.each(options.data, function (k, v) {
                    	fh += '<textarea name="'+k+'">'+v+'</textarea>';
                    });
                    
                    fh += '</form>';
                    form = $(fh).appendTo(document.body);
                    form = form[0];
                    form._tmp = true;
                }
                $(form).attr({target: 'CrossDomainAjax_'+uuid_flag, action:options.action, method:options.method});
                handles[uuid_flag] = {
                	cb: options.cb || $.noop
                    , form: form
                    , iframe: tmp_iframe
                };
//                Progress.show(options.busyMsg || '执行中...');
                form.submit();
            },
            onSuccess: function(responseText, uuid) {
//                if (typeof(Progress) != "undefined") {
//                    Progress.hide();
//                }
                if(uuid - 0) {//强制转换为整数
                    var ret = eval("(" + responseText + ")");
                    handles[uuid].cb(ret);
                    if(handles[uuid].form._tmp) $(handles[uuid].form).remove();
                    if(handles[uuid].iframe._tmp) $(handles[uuid].iframe).remove();
                    delete handles[uuid];
                }
            }
        };
    } ();

    var ModalDialog = function () {
        var jblock, jdialog;
        var init = function () {
            if (jblock) {
                return;
            }
            var blocktag = '<div class="modalDialog_block"></div>';
            if($.browser.msie && $.browser.version < 7) blocktag = '<iframe class="modalDialog_block"></iframe>' + blocktag;
            jblock = $(blocktag);
            $(document.body).append(jblock);
            jdialog = $('<center class="modalDialog_layout"></center>');
            $(document.body).append(jdialog);
        };
        return {
            show: function (jele) {
                init();
                jdialog.empty();
                if ( $.browser.msie && $.browser.version < 7 ){
                    jblock.css({position:'absolute', width:$(document.body).width(), height:$(document.body).height()});
                    jdialog.css({position:'absolute'});
                    $(window).scroll(this.rePosition);// 用于修复ie7以下浏览器不会随滚动条自动适应的问题
                }
                jdialog.append(jele);
                ModalDialog.rePosition();
                jblock.show();
                jdialog.show();
            },
            rePosition: function () {
                var offset = 0;
                if ( $.browser.msie && $.browser.version < 7 ){
                    offset = document.documentElement.scrollTop
                }
                var top = offset + ($(window).height() - jdialog.height()) / 3;
                jdialog.css('top', top);
            },
            hide: function () {
                init();
                jdialog.hide();
                jblock.hide();
            },
            createErrorElement: function (id) {
                return {
                    type: "rotext",
                    id: id,
                    className: "error"
                };
            }
        };
    } ();

    function ValidateForm(form, keyValue){
        function findErrEle(ele){ return $(ele).parents('tr').next().find('.error') }
        var errs = false;
        $('input, select, textarea', form).each(function(){
            var value = '';
            if(this.type == 'radio'){
                //alert(this.form[this.name])
                $.each(this.form[this.name], function(){
                    if(this.checked)    value = this.value || 'on';
                });
            }else   value = this.value;

            if($(this).attr('required_')){
                if(value == ''){
                    errs = true;
                    // 寻找报错节点 '请填写完整信息'
                    findErrEle(this).html('请填写完整信息');
                }else{
                    findErrEle(this).html('');
                }
            }
    
            if($(this).attr('list'))    value = this.value ? this.value.split(/\s*[,，、\n]\s*/) : [];//tag支持以,，、分隔
            if(typeof keyValue == 'object') keyValue[this.name] = value;
        });
        return !errs;
    }
    var LoginBox = function(){
        function showLoginIn(callback){
            var jform = $('<form method="post" accept-charset="utf-8"><input type="submit" style="position:absolute;left:-9999px;overflow:hidden; width:50px" /></form>');
            var fields = '<div class="pop" align="left"> <cite>优享团提示<a href="#na" class="close btnhide"></a></cite>' + 
                              '<div class="popCnt fo ad01">' + 
                                '<dl>' + 
                                  '<dt>请您登录YOKA时尚网</dt>' + 
                                  '<dd>' + 
                                    '<table cellspacing="0" cellpadding="0"><tbody>' +
                                    '<tr><th>用户名：</th><td><input type="text" name="username" value="' + (YokaPassport.getUserInfo().track_name || '') + '" tabindex=1 required_="true"/></td><td><a href="http://passport.yoka.com/reginster.php" class="jregister btnhide" style="color:#f00">30秒快速注册 &gt;&gt;</a></td></tr>' + 
                                    '<tr><td></td><td><span class="error"></span></td></tr>' + 
                                    '<tr><th>密&nbsp;&nbsp;码：</th><td><input type="password" name="password" tabindex=2 1 required_="true"/></td><td><a href="http://passport.yoka.com/forgot.php" target="_blank" class="btnhide">忘记密码？</a></td></tr>' + 
                                    '<tr><td></td><td><span class="error"></span></td></tr>' + 
                                    '<tr><td></td><td><span class="error"></span></td></tr>' + 
                                    '</tbody></table>' + 
                                 ' </dd>' + 
                                '</dl>' + 
                                '<p class="btn fo" style="*margin-bottom:10px"><a href="#" class="imgBtn1 btnSubmit" tabindex=3>登录</a><a href="#na" class="imgBtn1 btnhide" tabindex=4>取消</a></p>' + 
                                '<div class="jconnect" style="display:none">' + 
                                    '<p style="padding:15px 28px 0px;font-size:13px">如果您有以下网站账号，点击下面的按钮登录：</p>' + 
                                    '<table align="center" style="margin:auto; width:320px">' + 
                                        '<tr style="height:50px">' + 
                                            '<td><a id="sina_btn_login" href="javascript:;" tar-get="_blank"><img src="http://bdj1.yokacdn.com/shexiangtuan/sina_connect.gif" width="126" height="24" /></a></td>' + 
                                            '<td><a id="kx001_btn_login" onclick="yoka.common.LoginBox.Hide();" >登录</a></td>' + 
                                        '</tr>' +
                                    '</table>' +
                                '</div>' +
                              '</div>' + 
                              '<s></s> </div>';
            jform.append($(fields));
            
            jform.find('.btnSubmit').click(function(){jform.submit();return false;});
            jform.find('.btnhide').click(function(e){ModalDialog.hide()});
            jform.submit(function(){
                // 验证，并AJAX提交表单
                if(ValidateForm(this)){
                    jform.find('#error_msg').html('');
                    var uuid_flag = CrossDomainAjax.getUUID();
                    var cb_url = location.protocol + '//' + location.host + '/callback.php?callback=CrossDomainAjax.onSuccess&uuid=' + uuid_flag;
                    var jheu = jform.find('input[name="error_url"]');
                    if(jheu.length ==0){
                        jheu = $('<input type="hidden" name="error_url" value="" />');
                        jform.append(jheu);
                    }
                    jheu.val(cb_url);
                    document.charset='utf-8';
                    CrossDomainAjax.post({
                        uuid: uuid_flag,
                        form: jform,
                        action: 'http://passport.yoka.com/login.php?from=' + cb_url,
                        //action: 'login.php?uuid='+uuid_flag,
                        busyMsg: '正在登录...',
                        onSuccess: function (json) {
                            ModalDialog.hide();
                            if($.isFunction(callback))  callback();
                        },
                        onError: function(json){
                            jform.find('.error:last').html(json.message[0].content);
                        }
                    });
                }
                return false;
            });
            
            ModalDialog.show(jform);
            
            if(Cookie.get('enableConnect'))
            {
                $.get('/api/sinaConnectLoginUrl.php', function(ret){
                    $('#sina_btn_login').attr('href', ret);
                });
    
                jform.find('.jconnect').show();
                var isMsn = (location.hostname == 'msn.tuan.yoka.com');
                var apiKey = isMsn ? '75442964871337c98ba738f0b58a9bd1' : '4317853669625d789092b16dac3ba5ad';
                KX001.init(apiKey, '/kx001_receiver.html', '用开心网账号登录');
            }
        }
        return {
            Show: function(callback){
                showLoginIn(callback)
            }
            , Hide: function(){
                ModalDialog.hide()
            }
        };
    } ();
    var MessageBox = function(){
        function show(html, title, options) {
        	if(!title)  title = '高街网提示';
            var jdialog = $('<div class="modalDialog_window"><div class="modalDialog_document"><div class="modalDialog_head">'
            		+ '<h1><span><img class="close_window" src="http://wwwcdn.gaojie1oo.com/statics/i/popup_close_btn.png" /></span>' + title + '</h1>'
            		+ '</div><div class="modalDialog_body">'
            		+ html
            		+ '</div></div></div>');
            
            // 绑定关闭按键事件
            $('.close_window').live('click', function () {
				ModalDialog.hide();return false;
			});
            
            options = options || {};
            ModalDialog.show(jdialog);
            
            options.window_css = options.window_css || {};
            // 控制 modalDialog_window 的css
            if (!options.window_css.width) {
            	options.window_css.width = 500;
            }
            if (options.window_css) {
            	$('.modalDialog_window').css(options.window_css);
            }
            
            // 控制 modalDialog_document 的css
            if (options.document_css) {
            	$('.modalDialog_document').css(options.document_css);
            }
            
            // 控制 modalDialog_head 的css
            if (options.head_css) {
            	$('.modalDialog_head').css(options.head_css);
            }
            
            // 控制 modalDialog_body 的css
            if (options.body_css) {
            	$('.modalDialog_body').css(options.body_css);
            }
        }
        return {
            show: function(html, title, options) {
                show.apply(null, arguments);
            }
            , hide: function(){
                ModalDialog.hide()
            }
        };
    } ();


    //除法函数，用来得到精确的除法结果
    //说明：javascript的除法结果会有误差，在两个浮点数相除的时候会比较明显。这个函数返回较为精确的除法结果。
    //调用：accDiv(arg1,arg2)
    //返回值：arg1除以arg2的精确结果
    function accDiv(arg1,arg2){
        var t1=0,t2=0,r1,r2;
        try{t1=arg1.toString().split(".")[1].length}catch(e){}
        try{t2=arg2.toString().split(".")[1].length}catch(e){}
        with(Math){
            r1=Number(arg1.toString().replace(".",""));
            r2=Number(arg2.toString().replace(".",""));
            return (r1/r2)*pow(10,t2-t1);
        }
    }
    
    //给Number类型增加一个div方法，调用起来更加方便。
    Number.prototype.div = function (arg){
        return accDiv(this, arg);
    };
    
    //乘法函数，用来得到精确的乘法结果
    //说明：javascript的乘法结果会有误差，在两个浮点数相乘的时候会比较明显。这个函数返回较为精确的乘法结果。
    //调用：accMul(arg1,arg2)
    //返回值：arg1乘以arg2的精确结果
    function accMul(arg1,arg2)
    {
        var m=0,s1=arg1.toString(),s2=arg2.toString();
        try{m+=s1.split(".")[1].length}catch(e){}
        try{m+=s2.split(".")[1].length}catch(e){}
        return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m);
    }
    
    //给Number类型增加一个mul方法，调用起来更加方便。
    Number.prototype.mul = function (arg){
        return accMul(this, arg);
    };
    
    //加法函数，用来得到精确的加法结果
    //说明：javascript的加法结果会有误差，在两个浮点数相加的时候会比较明显。这个函数返回较为精确的加法结果。
    //调用：accAdd(arg1,arg2)
    //返回值：arg1加上arg2的精确结果
    function accAdd(arg1,arg2){
        var r1,r2,m;
        try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
        try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
        m=Math.pow(10,Math.max(r1,r2));
        //return (arg1*m+arg2*m)/m;
        return (arg1.mul(m)+arg2.mul(m)).div(m);
    }
    
    //给Number类型增加一个add方法，调用起来更加方便。
    Number.prototype.add = function (arg){
        return accAdd(this, arg);
    };

    // 减法
    Number.prototype.sub = function(arg){
        return accAdd(this, -arg);
    };

	function Validator()
	{
		var validator = this;
		var hash = {};
		
		this.setHandle = function(err, info)
		{
			this.showErr = function(ele, msg){err(ele, msg, 'err')};
			this.showInfo = function(ele, msg){(info ? info:err)(ele, msg, 'info')};
		};
		this.show = function(ele, msg, type)
		{
			(type ? this.showInfo : this.showErr)(ele, msg);
		};
		
		this.add = function(field, arr, pass, rel){
			hash[field] = {vis:arr, pass:pass, rel:rel};
		};
		
		this.init = function(frm, blurIgnoreEmpty)
		{
			var fthis = this;
			frm = $(frm);
			frm.find('input').each(function(i, input)
			{
				var rule;
				if (rule = hash[input.name])
				{
					var vevent = 'blur';
					switch (input.type)
					{
						case 'checkbox':
							vevent = 'click';
							break;
					}
					$(input).bind(vevent, function(){
						validator.validItem(input, rule, blurIgnoreEmpty);
						if (rule.rel) {
							fthis.validItem(rule.rel, hash[rule.rel.name]);
						}
					});
				}
			});
		};
		
		this.valid = function(frm, brek)
		{
			var bRet = true;
			frm = $(frm);
			var ipts = frm.find('input');
			var focused = false;
			ipts.each(function(i, input){
				var rule;
				if( rule = hash[input.name])
				{
					if (!validator.validItem(input, rule))
					{
						bRet = false;
						if (!focused) {
							input.tipsfocus ? input.tipsfocus() : input.focus();
							focused = true;
						}
						if (brek)	return false;
					}
				}
				return true;
			});
			return bRet;
		};
		
		this.validItem = function(input, rule, ignoreEmpty)
		{
			var bRet = true;
			if (ignoreEmpty && input.value=='')	return bRet;
			$.each(rule.vis, function(i, item){
				var v = item.v;
				if ($.isFunction(v)) {
					bRet = (v.call(validator, input) !== false);
				} else {
					if(!v.test(input.value))
					{
						validator.showErr(input, item.i);
						bRet = false;
						return false;
					}
				}
				return true;
			});
			if(bRet && rule.pass != undefined)	validator.showInfo(input, rule.pass);
			return bRet;
		};
	}
	
	// 校验类
	var Verify = {
		isMoney: function (price) {// 判断是否有效的金额
	    	var numStyle = /^[0-9]\d*(\.\d{1,2})?$/; 
	        if (!numStyle.test(price)) {
	            return false;
	        } else {
	            return true;
	        }
		}
		, isInt: function (num) {// 判断是否整数
	    	var numStyle = /^\d*$/;
	        if (!numStyle.test(num)) {
	            return false;
	        } else {
	            return true;
	        }
		}
	};
	
	/**
	 * base64编码类。
	 * 编码：Base64.encode(str);
	 * 解码：Base64.decode(str);
	 */
	var Base64 = function () {
		/* utf.js - UTF-8 <=> UTF-16 convertion
		*
		* Copyright (C) 1999 Masanao Izumo <iz@onicos.co.jp>
		* Version: 1.0
		* LastModified: Dec 25 1999
		* This library is free.  You can redistribute it and/or modify it.
		*/

		/*
		* Interfaces:
		* utf8 = utf16to8(utf16);
		* utf16 = utf8to16(utf8);
		*/

		function utf16to8(str) {
		    var out, i, len, c;

		    out = "";
		    len = str.length;
		    for(i = 0; i < len; i++) {
		        c = str.charCodeAt(i);
		        if ((c >= 0x0001) && (c <= 0x007F)) {
		            out += str.charAt(i);
		        } else if (c > 0x07FF) {
		            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
		            out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));
		            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
		        } else {
		            out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));
		            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
		        }
		    }
		    return out;
		}

		function utf8to16(str) {
		    var out, i, len, c;
		    var char2, char3;

		    out = "";
		    len = str.length;
		    i = 0;
		    while(i < len) {
		        c = str.charCodeAt(i++);
		        switch(c >> 4)
		        {
		          case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
		            // 0xxxxxxx
		            out += str.charAt(i-1);
		            break;
		          case 12: case 13:
		            // 110x xxxx   10xx xxxx
		            char2 = str.charCodeAt(i++);
		            out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
		            break;
		          case 14:
		            // 1110 xxxx  10xx xxxx  10xx xxxx
		            char2 = str.charCodeAt(i++);
		            char3 = str.charCodeAt(i++);
		            out += String.fromCharCode(((c & 0x0F) << 12) |
		                                           ((char2 & 0x3F) << 6) |
		                                           ((char3 & 0x3F) << 0));
		            break;
		        }
		    }

		    return out;
		}

		/* Copyright (C) 1999 Masanao Izumo <iz@onicos.co.jp>
		* Version: 1.0
		* LastModified: Dec 25 1999
		* This library is free.  You can redistribute it and/or modify it.
		*/

		/*
		* Interfaces:
		* b64 = base64encode(data);
		* data = base64decode(b64);
		*/
		var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		var base64DecodeChars = new Array(
		    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		    -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
		    52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
		    -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14,
		    15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
		    -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
		    41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);

		function base64encode(str) {
		    var out, i, len;
		    var c1, c2, c3;

		    len = str.length;
		    i = 0;
		    out = "";
		    while(i < len) {
		        c1 = str.charCodeAt(i++) & 0xff;
		        if(i == len)
		        {
		            out += base64EncodeChars.charAt(c1 >> 2);
		            out += base64EncodeChars.charAt((c1 & 0x3) << 4);
		            out += "==";
		            break;
		        }
		        c2 = str.charCodeAt(i++);
		        if(i == len)
		        {
		            out += base64EncodeChars.charAt(c1 >> 2);
		            out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
		            out += base64EncodeChars.charAt((c2 & 0xF) << 2);
		            out += "=";
		            break;
		        }
		        c3 = str.charCodeAt(i++);
		        out += base64EncodeChars.charAt(c1 >> 2);
		        out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
		        out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >>6));
		        out += base64EncodeChars.charAt(c3 & 0x3F);
		    }
		    return out;
		}

		function base64decode(str) {
		    var c1, c2, c3, c4;
		    var i, len, out;

		    len = str.length;
		    i = 0;
		    out = "";
		    while(i < len) {
		        /* c1 */
		        do {
		            c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
		        } while(i < len && c1 == -1);
		        if(c1 == -1)
		            break;

		        /* c2 */
		        do {
		            c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
		        } while(i < len && c2 == -1);
		        if(c2 == -1)
		            break;

		        out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

		        /* c3 */
		        do {
		            c3 = str.charCodeAt(i++) & 0xff;
		            if(c3 == 61)
		                return out;
		            c3 = base64DecodeChars[c3];
		        } while(i < len && c3 == -1);
		        if(c3 == -1)
		            break;

		        out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));

		        /* c4 */
		        do {
		            c4 = str.charCodeAt(i++) & 0xff;
		            if(c4 == 61)
		                return out;
		            c4 = base64DecodeChars[c4];
		        } while(i < len && c4 == -1);
		        if(c4 == -1)
		            break;
		        out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
		    }
		    return out;
		}
		
		return {
			encode: function (str) {
				return base64encode(utf16to8(str));
			}
			, decode: function (str) {
				return utf8to16(base64decode(str));
			}
		}
	} ();

    return {
        Methods : Methods
        , JSON          : JSON
        , Cookie        : Cookie
        , WindowMessage : WindowMessage
        , CrossDomainAjax:CrossDomainAjax
        , LoginBox      : LoginBox
        , MessageBox    : MessageBox
        , Passport      : YokaPassport
        , Event			: Event
        , Monitor		: Monitor
		, Validator		: Validator
		, Verify		: Verify
		, ModalDialog	: ModalDialog
		, Base64		: Base64
    };
}();

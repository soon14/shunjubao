var TMJF = jQuery.noConflict(true);
    // 存放网站的一些配置信息
    TMJF.conf = {
    	cdn_i: GAOJIE_STATICS_DOMAIN_I
    	, domain: GAOJIE_DOMAIN
    	, www_root_domain: GAOJIE_WWW_ROOT_DOMAIN
    	, passport_root_domain: GAOJIE_PASSPORT_ROOT_DOMAIN
    	, tuan_root_domain: GAOJIE_TUAN_ROOT_DOMAIN
    	, purchase_root_domain: GAOJIE_PURCHASE_ROOT_DOMAIN
    };
    
    if (typeof(console) == "undefined") {
        var console = {
            'log': function (msg) {

            }
        };
    }
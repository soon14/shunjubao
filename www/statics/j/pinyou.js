!function(){
	//将json转成参数字符串，只处理一层的json，节省字数
	function json_to_param(json){var r = [];for(var i in  json){r.push(i+"="+escape(json[i]));}return r.join("&")}
	//取cookie函数
	function get_cookie(name){var pairs=document.cookie.split(";"),obj={},i=0,a;while(a=pairs[i]){var c = a.split("=");obj[c.shift().replace(/\s/g,"")] = c.join("=");++i;}return obj[name]||"";}
	//解析url中参数的函数
	function analyze_params(url){var pairs=(url.split("?")[1] || "").split("&"),obj={},i=0,a;while(a=pairs[i]){var c = a.split("=");obj[c.shift()] = c.join("=");++i;}return obj;}
	//从url中读取广告位ID和物料ID
	var p_url=analyze_params(location.href),p_ru=analyze_params(document.referrer),meSiteId=p_url.meSiteId,adMaterialId=p_url.adMaterialId;
	(p_url.adMaterialId=="")&&(meSiteId=p_ru.meSiteId,adMaterialId=p_ru.adMaterialId);
	//如果url里面有广告位和物料ID，说明是着陆页面，将这些参数存到cookie中，在注册成功或者购买成功的时候做统计用
	if (meSiteId!=""&&adMaterialId!="") {
		var date = new Date();
		date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
		document.cookie = "meSiteId=" + meSiteId + ";path=/;expires=" + date.toGMTString();
		document.cookie = "adMaterialId=" + adMaterialId + ";path=/;expires=" + date.toGMTString();
	}else{
		//如果url里面没有，从cookie里面读取
		meSiteId = get_cookie("meSiteId");
		adMaterialId = get_cookie("adMaterialId");
	}
	//配置信息，注册成功或者购买成功的页面
	var successUrl=['http://www.gaojie.com/purchase_process/cod_pay_tips.php'];//注册成功页面
	//所有需要发回后台的参数
	var params=json_to_param({
		owId:'2061',//广告主ID
		owLabelId:'',//栏目ID
		clReferUrl:escape(encodeURI(((document.referrer!='')&&document.referrer)||'Directinput')),//来源网站
		clUrl:escape(encodeURI(location.href)),//当前页面
		meSiteId:meSiteId,//广告位ID
		adMaterialId:adMaterialId//物料ID
	});
	//判断是不是注册成功或者购买成功页面，如果是，向服务器发请求
	for(var i=0;i<successUrl.length;i++){
		if(location.href.indexOf(successUrl[i]) == 0){
			document.writeln("<img style='display:none' src='http://optimus.ipinyou.com/ai.jsp"+params+"&r="+Math.random()+"'/>");
			break;
		}
	}
	//向服务器回传统计信息
	document.writeln("<img style='display:none' src='http://optimus.ipinyou.com/collect.jsp?"+params+"&jsType=4&r="+Math.random()+"'/>");
}();
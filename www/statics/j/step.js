TMJF(function($){
	
	// 绑定省市区数据
	var chinaArea = TMJF.ChinaArea;
	var s_province = $('select[name="f[province]"]')[0];
	var s_city = $('select[name="f[city]"]')[0];
	//var s_county = $('select[name="f[county]"]')[0];
	
	function bindCity(province){
		for(var i=s_city.options.length - 1; i>=0; i--){
			s_city.options[i] = null;
		}
		for(var city in chinaArea[province]){
			s_city.options.add(new Option(city, city));
		}
	}
	/**
	 * function bindCounty(province, city){
		for(var i=s_county.options.length - 1; i>=0; i--){
			s_county.options[i] = null;
		}
		if(!chinaArea[province])
			return;
		var counties = chinaArea[province][city];
		if(!counties)   return;
		for(var i=0; i<counties.length; i++){
			var county = counties[i];
			s_county.options.add(new Option(county, county));
		}
	}
	 */
	
	
	s_province.onchange = function(){
		bindCity(s_province.value);
		//bindCounty(s_province.value, s_city.value);
	};
	/**
	 * s_city.onchange = function(){
		bindCounty(s_province.value, s_city.value);
	};
	 */
	
	for(var province in TMJF.ChinaArea){
		s_province.options.add(new Option(province, province));
	}
});




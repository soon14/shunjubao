/**
 * 日期联动
 */
var vip_date_liandong = function() {
	TMJF(function($){
		var dateDay = $(".dateDay");   
		var dateMonth = $(".dateMonth");   
		var dateYear = $(".dateYear"); 
		
		var dDate = new Date();
		var dCurYear = 2000;
		var option_html="<option value='' selected=true > - </option>";
		dateYear.append(option_html);
		dateMonth.append(option_html);
		
		for (var i = dCurYear; i < dCurYear + 1; i--) {
			option_html="<option value="+i+">"+i+"</option>";
			
			dateYear.append(option_html);
			
			if ( i == 1940 ) {
				break;
			}
		}
		
		for(var i = 1; i <= 12; i++){
			option_html="<option value="+i+">"+i+"</option>";
			
			dateMonth.append(option_html);
		}
		// 调用函数出始化日
		TUpdateCal($(".dateYear").val(),$(".dateMonth").val());
	});
};

function TUpdateCal(iYear, iMonth) {
	var dDate = new Date();
	daysInMonth = TGetDaysInMonth(iMonth, iYear);
	TMJF(".dateDay").empty(); 
	
	TMJF(".dateDay").append("<option value=''> - </option>");
	for (d = 1; d <= parseInt(daysInMonth); d++) {
		option_html = "<option value="+d+">"+d+"</option>";
		TMJF(".dateDay").append(option_html);
	}
}

function TGetDaysInMonth(iMonth, iYear) {
	var dPrevDate = new Date(iYear, iMonth, 0);
	return dPrevDate.getDate();
}
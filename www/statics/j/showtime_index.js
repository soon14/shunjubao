var timerID = null;   

TMJF(function($) {
$(".lastTime").each(function(){
	var _this = this;
	var objInterval = setInterval(function () {
		var endtime = showtime($(_this).attr("endtime"));
		if (endtime == false) {
			clearInterval(objInterval);
			$(_this).text('该特卖已结束');
		} else {
			$(_this).text(endtime);
		}
	    
	}, 1000);
    
});
});
	
	var timerRunning = false;   
	function showtime(endtime) {   
		Today = new Date();   
		var timenow = Today.getTime();
		if(endtime == timenow*1000)
		{
			return false;
		}
		var timediff = endtime - timenow/1000;
		DateLeft = Math.floor(timediff / (24*3600));
		Hourleft = Math.floor(timediff / 3600)-DateLeft*24;  
		Minuteleft =  Math.floor(timediff / 60)-DateLeft*24*60-Hourleft*60;  
		Secondleft = Math.floor(timediff)-DateLeft*24*60*60-Hourleft*60*60-Minuteleft*60;   
		Dateleft = DateLeft;
		if (Secondleft<0)   
		{   
			Secondleft=60+Secondleft;   
			Minuteleft=Minuteleft-1;   
		}   
		if (Minuteleft<0)   
		{    
			Minuteleft=60+Minuteleft;   
			Hourleft=Hourleft-1;   
		}   
		if (Hourleft<0)   
		{   
			Hourleft=24+Hourleft;   
			Dateleft=Dateleft-1;   
		}  	
		
		var text = '结束';
		var Temp=text + ' ' + Dateleft+'天 '+Hourleft+':'+Minuteleft+':'+Secondleft ;	
		timerRunning = true;   
		if(Dateleft < 0){
			Temp = '已结束';
		}
		return Temp;
	}   
	  
	function stopclock () {   
		if(timerRunning)   
		clearTimeout(timerID);   
		timerRunning = false;   
	}   

	function startclock () {   
		showtime();  
	}

//限时秒杀倒计时
TMJF(function($) {
	_fresh();
	var sh=setInterval(_fresh,1000);
	function _fresh(){
		var nowtime = new Date();//当前时间
		var hour = nowtime.getHours();
		var todayEndTime= new Date(nowtime.getFullYear(), nowtime.getMonth(), nowtime.getDate(), 12, 00 ,00);//今天的12点
		if (hour < 12) {
			var endtime= todayEndTime;
		} else {
			var endtime= new Date(nowtime.getTime() + 86400 * 1000 - (nowtime.getTime() - todayEndTime)); 
		}
		var leftsecond=parseInt((endtime.getTime()-nowtime.getTime())/1000);//得到到期时间与当前时间的差值；
		var _h=parseInt((leftsecond/3600)%24);//计算小时；
		var _m=parseInt((leftsecond/60)%60);//计算分钟；
		var _s=parseInt(leftsecond%60);//计算秒;
		if(leftsecond>=0){
			hstr = _h < 10 ? ("0" + _h) : _h;//变成两位数字显示； 
			mstr = _m < 10 ? ("0" + _m) : _m;  
			sstr = _s < 10 ? ("0" + _s) : _s;
			$("#times").html("<var>距结束：</var><b>"+hstr+"</b>"+":"+"<b>"+mstr+"</b>"+":"+"<b>"+sstr+"</b>");
		} else {
			$("#times").html("");
		}
	}
});
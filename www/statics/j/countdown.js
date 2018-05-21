/**
 * 倒计时
 */
var timerID = null;
var timerRunning = false;

function showtime(bcs, end_time) {
    Today = new Date();
    var timenow = Today.getTime();
    var text = '';
	var timediff = end_time - timenow/1000;
    DateLeft = Math.floor(timediff / (24*3600));
    Hourleft = Math.floor(timediff / 3600)-DateLeft*24;
    Minuteleft =  Math.floor(timediff / 60)-DateLeft*24*60-Hourleft*60;
    Secondleft = Math.floor(timediff)-DateLeft*24*60*60-Hourleft*60*60-Minuteleft*60;
    Dateleft = DateLeft;
    if (Secondleft<0) {
        Secondleft=60+Secondleft;
        Minuteleft=Minuteleft-1;
    }
    if (Minuteleft<0) {
        Minuteleft=60+Minuteleft;
        Hourleft=Hourleft-1;
    }
    if (Hourleft<0) {
        Hourleft=24+Hourleft;
        Dateleft=Dateleft-1;
    }
    
    Temp=text+Dateleft+'天 '+Hourleft+':'+Minuteleft+':'+Secondleft;
    
    var day = '';
    var hour = '';
    var min = '';
    var second = '';
    
    if (Dateleft > 99) {
    	Dateleft = 99;
    }
    Dateleft = String(Dateleft);
    for (i = 0; i < Dateleft.length; i++) {
    	day += "<span>" + Dateleft.substr(i, 1) + "</span>";
    }
    
    Hourleft = String(Hourleft);
    for (i = 0; i < Hourleft.length; i++) {
    	hour += "<span>" + Hourleft.substr(i, 1) + "</span>";
    }
    
    Minuteleft = String(Minuteleft);
    for (i = 0; i < Minuteleft.length; i++) {
    	min += "<span>" + Minuteleft.substr(i, 1) + "</span>";
    }
    
    Secondleft = String(Secondleft);
    for (i = 0; i < Secondleft.length; i++) {
    	second += "<span>" + Secondleft.substr(i, 1) + "</span>";
    }
    
    
    Temp = "剩余&nbsp;" + day + "天&nbsp;" + hour + "时&nbsp;" + min + "分&nbsp;" + second + "秒";
    TMJF("."+bcs+" .countdown").html(Temp);
    
    timerID = setTimeout("showtime('"+bcs+"', "+end_time+")",1000);
}

function stopclock () {
	if(timerRunning) clearTimeout(timerID);
	timerRunning = false;
}

function startclock (bcs, end_time) {
	//stopclock();
	showtime(bcs, end_time);
}

TMJF(function($){
	$('.bktime').each(function(){
		var end_time = $(this).attr('endTime');
		var bcs = $(this).attr('bcs');
		startclock(bcs, end_time);
	});
});
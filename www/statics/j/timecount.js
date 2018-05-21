	var secs; //倒计时的秒数    
	var URL ;    
	function auto_jump(url, secs){    
		URL =url;    
		for(var i=secs;i>=1;i--)    
		{    
		window.setTimeout('doUpdate(' + i + ')', (secs-i) * 1000);    
		}    
	}    
	function doUpdate(num) {    
		document.getElementById('timecount').innerHTML = num+'秒后自动跳转' ;    
		if(num == 1) 
		{ 
			window.location=URL; 
		}    
	} 
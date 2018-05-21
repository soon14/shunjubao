(function () {
	var n =0;
	var isMouseUp = true;
	TMJF(function($){
		var kk = $("#kk");
		var kkp = $("#kk div");
		var cs = kkp.length;
		var cimgh = 75;
		for(var i=0; i<kkp.length; i++){
			var i1 = i +1;
			var kkpspan = $("<span id=p"+i1+"></span>");
			kkpspan.appendTo($("#div"));
		}
		var kktop =$("#kk").css("top");
		var kktopn = parseInt(kktop);
		$("#div span").removeClass();
		$("#div span").eq(n).addClass("active");

		function change(){
			if (cs <= 1) {
				return;
			}
			if(isMouseUp){
					$("#kk div").eq(0).css({"position":"static"});
					kktopn-=cimgh;
					kk.animate({"top":kktopn+"px"});
					if(kktopn <= -2*cimgh ){
						$("#kk div").eq(0).css({"position":"relative", "top":cs*cimgh+"px"});
					}

					if (kktopn== -(cs+1)*cimgh){
						kktopn = 0;
						kk.stop().css({"top":kktopn+"px"});
						$("#kk div").eq(0).css({"position":"static"});
						kktopn-=cimgh;
						kk.animate({"top":kktopn+"px"});
						$("#kk div").eq(0).css({"position":"static"});
					}

					
					n++;
					if(n==cs){
						n=0;
						$("#div span").eq(n).show();
					}
					$("#div span").removeClass();
					$("#div span").eq(n).addClass("active");
			}
		}
		setInterval(change, 5000);

		$("#k").hover(function(){
			isMouseUp=false;
		},function(){
			isMouseUp=true;
		});

		$("#div span").hover(function(){
			var pid = this.id;
			var reg1 = /\d+$/;
			var reg1f = pid.match(reg1)-1;
			n = reg1f;

			kktopn = (0-reg1f)*cimgh;
			$("#kk div").eq(0).css({"position":"static"});
			kk.stop().animate({"top":kktopn+"px"});
			$("#div span").removeClass();
			$(this).addClass("active");
			isMouseUp=false;
		},function(){
			isMouseUp=true;
		});
		
	});
}) ();
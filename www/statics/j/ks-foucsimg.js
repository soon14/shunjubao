(function () {
	var n =0;
	var isMouseUp = true;
	TMJF(function($){
		var kk = $("#kk");
		var kkp = $("#kk p");
		var cs = kkp.length;
		var cimgh = 350;
		for(var i=0; i<kkp.length; i++){
			var i1 = i +1;
			var kkpspan = $("<span id=p"+i1+"></span>");
			kkpspan.appendTo($("#p"));
		}
		var kktop =$("#kk").css("top");
		var kktopn = parseInt(kktop);
		$("#p span").removeClass();
		$("#p span").eq(n).addClass("active");

		function change(){
			if(isMouseUp){
					$("#kk p").eq(0).css({"position":"static"});
					kktopn-=cimgh;
					kk.animate({"top":kktopn+"px"});
					if(kktopn <= -2*cimgh ){
						$("#kk p").eq(0).css({"position":"relative", "top":cs*cimgh+"px"});
					}

					if (kktopn== -(cs+1)*cimgh){
						kktopn = 0;
						kk.stop().css({"top":kktopn+"px"});
						$("#kk p").eq(0).css({"position":"static"});
						kktopn-=cimgh;
						kk.animate({"top":kktopn+"px"});
						$("#kk p").eq(0).css({"position":"static"});
					}

					
					n++;
					if(n==cs){
						n=0;
						$("#p span").eq(n).show();
					}
					$("#p span").removeClass();
					$("#p span").eq(n).addClass("active");
			}
		}
		setInterval(change, 5000);

		$("#k").hover(function(){
			isMouseUp=false;
		},function(){
			isMouseUp=true;
		});

		$("#p span").hover(function(){
			var pid = this.id;
			var reg1 = /\d+$/;
			var reg1f = pid.match(reg1)-1;
			n = reg1f;

			kktopn = (0-reg1f)*cimgh;
			$("#kk p").eq(0).css({"position":"static"});
			kk.stop().animate({"top":kktopn+"px"});
			$("#p span").removeClass();
			$(this).addClass("active");
			isMouseUp=false;
		},function(){
			isMouseUp=true;
		});
		function pst(){
			var aw = $("#a").width();
			var pw = 990;
			if(aw < pw){
				$("#p").css("left","0");
			}else{
				$("#p").css({"left":(aw-pw)/2+18+"px","bottom":"20px"});
			}
		}
		pst();
		window.onresize=pst;
	});
}) ();
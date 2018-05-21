(function () {
	var n =0;
	var isMouseUp = true;
	TMJF(function($){
		var kk = $(".slider-bd");
		var kkp = $(".slider-bd li"); 
		var cs = kkp.length;
		var cimgh = 315;
		for(var i=0; i<kkp.length; i++){
			var i1 = i +1;
			var kkpspan = $("<li id=p"+i1+"></li>");
			kkpspan.appendTo($(".pointul-bd"));
		}
		var kktop =$(".slider-bd").css("top");
		var kktopn = parseInt(kktop);
		$(".pointul-bd li").removeClass();
		$(".pointul-bd li").eq(n).addClass("active");
		
		$(".text-width-bd div").hide();
		$(".text-width-bd div").eq(n).css("display","block");

		function change(){
			if (cs <= 1) {
				return;
			}
			if(isMouseUp){
					$(".slider-bd li").eq(0).css({"position":"static"});
					kktopn-=cimgh;
					kk.animate({"top":kktopn+"px"});
					if(kktopn <= -2*cimgh ){
						$(".slider-bd li").eq(0).css({"position":"relative", "top":cs*cimgh+"px"});
					}

					if (kktopn== -(cs+1)*cimgh){
						kktopn = 0;
						kk.stop().css({"top":kktopn+"px"});
						$(".slider-bd li").eq(0).css({"position":"static"});
						kktopn-=cimgh;
						kk.animate({"top":kktopn+"px"});
						$(".slider-bd li").eq(0).css({"position":"static"});
					}

					
					n++;
					if(n==cs){
						n=0;
						$(".pointul-bd li").eq(n).show();
					}
					$(".pointul-bd li").removeClass();
					$(".pointul-bd li").eq(n).addClass("active");
					
					$(".text-width-bd div").hide();
					$(".text-width-bd div").eq(n).css("display","block");
			}
		}
		setInterval(change, 5000);

		$(".slide-list-bd").hover(function(){
			isMouseUp=false;
		},function(){
			isMouseUp=true;
		});

		$(".pointul-bd li").hover(function(){
			var pid = this.id;
			var reg1 = /\d+$/;
			var reg1f = pid.match(reg1)-1;
			n = reg1f;

			kktopn = (0-reg1f)*cimgh;
			$(".slider-bd li").eq(0).css({"position":"static"});
			kk.stop().animate({"top":kktopn+"px"});
			$(".pointul-bd li").removeClass();
			$(this).addClass("active");
			isMouseUp=false;
			
			$(".text-width-bd div").hide();
			$(".text-width-bd div").eq(n).css("display","block");
		},function(){
			isMouseUp=true;
		});
		
	});
}) ();
var TMJF = jQuery.noConflict(true);


TMJF(function($){


     $(".btn1").click(function(){
		$('.blackwindow').css('height',$(document).height());
		$(".popup").fadeIn();
	});	

     $(".cartclose").click(function(){
		$(".popup").fadeOut();
	});	

});






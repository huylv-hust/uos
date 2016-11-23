//jquery.fadeimg/////////////////////////////////////////////////////////////////////
$(function() {
	/* fadeimg */
	$.fn.fadeimg = function(options){
		var settings = $.extend({
			fadeimg_show: ".fadeimg_show"
		},options);
		$(this)
			.fadeTo(1,1)
			.click(function(){
				var changeSrc  = $(this).find('img').attr("src"),
					alt = $(this).attr("alt");
				$(settings.fadeimg_show).fadeOut("slow",function(){
					$(this).attr("style","background-image: url(" + changeSrc + ")");
					$('#detail_image').find('p').html(alt).attr('title',alt);
					$(this).fadeIn();
				});
				return false;
			});

	}/* End fadeimg */
});
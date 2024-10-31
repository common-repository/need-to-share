(function(jQuery) {
	window.setTimeout( function() { jQuery("#needtoshare, #tw-need-to-share, #fb-need-to-share, #gplus-need-to-share").css({"opacity": "1", "filter": "alpha(opacity=1)"}) }, need_to_share_data.timeDelay );
	jQuery("#close-need-to-share").on('click', function() {
		jQuery("#needtoshare").hide('slow');
		
	});
	
})(jQuery);

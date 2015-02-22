define(function(require) {
	var $ = require("jquery");
// Desktop version
			$(function() {

        $("li.elgg-more a").on('click', function() {
            $("#elgg-menu-account").slideUp("fast");
            //$(this).toggleClass("elgg-state-selected");
});

        $("li.elgg-menu-item-account a").on('click', function() {
            $("#elgg-menu-site-more").slideUp("fast");
            $(this).toggleClass("elgg-state-selected");
});
        $(window).resize(function() {

				 if($(window).width() >= 768) {
				$('.elgg-state-active').removeClass('elgg-state-active');
                $(".elgg-nav-collapse").show();
				 } else {
					$(".elgg-nav-collapse").hide();
					$('.elgg-state-active').removeClass('elgg-state-active');
					}
				}).resize();
// remove autofocus to avoid pagejump
   //$(".elgg-form-login input").removeClass("elgg-autofocus");
		
	});
});

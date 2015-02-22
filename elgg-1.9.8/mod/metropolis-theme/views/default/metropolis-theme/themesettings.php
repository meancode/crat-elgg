<?php
/**
 *
 * Juipo themesettings js
 *
 */

if (0) { ?><script><?php }

?>      
elgg.provide('juipo.options.panel');

juipo.options.panel.init = function() {
	var form = $('form[name=juipo-options-panel]');
	form.find('input[type=submit]').live('click', juipo.options.panel.submit);
};

juipo.options.panel.submit = function(e) {

	var form = $(this).parents('form');
	var id = form.find('textarea').attr('id');
	
	var data = form.serialize();
	
	$('.juipo-result').addClass('juipo-loader');

	elgg.action('metropolis-theme/admin/settings', {
		data: data,
		complete: function() {
			$('html, body').delay(800).animate({scrollTop:0}, 'slow');
				},
		success: function(json) {
			$('.juipo-result').removeClass('juipo-loader');
		}
	});
	e.preventDefault();
};
elgg.register_hook_handler('init', 'system', juipo.options.panel.init);

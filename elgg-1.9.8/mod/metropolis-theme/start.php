<?php
/**
 * Elgg Metropolis theme plugin 1.9
 *
 * @package ElggTheme
 */
 
elgg_register_event_handler('init','system','metropolis_theme_init');

function metropolis_theme_init() {

    $root = dirname(__FILE__);
	$plugin = elgg_get_plugin_from_id('metropolis-theme');
	
	// Register libraries
	elgg_register_library("metropolis:hooks", "$root/lib/hooks.php");
	elgg_register_library("metropolis:menus", "$root/lib/menus.php");
	elgg_load_library("metropolis:hooks");

	detectmobile();	
	$mobile = detectmobile();
    $action_path = dirname(__FILE__) . '/actions';
	elgg_register_action("metropolis-theme/admin/settings", "$action_path/settings.php", 'admin');
	elgg_register_action("metropolis-theme/admin/sidebar", "$action_path/settings.php", 'admin');
	elgg_register_action("metropolis-theme/admin/slider", "$action_path/settings.php", 'admin');
	elgg_register_action("metropolis-theme/admin/social", "$action_path/settings.php", 'admin');
	elgg_extend_view('js/admin', 'metropolis-theme/themesettings');

	elgg_register_event_handler('pagesetup', 'system', 'metropolis_theme_pagesetup', 1000);
	elgg_register_admin_menu_item('configure', 'metropolis-theme', 'settings');
	elgg_register_plugin_hook_handler('entity:icon:url', 'user', 'juipo_icon_url_handler');
	elgg_register_plugin_hook_handler('entity:icon:url', 'group', 'juipo_groups_icon_url_handler');	
	
	elgg_register_plugin_hook_handler('head', 'page', 'metropolis_setup_head');

	// theme specific CSS
	elgg_extend_view('css/elgg', 'metropolis-theme/css');
	elgg_extend_view('css/admin', 'metropolis-theme/admin');	

	if (elgg_get_context() != 'admin') {
	elgg_define_js('respond', array('src' => '/mod/metropolis-theme/vendors/js/respond.min.js'));
	elgg_require_js('respond');
	if ($mobile == true){
	elgg_define_js('metropolis.theme.mobi', array('src' => '/mod/metropolis-theme/vendors/js/metropolis_theme_mobi.js'));
	elgg_require_js('metropolis.theme.mobi');
	} else {
	elgg_define_js('metropolis.theme', array('src' => '/mod/metropolis-theme/vendors/js/metropolis_theme.js'));
	elgg_require_js('metropolis.theme');
	}
	} 
	elgg_register_js('topscroll', 'mod/metropolis-theme/vendors/js/juipo_topscroll.js', 'footer');
	
	if (elgg_is_logged_in()){
	elgg_register_action("juipo_update/add", "$action_path/add.php");		
	elgg_extend_view('js/elgg', 'metropolis-theme/update');
	elgg_unregister_js('elgg.friendspicker');
	}
	if (!elgg_is_active_plugin('custom_index')) {
		// Replace the default index page
	elgg_register_page_handler('', 'metropolis_front_page');
	}	
 
    $plugin = elgg_get_plugin_from_id('metropolis-theme');
	
	if ($plugin->roundicons == 'yes'){
	elgg_extend_view('css/elgg', 'metropolis-theme/avatar-css');
	}
	if ($plugin->sharethis == 'yes'){
	elgg_extend_view('page/elements/footer', 'metropolis-theme/sharethis');
	}
	if ($plugin->topscroll == 'yes'){
	elgg_load_js('topscroll');	
    elgg_extend_view('page/elements/footer', 'metropolis-theme/topscroll');
	}
	//Remove RSS feed icon for not logged in
	if (!elgg_is_logged_in()) {	
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}
	// Theme settings
	if ($plugin->sitemenumore == 'yes' || $mobile == true){
	elgg_unregister_plugin_hook_handler('prepare', 'menu:site', '_elgg_site_menu_setup');
	}
	
	themes_register_themes();

	$theme = elgg_get_plugin_setting('active_theme', 'metropolis-theme');
	
	if ($theme != 'default' && elgg_get_context() != 'admin'){
		elgg_load_css($theme);
	}
}
function themes_register_themes() {
	$themes = array('default', 'purple', 'blue', 'green', 'red', 'black', 'custom');

	foreach($themes as $theme) {
		elgg_register_simplecache_view("css/themes/$theme");
		$url = elgg_get_simplecache_url('css', "themes/$theme");
		elgg_register_css($theme, $url);
	}
}
function metropolis_theme_pagesetup() {

    elgg_load_library("metropolis:menus");

    $plugin = elgg_get_plugin_from_id('metropolis-theme');
	
	if (elgg_is_logged_in()	&& elgg_get_context() == 'activity'){
        if ($plugin->show_thewire == 'yes'){		
			elgg_extend_view('page/layouts/elements/header', 'page/elements/riverwire', 1);
		}
    }		
	if (elgg_is_logged_in()){
		if (elgg_get_context() == 'activity' || elgg_get_context() == 'thewire'){	

		if ($plugin->show_icon == 'yes'){
			elgg_extend_view('page/elements/sidebar', 'page/elements/rivericon', 501);
		}
		if ($plugin->show_menu == 'yes'){
			elgg_extend_view('page/elements/sidebar', 'page/elements/ownermenu', 502);
		}
	}
	}
		if ($plugin->show_custom == 'yes'){
			elgg_extend_view('page/elements/sidebar', 'page/elements/custom_module', 504);
		}
		if ($plugin->banner == 'yes'){
			elgg_extend_view('page/elements/sidebar', 'page/elements/banner', 503);
		}
        elgg_unextend_view('page/elements/header', 'search/header');	
        	
	if (elgg_is_logged_in()	|| $plugin->search == 'yes'){
	    elgg_extend_view('page/elements/header', 'search/header_top');
		elgg_extend_view('page/elements/sidebar', 'search/header', 0);
	}	
	
}

/**
 * Serve the front page
 * 
 * @return bool Whether the page was sent.
 */
function metropolis_front_page() {
	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}

	return true;
}
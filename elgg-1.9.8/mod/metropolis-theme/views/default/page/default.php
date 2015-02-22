<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 * Juipo Metropolis Theme
 *
 * @author Damir Gasparlin - Juipo.com
 * @copyright Copyright (c) 2013, Juipo.com
 * @link http://juipo.com/
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']       The page title
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	if (get_input('handler') != 'admin') {
		elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	}
	elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

// render content before head so that JavaScript and CSS can be loaded. See #4032
$topbar = elgg_view('page/elements/topbar', $vars);
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('page/elements/header', $vars);
$navbar = elgg_view('page/elements/navbar', $vars);
$slider = elgg_view('page/elements/slider', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);
$accmenu = elgg_view_menu('account', array('sort_by' => 'priority', array('elgg-menu-hz')));

$body = <<<__BODY
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-messages">
		$messages
	</div>
__BODY;

if (elgg_is_logged_in() && elgg_get_plugin_setting('topbar', 'metropolis-theme') == 'yes'){
	$topbar = elgg_view('page/elements/topbar', $vars);

	$body .= <<<__BODY
	<div class="elgg-page-topbar">
		<div class="elgg-inner">
			$topbar
		</div>
	</div>
__BODY;
}
$body .= <<<__BODY
	<div class="elgg-page-header">
		<div class="elgg-inner">
			$header
		</div>
	</div>
	<div class="elgg-page-globalnav">
		<div class="elgg-inner">
			$navbar
		</div>
	</div>
	<div class="elgg-page-slidemenu">
		<div class="elgg-inner">
			$accmenu
		</div>
	</div>
__BODY;
if (!elgg_is_logged_in() && elgg_get_context() == 'main' && elgg_get_plugin_setting('slider', 'metropolis-theme') == 'yes'){
$body .= <<<__BODY
<!--- Responsive Slider --->
	<div class="elgg-page-body-slider">
	 $slider;	
	</div>
__BODY;
}
$body .= <<<__BODY
	<div class="elgg-page-body">
		<div class="elgg-inner">
			$content
		</div>
	</div>
	<div class="elgg-page-footer">
		<div class="elgg-inner">
			$footer
		</div>
	</div>
</div>
__BODY;

$body .= elgg_view('page/elements/foot');
$body .= "<!-- Custom Elgg Theme by Juipo Web Design - http://juipo.com/,  sponsored by http://www.mobilenetinc.com/, http://www.skeletonkeyantique.com/ and http://www.cheap-bmw-parts.com/ -->";

$head = elgg_view('page/elements/head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);

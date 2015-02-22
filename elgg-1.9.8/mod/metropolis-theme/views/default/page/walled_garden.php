<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
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
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('page/elements/header', $vars);
$navbar = elgg_view('page/elements/navbar', $vars);
$slider = elgg_view('page/elements/slider', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

$body = <<<__BODY
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-messages">
		$messages
	</div>
__BODY;

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
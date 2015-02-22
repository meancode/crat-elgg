<?php
/**
 * Elgg custom index page
 * Juipo Metropolis Theme
 *
 * @author Damir Gasparlin - Juipo.com
 * @copyright Copyright (c) 2013, Juipo.com
 * @link http://juipo.com/
 */

if (elgg_is_logged_in()) {
	forward('activity');
}
//elgg_push_context('metropolis');
$class = array('class' => 'juipo-landing-page');

//grab the login form
$login = elgg_view("core/account/login_box");

// lay out the content
$params = array(
	'login' => $login
);
$body = elgg_view_layout('juipo_index', $params);

//echo elgg_view_page($title, $body);
//echo elgg_view_page($title, $body, array('body_attrs' => $class));
//echo elgg_view_page($title, $body, '', array('body_attrs' => $class));
echo elgg_view_page($title, $body, 'default', array('body_attrs' => $class));
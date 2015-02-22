<?php
/**
 *
 *  Juipo Metropolis Theme hooks
 *
 * @package Juipo Metropolis Theme
 * 
 */


function elgg_view_icon_white($name, $class = '') {
	// @todo deprecate boolean in Elgg 1.9
	if ($class === true) {
		$class = 'float';
	}
	return "<span class=\"elgg-icon-white elgg-icon-$name $class\"></span>";
} 
function elgg_view_icon_sync($name, $class = '') {
	// @todo deprecate boolean in Elgg 1.9
	if ($class === true) {
		$class = 'float';
	}
	return "<span class=\"elgg-icon-sync elgg-icon-$name $class\"></span>";
} 
function elgg_view_icon_sync_white($name, $class = '') {
	// @todo deprecate boolean in Elgg 1.9
	if ($class === true) {
		$class = 'float';
	}
	return "<span class=\"elgg-icon-sync-white elgg-icon-$name $class\"></span>";
} 
function juipo_icon_url_handler($hook, $entity_type, $returnvalue, $params) {

	$user = $params['entity'];
	$size = $params['size'];

	if (isset($user->icontime)) {
		return "avatar/view/$user->username/$size/$user->icontime";
	} else {
		return "mod/metropolis-theme/graphics/user/default{$size}.jpg";
	}
}

function juipo_groups_icon_url_handler($hook, $entity_type, $returnvalue, $params) {
	
	$group = $params['entity'];
	$size = $params['size'];

	$icontime = $group->icontime;
		
	if ($icontime) {
		// return thumbnail
		return "groupicon/$group->guid/$size/$icontime.jpg";
	}
	return "mod/metropolis-theme/graphics/groups/default{$size}.jpg";
}

function detectmobile(){
	if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipaq|ipod|ipad|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])) {
		return true;
	} else {
		return false;
	}
}
  
/**
 * Register items for the html head
 *
 * @param string $hook Hook name ('head')
 * @param string $type Hook type ('page')
 * @param array  $data Array of items for head
 * @return array
 */
function metropolis_setup_head($hook, $type, $data) {
	
	$data['metas'][] = array(
		'name' => 'viewport',
		'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0',
	);

	// https://developer.chrome.com/multidevice/android/installtohomescreen
    $data['metas'][] = array(
        'name' => 'mobile-web-app-capable',
        'content' => 'yes',
    );

    $data['metas'][] = array(
        'name' => 'apple-mobile-web-app-capable',
        'content' => 'yes',
    );
	
	$data['links'][] = array(
		'rel' => 'stylesheet',
		'href' => '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css',
	);
	
	$data['links'][] = array(
		'rel' => 'apple-touch-icon',
		'href' => elgg_normalize_url('mod/metropolis-theme/graphics/homescreen.png'),
	);
	$data['links'][] = array(
		'rel' => 'apple-touch-startup-image',
		'href' => elgg_normalize_url('mod/metropolis-theme/graphics/homesplash.png'),
	);
	
	// favicons
	$data['links'][] = array(
			'rel' => 'icon',
			'href' => elgg_normalize_url('mod/metropolis-theme/graphics/favicon.ico'),
		);
	$data['links'][] = array(
		'rel' => 'icon',
		'sizes' => '16x16',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/metropolis-theme/graphics/favicon-16.png'),
	);
	$data['links'][] = array(
		'rel' => 'icon',
		'sizes' => '32x32',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/metropolis-theme/graphics/favicon-32.png'),
	);
	$data['links'][] = array(
		'rel' => 'icon',
		'sizes' => '64x64',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/metropolis-theme/graphics/favicon-64.png'),
	);
	$data['links'][] = array(
		'rel' => 'icon',
		'sizes' => '128x128',
		'type' => 'image/png',
		'href' => elgg_normalize_url('mod/metropolis-theme/graphics/favicon-128.png'),
	);

	return $data;
}
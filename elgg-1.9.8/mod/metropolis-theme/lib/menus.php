<?php
/**
 *
 * Set up menu items
 *
 * @package Juipo Metropolis Theme
 * 
 */

    $site = elgg_get_site_entity();
    $site_name = $site->name;
    $site_url = elgg_get_site_url();
	
	elgg_unregister_menu_item('topbar', 'elgg_logo');
	elgg_unregister_menu_item('footer', 'powered');
	
    	if (elgg_is_logged_in()) {

		$user = elgg_get_logged_in_user_entity();
		elgg_register_menu_item('dropaccount', array(
			'name' => 'account',
			'text' => elgg_echo('account'),
			'title' => elgg_echo('account'),
			'href' => "#elgg-menu-account",
			'rel' => "toggle",
			'priority' => 100,
			'span_after' => true,
			'icon_class_after' => 'elgg-icon-sync-white',
			'link_icon_after' => 'elgg-icon-icon-swapdown',
		));
		
		elgg_register_menu_item('account', array(
			'name' => 'profile',
			'href' => "/profile/" . elgg_get_logged_in_user_entity()->username,
			'text' => elgg_echo('profile'),
			'priority' => 101,
            'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-user',
		));
		elgg_register_menu_item('account', array(
			'name' => 'friends',
			'href' => "/friends/" . elgg_get_logged_in_user_entity()->username,
			'text' => elgg_echo('friends'),
			'title' => elgg_echo('friends'),
			'priority' => 103,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-users',
		));
		elgg_register_menu_item('extras', array(
			'name' => 'friends',
			'title' => elgg_echo('friends'),
			'text' => elgg_view_icon('users'),
			'href' => "/friends/" . elgg_get_logged_in_user_entity()->username,
			'priority' => 150,
		));
		elgg_register_menu_item('topbar', array(
			'name' => 'friends',
			'title' => elgg_echo('friends'),
			'text' => elgg_view_icon_white('users'),
			'href' => "/friends/" . elgg_get_logged_in_user_entity()->username,
			'priority' => 300,
		));
		
		if (elgg_is_active_plugin('messages')) {	
			elgg_unregister_menu_item('topbar', 'messages');
			// get unread messages
			$num_messages = (int)messages_count_unread();
			if ($num_messages != 0) {
				$text .= "<span class=\"messages-new\">$num_messages</span>";
				$tooltip .= " (" . elgg_echo("messages:unreadcount", array($num_messages)) . ")";
			}							
			elgg_register_menu_item('extras', array(
				'name' => 'messages',
				'href' => 'messages/inbox/' . elgg_get_logged_in_user_entity()->username,
				'text' => $text . elgg_view_icon('mail'),
				'title' => elgg_echo('messages').$tooltip,
				'priority' => 200,
			));

		elgg_register_menu_item('account', array(
			'name' => 'messages',
			'href' => 'messages/inbox/' . elgg_get_logged_in_user_entity()->username,
			'text' => $text . elgg_echo('messages'),
			'title' => elgg_echo('messages').$tooltip,
			'priority' => 102,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-mail',
		));
		elgg_register_menu_item('topbar', array(
			'name' => 'messages',
			'href' => 'messages/inbox/' . elgg_get_logged_in_user_entity()->username,
			'text' => $text . elgg_view_icon_white('mail'),
			'title' => elgg_echo('messages').$tooltip,
            'priority' => 600,
		));
		}
		elgg_register_menu_item('account', array(
			'name' => 'profileedit',
			'href' => "/profile/$user->username/edit",
			'text' => elgg_echo('profile:edit'),
			'priority' => 104,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-briefcase',
		));
		elgg_register_menu_item('account', array(
			'name' => 'editavatar',
			'href' => "/avatar/edit/" . elgg_get_logged_in_user_entity()->username,
			'text' => elgg_echo('avatar:edit'),
			'priority' => 105,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-adduser',
		));
		elgg_register_menu_item('account', array(
			'name' => 'usersettings',
			'href' => "/settings/user/" . elgg_get_logged_in_user_entity()->username,
			'text' => elgg_echo('settings'),
			'priority' => 109,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-settings-alt',
		));
		elgg_register_menu_item('account', array(
			'name' => 'notifications',
			'href' => "/notifications/personal/" . elgg_get_logged_in_user_entity()->username,
			'text' => elgg_echo('juipo:notifications'),
			'priority' => 110,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-notifications',
		));
		
		elgg_register_menu_item('account', array(
			'name' => 'logout',
			'href' => '/action/logout',
			'is_action' => TRUE,
			'text' => elgg_echo('logout'),
			'priority' => 130,
			'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-off',
		));
		
		if (elgg_is_admin_logged_in()) {		
			elgg_register_menu_item('account', array(
				'name' => 'administration',
				'href' => 'admin',
				'text' => elgg_echo('admin'),
				'priority' => 100,
				'span_before' => true,
			'icon_class_before' => 'elgg-icon-white',
			'link_icon_before' => 'elgg-icon-settings',
			));
		}		
		
		elgg_unregister_menu_item('footer', 'report_this');
		if (elgg_is_active_plugin('reportedcontent')) {
			$href = "javascript:elgg.forward('reportedcontent/add'";
			$href .= "+'?address='+encodeURIComponent(location.href)";
			$href .= "+'&title='+encodeURIComponent(document.title));";

			elgg_register_menu_item('extras', array(
				'name' => 'report_this',
				'href' => $href,
				'text' => elgg_view_icon('report-this') . elgg_echo(''),
				'title' => elgg_echo('reportedcontent:this:tooltip'),
				'priority' => 100,
			));
		}
	}
	elgg_unregister_menu_item('topbar', 'dashboard');
	if (elgg_is_active_plugin('dashboard')) {
		elgg_register_menu_item('site', array(
			'name' => 'dashboard',
			'href' => 'dashboard',
			'text' => elgg_echo('dashboard'),
		));
	}
	// Social Icons
$plugin = elgg_get_plugin_from_id('metropolis-theme');
if (elgg_is_logged_in() && $plugin->sharethis == 'yes'){
elgg_register_menu_item('extras', array(
				'name' => 'sharethis',
				'href' => '',
				'text' => '<span class="elgg-icon st_sharethis_custom"></span>',
				'title' => elgg_echo('juipo:sharepage'),
				'priority' => 1,
			));
}
$skype = '<script type="text/javascript" src="http://cdn.dev.skype.com/uri/skype-uri.js"></script>
<div id="SkypeButton_Chat_'.$plugin->skype.'_1">
  <script type="text/javascript">
    Skype.ui({
      "name": "chat",
      "element": "SkypeButton_Chat_'.$plugin->skype.'_1",
      "participants": ["'.$plugin->skype.'"],
      "imageSize": 24
    });
  </script>
</div>';
        if ($plugin->socialheading != '') {
		elgg_register_menu_item('connect', array(
			'name' => 'follow',
			'text' => '<h3>'.$plugin->socialheading.'</h3>',
			'href' => false,
			'priority' => 1,
			'link_class' => 'follow',
		));
		}

        if (elgg_get_config('walled_garden') && !elgg_is_logged_in()) { 
        } else {
		elgg_register_menu_item('connect', array(
			'name' => 'rss',
			'text' => elgg_view_icon('rss') . elgg_echo(''),
			'href' => $site_url . 'activity?view=rss',
			'target' => '_blank',
		    'title' => elgg_echo('RSS'),
			'priority' => 2,
			'link_class' => 'rss',
		));
		}
		if ($plugin->facebook != '') {
		elgg_register_menu_item('connect', array(
			'name' => 'facebook',
			'text' => elgg_view_icon('facebook') . elgg_echo(''),
			'href' => $plugin->facebook,
			'target' => '_blank',
		    'title' => elgg_echo('Facebook'),
			'priority' => 7,
			'link_class' => 'facebook',
		));
		}
		if ($plugin->twitter != '') {
		elgg_register_menu_item('connect', array(
			'name' => 'twitter',
			'text' => elgg_view_icon('twitter') . elgg_echo(''),
			'href' => $plugin->twitter,
			'target' => '_blank',
		    'title' => elgg_echo('Twitter'),
			'priority' => 8,
			'link_class' => 'twitter',
		));
		}
		if ($plugin->google != '') {
		elgg_register_menu_item('connect', array(
			'name' => 'google',
			'text' => elgg_view_icon('google') . elgg_echo(''),
			'href' => $plugin->google,
			'target' => '_blank',
		    'title' => elgg_echo('Google'),
			'priority' => 9,
			'link_class' => 'google',
		));
		}
		
		if ($plugin->skype != '') {
		elgg_register_menu_item('connect', array(
			'name' => 'skype',
			'text' => $skype,
            'href' => false,
		    'title' => elgg_echo('Skype'),
			'priority' => 10,
			'link_class' => 'skype',
		));
		}

	        // Homepage slider
	        $slide1 = $plugin->slide1;
			$slide2 = $plugin->slide2;
			$slide3 = $plugin->slide3;
			$slide4 = $plugin->slide4;
			$slide5 = $plugin->slide5;
			$slide1text = $plugin->slide1text;
			$slide2text = $plugin->slide2text;
			$slide3text = $plugin->slide3text;
			$slide4text = $plugin->slide4text;
			$slide5text = $plugin->slide5text;
			$slide1color = $plugin->slide1color;
			$slide2color = $plugin->slide2color;
			$slide3color = $plugin->slide3color;
			$slide4color = $plugin->slide4color;
			$slide5color = $plugin->slide5color;
			$text1 = '<img alt="'.$site_name.'" src="'.$slide1.'">';
			if ($plugin->slide1text !== ''){
			$text1 .= '<div class="flex-caption" style="background-color:'.$slide1color.' !important;">' . $slide1text . '</div>';
			}
			$text2 = '<img alt="'.$site_name.'" src="'.$slide2.'">';
			if ($plugin->slide2text !== ''){
			$text2 .= '<div class="flex-caption" style="background-color:'.$slide2color.' !important;">' . $slide2text . '</div>';
			}
			$text3 = '<img alt="'.$site_name.'" src="'.$slide3.'">';
			if ($plugin->slide3text !== ''){
			$text3 .= '<div class="flex-caption" style="background-color:'.$slide3color.' !important;">' . $slide3text . '</div>';
			}
			$text4 = '<img alt="'.$site_name.'" src="'.$slide4.'">';
			if ($plugin->slide4text !== ''){
			$text4 .= '<div class="flex-caption" style="background-color:'.$slide4color.' !important;">' . $slide4text . '</div>';
			}
			$text5 = '<img alt="'.$site_name.'" src="'.$slide5.'">';
			if ($plugin->slide5text !== ''){
			$text5 .= '<div class="flex-caption" style="background-color:'.$slide5color.' !important;">' . $slide5text . '</div>';
			}

			
		if ($plugin->slide1 !== ''){
			elgg_register_menu_item('homeslide', array(
				'name' => 'slide1',
				'href' => false,
				'text' => $text1,
				'link_class' => 'slide',
				'priority' => $slideorder1,
			));
			} 
		if ($plugin->slide2 !== ''){
			elgg_register_menu_item('homeslide', array(
				'name' => 'slide2',
				'href' => false,
				'text' => $text2,
				'link_class' => 'slide',
				'priority' => $slideorder2,
			));
			} 
			if ($plugin->slide3 !== ''){
			elgg_register_menu_item('homeslide', array(
				'name' => 'slide3',
				'href' => false,
				'text' => $text3,
				'link_class' => 'slide',
				'priority' => $slideorder3,
			));
			}
			if ($plugin->slide4 !== ''){
			elgg_register_menu_item('homeslide', array(
				'name' => 'slide4',
				'href' => false,
				'text' => $text4,
				'link_class' => 'slide',
				'priority' => $slideorder4,
			));
			}
			if ($plugin->slide5 !== ''){
			elgg_register_menu_item('homeslide', array(
				'name' => 'slide5',
				'href' => false,
				'text' => $text5,
				'link_class' => 'slide',
				'priority' => $slideorder4,
			));
			}
<?php
/**
 * Juipo Simple tabs
 */
$site_url = elgg_get_site_url();		

echo "<div class=\"juipo-options-panel\">";
	echo "<div class=\"juipo-holder\">";
		echo "<div class=\"panel-header\">" . elgg_echo('juipo:panel') . "</div>";
		echo "<div class=\"panel-line\"></div>";
		
		echo elgg_view_form('metropolis-theme/admin/settings', array('class' => 'settings-optionspanel', 'name' => 'juipo-options-panel'));

	echo "</div>";
echo "</div>";



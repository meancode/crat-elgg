<?php
/**
 * Wire add form body
 *
 * @uses $vars['post']
   * Juipo Custom Elgg Theme
	 *
	 * @package Juipo Custom
	 * @author Damir Gasparlin - juipo Web Design
	 * @copyright Juipo.com 2014
	 * @link http://juipo.com/
 *
 */
elgg_load_js('elgg.thewire');

$post = elgg_extract('post', $vars);
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire');

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('reply');
}
$chars_left = elgg_echo('thewire:charleft');

$parent_input = '';
if ($post) {
	$parent_input = elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $post->guid,
	));
}

$count_down = "<span>$char_limit</span> $chars_left";
$num_lines = 2;
if ($char_limit == 0) {
	$num_lines = 3;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 3;
}
// render placeholder separately so it will double-encode if needed
$placeholder = htmlspecialchars(elgg_echo('metropolis_theme:thewire'), ENT_QUOTES, 'UTF-8');

$post_input = elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm',
	'id' => 'thewire-textarea',
	'placeholder' => $placeholder,
	'rows' => $num_lines,
	'data-max-length' => $char_limit,
));

$submit_button = elgg_view('input/submit', array(
	'value' => $text,
	'id' => 'thewire-submit-button',
));

echo <<<HTML
	$post_input
<div class="river-wire-foot">
<div id="thewire-characters-remaining">
	$count_down
</div>
<div class="elgg-foot mts">
	$parent_input
	$submit_button
</div>
</div>
HTML;

?>

<script>
$('.river-wire-foot').hide();

$('#thewire-textarea').focus(function() {
   $('.river-wire-foot').show('slow');
   
}).blur(function() {
    //$('#thewire-characters-remaining, .elgg-foot').hide('slow');
	
	$('.river-wire-foot').hide('slow');
});
</script>
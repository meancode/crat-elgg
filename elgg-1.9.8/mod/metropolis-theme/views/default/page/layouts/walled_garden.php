<?php
/**
 * Walled Garden layout
 *
 * @uses $vars['content'] Main content
 * @uses $vars['class']   CSS classes
 * @uses $vars['id']      CSS id
 */

$class = 'elgg-layout elgg-layout-one-column clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

?>
<div class="<?php echo $class; ?>">
	<div class="elgg-main elgg-body">
	<?php
		echo elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

			echo elgg_view('page/layouts/elements/header', $vars);

			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
				echo $vars['content'];
			}

			echo elgg_view('page/layouts/elements/footer', $vars);
	?>
	</div>
</div>
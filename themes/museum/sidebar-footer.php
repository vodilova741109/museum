<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package museum
 */

if ( ! is_active_sidebar( 'footer-sidebar') ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'footer-sidebar' ); ?>
</aside><!-- #secondary -->

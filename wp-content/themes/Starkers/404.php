<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div id="content" class="fourOh">
	<div class="span1 contact">
			<img src="/wp-content/uploads/hamstertown.png" width="231.25px">
	</div>
	<div class="span3">
<h1>Oh,no! Page not found</h1>
<p>Try again, search below.</p>
	</div>
</div>
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
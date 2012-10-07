<?php
/**
 * Template Name: Thumbnail Page
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header-work' ) ); ?>
	<div id="content" class="workPage">
		<div class="row">
			<div class="thumbnail map"><a href="/work/boston-map/"><img class="thumb" src="http://localhost:8888/wp-content/uploads/2012/10/boston_thumb.jpg"></a></div>
			<div class="thumbnail web"><a href="/work/file-bakery/"><img class="thumb" src="http://localhost:8888/wp-content/uploads/2012/10/filebakery-thumb.png"></a></div>
			<div class="thumbnail map web"><a href="/work/mta/"><img class="thumb" src="http://localhost:8888/wp-content/uploads/2012/10/mta_thumb.png"></a></div>
			<div class="thumbnail graphic"><a href="http://localhost:8888/work/common-scale/"><img class="thumb" src="http://localhost:8888/wp-content/uploads/2012/10/speedfatality_thumb.jpg"></a></div>
		</div>
		<div class="row">
			<div class="thumbnail graphic"><a href="http://localhost:8888/work/common-scale/"><img class="thumb" src="http://localhost:8888/wp-content/uploads/2012/10/streetsystem_thumb.png"></a></div>
			<div class="thumbnail map"><a href="#"><img class="thumb" src="http://localhost:8888/wp-content/uploads/2012/10/plannersguide_thumb.png"></a></div>
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
		</div>
		<div class="row">
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
		</div>
		<div class="row">
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
			<div class="thumbnail"></div>
		</div>		
	</div>

<script src="/wp-content/themes/starkers/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="/wp-content/themes/starkers/mask.js" type="text/javascript"></script> 

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
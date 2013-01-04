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
			<div class="thumbnail map"><a href="/work/boston-map/"><img class="thumb" src="/wp-content/uploads/boston_thumb.jpg"></a></div>
			<div class="thumbnail web"><a href="/work/file-bakery/"><img class="thumb" src="/wp-content/uploads/filebakery-thumb.png"></a></div>
			<div class="thumbnail map web"><a href="/work/mta/"><img class="thumb" src="/wp-content/uploads/mta_thumb.png"></a></div>
			<div class="thumbnail graphic"><a href="/work/common-scale/"><img class="thumb" src="/wp-content/uploads/speedfatality_thumb.jpg"></a></div>
		</div>
		<div class="row">
			<div class="thumbnail graphic map"><a href="/work/more-bra/"><img class="thumb" src="/wp-content/uploads/bra_misc_thumb.jpg"></a></div>
			<div class="thumbnail map graphic"><a href="/work/apa-planners-guide/"><img class="thumb" src="/wp-content/uploads/plannersguide_thumb.png"></a></div>
			<div class="thumbnail web"><a href="/work/see-penny-work/"><img class="thumb" src="/wp-content/uploads/seepennywork_thumb.png"></a></div>
			<div class="thumbnail web"><a href="/work/stuart-street/"><img class="thumb" src="/wp-content/uploads/stuart_thumb.jpg"></a></div>
		</div>
		<div class="row">
			<div class="thumbnail graphic"><a href="/work/architecture/"><img class="thumb" src="/wp-content/uploads/arch_thumb.jpg"></a></div>
			<div class="thumbnail fun"><a href="/work/summer/"><img class="thumb" src="/wp-content/uploads/summer_thumb.png"></a></div>
			<div class="thumbnail graphic fun map"><a href="/work/new-orleans-map/"><img class="thumb" src="/wp-content/uploads/nola_thumb.png"></a></div>
			<div class="thumbnail graphic fun web"><a href="/work/ecab/"><img class="thumb" src="/wp-content/uploads/ecab_thumb.png"></a></div>
		</div>
		<div class="row">
			<div class="thumbnail graphic fun"><a href="/work/book-cover/"><img class="thumb" src="/wp-content/uploads/hollycover_thumb.jpg"></a></div>
			<div class="thumbnail fun map"><a href="/work/sabbatical/"><img class="thumb" src="/wp-content/uploads/jlordtravel_thumb.jpg"></a></div>
			<div class="thumbnail graphic"><a href="/work/bpma/"><img class="thumb" src="/wp-content/uploads/bpma_thumb.jpg"></a></div>
			<div class="thumbnail graphic map"><a href="/work/id/"><img class="thumb" src="/wp-content/uploads/braid_thumb.jpg"></a></div>
			
		</div>		
		<div class="row">
			<div class="thumbnail graphic"><a href="/work/common-scale/"><img class="thumb" src="/wp-content/uploads/streetsystem_thumb.png"></a></div>
			<div class="thumbnail graphic fun"><a href="/work/more-graphics/"><img class="thumb" src="/wp-content/uploads/misc_thumb.jpg"></a></div>
			<div class="thumbnail fun map"><a href="/work/more-maps/"><img class="thumb" src="/wp-content/uploads/misc_maps_thumb.png"></a></div>
			<div class="thumbnail graphic fun"><a href="/work/posters/"><img class="thumb" src="/wp-content/uploads/poster_thumb.jpg"></a></div>
		</div>
	</div>

<script src="/wp-content/themes/Starkers/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="/wp-content/themes/Starkers/js/site.js" type="text/javascript"></script> 

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
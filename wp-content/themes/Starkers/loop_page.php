<?php
/**
 * Template Name: Loop Page
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
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div id="content" class="projectPage">
	<div class="span1" >
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h3 class="capTitle"><?php the_title(); ?></h3>
<div id="content-text"><?php the_content(); ?></div>
<div id="post-nav">
		    <span class="prevPageNav">
		      <?php 
		      echo previous_page_not_post('&larr;', true, ''); ?> 
		    </span>  
		    <span class="nextPageNav" >
		      <?php 
		      echo next_page_not_post('&rarr;', true, '' );  ?> 
		    </span>
</div>
<?php endwhile; ?>
</div>
</div> 

<script src="/wp-content/themes/Starkers/rainbow.min.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/rainbow.generic.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/rainbow.javascript.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/rainbow.css.js" type="text/javascript"></script> 

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
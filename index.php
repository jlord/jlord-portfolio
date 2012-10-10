<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	jlord online 
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div id="content" class="loop">
	<div class="span3">
<?php if ( have_posts() ): ?>
<ol>
<?php while ( have_posts() ) : the_post(); ?>
	<li>
		<article>
			<h1 class="postTitle blogLoop"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<h6 class="postDate"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></h6>
			<?php the_content(); ?>
		</article>
	</li>
<?php endwhile; ?>
</ol>
<?php else: ?>
<h2>No posts to display</h2>
<?php endif; ?>
</div>

<div class="span1 noMobile">
	<div id="blogSidebar">
	<h4>Blog Life</h4>
	<p>Me: on urban design, cities and web dev.</p>	
	</div>
</div>

</div>

<script src="/wp-content/themes/Starkers/rainbow.min.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/rainbow.generic.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/rainbow.javascript.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/rainbow.css.js" type="text/javascript"></script> 

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
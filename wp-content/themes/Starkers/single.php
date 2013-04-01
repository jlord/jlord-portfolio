<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="content">

<article class="span3 ">
<div id="post">
	<h1 class="postTitle"><?php the_title(); ?></h1>
	<h6 class="postDate"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> 
		<?php the_time(); ?></time> | 
		<!-- comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); -->
	 Category: 
		<?php
		$categories = get_the_category();
		$separator = ' ';
		$output = '';
		if($categories){
			foreach($categories as $category) {
				$output .= '<a href="'.get_category_link($category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
			}
		echo trim($output, $separator);
		}
		?> | 
		<?php the_tags(); ?>
</span>

	</h6>
	<?php the_content(); ?>		

	<div id="post-to-fro">
		<h5 style="float: left;">		<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'twentyten' ) . ' %title' ); ?></h5>
		<h5 style="float: right;">		<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '' ); ?></h5>
	</div>


</div>

</article>
<div class="span1 noMobile">
	<div id="blogSidebar">
	<h4>Blog Life</h4>
	<p>Me: on urban design, cities and web dev.</p>	
	<p><a href="<?php bloginfo('atom_url'); ?>">Subscribe</a> to the feed.</p>
	</div>
</div>


<?php endwhile; ?>
</div>

		<script src="/wp-content/themes/Starkers/rainbow.min.js" type="text/javascript"></script> 
		<script src="/wp-content/themes/Starkers/rainbow.generic.js" type="text/javascript"></script> 
		<script src="/wp-content/themes/Starkers/rainbow.javascript.js" type="text/javascript"></script> 
		<script src="/wp-content/themes/Starkers/rainbow.css.js" type="text/javascript"></script> 

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
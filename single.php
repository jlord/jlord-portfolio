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
<div class="post">
	<h1 class="postTitle"><?php the_title(); ?></h1>
	<h6 class="postDate"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> 
		<?php the_time(); ?></time> | 
		<!-- comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); -->
		Tags:
		<?php 
			$tags = get_tags();
			$html = '';
			foreach ($tags as $tag){
			$tag_link = get_tag_link($tag->term_id);
				
			$html .= "<span class='aTag'><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
			$html .= "{$tag->name}</a></span>";
			}
			$html .= '';
			echo $html;
		?></span>

	</h6>
	<?php the_content(); ?>		

	<div id="post-to-fro">
		<h5 style="float: left;">		<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'twentyten' ) . ' %title' ); ?></h5>
		<h5 style="float: right;">		<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '' ); ?></h5>
	</div>


</div>
<div class="comments">
	<?php if ( get_the_author_meta( 'description' ) ) : ?>
	<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
	<h3>About <?php echo get_the_author() ; ?></h3>
	<?php the_author_meta( 'description' ); ?>
	<?php endif; ?>

	<?php comments_template( '', true ); ?>
</div>
</article>
<div class="span1">
	<div id="blogSidebar">
	<h4>Tags</h4>
	<p>Cars, Streets, Views, Speed, Buildings, Trucks, Cake, Coffee, Height, Shadow, Maps, History</p>	
	<h4>Entries of Note</h4>
	<p>Cars, Streets, Views, Speed, Buildings, Trucks, Cake, Coffee, Height, Shadow, Maps, History</p>
	</div>
</div>


<?php endwhile; ?>
</div>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
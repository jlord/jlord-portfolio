<?php
/**
 * Search results page
 * 
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div id="content" class="searchPage">
<?php if ( have_posts() ): ?>
		<div class="span1 contact">
			<img src="/wp-content/uploads/me_city2.png" width="231.25px">
	</div>
	
<div class="span3">
	<h2>Search Results for '<?php echo get_search_query(); ?>'</h2>	
<ol>
<?php while ( have_posts() ) : the_post(); ?>
	<li>
		<article>
			<span class="projTitle"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></span>
			<!-- <h6 class="postDate"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></h6> -->
			<!-- the_content(); -->
	<div id="content-text">
	  <?php
	  ob_start();
	  the_content('Read the full post',true);
	  $postOutput = preg_replace('/<img[^>]+./','', ob_get_contents());
	  ob_end_clean();
	  echo $postOutput;
	  ?>
	</div>
		</article>
	</li>
<?php endwhile; ?>
</ol>
</div>
<?php else: ?>
		<div class="span1 contact">
			<img src="/wp-content/uploads/me_4wheeler2.png" width="231.25px">
	</div>
	<div class="span3">
<h1>Dang!</h1>
<h2>Computer internet machine couldn't find <span class="textHighlight"><?php echo get_search_query(); ?></span> - try again!</h2>
</div>
<?php endif; ?>


</div>
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
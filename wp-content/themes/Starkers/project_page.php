<?php
/**
 * Template Name: Project Page
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
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div id="content" class="projectPage">
		<div class="span1">
			<h3 class="capTitle"><?php the_title(); ?></h3>
			<h2 class="projCategory theMeta"><?php $key="projCategory"; echo get_post_meta($post->ID, $key, true); ?></h2>

			<div id="content-text">
		    <?php
      $posttext = $post->post_content;
      $regex = '~<img [^\>]*\ />~';
      preg_match_all($regex, $posttext, $images);
      $posttext = preg_replace($regex, '', $posttext); 
      $noOfImgs = count($images[0]); 
      ?>
			<p class="realBody"><?php echo $posttext; ?></p>
		    
	  	</div>
	  	<h2 class="projFor theMeta">for: <?php $key="projFor"; echo get_post_meta($post->ID, $key, true); ?></h2>
	  	<!-- <h2 class="projURL theMeta"><a href=" - $key="projFor"; echo get_post_meta($post->ID, $key, true); ?>" target="_blank">Website</a></h2> -->
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
		</div>

		<div class="span3 projImgColumn">
			<span class="video"><?php $key="video"; echo get_post_meta($post->ID, $key, true); ?></span>
			<span class="webmap"><?php $key="webmap"; echo get_post_meta($post->ID, $key, true); ?></span>

			<div class="content-img">
		  <?php
		    preg_match_all("/(<img [^>]*>)/",get_the_content(),$matches,PREG_PATTERN_ORDER);
		    for( $i=0; isset($matches[1]) && $i < count($matches[1]); $i++ ) {
		      $beforeEachImage = '<a href="#">';
		      $afterEachImage = '</a>';
		      echo $beforeEachImage . $matches[1][$i] . $afterEachImage;}?>
			</div>
		</div>


<?php endwhile; ?>
</div>
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
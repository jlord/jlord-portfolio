<?php
/**
 * Template Name: Front Dash
 *
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div id="content" class="front-dashboard">
<div class="span4 hi-currently">
	<div class="span2">
		<h1>Hello</h1>
		<p>I spend my time in the spaces and sometimes intersections of open source, urban design, government technology, citizenry and information design. Also bikes, Oakland, coffee.</p>
	</div>
	<div class="span2">
		<h3 class="box-header">Currently</h3>
		<p class="sm-sans">I’ll be spending the next few months contracting at the fantastic <a href="http://www.diy.org" target="_blank">DIY.org</a> to build out the hacker skills and challenges; taking my CfA project <a href="http://jllord.github.com/sheetsee.js" target="_blank">sheetsee.js</a> to the next level through a Code Sprint grant from <a href="http://www.mozillaopennews.org/" target="_blank">Mozilla and the Knight Foundation</a>; and proudly as a submission reader in Knight Foundation’s <a href="http://www.newschallenge.org" target="_blank">Open Gov News Challenge</a>	.</p>
	</div>

	</div>

	<div class="span4 fd-section">
	<div class="span2">
		<h3>Latest Entry</h3>
		<div id="fp-blog-entry">
			<?php
				$args = array( 'numberposts' => 1 );
				$lastposts = get_posts( $args );
				foreach($lastposts as $post) : setup_postdata($post); ?>
				<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				 <?php if ( has_post_thumbnail()) the_post_thumbnail(); ?>
				<?php  the_excerpt(); ?>
			<?php endforeach; ?> 
		</div>
		<h4>More Entries</h4>
			<div id="fp-recent-entries">
				<ul>
				<?php
					$args = array( 'numberposts' => '3', 'offset' => '1' );
					$recent_posts = wp_get_recent_posts( $args );
					foreach( $recent_posts as $recent ){
						echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a>  </li> ';
					}
				?>
				</ul>
			</div>
			<h3 class="box-header">ECAB</h3>
				<p class="sm-sans">My <a href="http://www.ecabonline.com" target="_blank">website</a> on making tangible things.</p>
	</div>
	<div class="span1 pocketBox">
		<h3>Reading Articles</h3>
		<div id="pocketReader"></div>
	</div>
	<div class="span1">
		<h3>Tweets & Intagrams</h3>
		<div id="tweetBox">
		<?php
			// Your twitter username.
			$username = "jllord";
			$prefix = "<small><a href=\"http://www.twitter.com/jllord\">@jllord</a></small><div id='tweet'><p>";
			$suffix = "</p></div>";
			$feed = "http://search.twitter.com/search.atom?q=from:" . $username . "&rpp=1";
			function parse_feed($feed) {
			    $stepOne = explode("<content type=\"html\">", $feed);
			    $stepTwo = explode("</content>", $stepOne[1]);
			    $tweet = $stepTwo[0];
			    $tweet = str_replace("&lt;", "<", $tweet);
			    $tweet = str_replace("&gt;", ">", $tweet);
			    return $tweet;
			}
			$twitterFeed = file_get_contents($feed);
			echo stripslashes($prefix) . parse_feed($twitterFeed) . stripslashes($suffix);
			?>
		</div>
				<div class="instaBox">
			<small><a href="http://instagram.com/jlord" target="_blank">instagram/jlord</a></small>
			<div id="instagram"></div>
			<small>See <a href="http://jlord.us/instagram">more</a> of feed - in circles!</small>
		</div>
	</div>

	</div>
	<div class="span4 fd-section">
		<div class="row">
			
			<div class="thumbnail title"><h3>Recent Work</h3><a href="/work/see-penny-work/"><img class="thumb" src="/wp-content/uploads/seepennywork_thumb.png"></a></div>
			<div class="thumbnail notitle"><a href="/work/future-aloof/"><img class="thumb" src="/wp-content/uploads/future-aloof-thumb.png"></a></div>
			
			<div class="thumbnail title"><h3>Recent ECAB Projects</h3><a href="http://www.ecabonline.com/2013/03/hanging-herb-garden.html" target="_blank"><img class="thumb" src="/wp-content/uploads/ecab1.png"></a></div>
			<div class="thumbnail notitle"><a href="http://www.ecabonline.com/2013/01/naturally-dyed-tea-towels.html" target="_blank"><img class="thumb" src="/wp-content/uploads/ecab2.png"></a></div>
		</div>
	</div>




</div>




<script src="/wp-content/themes/Starkers/sheetsee.js?0"></script>
<script src="/wp-content/themes/Starkers/tabletop.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/ICanHaz.js" type="text/javascript"></script> 

<script id="instagram" type="text/html">
  <table>
  {{#rows}}
    <tr><td class="postDate">{{instadate}}</td></tr>
    <tr><td class="instaImg"><img src="{{instasource}}" width="209.25px"/></td></tr>
    <tr><td class="instaCaption">{{instacaption}}</td></tr>
  {{/rows}}
  </table>
</script>

<script id="pocketReader" type="text/html">
  <table>
  {{#rows}}
    <tr><td class="postDate">{{readdate}}</td></tr>
    <tr><td class="instaCaption"><a href="{{readurl}}">{{readtitle}}</a></td></tr>
  {{/rows}}
  </table>
</script>


<script type="text/javascript">    
  document.addEventListener('DOMContentLoaded', function() {
     loadSpreadsheet()
   }) 

	 var instaData = []

  showDataA = function(data) {
		var data = data
		var instaData = data

		var instagram = ich.instagram({
			"rows": getLast(instaData, 1)
		})
		document.getElementById('instagram').innerHTML = instagram;

		return instaData
	}


	

	showDataB = function(data) {
		var data = data
		var pocketData = data

 		var pocketReader = ich.pocketReader({
    	"rows": getLast(pocketData, 6)
 		})
 		document.getElementById('pocketReader').innerHTML = pocketReader; 
		}

</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


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
		<p>I spend my time in the spaces and sometimes intersections of open source, web development, urban design, government technology and information design. All the things. Also bikes, Oakland, coffee.</p>
	</div>
	<div class="span2">
		<h3 class="box-header">Specifically</h3>
		<p class="sm-sans">I work at <a href="http://www.github.com" target="_blank">GitHub</a> with really awesome people making awesomes tool for development and open source. I work on frontend dev things, gov things, design things, occassionally I toy with Node. I've got a little open source library, <a href="http://jlord.github.io/sheetsee.js" target="_blank">sheetsee.js</a>, that makes it easy to make visualzations websites from Google Spreadsheets.</p>

	</div>

	</div>

	<div class="span4 fd-section latest-things">
	<div class="span2">
		<h3>Latest Entry</h3>
		<div id="fp-blog-entry">
			<?php
				$args = array( 'numberposts' => 1, 'post_status' => 'publish' );
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
					$args = array( 'numberposts' => '3', 'offset' => '1', 'post_status' => 'publish' );
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
		<h3>Tweets & Instagrams</h3>
		<div id="tweetBox">
			<small><a href="http://www.twitter.com/jllord" target="_blank">twitter/jllord</a></small>
			<div id="twitterTweet"></div>
		</div>
				<div class="instaBox">
			<small><a href="http://instagram.com/jlord" target="_blank">instagram/jlord</a></small>
			<div id="instagram"></div>
			<small>See <a href="http://jlord.us/instagram">more</a> of feed - in circles!</small>
		</div>
	</div>

	</div>
	<div class="span4 fd-section">
		<div class="row-titles"><span class="span2"><h3>Recent Work</h3></span><span class="span2"><h3>Recent ECAB Projects</h3></span></div>
		<div class="row">
			
			<div class="thumbnail"><a href="/work/see-penny-work/"><img class="thumb" src="/wp-content/uploads/seepennywork_thumb.png"></a></div>
			<div class="thumbnail"><a href="/work/future-aloof/"><img class="thumb" src="/wp-content/uploads/future-aloof-thumb.png"></a></div>
			
			<div class="thumbnail"><a href="http://www.ecabonline.com/2013/03/hanging-herb-garden.html" target="_blank"><img class="thumb" src="/wp-content/uploads/ecab1.png"></a></div>
			<div class="thumbnail"><a href="http://www.ecabonline.com/2013/01/naturally-dyed-tea-towels.html" target="_blank"><img class="thumb" src="/wp-content/uploads/ecab2.png"></a></div>
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
    <tr><td class="postDate">{{date}}</td></tr>
    <tr><td class="instaCaption"><a href="{{url}}">{{article}}</a></td></tr>
  {{/rows}}
  </table>
</script>

<script id="twitterTweet" type="text/html">
	<table>
	{{#rows}}
		<tr><td class="postDate">{{date}}</td></tr>
		<tr><td class="instaCaption" style="line-height: 24px;">{{{tweet}}}</td>
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
			"rows": instaData[instaData.length - 1]
		})
		document.getElementById('instagram').innerHTML = instagram

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
		
	showDataC = function(data) {
    var lastTweet = data[data.length - 1]
		var tweet = findLinks(lastTweet)
    var tweetData = {"tweet": tweet}
    
     var twitterTweet = ich.twitterTweet({
       "rows": tweetData
     })
     document.getElementById('twitterTweet').innerHTML = twitterTweet
	}
  
  function getLast(array, howMany) {
    start = array.length
    cut = start - howMany
    if (start < 12) {
    return array
    } else {
      array = array.splice(cut)
      return array.reverse()
    }
  }
	
  function findLinks(tweet) {
    if (!tweet.tweet) return
      var linkPattern = /(^|\s)((https?:\/\/)?[\w-]+(\.[\w-]+)+\.?(:\d+)?(\/\S*)?)/gi
      
      if (!tweet.tweet.match(linkPattern)) {
        return tweetMentions(tweet.tweet)
      } else {
        var links = tweet.tweet.match(linkPattern)
        var linkLinks = linkLink(links)
        var newTweet = injectLinks(tweet.tweet, links, linkLinks)
        return tweetMentions(newTweet)
      }       
  }

  function tweetMentions(tweet) {
    if (!tweet) return
    var mentionPattern = /\B@[a-z0-9_-]+/gi
    
    if (tweet.match(mentionPattern)) {
      var mentions = tweet.match(mentionPattern)
      var linkMentions = linkMention(mentions)
      var newTweet = injectLinks(tweet, mentions, linkMentions)
      return newTweet
    } else { return }
  }
  
  function linkMention(mentions) {
    if (!mentions) return
    var linkMentions = []
    mentions.forEach(function(mention){
      var wrap = "<a href='http://www.twittter.com/" + mention + "' target='_blank'>" + mention + "</a>"
      linkMentions.push(wrap)
    })
    return linkMentions
  }
  
  function linkLink(links) {
    if (!links) return
    var linkLinks = []
    links.forEach(function(link) {
      link = '<a href="' + link + '" target="_blank">' + link + '</a>'
      linkLinks.push(link)
    })
    return linkLinks
  }
  
  function injectLinks(tweet, mentions, linkMentions) {
    for (var i = 0; i <= mentions.length; i++) {
      tweet = tweet.replace(mentions[i], linkMentions[i])
      if (i === mentions.length) return tweet
    }    
  }
	
</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


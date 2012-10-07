<?php
/**
 * Template Name: Dashboard 
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
<div id="content" class="dashboard">
<div class="span1">
	<h1>Dashboard</h1>
	<p>Much of this is powered through spreadsheets filled by <a href="http://www.iftt.com" target="_blank">iftt.com</a> 
		plus <a href="http://builtbybalance.com/Tabletop/" target="_blank">tabletop.js</a> in a mashup I call <a href="http://jllord.github.com/sheetsee.js" target="_blank">sheetsee.js</a>.</p>
</div>
<div class="span2">
	<h3>Lastest Reads from Pocket</h3>
	<div id="pocketReader"></div>
</div><!-- end span2 -->
	<div class="span1">
		<div id="tweetBox">
		<?php
		// Your twitter username.
		$username = "jllord";
		$prefix = "<h3><a href=\"http://www.twitter.com/jllord\">@jllord</a>'s Latest Tweet</h3><div id='tweet'><p>";
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

		<div class="span1">
			<h3>Lastest Instagram</h3>
		<div id="instagram"></div>
		</div>
</div><!-- end span1 -->


</div> 

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
    <tr><td class="instaCaption"><a href="{{readURL}}">{{readtitle}}</a></td></tr>
  {{/rows}}
  </table>
</script>


<script type="text/javascript">    
  document.addEventListener('DOMContentLoaded', function() {
     loadSpreadsheet()
   }) 



  showDataA = function(data) {
		var data = data
		var instaData = data

		var instagram = ich.instagram({
			"rows": getLast(instaData)
		})
		document.getElementById('instagram').innerHTML = instagram;
	}

	showDataB = function(data) {
		var data = data
		var pocketData = data

 		var pocketReader = ich.pocketReader({
    	"rows": getLastFive(pocketData)
 		})
 		document.getElementById('pocketReader').innerHTML = pocketReader; 
		}

</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


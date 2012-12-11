<?php
/**
 * Template Name: Oakland 
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
<div class="span4">
	<div class="span1">
		<h1>Oakland, Ca</h1>
		<p>Much of this is powered through spreadsheets filled by <a href="http://www.iftt.com" target="_blank">iftt.com</a> 
			plus <a href="http://builtbybalance.com/Tabletop/" target="_blank">tabletop.js</a> in a mashup I call <a href="http://jllord.github.com/sheetsee.js" target="_blank">sheetsee.js</a>.</p>
		<div class="instaBox">
			<h3>Lastest Instagram</h3>
			<div id="instagram"></div>
			<p>See <a href="http://jlord.us/instagram">all</a> of feed.</p>
		</div>
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



  showDataA = function(data) {
		var data = data
		var instaData = data

		var instagram = ich.instagram({
			"rows": getLast(instaData, 1)
		})
		document.getElementById('instagram').innerHTML = instagram;
	}

	showDataB = function(data) {
		var data = data
		var pocketData = data

 		var pocketReader = ich.pocketReader({
    	"rows": getLast(pocketData, 4)
 		})
 		document.getElementById('pocketReader').innerHTML = pocketReader; 
		}

</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


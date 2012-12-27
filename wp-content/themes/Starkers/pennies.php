<?php
/**
 * Template Name: Pennies 
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
	<div class="span4" style="width: 100%;">
		<h1>Flattened Penny Collection</h1>
	</div>
	
	<div class="span4" style="width: 100%;">
		<div class="span3" style="width: 100%;"><iframe width='100%' height='450' frameBorder='0' 		src='http://a.tiles.mapbox.com/v3/jllord.pennies.html#4/39.8085/-98.4375'></iframe></div>
		<div class="span1" style="margin: 0px; padding: 0px;"><img src="/wp-content/uploads/penny.png" width="100%"/></div>
	</div>
	
	<div class="span4 pennyArticle" style="width: 100%;">
		<div class="span2">
			<h3>What?</h3><small>Probably the most serious collection I own as I own 28+ of nothing else. Finding penny presses is a joy. I remember when they just cost a 					penny, now they’re 50c. How times change.</small></div>
		<div class="span1">
			<h3>Data</h3><small>Data handmade into this spreadsheet and mapped with TileMill.</small></div>
		<div class="span1">
			<h3>Data</h3><small>Data handmade into this spreadsheet and mapped with TileMill.</small></div>
	</div>
	
	<div class="span4 pennyArticle" style="width: 100%;"><!-- gallery -->
		<h3>Gallery</h3></div>
		<div class="row">
			<div class="thumbnail map"><a href="/work/boston-map/"><img src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail web"><a href="/work/file-bakery/"><img src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail map web"><a href="/work/mta/"><img src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail graphic"><a href="/work/common-scale/"><img src="/wp-content/uploads/penny.png"></a></div>
		</div>
		<div class="row">
			<div class="thumbnail map"><a href="/work/boston-map/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail web"><a href="/work/file-bakery/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail map web"><a href="/work/mta/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail graphic"><a href="/work/common-scale/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
		</div>
		<div class="row">
			<div class="thumbnail map"><a href="/work/boston-map/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail web"><a href="/work/file-bakery/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail map web"><a href="/work/mta/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
			<div class="thumbnail graphic"><a href="/work/common-scale/"><img class="thumb" src="/wp-content/uploads/penny.png"></a></div>
		</div>
	</div>
</div><!-- end wrap span4 -->


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


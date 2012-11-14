<?php
/**
 * Template Name: iFeed 
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
<div id="content" class="instagramFeed">
	<div id="instagram" class="span4"><img class="spinner" src="http://jlord.s3.amazonaws.com/wp-content/uploads/fbi_spinner1.gif"></div>
	<div class="span3"><p>These are my Instagram photos starting when I started saving them to a Google Spreadsheet using <a href="http://www.ifttt.com" target="_blank">ifttt.com</a>. My <a href="http://jlord.us/your-own-instagram-feed/">blog post</a> on how.</p></div>
</div> 

<script src="/wp-content/themes/Starkers/sheetsee.js?0"></script>
<script src="/wp-content/themes/Starkers/tabletop.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/ICanHaz.js" type="text/javascript"></script> 

<script id="instagram" type="text/html">
  {{#rows}}
    <div class="span1 instaImgCirc"><img src="{{instasource}}" width="100%"/></div>
  {{/rows}}
</script>

<script type="text/javascript">    
  document.addEventListener('DOMContentLoaded', function() {
     loadSpreadsheet()
   }) 

  showDataA = function(data) {
		var instagram = ich.instagram({
			"rows": data.reverse()
		})
		document.getElementById('instagram').innerHTML = instagram;
	}

</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


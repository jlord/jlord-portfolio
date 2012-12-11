<?php
/**
 * Template Name: Lastest
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
<div id="content" class="last">
<div class="span4" style="background: #e6e6e6; width: 100%;">		
	<p>This is a test of Anglebars. The last article I read was <span id="output">Hi</span></p>
</div><!-- end span4 wrapper -->
</div> 
<script src="/wp-content/themes/Starkers/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="/wp-content/themes/Starkers/underscore.js"></script>
<!-- <script src="/wp-content/themes/Starkers/sheetsee.js?0"></script> -->
<script src="/wp-content/themes/Starkers/anglebars.js"></script>
<script src="/wp-content/themes/Starkers/tabletop.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/ICanHaz.js" type="text/javascript"></script> 


<script id="pocketReader" type="text/template">
  {{readtitle}}
</script>


<script type="text/javascript">    
  document.addEventListener('DOMContentLoaded', function() {
     loadSpreadsheet()
   }) 
	 
	 var URL2 = 'https://docs.google.com/spreadsheet/pub?key=0Ao5u1U6KYND7dERheVpFZThEUkdPZnFXXzMxTzJ3dEE&single=true&gid=0&output=html';

	 function loadSpreadsheet() {
	   var b = Tabletop.init( { key: URL2, callback: showDataB, simpleSheet: true } )
	 }
	 
	 window.setInterval(function(){
		 loadSpradsheet()
		}, 5000);
		
	showDataB = function(data) {
		var pocketData = data.reverse()
		console.log(pocketData[0].readtitle)
		var anglebars = new Anglebars({
		  el: 'output',
		  template: $('#pocketReader').html(),
		  data: { 
				readtitle: pocketData[0].readtitle 
			}
		});
		anglebars.set('readtitle', pocketData[0].readtitle);
 		}
		
		
	
</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


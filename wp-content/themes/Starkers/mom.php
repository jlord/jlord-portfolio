<?php
/**
 * Template Name: Mom 
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
<div id="content" class="momPage">
<div class="span4">
	<div class="span3">
		<h1>Dear Mom,</h1>
		<p>2012 was an incredible year. It was the year I wrote an API for my annual Year in Review letter and made this page.  I hope you enjoy this addition to the written letter - which you’ll still recieve!</p>
		<p class="right" style="padding-right: 70px;">Lu!<br /> Jecca</p>
	</div>
</div>

<div class="span4">
	<div class="horzSec">Geographies</div>
	<img src="/wp-content/uploads/mom-map.png" style="max-width: 1000px;">
	
	<div class="span1 flightStats">
		<img src="/wp-content/uploads/plane.png" />
		<p class="lrgNumber">24</p>
		<p class="numCaption">FLIGHTS</p>
		<p class="lrgNumber">53k</p>
		<p class="numCaption">MILES</p>
	</div>
	
	<div class="span3 itenerary">
		<table>
			<tr><td class="month">January</td><td class="city">San Francisco, Ca</td><td class="desc">Started new year in a new city and CfA</td></tr>
			<tr><td class="month"></td><td class="city">San Francisco, Ca</td><td class="desc">Max and I start dating</td></tr>
			<tr><td class="month">February</td><td class="city">Macon, Ga</td><td class="desc">Began CfA residency</td></tr>
			<tr><td class="month">March</td><td class="city">San Francisco, Ca</td><td class="desc">Returned from Residency</td></tr>
			<tr><td class="month">April</td><td class="city">Portland, Or</td><td class="desc">To Speak at Rebooting Democracy with Max</td></tr>
			<tr><td class="month">May</td><td class="city">Buenos Aires, Ca</td><td class="desc">Javascript Conf, Max is a speaker</td></tr>
			<tr><td class="month"></td><td class="city">New Orleans, La</td><td class="desc">Kathy and Morgan reception</td></tr>
			<tr><td class="month">June</td><td class="city">Boston</td><td class="desc">Knight/MIT Civic Media Conf with Max</td></tr>
			<tr><td class="month">July</td><td class="city">Portland, Or</td><td class="desc">NodeConf with Max (speaker and org)</td></tr>
			<tr><td class="month">August</td><td class="city">Macon, Ga</td><td class="desc">Return trip to CfA city/home</td></tr>
			<tr><td class="month">September</td><td class="city">Marshall, Ca</td><td class="desc">Node Summercamp with Max</td></tr>
			<tr><td class="month"></td><td class="city">New Orleans, La</td><td class="desc">Rethinking Local News Knight Foundation meeting</td></tr>
			<tr><td class="month">October</td><td class="city">San Francisco, Ca</td><td class="desc">Code for America Summit, speaker</td></tr>
			<tr><td class="month"></td><td class="city">Portland, Or</td><td class="desc">State of the Map, speaker</td></tr>
			<tr><td class="month"></td><td class="city">Macon, Ga</td><td class="desc">Final trip to CfA city</td></tr>
			<tr><td class="month"></td><td class="city">New York, Ny</td><td class="desc">Meet Max after his 2mos speaking abroad</td></tr>
			<tr><td class="month">November</td><td class="city">London, UK</td><td class="desc">Mozilla Festival with Max</td></tr>
			<tr><td class="month">December</td><td class="city">Miami, Fl</td><td class="desc">Knight Foundation staff meeting</td></tr>
		</table>
	</div>
</div>

<div id="span4">
	<div class="horzSec">Scenes</div>
	<div id="photoData">hi waitng</div>
</div>

</div> 

<script src="/wp-content/themes/Starkers/sheetsee.js?0"></script>
<script src="/wp-content/themes/Starkers/tabletop.js" type="text/javascript"></script> 
<script src="/wp-content/themes/Starkers/ICanHaz.js" type="text/javascript"></script> 


<script id="photoData" type="text/html">
		{{#rows}}
	  <div class="span1 oneCell thumbnail">
	    <img src="{{photoURL}}"/>
			<h5 class="month">{{month}}</h5>
			<h5>{{date}}</h5>
			<p>{{details}}</p>
			<h6>{{city}}</h6>
	  </div>
		{{/rows}}
		
</script>

<script type="text/javascript">

  document.addEventListener('DOMContentLoaded', function() {
		var photoData = ich.photoData({
			"rows": yearData
		})
		document.getElementById('photoData').innerHTML = photoData;
   }) 
		
	 var yearData = [
	 			{
	 			"month": "january",
	 			"photoURL" : "http://distilleryimage2.s3.amazonaws.com/15f7bc08359d11e1abb01231381b65e3_7.jpg",
	 			"city" : "San Fransico, Ca",
	 			"date" : "01/02/12",
	 			"place" : "Ft. Funston",
	 			"details" : "West Coast, America"
	 		},
	 			{
	 			"month": "january",
	 			"photoURL" : "http://distilleryimage2.s3.amazonaws.com/4be860404a9e11e19896123138142014_7.jpg",
	 			"city" : "San Fransico, Ca",
	 			"date" : "01/26/12",
	 			"place" : "Haus Cofffe",
	 			"details" : "Lots of coffee and hacking with a certain fellow."
	 		},
	 			{
	 			"month": "feburary",
	 			"photoURL" : "http://distilleryimage5.s3.amazonaws.com/3340fc6447ba11e180c9123138016265_7.jpg",
	 			"city" : "Warner Robins, Ga",
	 			"date" : "01/29/12",
	 			"details" : "Back home, caviar of the south!"
	 		},
	 			{
	 			"month": "feburary",
	 			"photoURL" : "http://distilleryimage0.s3.amazonaws.com/25d2545c4ac011e1a87612313804ec91_7.jpg",
	 			"city" : "Warner Robins, Ga",
	 			"date" : "01/29/12",
	 			"details" : "With my awesome family!"
	 		},
	 		{
	 		"month": "feburary",
	 		"photoURL" : "http://distilleryimage9.s3.amazonaws.com/6156553a4c7f11e19e4a12313813ffc0_7.jpg",
	 		"city" : "Macon, Ga",
	 		"date" : "02/01/12",
	 		"details" : "My CfA team"
	 	},
	 ]





</script>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>


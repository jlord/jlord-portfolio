<?php
/**
 * Template Name: About
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

	<div id="content" class="aboutPage">
		<div class="span1 contact">
					<img src="/wp-content/uploads/circle_me.png" width="231.25px">
		</div>
		
		<div class="span3 bio">
			<h3 class="capTitle">Jessica Lord</h3>
			<h6><small>Hi</small></h6>
			<p class="biobody">I believe in cities for people - this is the guiding principal of my work. Urban Design is a unique field whose moves have a deep reaching effect on our lives from health to happiness. The most meaningful work for me is communicating the impact of our cities be it a diagram, a map or with the help of JavaScript.</p>
			<p class="biobody">Born in Warner Robins, Georgia, I now live in Oakland, California. <a href="http://mailto:to.jlord@gmail.com">Let me know</a> if you have a project in mind.</p>
		
			<h3 class="capTitle">Cities + Tech</h3>
			<ul><li>After an urban design study abroad year in Paris my senior year of college I shifted my focus from architecture to urban design. While working in architecture after graduation I quickly learned new Building Information Modeling software
				and started visualizing the built environment, working on single family and multi-family scale projects from concept to construction documents as well as earning LEED BD&C accreditation. Working for the City of Boston in the Boston Redevelopment Authority's
				Urban Design Technology group I contributed to and visualized design guidelines, height regulations, project reviews and earned LEED ND accreditation. I worked across departments often with Economic Development and the Mayor's Office of New Urban Mechanics. 
				In 2012 I was accepted as a Code for America Fellow and focused on designing and building lightweight technology for city government. 

		</li></ul><p></p>

			<div class="span1 contact">
			<h3 class="capTitle">Contact</h3>
			<h6><small>e Ways</small></h6>
			<ul>
				<li><a href="http://www.github.com/jllord">Github</a></li>
				<li><a href="mailto:to.jlord@gmail.com?subject=Hi!">to.jlord@gmail.com</a></li>
				<li><a href="http://www.twitter.com/jllord">@jllord</a></li>
				<li><a href="#">#codeforamerica on freenode.net</a></li>
			</ul>
			<h6><small>IRL</small></h6>
			<ul><li>Coffee shops in Oakland: Awaken, Sub Rosa, Modern, Arbor, Room 389</li></ul>
			
		</div>

		
		<div class="span2 edu">

			<h3 class="capTitle">Experience</h3>
			<h6><small>Work</small></h6>
			<ul>
				<li>Code for America, 2012 Fellow, San Francisco</li>
				<li>Jr. Urban Designer, Boston Redevelopment Auth., City of Boston</li>
				<li>Intern Architect, Rutledge-Alcock Architects, Atlanta</li>
			</ul>
			<h6><small>Education</small></h6>
			<ul>
				<li>Georgia Institute of Technology, Architecture</li>
			</ul>
			<h6><small>Skills</small></h6>
			<ul>
				<li>Urban and Architectural Design, graphic design, diagraming, static and web mapping, Adobe Suite, CSS, HTML, Javascript, Wordpress PHP.</li></ul>
			<ul>
				<li>Was LEED ND and LEED BD&C but they lapsed this year during my Code for America Fellowship. </li>
			</ul>
			<h6><small>Speaking</small></h6>
			<ul>
				<li>State of the Map, 2012</li>
				<li><a href="http://www.youtube.com/watch?v=Q76bKK229aM" target="_blank">Code for America Summit, 2012</a></li>
			</ul>
		</div>


		<div class="span3 siteInfo">
			<h3 class="capTitle">About this Site</h3>
			<ul><li>I built this site from scratch using <a href="http://viewportindustries.com/products/starkers/" target="_blank">Starkers</a>, a naked Wordpress theme. 
			I rounded it out with some jquery and javascript, which I'll blog about soon. The typefaces are <a href="http://www.google.com/webfonts/specimen/Open+Sans" target="_blank">Open Sans</a> and <a href="http://www.google.com/webfonts/specimen/Merriweather" target="_blank">Merriweather</a>, both from Google Web Fonts.
		</li></ul>
		</div>

		
</div>

		
		
	</div><!-- end content -->
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>